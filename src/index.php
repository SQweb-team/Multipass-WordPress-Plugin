<?php
/**
Plugin Name: SQweb
Plugin URI: https://www.sqweb.com/
Description: Earn money with user subscriptions instead of advertising. Solution to adblocking (detection included).
Version: 1.0.3
Author: SQweb
Author URI: https://www.sqweb.com
Text Domain: sqweb
License: GPL2
 */

load_plugin_textdomain( 'sqweb', false, dirname( plugin_basename( __FILE__ ) ).'/languages/' );

// Including classes and dependencies files.
require_once( 'config.php' );
require_once( 'class/build-script.class.php' );
require_once( 'class/widget-sqweb-button.class.php' );
require_once( 'class/sqweb-ad-control.class.php' );
require_once( 'functions.php' );
require_once( 'shortcode-function.php' );
require_once( 'sqweb-init.php' );
