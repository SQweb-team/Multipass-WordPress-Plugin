<?php

include_once( 'transpartext.php' );

/**
 * Declaring and adding widget
 */
function register_sqweb_ad_control_widget() {

	register_widget( 'sqwebAdControl' );
}

/**
 * Declaring SQweb Button widget
 */
function register_widget_sqweb_button() {

	register_widget( 'widgetSqwebButton' );
}

add_action( 'widgets_init', 'register_sqweb_ad_control_widget' );
add_action( 'widgets_init', 'register_widget_sqweb_button' );

/**
 * admin-menu.php is required to display the admin page content
 */
function sqweb_display_admin_menu() {

	//echo '<div class="wrap sqw-container"><div id="icon-tools" class="icon32"></div>';
	//echo '<h2>Administration SQweb</h2>';
	include 'backoffice/admin-menu.php';
	//echo '</div>';
}

function install_help_sqw() {
	echo 'test';
}

function sqweb_display_php_info() {
	phpinfo();
}

/**
* Generating SQweb script
*/
buildScript::save();

function sqw_login_content( $content ) {

	$wsid = ( get_option( 'wsid' ) != false ) ? get_option( 'wsid' ) : '0';
	if ( function_exists( 'sqw_pmp_access' ) && sqw_pmp_access( get_the_category() ) ) {
		return $content;
	}
	if ( ! apply_filters( 'sqw_check_credentials', $wsid ) ) {
		$content = apply_filters( 'sqw_limited', $content );
	}
	return $content;
}

function paywall_style() {
	wp_enqueue_style(
		'sqweb-admin-style',
		'/wp-content/plugins/sqweb/resources/css/sqweb_paywall_style.css'
	);
}

if ( get_option( 'dateart' ) !== false || get_option( 'artbyday' ) !== false || get_option( 'cutartperc' ) !== false ) {
	add_filter( 'the_content', 'sqw_login_content' );
	add_action( 'wp_enqueue_scripts', 'paywall_style' );
}
