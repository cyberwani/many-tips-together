=== Many Tips Together ===
Contributors: brasofilo
Donate link: http://mtt.brasofilo.com
Tags: admin, admin interface, tuning, profile, posts, pages, login, maintenance mode, tuning, snippets, clients
Requires at least: 3.3
Tested up to: 3.5
Stable tag: 1.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Do you like to adjust and style the backend as much as the frontend?
So, we are together!
Lots of pro tips and enhancements in one place.

== Description ==
With MTT you'll be able to simplify and make deep customizations in the administrative interface.

It is a compilation of tips for enhancing, styling and reducing WordPress backend. 
Some are borrowed from other plugins, many are not. 
Usually we put them in the theme's functions.php, 
but if you handle many WordPress installations or swap themes frequently so better plugged then themed.

The plugin interface is pretty straight forward: choose the section and select your customizations.
The tips came from a variety of sources and are documented, whenever due and the best I could, 
throughout the code and in the help sections.

If you notice a missing credit, please notify it.

= Features =
* Appearance
* Admin Bar - remove and add items
* Admin Menus - remove menu items
* Dashboard - remove and add widgets
* Post and Page Listing - customize rows and columns
* Post and Page Editing
* Media
* Widgets - remove default widgets
* Plugins
* Users and Profile - fully customize
* Shortcodes
* General Settings
* Login and Logout - fully customize
* Maintenance Mode - with minimum Role allowed and possibility to block only the backend


= Acknowledgements =
* Everything changed after [WordPress Stack Exchange](http://wordpress.stackexchange.com/)
* Plugin interface using @bainternet's [Admin Page Class](https://github.com/bainternet/Admin-Page-Class)
* Plugin theme by [@toscho](wordpress.stackexchange.com/users/73/toscho)
* CSS for hiding help texts, by {CITATION NEEDED}
* {TODO: revise this}
* Everything started with [Adminimize](http://wordpress.org/extend/plugins/adminimize/), by Frank Büeltge, which does an awesome job hiding WordPress elements, but I wanted more, and these are some of the great resources where I found many snippets: [Stack Exchange](http://wordpress.stackexchange.com/questions/1567/best-collection-of-code-for-your-functions-php-file), [WPengineer](http://wpengineer.com), [wpbeginner](http://www.wpbeginner.com), [CSS-TRICKS](http://css-tricks.com), [Smashing Magazine](http://wp.smashingmagazine.com), [Justin Tadlock](http://justintadlock.com)...
* The option to hide the help texts from many areas of WordPress uses the CSS file of the plugin [Admin Expert Mode](http://wordpress.org/extend/plugins/admin-expert-mode/), by Scott Reilly.

= Localizations =
* Português
* Español

== Installation ==
1. Upload `many-tips-together.zip` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the *Plugins* menu in WordPress.
3. Go to *Settings -> Many Tips Together* and have fun.

= Uninstall =
The 'reset' button doesn't delete the database entry, but if you delete the plugin, the entry will be deleted (via unsinstall.php)

== Frequently Asked Questions ==
= Doubts, bugs, suggestions =
Don't hesitate in posting a new topic here in [WordPress support forum](http://wordpress.org/tags/many-tips-together?forum_id=10).


== Screenshots ==
1. Login screen
2. Maintenance mode
3. Admin bar (custom site link and custom menu, hidden elements and no Howdy), Admin menu (Posts renamed to Articles, hidden elements), Posts listing (ID and Thumbnail columns, custom color for different post status)
4. Profile page (the button Logout instead of Your Account is a feature of Adminimize)

== Changelog ==
**Version 2.0**

* Completely refactored, new interface and optimized code

* Interface using @bainternet's [Admin Page Class](https://github.com/bainternet/Admin-Page-Class)
 
* Coded after one year of learning at [WordPress Stack Exchange](http://wordpress.stackexchange.com/users/12615/brasofilo)

**Version 1.0.3**

* New feature: hide plugin actions, for achieving an extreme slim plugin page

* New feature: add image dimensions to Media Upload window (see this [WordPress Answers](http://wordpress.stackexchange.com/a/51165/12615))

* New feature: Duplicate and Delete Revisions available in Quick Edit for posts and pages

* Improvement: started to add basic Multisite support (inactive plugins colors - has to be enabled in the main site)

* Improvement: hide general plugin notices will be replaced with specific plugin notices (at first, BackupBuddy and Analytics360º notices are available for removal, please report other plugin notices you wish to hide)

**Version 1.0.2**

* Bug fix: corrected incompatibility with PHP versions prior to 5.3

**Version 1.0.1**

* Bug fix: developer section not loading

**Version 1.0**

* Remake of the interface
* Revised code
* Lots of new features

**Version 0.9.4**

* Bug fix: finally fixed html escaping... sorry for the mistake in 0.9.3
* Bug fix: login error message does not accept html code as stated before. Fixed html escaping.
* Improvement: select the roles capable of viewing the site when in Maintenance Mode.
* Improvement: new system for the Custom Maintenance Mode, full instructions in plugin page.
* Improvement: more options to customize the Profile page

**Version 0.9.3**

* Maintenance Mode readjustment, now the second line serves as a link, so you can use it like this: 'Meanwhile, visit us in this url...'
* correction of 'Disable self ping' that had a typo and wasn't working properly
* Custom Dashboard's now works, it was lacking html character escaping
* Help texts completed
* Portuguese and Spanish localizations are now complete

**Version 0.9.2**

* Maintenance Mode now works correctly on a site under MultiSite (it's not a global MM)
* Hope the version numbering goes correct...

**Version 0.9b**

* correction of minor bug in checkbox interface

**Version 0.9**

* adjusted checkbox interface
* Spanish localization

**Version 0.8**

* fixes on the readme.txt and plugin logo

**Version 0.7**

* Plugin launch. Technically fully functional. 
* To do: review code comments, translate some comments and var names to English 
 (right now it's mixed EN/PT/ES), few help texts to complete, Portuguese_BR translation incomplete, 
 Spanish translation not done yet.

== Upgrade Notice ==

= 2.0 =
Complete remake, interface and code. New features, fully tested with 3.5. Basic Multisite capabilities.

