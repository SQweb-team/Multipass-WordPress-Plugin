=== Multipass for WordPress ===
Contributors: plavaux, nverdonc, bastienbotella, matdarr
Tags: paywall, subscription, analytics, support
Requires at least: 3.6
Tested up to: 4.9.4
Stable tag: 2.9.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.en.html

The friendly alternative to paywalls. Set up a simple universal subscription on your site with just a few clicks.

== Description ==

**[Multipass]("https://www.multipass.net") makes it easy to earn money from your readers, rather than ads.**

With Multipass you can:

- **Set up a simple subscription system, and/or paywall**, so that your readers can access the ad-free version of your site, and premium content if you have any.

Our plugin allows you to be fully set up within minutes. All Multipass users will then be able to enjoy the premium version of your website.

Multipass-enabled websites need this plugin to manage the display of ads and premium content. Installing the plugin is also required for subscribers signin, signup and tracking.

Their monthly subscriptions are then shared between visited websites, on a time based ratio.

For more information, see the **Frequently Asked Questions**.

If you'd like to talk to us, leave us a note at hello@sqweb.com and we'll be in touch!

== Installation ==

1. Upload the plugin to the '/wp-content/plugins/' directory, or download it through the official WordPress plugin repository.
2. Activate the plugin via the 'Plugins' menu. You will be prompted to login on Multipass, with the option to create an account if you need to.
3. Add your website, and customize the preferences to your liking.
4. Add the widget or shortcode on your site :

= The Shortcode Way =
`[sqweb_button]`

You can specify the button's type with :
`[sqweb_button type="TYPE"]`

TYPE can be : tiny, slim, normal, large or free.

= The Manual Way =

In your theme, to display the button, add the following :

`<?php do_shortcode('[sqweb_button]') ?>`

You can specify the button's type with :
`<?php do_shortcode('[sqweb_button type="TYPE"]') ?>`

TYPE can be : tiny, slim, normal, large.

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

You can also use this shortcode:

`[sqweb_add_filter ads="YOUR ADVERTISEMENT CODE HERE"]`
or
`<?php do_shortcode('[sqweb_add_filter ads="YOUR ADVERTISEMENT CODE HERE"]') ?>`

Warning: if you have a `]` in your advertisement tag, you have to replace it with it's html code i.e: `&#093;` or else the shortcode will not work.

Add a premium argument to this shortcode to display something in the place of the advertising block, this is optionnal.
i.e:

`[sqweb_add_filter ads="YOUR ADVERTISEMENT CODE HERE" premium="SOMETHING TO REPLACE THE AD WITH"]`
or
`<?php do_shortcode('[sqweb_add_filter ads="YOUR ADVERTISEMENT CODE HERE" premium="SOMETHING TO REPLACE THE AD WITH"]') ?>`

= Using this plugin with a cache plug-in =

At the moment we are compatible with W3 Total Cache, to use it with Multipass, you need to go to W3 Total Cache settings under cookie groups panel. Then create a groupe with and write sqw_z in the Cookies textarea.

= Using this plugin with a load-balancer or a reverse proxy =

Please make sure that you're forwarding client IPs properly. A detailed thread with example configurations is available [here]("https://core.trac.wordpress.org/ticket/9235").

If you need any help, email us at hello@sqweb.com and one of our engineers will check your configuration with you.

= Change box displayed by Multipass on paywall =

You can add in your theme on function.php a filter to edit the box displayed by Multipass paywall

Example to add content after box:
`
function box_sqweb( $content ) {
    return $content . 'I add my content';
}

add_filter( 'sqw_msg_restrict_cut_art_perc', 'box_sqweb' );
`

`
function box_sqweb( $content ) {
    return $content . 'I add my content';
}

add_filter( 'sqw_msg_restrict_art_by_day', 'box_sqweb' );
`

`
function box_sqweb( $content ) {
    return $content . 'I add my content';
}

add_filter( 'sqw_msg_restrict_date_art', 'box_sqweb' );
`

You can also delete the box to create your customized box for your website.

Example to create your own box :
`
function box_sqweb( $content ) {
    return 'I don\'t need the box so I create a customized box';
}

add_filter( 'sqw_msg_restrict_cut_art_perc', 'box_sqweb' );
`

== Frequently asked questions ==

= How much does Multipass cost ? =
Multipass is completely free for publishers and website owners. We're currently offering a special early adopter price of 6,90€ for suscribers, instead of 9€.

= How do users register ? =
Users can register on Multipass without ever leaving your website : when they click on the button, they will be shown a modal window to login or register. They can also register via multipass.net, or any other Multipass-enabled website.

= How much will I earn ? =
Your earnings are based on the time Multipass users spend on your website, rather than individual clicks or impressions. We expect your earnings per subscriber to be 2-3x greater than regular advertisement, because your Multipass users are highly engaged users.

= Do I have to change my advertising solution ? =
You can keep your current adverting setup. We're compatible with AdSense, DoubleClick and Criteo, to name a few.

== Changelog ==

= v2.9.3 =
* Added the free version button

= v2.9.2 =
* Fixed some typo errors.

= v2.9.1 =
* Fixed a crash occuring when Wordpress Super Cache was installed.
* Updated the readme on how to install W3 Total Cache along with Multipass.

= v2.9.0 =
* Improved the way we log actions with the support button

= v2.8.9 =
* Fixed Support us message not disapearing once logged in if it was displayed via the shortcode

= v2.8.8 =
* Implemented a shortcode to display the "Support us" message

= v2.8.7 =
* Fixed iframe sometimes not appearing

= v2.8.6 =
* Improved the compatibility of the "Support us" display

= v2.8.5 =
* Support message is not displayed anymore on a locked article

= v2.8.4 =
* Renamed plugin from SQweb to Multipass.

= v2.8.3 =
* Improved the method injecting our script.

= v2.8.2 =
* Added missing localizations.

= v2.8.1 =
* Fixed a variable bug.

= v2.8.0 =
* Improved the way the script is built
* Improved auto login feature

= v2.7.8 =
* Now passing event when opening iframe to get CTA logs

= v2.7.7 =
* Fixed a bug when trying to lock a specific article while he was not in archive day range

= v2.7.6 =
* Add a way to customize all Multipass buttons
* Coding style

= v2.7.5 =
* Restore the option to chose the plugin language
* You can now use the "Support Us" button with restictions options, the support us button will appears on pages without restrictions.

= v2.7.4 =
* Add an option to enable php to be parsed in text widgets, hence in theme template.

= v2.7.3 =
* Add an option to display a supportive button at the end of an article.

= v2.7.2 =
* Add a new style for the locked article button.

= v2.7.1 =
* Add a new shortcode to enhance ads filtering in themes.

= v2.7.0 =
* Check whether WSID is defined in wp_options.
* Add a link to diagnostic feature once logged in.
* Improve the diagnostic feature: it now send data about which plugin is active and what is your PHP version.
* Add an archive feature (lock content after X day(s)).

= v2.6.3 =
* Administrator and editors will not be blocked by Multipass anymore.
* Improve the diagnostic feature to send informations about the website's header and check if your website can access to our API.

= v2.6.2 =
* Add an option to filter all articles at once.

= v2.6.1 =
* Improve database and scheduled task management.

= v2.6.0 =
* Introduce diagnostic feature.

= v2.5.2 =
* Add dynamic popup option.

= v2.5.1 =
* Fixed missing semicolon.

= v2.5.0 =
* Fixed a typo
* Coding style

= v2.4.9 =
* Fixed broken release.

= v2.4.8 =
* Update visual button on admin.

= v2.4.7 =
* Improve comment.
* Fix check variable set.

= v2.4.6 =
* Add new version of button.
* Clean widget code.

= v2.4.5 =
* Compatibility with WordPress 4.7.

= v2.4.4 =
* Add translation of plugin description.
* Add option to display a tiny Multipass button.
* Add visual change of lang in SQweb admin.
* Add site name variable in JS.
* Now compatible with Cache Enabler.
* Now compatible with W3 Super Cache v0.9.5.1.
* Fixed a bug making previous installs of W3TC break ads management.
* Updated notice message when signing in and signing up.
* Add a default message for adblockers.

= v2.4.3 =
* Fix CSS include.

= v2.4.2 =
* Compatibility with Easy Adsense.
* Compatibility with Ads filter Paid membership Pro.

= v2.4.1 =
* Add condition for requiere Pluggable file.
* Fix lang selector.

= v2.4.0 =
* Updated SQweb script URL (now HTTPS only).
* Fix API Connexion with special char.

= v2.3.9 =
* Compatibility with WP Rocket.

= v2.3.8 =
* Fixed error on plugin activation when WordPress Super Cache is missing.

= v2.3.7 =
* Change design Multipass button.

= v2.3.6 =
* Add customized box.
* Improved compatibility with Paid Membership Pro.

= v2.3.5 =
* Reset sqweb-config.php.

= v2.3.4 =
* Ability to schedule public availability for premium content.
* Improved compatibility with Paid Membership Pro.

= v2.3.3 =
* Fix Missing function exists.

= v2.3.2 =
* Add excludes according to WordPress user role from SQweb panel.
* Compatibility with Paid Membership Pro.
* Improve compatibility with others plugin via filters.

= v2.3.1 =
* Fixed broken release process.

= v2.3.0 =
* Compatibility with Adrotate plugin.
* Fixed transpartext offset error.

= v2.2.4 =
* Added option to enforce limits on selected articles.
* Added reset button to reset plugin configuration.
* Added automatic caching configuration option.
* Improved compatibility with W3 Total Cache and Wordpress Super Cache.
* Updated readme with load-balancers/reverse proxies configuration notes.
* Major code cleanup and performance improvements.

= v2.2.3 =
* Internal Release.

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

= v2.6.0 =
A new button is now displayed under the login / registration button to send a full diagnostic about your website to our support team.

= v2.2.4 =
A new button has appeared on the bottom of SQweb plugin, if a bug appared when you used SQweb, try use it, if don't work, contact us.

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

**A note about the diagnostic feature:**

A diagnostic feature is available in the plugin, which performs a number of checks for our support team.

The following information is gathered when running a diagnostic:

- Website name
- WordPress version
- PHP version
- Website URL
- Admin email
- Template URL
- Server information (`$_SERVER['SERVER_SOFTWARE']` and `$_SERVER['SERVER_SIGNATURE']`, if available)
- List of installed plugins + activation status

The diagnostic also performs connectivity checks to ensure that a connection to our API (required for the proper operation of this plugin) is possible.

== Translations ==

* English
* French
