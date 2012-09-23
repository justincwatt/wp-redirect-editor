=== Redirect Editor ===
Contributors: justincwatt
Donate link: http://justinsomnia.org/
Tags: redirect, redirection, 301, 301 redirect, htaccess
Requires at least: 3.0
Tested up to: 3.4.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Centrally edit and manage .htaccess-style 301 redirects.

== Description ==

Unlike more complex plugins for managing redirects, the Redirect Editor gives 
you a simple textarea to edit and manage `.htaccess`-style 301 redirects, one per line.

Enter each redirect rule in the following format, starting with the relative 
path of the requested URL to match, followed by the absolute URL of the 
destination to redirect to, separated by a space.

    /2012/09/old-post/ http://www.example.com/2012/09/new-post/

After installing, go to Settings > Redirect Editor to configure.

== Installation ==

Extract the zip file, drop the contents in your wp-content/plugins/ directory, and then activate from the Plugins page.

== Frequently Asked Questions ==

= Does it support wildcard/regular expression matching? =

No, just simple string matching.

== Screenshots ==

1. That's it, just a textarea.

== Changelog ==
= 1.0 =
* Initial version

== Upgrade Notice ==
= 1.0 =
Initial version