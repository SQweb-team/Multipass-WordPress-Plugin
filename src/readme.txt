=== SQweb for WordPress ===
Contributors: plavaux, nverdonc, bastienbotella
Tags: paywall, subscription, adblock, analytics
Requires at least: 3.6
Tested up to: 4.5.2
Stable tag: 2.2.4
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

In your theme, to display the button, add the following :

`do_shortcode('sqweb_button')`

To manage your advertisement blocks, use the following function :

`
<?php
	SQweb_filter::get_instance()->add_ads('YOUR ADVERTISEMENT CODE HERE');
?>
`

Replace 'YOUR ADVERTISEMENT CODE HERE' with your code.

If you wish to show extra content to your subscribers, you can add a second parameter like so :

`
<?php
	SQweb_filter::get_instance()->add_ads('YOUR ADVERTISEMENT CODE HERE', 'YOUR SUBSCRIBER CONTENT HERE');
?>
`

**If you're using WordPress Super Cache, you must enable "Dynamic Content" under "Advanced Settings".** Also, if you used 'mod_rewrite' with WordPress Super Cache, make sure to comment the rules in your '.htaccess' file.

If it doesn't work, contact us at hello@sqweb.com and we'll be in touch as soon as possible.

= Personnalize Paywall button =

Since 2.2.4 you can personnalize Paywall button for corresponding with your website
You need to use the css class
`
sqw-paywall-button-container
`
For personnalize the div contain button and
`
sqw-paywall-button
`
for the button.

= Using this plugin with a load-balancer or a reverse proxy =

Please make sure that you're forwarding client IPs properly. A detailed thread with example configurations is available [here]("https://core.trac.wordpress.org/ticket/9235").

If you need any help, email us at hello@sqweb.com and one of our engineers will check your configuration with you.


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

= v2.2.4 =
* Add support for personnalize the paywall button.
* Add ability to enforce limits on specific articles only.
* Cleaned the code to make it easier to understand.
* Improve compatibility with W3 Total Cache and Wordpress Super Cache.
* Optimise the code for improve performance when website don't use all fonctionnality of SQweb and Multipass.
* Add reset button for reset configuration of SQweb.
* Add autoconfig plugin, now you can autorize SQweb to configure automatically your cache plugin.

= v2.2.3 =
* Updated readme with load-balancers/reverse proxies configuration.

= v2.2.2 =
* Improved installation instructions.
* Updated root certificates.

= v2.2.1 =
* Fixed WordPress route rewriting.

= v2.2.0 =
* Removed usage of late init on Wordpress Super Cache.
* Resolved issue when checking subscribers' credentials.

= v2.1.0 =
* Add compatibility with W3TC.
* Changed storage method, allowing for the removal of late init on Wordpress Super Cache.

= v2.0.1 =
* Improve usage of late init on Wordpress Super Cache.
* Improve detection of Wordpress Super Cache.

= v2.0.0 =
* New design.
* Improve UX.
* Improve compatibility with Wordpress Super Cache.

= v1.8.1 =
* Fixed regression with older PHP versions, due to modern array syntax.

= v1.8.0 =
* Add compatibility with Wordpress Super Cache plugin.
* Improve ads display method.
* WordPress 4.5 compatibility.
* Improved translation.

= v1.7.0 =
* Fixed bad config for existing users.
* Fixed no error message when failing connection.
* Improved users experience.

= v1.6.0 =
* Fixed template.
* Fixed including unused CSS.

= v1.5.2 =
* Improved translation.

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

= v2.2.4 =
A new button as appared on the bottom of SQweb plugin, if a bug appared when you used SQweb, try use it, if don't work, contact us.

= v2.1.0 =
If you previously used SQweb with WordPress Super Cache, you must delete sqweb.php in the plugins directory of WP Super Cache.

= v2.0.0 =
Completly new design with quicker setup. Improved compatibility with Wordpress Super Cache.

= v1.5.1 =
Improved end of the installation guidance.

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
