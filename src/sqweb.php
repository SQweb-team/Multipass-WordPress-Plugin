<?php
/**
Plugin Name: Multipass
Plugin URI: https://www.multipass.net/
Description: Earn money with user subscriptions instead of advertising. Set up a simple universal subscription on your site with just a few clicks.
Version: 2.9.3
Author: Multipass
Author URI: https://www.multipass.net
Text Domain: sqweb
Domain Path: /languages
License: GPL3
 */

/**
 * Ensure compatibility with all installs of WordPress.
 * https://core.trac.wordpress.org/changeset/15452
 */

global $wp_version;
if ( isset( $wp_version ) && $wp_version < 4 ) {
	require_once ABSPATH . 'wp-includes/pluggable.php';
}

load_plugin_textdomain( 'sqweb', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Short description translation.
 */

__( 'Earn money with user subscriptions instead of advertising. Set up a simple universal subscription on your site with just a few clicks.', 'sqweb' );

function sqw_install() {
	sqw_send_data( 'enabled' );
	if ( function_exists( 'wp_cache_clear_cache' ) ) {
		wp_cache_clear_cache();
	}
	if ( ! wp_next_scheduled( 'sqweb_daily_event' ) ) {
		wp_schedule_event( time(), 'daily', 'sqweb_daily_event' );
	}
	$content = '<?php

return array(
	\'wsid\' => ' . ( get_option( 'wsid' ) != false ? get_option( 'wsid' ) : 0 ) . ',
	\'filter.ads\' => \'YTowOnt9\',
	\'filter.text\' => \'YTowOnt9\',
);
';
	file_put_contents( plugin_dir_path( __FILE__ ) . 'sqweb-config.php', $content );
	global $wp_cache_mfunc_enabled, $cache_enabled, $super_cache_enabled;
	if ( $cache_enabled && $super_cache_enabled ) {
		/** Install plugins on WP Super Cache */
		$file = file_get_contents( plugin_dir_path( __FILE__ ) . 'plugins/wp-super-cache.php' );
		file_put_contents( plugin_dir_path( __FILE__ ) . '/wp-super-cache/plugins/sqweb.php', $file );
	}
}

function sqw_deactivation() {
	sqw_send_data( 'disabled' );
	wp_clear_scheduled_hook( 'sqweb_daily_event' );
}

function sqw_notice_install() {
	?>
	<div class="notice notice-success is-dismissible">
		<p><?php _e( '<b>SQweb notice : </b>You need to log in to use SQweb. <a href="admin.php?page=SQwebAdmin">Click here to proceed</a>.', 'sqweb' ); ?></p>
	</div>
	<?php
}

if ( ! get_option( 'wsid' ) ) {
	add_action( 'admin_notices', 'sqw_notice_install' );
}

register_activation_hook( __FILE__, 'sqw_install' );
register_deactivation_hook( __FILE__, 'sqw_deactivation' );

/**
 * Check curl install
 */
function check() {

	if ( version_compare( phpversion(), '5.3.29', '<' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		echo '<div class="error"><p><b>Error : </b>You are using an unsupported version of PHP (' . phpversion() . '). The SQweb plugin cannot be activated.</p></div>';
	}

	if ( ! function_exists( 'curl_version' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		_e( '<div class="error"><p><b>Error : </b>SQweb requires the curl extension, which is currently disabled or missing on your server. The SQweb plugin cannot be activated.</p></div>', 'sqweb' );
	}

	if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		_e( '<div class="error"><p><b>Error : </b>SQweb requires WordPress 3.6 or greater. The SQweb plugin cannot be activated.</p></div>', 'sqweb' );
	}
}

add_action( 'admin_init', 'check' );

/**
 * Add settings option in plugins panel
 */

function add_action_links_sqweb( $links ) {
	$mylinks = array(
		'<a href="' . admin_url( 'admin.php?page=SQwebAdmin' ) . '">' . __( 'Settings', 'sqweb' ) . '</a>',
	);
	return array_merge( $links, $mylinks );
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'add_action_links_sqweb' );

// Compatibility with WP_Rocket
add_filter( 'rocket_cache_reject_cookies', 'compatibility_wp_rocket' );

function compatibility_wp_rocket( $cookies ) {
	$cookies[] = 'sqw_z';
	return $cookies;
}

// Including classes and dependencies files.
require_once 'config.php';
require_once 'class/class-sqweb-auto-config.php';
require_once 'sqweb-admin.php';
require_once 'class/class-sqweb-build-script.php';
require_once 'class/class-sqweb-widget-button.php';
require_once 'functions.php';
require_once 'shortcode-function.php';

function pmpro_remove_ads() {
	global $pmpro_display_ads;
	if ( 1 == $pmpro_display_ads ) {
		$pmpro_display_ads = 0;
	}
}

// Compatibility with Paid Membership Pro
if ( shortcode_exists( 'membership' ) ) {
	require_once 'plugins/paidmembership.php';
	if ( apply_filters( 'sqw_check_credentials', get_option( 'wsid' ) ) ) {
		add_action( 'set_current_user', 'pmpro_remove_ads' );
		add_action( 'init', 'pmpro_remove_ads' );
	}
}

require_once 'includes/sqweb-filter.php';
require_once 'sqweb-init.php';
require_once 'sqweb-wsc-filter.php';
require_once 'class/class-sqweb-ad-control.php';

// Compatibility with Adrotate
if ( function_exists( 'adrotate_ad' ) ) {
	$return_register_widget = function() {
		return register_widget( 'AdrotateWidgetsSqwCompatibility' );
	};
	require_once 'plugins/adrotate-widget.php';
	require_once 'plugins/adrotate-shortcode.php';
	remove_shortcode( 'adrotate', 'adrotate_shortcode' );
	add_shortcode( 'adrotate', 'adrotate_shortcode_sqw_compatibility' );
	add_action( 'widgets_init', $return_register_widget );
}


/*
	Ignore class and variable name of other plugins.
 */
function compatibility_easy_adsense() {
	//Compatibility easy adsense
	//disable ads in ezAdsense
	// @codingStandardsIgnoreStart
	if ( class_exists( 'ezAdSense' ) ) {
		if ( apply_filters( 'sqw_check_credentials', get_option('wsid') ) ) {
			global $ezCount, $urCount;
			$ezCount = 100;
			$urCount = 100;
		}
	}
	//disable ads in Easy Adsense (newer versions)
	if ( class_exists( 'EzAdSense' ) ) {
		if ( apply_filters( 'sqw_check_credentials', get_option('wsid') ) ) {
			global $ezAdSense;
			$ezAdSense->ezCount = 100;
			$ezAdSense->urCount = 100;
		}
	}
	// @codingStandardsIgnoreEnd
}

add_action( 'set_current_user', 'compatibility_easy_adsense' );
add_action( 'init', 'compatibility_easy_adsense' );

/*
	Compatibility with Cache Enabler
*/

function compatibility_cache_enabler() {
	return ( apply_filters( 'sqw_check_credentials', get_option( 'wsid' ) ) );
}

add_filter( 'bypass_cache', 'compatibility_cache_enabler' );
