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

	global $wpdb, $post;
	$wsid = ( get_option( 'wsid' ) != false ) ? get_option( 'wsid' ) : '0';
	if ( sqweb_check_credentials( $wsid ) == 0 ) {
		if ( get_post_meta( $post->ID, 'sqw_limited', true ) ) {
			$content = sqw_filter_content( $content );
			return $content;
		} elseif ( get_option( 'categorie' ) ) {
			$categorie = unserialize( get_option( 'categorie' ) );
			$categorie = is_array( $categorie ) ? $categorie : array();
			$category = get_the_category();
			foreach ( $category as $value ) {
				foreach ( $categorie as $cat ) {
					if ( $value->slug == $cat ) {
						$content = sqw_filter_content( $content );
						return $content;
					}
				}
			}
		}
	}
	return $content;
}

function sqw_filter_content( $content ) {

	$connectsqw = '<div class="sqw-paywall-button-container">' . __( 'Content restricted to subscribers.', 'sqweb' ) . '<div class="sqweb-button"></div></div>';
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
	}
	if ( get_option( 'cutartperc' ) !== false ) {
		return transparent( $content, get_option( 'cutartperc' ) ) . $connectsqw;
	}
	return $content;
}

add_filter( 'the_content', 'sqw_login_content' );
