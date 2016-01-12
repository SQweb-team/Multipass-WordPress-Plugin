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
 * Add the backoffice link to wordpress admin sidebar
 */
function sqweb_register_admin_menu() {

	add_menu_page( 'Manage SQweb', 'SQweb', 'manage_options', 'SQwebAdmin', 'sqweb_display_admin_menu' );
	if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
		add_menu_page( 'Debug info', 'Debug info', 'manage_options', 'sqweb_debug', 'sqweb_display_php_info' );
	}

}
add_action( 'admin_menu', 'sqweb_register_admin_menu' );

/**
 * admin_menu.php is required to display the admin page content
 */
function sqweb_display_admin_menu() {

	echo '<div class="wrap sqw-container"><div id="icon-tools" class="icon32"></div>';
	echo '<h2>Administration SQweb</h2>';
	include 'backoffice/admin-menu.php';
	echo '</div>';
}

function sqweb_display_php_info() {
		phpinfo();
}

/**
* Generating SQweb script
*/
buildScript::save();

/**
* CSS + JS
*/
function sqw_enqueue_styles() {

	wp_enqueue_style(
		'sqweb-style',
		plugins_url( '/resources/css/sqweb_style.css', __FILE__ )
	);
}

function sqwadmin_enqueue_styles( $hook ) {

	if ( 'toplevel_page_SQwebAdmin' != $hook ) {
		return;
	}
	wp_enqueue_style(
		'sqweb-admin-style',
		plugins_url( '/resources/css/sqweb_admin_style.css', __FILE__ )
	);
}

function sqwadmin_enqueue_scripts( $hook ) {

	if ( 'toplevel_page_SQwebAdmin' != $hook ) {
		return;
	}
	wp_enqueue_script(
		'chart',
		plugins_url( '/resources/js/Chart.min.js', __FILE__ ),
		array( 'jquery' ),
		'1.0.0',
		false
	);
}

add_action( 'admin_enqueue_scripts', 'sqwadmin_enqueue_styles' );
add_action( 'admin_enqueue_scripts', 'sqwadmin_enqueue_scripts' );
add_action( 'wp_enqueue_scripts', 'sqw_enqueue_styles' );
