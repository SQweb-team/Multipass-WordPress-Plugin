<?php
/**
Plugin Name: SQweb
Plugin URI: https://www.sqweb.com/
Description: Earn money with user subscriptions instead of advertising. Set up a simple universal subscription on your site with just a few clicks. Includes adblock detection and targeting.
Version: 2.3.8
Author: SQweb
Author URI: https://www.sqweb.com
Text Domain: sqweb
Domain Path: /languages
License: GPL3
 */

/**
 * Ensure compatibility with all installs of WordPress.
 * https://core.trac.wordpress.org/changeset/15452
 */
require_once ABSPATH . 'wp-includes/pluggable.php';

load_plugin_textdomain( 'sqweb', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

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
	\'wsid\' => ' . (get_option( 'wsid' ) != false ? get_option( 'wsid' ) : 0) . ',
	\'filter.ads\' => \'YTowOnt9\',
	\'filter.text\' => \'YTowOnt9\',
);
';
	file_put_contents( WP_PLUGIN_DIR . '/sqweb/sqweb-config.php', $content );
	global $wp_cache_mfunc_enabled, $cache_enabled, $super_cache_enabled;
	if ( $cache_enabled && $super_cache_enabled ) {
		/** Install plugins on WP Super Cache */
		$file = file_get_contents( WP_PLUGIN_DIR . '/sqweb/plugins/wp-super-cache.php' );
		file_put_contents( WP_PLUGIN_DIR . '/wp-super-cache/plugins/sqweb.php', $file );
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

	if ( version_compare( phpversion(), '5.2.17', '<' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		echo '<div class="error"><p><b>Error : </b>You are using an unsupported version of PHP (' . phpversion() . '). The SQweb plugin cannot be activated.</p></div>';
	}

	if ( ! function_exists( 'curl_version' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		_e( '<div class="error"><p><b>Error : </b>SQweb requires the curl extension, which is currently disabled or missing on your server. The SQweb plugin cannot be activated.</p></div>', 'sqweb' );
	}

	if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		_e( '<div class="error"><p><b>Error : </b>SQweb requires Wordpress 3.6 or greater. The SQweb plugin cannot be activated.</p></div>', 'sqweb' );
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

// Including classes and dependencies files.
require_once 'config.php';
require_once 'auto-config.php';
require_once 'sqweb-admin.php';
require_once 'class/build-script.class.php';
require_once 'class/widget-sqweb-button.class.php';
require_once 'functions.php';
require_once 'shortcode-function.php';

// Compatibility with Paid Membership Pro
if ( shortcode_exists( 'membership' ) ) {
	require_once 'plugins/paidmembership.php';
}

require_once 'includes/sqweb-filter.php';
require_once 'sqweb-init.php';
require_once 'sqweb-wsc-filter.php';
require_once 'class/sqweb-ad-control.class.php';

// Compatibility with Adrotate
if ( function_exists( 'adrotate_ad' ) ) {
	require_once 'plugins/adrotate-widget.php';
	require_once 'plugins/adrotate-shortcode.php';
	remove_shortcode( 'adrotate', 'adrotate_shortcode' );
	add_shortcode( 'adrotate', 'adrotate_shortcode_sqw_compatibility' );
	add_action( 'widgets_init', create_function( '', 'return register_widget("AdrotateWidgetsSqwCompatibility");' ) );
}
