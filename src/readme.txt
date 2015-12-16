=== SQweb for WordPress ===
Contributors: plavaux, nverdonc, bastienbotella
Tags: paywall, subscription, adblock, analytics
Requires at least: 3.6
Tested up to: 4.4
Stable tag: 1.2.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.en.html

This plugin enables you to easily install SQweb, a friendly subscription system, on your WordPress powered site.

== Description ==

[SQweb]("https://www.sqweb.com") is a subscription to access the premium ad free version of all partner websites. Every partner publisher has a plugin to identify SQweb users and to manage ads display. The subscription is shared between visited websites, on a time based ratio.

The SQweb plugin also detects Adblock users, so that you can target blockers and non blockers, and show them the message(s) of your choice.

== Installation ==

1. Upload the plugin to the '/wp-content/plugins/' directory, or download it through the official WordPress plugin repository.
2. Activate the plugin via the 'Plugins' menu in WordPress.
3. If you don't already have one, create an account on SQweb. Then, login via the SQweb interface.
4. Add your website, and customise your preferences.
5. Add the widget or shortcode on your site (ref: A brief Markdown Example).

That's it! If it doesn't work, contact us at hello@sqweb.com and we'll be in touch as soon as possible.

== Frequently asked questions ==

= How much does SQweb cost ? =
SQweb is free for publishers. Users pay 9€ per month, with an early adopter price of 2€.

= How do users register ? =
With the SQweb, button they can login and subscribe without leaving your website.

= How much will i earn ? =
We believe the RPM will be two to three times greater than regular advertisement.

= Do I have to change my advertising solution ? =
No, SQweb lets you to keep your current adverting network(s). We're compatible with networks such as Adsense and Criteo.

== Changelog ==

= 1.2.2 =

* Added new post meta filter.
* Fixed misleading wording in the signup process.
* Minor optimizations.

= 1.2.1 =

Fixed PHP compatibility regression.

= 1.2.0 =

* Refactored curl calls to use the WordPress HTTP API instead.
* Major performance improvements.
* Changed file naming to be WordPress compliant.
* Fixed broken link.
* Fixed license in headers.
* Added WordPress version check.
* Added configation shortcut.
* Added debug mode.

= 1.1.3 =

* Improved handling of advertising blocks.
* Improved curl behavior.

= 1.1.2 =

Improved custom message handling.

= 1.1.1 =

Improved script loading method.

= 1.1.0 =

Bugfix (sign up bug for new users.).

= 1.0.9 =
* Fixed curl response error.
* Fixed missing include with some WordPress installations.

= 1.0.8 =
Added manual language selection and targeting option.

= 1.0.7 =
Added support for modal translation.

= 1.0.6 =
Fixed a bug that prevented the button from showing if a token was missing.

= 1.0.5 =
* Compatibility checks improvements (PHP version + CURL).
* Code cleanup.

= 1.0.4 =
* Code cleanup.
* Readme Improvements.

= 1.0.3 =
Initial Public Release.

= 1.0.2 =
Fixed Trench translations.

== Upgrade notice ==

= 1.2.2 =

Improved filtering options.

= 1.2.1 =

Fixed PHP compatibility regression.

= 1.2.0 =

This is a major update (improved performance and handling of remote calls).

= 1.1.3 =

Improved handling of advertising blocks and curl behavior.

= 1.1.2 =

Improved custom message handling.

= v1.1.1 =

Improved script loading method.

= 1.1.0 =

This version fixes a sign up bug for new users.

= 1.0.9 =

This version fixes a blocking bug that happened with some WordPress installations.

= 1.0.8 =

Added manual language selection, and targeting option.

= 1.0.7 =
Added support for modal translation.

= 1.0.6 =
This version fixes a critical bug with the button.

= 1.0.5 =
This version improves the compatibility checks (PHP version + CURL).

= 1.0.4 =
This version includes a significant cleanup of the plugin.

== Using the Plugin ==

= The Shortcode Way =
`[sqweb_button]`

= The Manual Way =
`
$wsid = get_option( 'wsid' );
if ( !sqweb_check_credentials( $wsid ) > 0 ) {
	echo "ads";
} else {
	echo "content";
}
`

== Privacy Policy ==

Your privacy is critically important to us. At SQweb we have a few fundamental principles:

* We don't ask for personal information unless we truly need it ;
* We don't store personal information on our servers unless required for the on-going operation of one of our services ;
* We don't share personal information with anyone except to comply with the law, develop our products, or protect our rights.
The gathering and processing of information operated by SQweb has been declared to the CNIL (N° 1877571).

For more information, please see our full [Privacy Policy](https://www.sqweb.com/privacy).

== Translations ==

* English
* French