<?php

include_once( 'transpartext.php' );

/**
 * Add notice
 */
if ( isset( $_GET['page'] ) && 'SQwebAdmin' == $_GET['page'] ) {
	function notice_event() {
		$message = unserialize( get_option( 'sqw_message' ) );
		foreach ( $message as $value ) {
			?>
			<div class="notice notice-<?php echo $value['type']; ?> is-dismissible">
			<p><?php _e( '<b>SQweb notice : </b>', 'sqweb' ); ?><?php echo $value['message']; ?></p>
			</div>
			<?php
		}
		delete_option( 'sqw_message' );
	}

	function add_notice_event( $type, $message ) {
		$messages = unserialize( get_option( 'sqw_message' ) );
		if ( empty( $messages ) ) {
			$messages = array();
		}
		array_push( $messages, array( 'type' => $type, 'message' => $message ) );
		update_option( 'sqw_message', serialize( $messages ) );
	}

	if ( unserialize( get_option( 'sqw_message' ) ) ) {
		add_action( 'admin_notices', 'notice_event' );
	}
}
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
 * Add the backoffice link to wordpress admin sidebar
 */
function sqweb_register_admin_menu() {

	global $wpdb;
	if ( isset( $_GET['page'] ) && 'SQwebAdmin' == $_GET['page'] ) {
		include_once 'login.php';
		if ( isset( $_GET['logout'] ) && 1 == $_GET['logout'] ) {
			delete_option( 'sqw_token' );
			wp_redirect( remove_query_arg( 'logout' ) );
			exit;
		} elseif ( get_option( 'sqw_token' ) ) {
			include_once 'logout.php';
		}
		include_once 'save.php';
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

	//echo '<div class="wrap sqw-container"><div id="icon-tools" class="icon32"></div>';
	//echo '<h2>Administration SQweb</h2>';
	include 'backoffice/admin-menu.php';
	//echo '</div>';
}

function sqweb_display_php_info() {
		phpinfo();
}

/**
* Generating SQweb script
*/
buildScript::save();

function sqwadmin_enqueue_styles( $hook ) {

	if ( 'toplevel_page_SQwebAdmin' != $hook ) {
		return;
	}
	wp_enqueue_style(
		'sqweb-admin-style',
		plugins_url( '/resources/css/sqweb_admin_style.css', __FILE__ )
	);
	wp_enqueue_script(
		'sqweb-jquery',
		'https://code.jquery.com/jquery-2.2.3.min.js'
	);
	wp_enqueue_script(
		'sqweb-admin-script',
		plugins_url( '/resources/js/sqweb.js', __FILE__ )
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

function sqw_login_content( $content ) {
	global $wpdb;
	$wsid = (get_option( 'wsid' ) != false) ? get_option( 'wsid' ) : '0';
	$lang = (get_option( 'lang' ) != false) ? get_option( 'lang' ) : 'en';
	$connectsqw = '<div><button onClick="sqw.modal_first()">' . __( 'Content restricted to subscribers, Click here to activate your account.', 'sqweb' ) . '</button></div>';
	if ( get_option( 'categorie' ) ) {
		$categorie = unserialize( get_option( 'categorie' ) );
		$categorie = is_array( $categorie ) ? $categorie : array();
		$category = get_the_category();
		foreach ( $category as $value ) {
			foreach ( $categorie as $cat ) {
				if ( $value->slug == $cat ) {
					if ( get_option( 'dateart' ) !== false ) {
						if ( get_post_time( 'U', true ) > time() - get_option( 'dateart' ) * 86400 ) {
							if ( get_option( 'cutartperc' ) !== false ) {
								return transparent( $content, get_option( 'cutartperc' ) ) . $connectsqw;
							} else {
								return $connectsqw;
							}
						}
					}
					if ( get_option( 'artbyday' ) !== false ) {
						$id = get_the_ID();
						$count = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}sqw_limit WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "' AND time > '" . (time() - 86400) . "' ORDER BY id DESC" );
						if ( empty( $count ) ) {
							$wpdb->query( "INSERT INTO {$wpdb->prefix}sqw_limit (ip, nbarticles, seeingart, time) VALUES ('" . $_SERVER['REMOTE_ADDR'] . "', 1, '" . serialize( array( $id ) ) . "', " . time() . ')' );
						} elseif ( ! empty( $count['0'] ) && $count['0']->nbarticles >= get_option( 'artbyday' ) ) {
							$newseeing = unserialize( $count['0']->seeingart );
							if ( ! in_array( $id, $newseeing ) ) {
								if ( get_option( 'cutartperc' ) !== false ) {
									return transparent( $content, get_option( 'cutartperc' ) ) . $connectsqw;
								} else {
									return $connectsqw;
								}
							}
						} else {
							$newseeing = unserialize( $count['0']->seeingart );
							if ( ! in_array( $id, $newseeing ) ) {
								$newseeing = serialize( array_merge( $newseeing, array( $id ) ) );
								$wpdb->query( "UPDATE {$wpdb->prefix}sqw_limit SET nbarticles = nbarticles + 1, seeingart = '" . $newseeing . "' WHERE id = " . $count['0']->id );
							}
						}
						break;
					}
					if ( get_option( 'cutartperc' ) !== false ) {
						return transparent( $content, get_option( 'cutartperc' ) ) . $connectsqw;
					}
				}
			}
		}
	}
	return $content;
}

if ( get_option( 'categorie' ) ) {
	$wsid = ( get_option( 'wsid' ) != false ) ? get_option( 'wsid' ) : '0';
	if ( sqweb_check_credentials( $wsid ) == 0 ) {
		add_filter( 'the_content', 'sqw_login_content' );
	}
}
