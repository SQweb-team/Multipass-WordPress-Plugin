=== SQweb ===
Contributors: SQweb
Tags: adblock, advertising, adsense, publicité, subscription, inscription
Requires at least: 3.9.8
Tested up to: 4.3.1
Stable Tag: 1.0.3
License: GPLv3

Make the first step to end the adblocking war, Add SQweb on your website.

== Description ==

	= Make the first step to end the adblocking war with SQweb =

* [SQweb]("https://www.sqweb.com") is a subscription to access the premium ad free version of all partner websites.
* Every partner publisher has a plugin to identify SQweb users and manage ads display.
* The subscription is shared between visited websites, on a time based ratio.
* The SQweb plugin also detects Adblock users and show them the message of your choice.

== Installation ==

* Upload 'sqweb' to the '/wp-content/plugins/' directory.
* Activate the plugin through the 'Plugins' menu in Wordpress.
* If you don't already have one, create an account on sqweb.
* Login you in the SQweb interface.
* Add your website and setup it up.
* Add the widget or shortcode on your site (ref: A brief Markdown Example).
* That's it! If it doesn't work, contact us at hello@sqweb.com.

== Frequently Asked Questions ==

	= How much does SQweb cost ? =
		SQweb is free for publishers. Users pay 9€ per month, with an early adopter price of 2€.

	= How does user register ? =
		With the SQweb button they can login and subscribe without leaving your website.

	= How much will i earn ? =
		We believe the RPM will be two to three times greater than regular advertisement.

	= Do i have to change my advertising solution ? =
		No, SQweb lets you to keep your current adverting network(s). We work with biggest like Adsense and Criteo.

	= Is SQweb the solution to adblocking ? =
		Yes, because you offer your users a fair and educated choice : pay a fair price or start seeing ads again.

== Changelog ==

	1.00 : release.
	1.02 : Add JS Color changer admin and correct french translations.
	1.03 : Remove shortcode ad control

== Upgrade Notice ==

	1.00 : release.

== A brief Markdown Example ==

	= SQweb button shortcode =
`[sqweb_button]`

	= SQweb Ad control php code =
`
	$wsid = get_option( 'wsid' );
    if ( !sqweb_check_credentials( $wsid ) > 0 ) {
        echo "ads";
    } else {
        echo "content";
    }
`

== Translations ==

* English.
* French.
