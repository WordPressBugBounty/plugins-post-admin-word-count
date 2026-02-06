=== Post Admin Word Count ===
Contributors: JonBishop
Donate link: https://jonbishop.com/donate/
Tags: word count, post word count, admin columns, custom post types, content analysis
Requires at least: 5.0
Tested up to: 6.8
Requires PHP: 7.2
Stable tag: 2.0
License: GPLv2

Adds a sortable word count column to the admin post list for all public post types. Efficient, lightweight and built with modern best practices.

== Description ==

Post Admin Word Count adds a sortable "Words" column to the WordPress admin for all public post types. This lightweight plugin automatically calculates and stores word counts when posts are saved or viewed in the admin, ensuring performance and accuracy without scanning your entire site. It supports custom post types, integrates cleanly with the WordPress admin UI and adheres to modern coding standards. Ideal for publishers, bloggers and content editors who want quick insight into post length directly from the dashboard.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/post-admin-word-count` directory, or install the plugin through the WordPress plugin repository.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Go to the 'Posts' screen (or any supported post type) in your WordPress admin to see the new "Words" column.
4. Click the "Words" column header to sort posts by word count.

== Frequently Asked Questions ==

= Does this plugin work with custom post types? =
Yes. The plugin supports all public post types that use the WordPress editor, including custom post types.

= Will it calculate word counts for existing posts? =
Yes. Word counts are calculated and saved the first time you view the post list if they don’t already exist.

= Is the word count updated automatically? =
Yes. Word counts are updated automatically whenever a post is saved or updated.

= Does this plugin impact site performance? =
No. It only calculates word counts when needed and does not run any bulk operations on page load.

= Can I sort posts by word count? =
Yes. The "Words" column is sortable just like date or title.


== Screenshots ==

1. Word count on post list

== Changelog ==

The current version is 2.0 (2025.05.21)

= 2.0 =
* Complete plugin rewrite with modern best practices
* Word count column now supports all public post types (excluding attachments and system types)
* Word counts are lazily saved for existing posts, improving performance and accuracy
* Replaced legacy raw SQL with native WordPress query handling
* Added sortable column support across custom post types
* Improved security, escaping and overall code quality

= 1.2 =
* Process post meta before display
* Upload screenshot

= 1.1 =
* Fixed sorting

= 1.0 =
* First version