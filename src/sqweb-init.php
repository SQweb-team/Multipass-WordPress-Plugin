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
 * Add the backoffice link to wordpress admin sidebar
 */
function sqweb_register_admin_menu() {

	global $wpdb;
	if ( isset( $_GET['page'] ) && 'SQwebAdmin' == $_GET['page'] ) {
		if ( isset( $_GET['logout'] ) && 1 == $_GET['logout'] ) {
			delete_option( 'sqw_token' );
			wp_redirect( remove_query_arg( 'logout' ) );
			exit;
		}
		if ( isset( $_GET['save'] ) && ! empty( $_POST ) ) {
			if ( isset( $_POST['flogin'], $_POST['flogout'], $_POST['btheme'], $_POST['lang'] ) ) {
				update_option( 'flogin', $_POST['flogin'] );
				update_option( 'flogout', $_POST['flogout'] );
				update_option( 'btheme', $_POST['btheme'] );
				update_option( 'lang', $_POST['lang'] );
			}

			if ( isset( $_POST['categorie'] ) && ( isset( $_POST['squared%art'] ) || isset( $_POST['squarednbart'] ) || isset( $_POST['squareddateart'] ) ) ) {
				update_option( 'categorie', serialize( $_POST['categorie'] ) );
			} else {
				delete_option( 'categorie' );
			}

			if ( isset( $_POST['squared%art'], $_POST['perctart'] ) ) {
				update_option( 'cutartperc', $_POST['perctart'] );
			} else {
				delete_option( 'cutartperc' );
			}

			if ( isset( $_POST['squarednbart'], $_POST['artbyday'] ) ) {
				update_option( 'artbyday', $_POST['artbyday'] );
				$wpdb->query( "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}sqw_limit (id INT AUTO_INCREMENT PRIMARY KEY, ip VARCHAR(255) NOT NULL, nbarticles INT NOT NULL, seeingart TEXT NOT NULL, time BIGINT NOT NULL)" );
			} else {
				delete_option( 'artbyday' );
				$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}sqw_limit" );
			}

			if ( isset( $_POST['squareddateart'], $_POST['dateart'] ) ) {
				update_option( 'dateart', $_POST['dateart'] );
			} else {
				delete_option( 'dateart' );
			}

			if ( isset( $_POST['msgadblck'] ) && isset( $_POST['fmes'] ) ) {
				update_option( 'fmes', $_POST['fmes'] );
			} else {
				delete_option( 'fmes' );
			}
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
				$website = sqw_add_website( array( 'sqw-ws-name' => $blogname, 'sqw-ws-url' => $siteurl ), get_option( 'sqw_token' ) );
				update_option( 'wsid', $website->id );
				wp_redirect( add_query_arg( array( 'action' => 'signin', 'success' => 'true' ) ) );
				exit;
			}
		} elseif ( ! empty( $_POST ) ) {
			$error = 1;
		}
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
