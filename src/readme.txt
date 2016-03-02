=== SQweb for WordPress ===
Contributors: plavaux, nverdonc, bastienbotella
Tags: paywall, subscription, adblock, analytics
Requires at least: 3.6
Tested up to: 4.4
Stable tag: 1.6.0
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.en.html

The friendly alternative to adblock and paywalls. Set up a simple universal subscription on your site with just a few clicks.

== Description ==

**[SQweb]("https://www.sqweb.com") makes it easy to earn money from your readers, rather than ads.**

With SQweb you can:

- **Find out how much revenue you're losing from adblocking**, with detailed analytics per browser and device ;
- **Detect adblockers and show them the message of your choice**, to tell them that you're offering an alternative ;
- **Set up a simple subscription system, and/or paywall**, so that your readers can access the ad-free version of your site, and premium content if you have any.

Our plugin allows you to be fully set up within minutes. All SQweb users will then be able to enjoy the premium version of your website.

SQweb-enabled websites need this plugin to manage the display of ads and premium content. Installing the plugin is also required for subscribers signin, signup and tracking.

Their monthly subscriptions are then shared between visited websites, on a time based ratio.

For more information, see the **Frequently Asked Questions**.

If you'd like to talk to us, leave us a note at hello@sqweb.com and we'll be in touch!

== Installation ==

1. Upload the plugin to the '/wp-content/plugins/' directory, or download it through the official WordPress plugin repository.
2. Activate the plugin via the 'Plugins' menu. You will be prompted to login on SQweb, with the option to create an account if you need to.
3. Add your website, and customize the preferences to your liking.
4. Add the widget or shortcode on your site :

= The Shortcode Way =
`[sqweb_button]`

= The Manual Way =

In your theme, add the following :

`do_shortcode('sqweb_button')`

`
if (function_exists('sqweb_check_credentials')) {
	$wsid = get_option( 'wsid' );
	if ( !sqweb_check_credentials( $wsid ) > 0 ) {
		// ADS
	} else {
		// PREMIUM CONTENT
	}
}
`

If it doesn't work, contact us at hello@sqweb.com and we'll be in touch as soon as possible.

== Frequently asked questions ==

= How much does SQweb cost ? =
SQweb is completely free for publishers and website owners. We're currently offering a special early adopter price of 2€ for suscribers, instead of 9€.

= How do users register ? =
Users can register on SQweb without ever leaving your website : when they click on the button, they will be shown a modal window to login or register. They can also register via SQweb.com, or any other SQweb-enabled website.

= How much will I earn ? =
Your earnings are based on the time SQwebers spend on your website, rather than individual clicks or impressions. We expect your earnings per subscriber to be 2-3x greater than regular advertisement, because your SQwebers are highly engaged users.

= Do I have to change my advertising solution ? =
You can keep your current adverting setup. We're compatible with AdSense, DoubleClick and Criteo, to name a few.

== Changelog ==

= v1.6.0 =
* Fixed template.
* Fixed including unused CSS.

= v1.5.2 =
* Improved traduction.

= v1.5.1 =
* Improved end of the installation guidance.

= v1.5.0 =
* Major overhaul of the configuration panel.
* Introduced new options, including a fully customizable paywall.

= v1.4.2 =
Fixed permanent admin connection (again).

= v1.4.1 =
Fixed permanent admin connection.

= v1.4.0 =

* Improved the installation and activation notice.
* Improved the French translation.
* Misc. UI improvements.
* Significant refactoring of internal functions.

= 1.3.3 =

* Fixed PHP compatibility regression.
* Improved Readme.
* Added banner for WordPress.org listing.

= 1.3.2 =

Hotfix : Fixed PHP compatibility regression.

= 1.3.1 =

Hotfix : PHP < 5.5 compatibility.

= 1.3.0 =

* Permanent backoffice login.
* Included up-to-date SSL certificates.
* Updated timeout threshold.
* Introduced unit tests.

= 1.2.3 =

Bugfix (timeout) and documentation update.

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

= v1.5.1 =
* Improved end of the installation guidance.

= v1.5.0 =
Major overhaul of the configuration panel. Introduced new options, including a fully customizable paywall.

= v1.4.2 =
Fixed admin connection.

= v1.4.1 =

Admins no longer have to re-connect to update the settings in the back office.

= 1.4.0 =

This version includes general improvements (UI, translation) and a significant code refactoring.

= 1.3.3 =

This version fixes a regression with older PHP installations, and ships with a better description of the plugin.

= 1.3.2 =

This version fixes a regression with older PHP installations.

= 1.3.1 =

This version fixes a regression with older PHP installations.

= 1.3.0 =

Permanent backoffice login and longer timeout threshold.

= 1.2.3 =

Bugfix (timeout) and documentation update.

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