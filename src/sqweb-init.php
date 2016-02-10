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

	if ( isset( $_GET['logout'] ) && 1 == $_GET['logout'] ) {
		delete_option( 'sqw_token' );
		wp_redirect( remove_query_arg( 'logout' ) );
		exit;
	}

	if ( isset( $_POST['flogin'], $_POST['flogout'], $_POST['btheme'], $_POST['lang'] ) ) {
		update_option( 'flogin', $_POST['flogin'] );
		update_option( 'flogout', $_POST['flogout'] );
		update_option( 'btheme', $_POST['btheme'] );
		update_option( 'lang', $_POST['lang'] );
	}

	if ( isset( $_POST['msgadblck'] ) && isset( $_POST['fmes'] ) ) {
		update_option( 'fmes', $_POST['fmes'] );
	}

	if ( isset( $_POST ) && ( ! empty( $_POST['sqw-firstname'] ) || ! empty( $_POST['sqw-lastname'] ) || ! empty( $_POST['sqw-email'] ) || ! empty( $_POST['sqw-password'] ) ) ) {
		$error = 0;
		$r = sqweb_sign_up( $_POST['sqw-firstname'], $_POST['sqw-lastname'], $_POST['sqw-email'], $_POST['sqw-password'] );
		if ( 1 == $r ) {
			if ( function_exists( 'get_blog_details' ) ) {
				$current_site = get_blog_details();
				$blogname = $current_site->blogname;
				$siteurl = $current_site->siteurl;
			} else {
				$blogname = get_option( 'blogname' );
				$siteurl = get_option( 'siteurl' );
			}
			$website = sqw_add_website( [ 'sqw-ws-name' => $blogname, 'sqw-ws-url' => $siteurl ], get_option( 'sqw_token' ) );
			update_option( 'wsid', $website->id );
			wp_redirect( add_query_arg( array( 'action' => 'signin', 'success' => 'true' ) ) );
			exit;
		}
	} elseif ( ! empty( $_POST ) ) {
		$error = 1;
	}

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

function sqw_login_content() {
	$wsid = (get_option( 'wsid' ) != false) ? get_option( 'wsid' ) : '0';
	$lang = (get_option( 'lang' ) != false) ? get_option( 'lang' ) : 'en';
	$return = '
	<iframe frameBorder="0" style="height: 500px; width: 100%;" src="https://www.sqweb.com/iframe/'. $lang .'/login/'. $wsid .'"></iframe>
	';
	return $return;
}

function sqw_login_template() {
	include( TEMPLATEPATH.'/page.php' );
	exit;
}

if ( get_option( 'targets' ) == 'tpw' ) {
	$wsid = (get_option( 'wsid' ) !== '') ? get_option( 'wsid' ) : '0';
	if ( sqweb_check_credentials( $wsid ) == 0 ) {
		add_filter( 'the_content','sqw_login_content' );
		add_action( 'template_redirect', 'sqw_login_template' );
	}
}
