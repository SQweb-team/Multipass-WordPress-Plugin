<?php

/**
 * Declaring and adding widget
 */
function register_sqweb_ad_control_widget() {
	register_widget( 'sqwebAdControl' );
}

add_action( 'widgets_init', create_function( '', 'return register_widget("sqwebAdControl");' ) );

/**
 * Declaring SQweb Button widget
 */
function register_widget_sqweb_button() {
	register_widget( 'widgetSqwebButton' );
}

add_action( 'widgets_init', create_function( '', 'return register_widget("widgetSqwebButton");' ) );

/**
 * Declaring SQweb Shortcode
 */

add_shortcode( 'sqweb_button', 'sqweb_button_short_code' );

/**
 * Display a notice if the user has not submitted his website or webmaster id
 */
function my_admin_notice() {
	$wmid = (get_option( 'wmid' ) !== '') ? get_option( 'wmid' ) : '';
	$wsid = (get_option( 'wsid' ) !== '') ? get_option( 'wsid' ) : '';
	if ( '' == $wsid || '' == $wmid ) {
		echo '<div class="error"><p><b>Notice : </b>You need to sign in and select your domain in order to use SQweb. <a href="admin.php?page=SQwebAdmin">Click here to proceed</a>.</p></div>';
	}
}
add_action( 'admin_notices', 'my_admin_notice' );

/**
 * Display a notice if the user is running an unsupported version of PHP.
 */
function check_env_phpv() {
	if ( current_user_can( 'install_plugins' ) && version_compare( phpversion(), '5.5.9', '<' ) ) {
		echo '<div class="error"><p><b>Notice : </b>You are using an unsupported version of PHP (' . phpversion() . '). The SQweb plugin may not work as expected.</p></div>';
	}
}
add_action( 'admin_notices', 'check_env_phpv' );

/*
 * Display an error if CURL is missing.
 */
function check_env_curl() {
	if ( current_user_can( 'install_plugins' ) && ! function_exists( 'curl_version' ) ) {
		echo '<div class="error"><p><b>Error : </b>SQweb requires the curl extension, which is currently disabled or missing from your system.</p></div>';
	}
}
add_action( 'admin_notices', 'check_env_curl' );

/**
 * Add the backoffice link to wordpress admin sidebar
 */
function sqweb_register_admin_menu() {
	add_menu_page( 'Manage SQweb', 'SQweb', 'manage_options', 'SQwebAdmin', 'sqweb_display_admin_menu' );
}
add_action( 'admin_menu', 'sqweb_register_admin_menu' );

/**
 * admin_menu.php is required to display the admin page content
 */
function sqweb_display_admin_menu() {
	echo '<div class="wrap sqw-container"><div id="icon-tools" class="icon32"></div>';
	echo '<h2>Administration SQweb</h2>';
	require( 'backoffice/admin-menu.php' );
	echo '</div>';
}

/**
* Generating SQweb script
*/
buildScript::save();

/**
* CSS + JS
*/
function sqw_enqueue_styles() {
	wp_enqueue_style( 'sqweb-style',
		plugins_url( '/resources/css/sqweb_style.css', __FILE__ )
	);
}

function sqwadmin_enqueue_styles( $hook ) {
	if ( 'toplevel_page_SQwebAdmin' != $hook ) {
		return;
	}
	wp_enqueue_style( 'sqweb-admin-style',
		plugins_url( '/resources/css/sqweb_admin_style.css', __FILE__ )
	);
}

function sqw_enqueue_scripts() {
	wp_enqueue_script( 'sqweb-script',
		plugins_url( '/resources/js/sqweb.js', __FILE__ ),
		array(),
		'1.0.0',
		true
	);
}

function sqwadmin_enqueue_scripts( $hook ) {
	if ( 'toplevel_page_SQwebAdmin' != $hook ) {
		return;
	}
	wp_enqueue_script( 'chart',
		plugins_url( '/resources/js/Chart.min.js', __FILE__ ),
		array( 'jquery' ),
		'1.0.0',
		false
	);
}

add_action( 'admin_enqueue_scripts', 'sqwadmin_enqueue_styles' );
add_action( 'admin_enqueue_scripts', 'sqwadmin_enqueue_scripts' );
add_action( 'wp_enqueue_scripts', 'sqw_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'sqw_enqueue_scripts' );
