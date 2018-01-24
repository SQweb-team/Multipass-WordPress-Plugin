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
}

function sqweb_display_php_info() {
	phpinfo();
}

/**
* Generating SQweb script
*/
buildScript::save();

function sqw_login_content( $content ) {

	global $post;

	$wsid = ( get_option( 'wsid' ) != false ) ? get_option( 'wsid' ) : '0';
	if ( function_exists( 'sqw_pmp_access' ) && sqw_pmp_access( get_the_category() ) ) {
		return $content;
	}
	$value = get_post_meta( $post->ID, 'sqw_unlimited', true );
	if ( empty( $value ) ) {
		if ( ! apply_filters( 'sqw_check_credentials', $wsid ) ) {
			$content = apply_filters( 'sqw_limited', $content );
		}
	}
	return $content;
}

function paywall_style() {
	wp_register_style(
		'sqweb_paywall_style',
		plugin_dir_url( __FILE__ ) . 'resources/css/sqweb_paywall_style.css'
	);
	wp_enqueue_style( 'sqweb_paywall_style' );
}

function end_of_article_support_button( $content ) {
	if ( ! strstr( $content, 'mltpss.modal_first(event)' ) && ! strstr( $content, 'sqw.modal_first(event)' ) ) {
		$content .= sqw_support_button_html();
	}

	return $content;
}

if ( get_option( 'archiveart' ) !== false || get_option( 'filter_all' ) !== false || get_option( 'dateart' ) !== false || get_option( 'artbyday' ) !== false || get_option( 'cutartperc' ) !== false || get_option( 'sqw_display_support' ) != 0 ) {
	add_filter( 'the_content', 'sqw_login_content' );
	add_action( 'wp_enqueue_scripts', 'paywall_style' );
}

if ( sqweb_check_credentials( get_option( 'wsid' ) ) === false && get_option( 'sqw_display_support' ) != 0 ) {
	if ( '/' != $_SERVER['REQUEST_URI'] ) {
		add_filter( 'the_content', 'end_of_article_support_button' );
	}
}

if ( get_option( 'sqw_php_parsing' ) !== false ) {
	add_filter( 'widget_text', 'sqw_php_execute' );
}
