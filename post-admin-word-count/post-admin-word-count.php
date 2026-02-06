<?php

/**
 * Plugin Name: Post Admin Word Count
 * Plugin URI: https://jonbishop.com/downloads/wordpress-plugins/post-admin-word-count/
 * Description: Adds a sortable column to the admin post list displaying the word count for each post.
 * Version: 2.0
 * Author: Jon Bishop
 * Author URI: https://www.jonbishop.com
 * License: GPL2+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: post-admin-word-count
 */

if (!defined('ABSPATH')) {
    exit;
}

class Post_Admin_Word_Count
{

    public function __construct()
    {
        add_action('init', function () {
            foreach (get_post_types(['public' => true], 'names') as $post_type) {
                if (in_array($post_type, ['attachment', 'wp_block', 'wp_template', 'wp_template_part'])) continue;
                add_filter("manage_{$post_type}_posts_columns", [$this, 'add_word_count_column']);
                add_action("manage_{$post_type}_posts_custom_column", [$this, 'render_word_count_column'], 10, 2);
                add_filter("manage_edit-{$post_type}_sortable_columns", [$this, 'make_column_sortable']);
            }
        });

        add_action('admin_enqueue_scripts', [$this, 'enqueue_custom_stylesheet']);

        add_action('pre_get_posts', [$this, 'handle_column_sorting']);
        add_action('save_post', [$this, 'update_word_count_meta'], 10, 2);
    }

    /**
     * Enqueues a custom stylesheet for post types where this plugin is active.
     */
    public function enqueue_custom_stylesheet($hook_suffix)
    {
        global $post_type;
        if (in_array($post_type, ['post', 'page']) || post_type_supports($post_type, 'editor')) {
            wp_enqueue_style('post-admin-word-count-style', plugin_dir_url(__FILE__) . 'css/post-word-count-style.css');
        }
    }

    /**
     * Adds a new "Word Count" column to the Posts admin screen.
     */
    public function add_word_count_column($columns)
    {
        $columns['post_word_count'] = __('Words', 'post-admin-word-count');
        return $columns;
    }

    /**
     * Outputs the word count for each post in the custom column.
     */
    public function render_word_count_column($column, $post_id)
    {
        if ($column === 'post_word_count') {
            $count = get_post_meta($post_id, '_post_word_count', true);

            if ($count === '') {
                $post = get_post($post_id);
                $content = wp_strip_all_tags($post->post_content, true);
                $count = str_word_count($content);
                update_post_meta($post_id, '_post_word_count', $count);
            }

            echo esc_html($count);
        }
    }

    /**
     * Registers the column as sortable in the admin.
     */
    public function make_column_sortable($columns)
    {
        $columns['post_word_count'] = 'post_word_count';
        return $columns;
    }

    /**
     * Adjusts query to sort by word count meta key.
     */
    public function handle_column_sorting($query)
    {
        if (is_admin() && $query->is_main_query() && $query->get('orderby') === 'post_word_count') {
            $query->set('meta_key', '_post_word_count');
            $query->set('orderby', 'meta_value_num');
        }
    }

    /**
     * Updates the word count meta whenever a post is saved.
     */
    public function update_word_count_meta($post_id, $post)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        if (!current_user_can('edit_post', $post_id)) return;
        if (!post_type_supports($post->post_type, 'editor')) return;
        if (in_array($post->post_type, ['attachment', 'revision', 'nav_menu_item', 'customize_changeset', 'wp_block', 'wp_template', 'wp_template_part'])) return;

        $content = wp_strip_all_tags($post->post_content, true);
        $word_count = str_word_count($content);
        update_post_meta($post_id, '_post_word_count', $word_count);
    }
}

new Post_Admin_Word_Count();
