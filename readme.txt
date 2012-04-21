=== Many Tips Together ===
Tags: customize admin, web tips, maintenance mode, profile, login, logout 
Requires at least: 3.1
Tested up to: 3.2.1
Stable tag: 0.9.4
Contributors: brasofilo

This plugin compiles many administrative customization tips in one simple interface.

== Description ==
There are lots of little administrative customization tips that are spread in many web tutorials, and some of them (not most, neither all) are included in other plugins.

All the hooks are simple and could be inserted in the theme's functions.php, but if you're always swapping themes or managing lot's of sites, well, this is what a plugin is for...

= Features =
* Customize Login Page
* Maintenance Mode with custom html/css/title/description
* Modify and hide Profile information
* Redirect on Logout
* Block update notices (WP/Plugins)
* Block WP 'phone home'
* Set Revisions number
* Set Autosave interval
* Disable Admin Bar globally
* Disable SmartQuotes, CapitalP, AutoP, SelfPing, WP Version

= Localizations =
Portuguese, Spanish

== Installation ==
1. Upload `many-tips-together.zip` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the *Plugins* menu in WordPress.
3. Go to your *Settings* control panel and configure the plugin.

= Uninstall =
The 'reset' button doesn't delete the database entry, but if you delete the plugin, the entry will be deleted (via unsinstall.php)

== Frequently Asked Questions ==
= Do I need this plugin? =
No. You can just copy/paste the functions_basic.php into your functions.php, or do a basic plugin without interface using those functions and everything will work.

= So, what is it for? =
If you swap themes constantly or manage lots of WP sites you'll probably be thankful for being able to adjust all these small and hidden settings at once, in a fast move.

= I can't find the functions_basic.php file =

Sorry, it's not ready yet. It will be on final version. 

== Screenshots ==
1. Viewing all options, with some demo settings, and help texts not visible

== Changelog ==
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
* To do: rewrite the code more elegantly and MultiSite suppport

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