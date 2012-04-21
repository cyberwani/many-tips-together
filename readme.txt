=== Many Tips Together ===
Tags: customize admin, web tips, maintenance mode, profile, login, logout 
Requires at least: 3.1
Tested up to: 3.4-beta2
Stable tag: 1.0
Contributors: brasofilo

Do you like to adjust and style the backend as much as the frontend?
So, we are together!

== Description ==
This plugin is a compilation of lots of tips for enhancing, styling and reducing WordPress backend. Some are present in some plugins, some are not. Usually we put them in our functions.php, but if you handle many WordPress installations then better plugged then themed.

The interface, although loaded, is pretty straigh forward: choose the section and select your customizations. 
The tips came from a variety of sources and are documented, whenever due, in the help sections.

> Upgrading to version 1.0 - *Unfortunately your previous settings will be lost, please take note of them before updating the plugin. This won't happen again, sorry for the inconvenience*.

= Features =
* Customize Login Screen
* Admin Bar - remove and add items
* Dashboard - remove and add widgets
* Admin Menus - remove menu items
* Posts - rename the word "Posts" in (almost) all WordPress interface
* Posts and Pages listings - customize rows and columns
* Widgets - remove default widgets
* Customize User Profile page
* Maintenance Mode - with minimum Role allowed and possibility to block only the backend
* some other goodies in Post/Page editing, Media Library, Site E-mail, WordPress behavior, Header and Footer, 3 handy Shortcodes 

= Screencast =
[youtube htpp]

= Localizations =
Portuguese, Spanish

== Installation ==
1. Upload `many-tips-together.zip` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the *Plugins* menu in WordPress.
3. Go to *Settings -> Many Tips Together* and configure the plugin.

= Uninstall =
The 'reset' button doesn't delete the database entry, but if you delete the plugin, the entry will be deleted (via unsinstall.php)

== Frequently Asked Questions ==
= Doubts, bugs, suggestions =
Don't hesitate in posting a new topic here in [WordPress support forum](http://wordpress.org/tags/many-tips-together?forum_id=10).


== Screenshots ==
1. Viewing all options, with some demo settings, and help texts not visible

== Changelog ==
**Version 1.0**
* Remake of the interface, better organization, revised code
* Improvement: select the roles capable of viewing the site when in Maintenance Mode.
* Improvement: maintenance mode now blocks admin area for selected roles
* Improvement: more options to customize the Profile page
* New feature: Admin Bar customization
* New feature: Post/Page listing options
* New feature: Rename the word "Posts" to whatever you want
* New feature: Shortcodes : YouTube full window popup - SoundCloud official shortcode - Google Docs document viewer  

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

* Plugin launch. Technicaly fully functional. To do: review code comments, translate some comments and var names to English (right now it's mixed EN/PT/ES), few help texts to complete, Portuguese_BR translation incomplete, Spanish translation not done yet.