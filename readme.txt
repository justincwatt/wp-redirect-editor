=== Redirect Editor ===
Contributors: justincwatt, weskoop
Donate link: http://justinsomnia.org/2012/09/redirect-editor-plugin-for-wordpress/
Tags: redirect, redirection, 301, 301 redirect, htaccess
Requires at least: 3.0
Tested up to: 4.2.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Centrally edit and manage .htaccess-style 301 redirects.

== Description ==

Unlike more complex plugins for managing redirects, the Redirect Editor gives 
you a simple textarea to edit and manage `.htaccess`-style 301 redirects, one per line.

Enter each redirect rule in the following format, starting with the 
relative path of the URL to match, followed by the absolute URL of the 
destination to redirect to, separated by a space. Each redirect should 
be on its own line. Blank lines and lines that start with # (hash) are 
ignored and can be used for spacing and comments.

    /2012/09/old-post/ http://www.example.com/2012/09/new-post/

After installing, go to Settings > Redirect Editor to configure.

If you're interested in contributing to the code behind this plugin, it's also hosted on GitHub:
https://github.com/justincwatt/wp-redirect-editor

== Installation ==

Extract the zip file, drop the contents in your wp-content/plugins/ directory, and then activate from the Plugins page.

== Frequently Asked Questions ==

= Does it support wildcard/regular expression matching? =

No, just simple string matching.

== Screenshots ==

1. That's it, just a textarea.

== Changelog ==
= 1.3 =
* Fix CSS error causing redirect lines to all appear on a single line

= 1.2 =
* Minor fix for possible corrupted redirects options

= 1.1 =
* Prevent redirect plugin from running on every query, in the admin, etc (thanks Wes Koop)

= 1.0 =
* Initial version

== Upgrade Notice ==
= 1.3 =
Bug fix

= 1.2 =
Bug fix

= 1.1 =
Performance enchancement

= 1.0 =
Initial version
