<?php
/**
Plugin Name: SQweb
Plugin URI: https://www.sqweb.com/
Description: Earn money with user subscriptions instead of advertising. Solution to adblocking (detection included).
Version: 1.1.3
Author: SQweb
Author URI: https://www.sqweb.com
Text Domain: sqweb
License: GPL2
 */

load_plugin_textdomain( 'sqweb', false, dirname( plugin_basename( __FILE__ ) ).'/languages/' );

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
		echo '<div class="error"><p><b>Error : </b>SQweb requires the curl extension, which is currently disabled or missing from your system. The SQweb plugin cannot be activated.</p></div>';
	}

	if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
		deactivate_plugins( __FILE__ );
		if ( isset( $_GET['action'] ) && ( $_GET['action'] == 'activate' || $_GET['action'] == 'error_scrape' ) ) {
			echo '<div class="error"><p><b>Error : </b>SQweb requires Wordpress 3.6 or greater. The SQweb plugin cannot be activated.</p></div>';
		}
	}
}

add_action( 'admin_init', 'check' );

/**
 * Add settings option in plugins panel
 */

function add_action_links_sqweb ( $links ) {
	$mylinks = array(
		'<a href="' . admin_url( 'admin.php?page=SQwebAdmin' ) . '">' . __('Settings', 'sqweb') . '</a>',
	);
	return array_merge( $links, $mylinks );
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_action_links_sqweb' );

/**
 * Ensure compatibility with all installs of WordPress.
 * https://core.trac.wordpress.org/changeset/15452
 */
require_once ABSPATH . 'wp-includes/pluggable.php';

// Including classes and dependencies files.
require_once 'config.php';
require_once 'class/build-script.class.php';
require_once 'class/widget-sqweb-button.class.php';
require_once 'class/sqweb-ad-control.class.php';
require_once 'functions.php';
require_once 'shortcode-function.php';
require_once 'sqweb-init.php';
require_once 'sqweb-filter.php';
