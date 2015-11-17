<?php
/**
Plugin Name: SQweb
Plugin URI: https://www.sqweb.com/
Description: Earn money with user subscriptions instead of advertising. Solution to adblocking (detection included).
Version: 1.0.5
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

	if ( version_compare( phpversion(), '5.2.17', '<') ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		echo '<div class="error"><p><b>Error : </b>You are using an unsupported version of PHP (' . phpversion() . '). The SQweb plugin cannot be activated.</p></div>';
	}

	if ( ! function_exists('curl_version') ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		echo '<div class="error"><p><b>Error : </b>SQweb requires the curl extension, which is currently disabled or missing from your system. The SQweb plugin cannot be activated.</p></div>';
	}
}

add_action( 'admin_init', 'check' );

// Including classes and dependencies files.
require_once( 'config.php' );
require_once( 'class/build-script.class.php' );
require_once( 'class/widget-sqweb-button.class.php' );
require_once( 'class/sqweb-ad-control.class.php' );
require_once( 'functions.php' );
require_once( 'shortcode-function.php' );
require_once( 'sqweb-init.php' );