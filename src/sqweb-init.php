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
	if ( function_exists( 'sqw_pmp_access' ) && sqw_pmp_access( get_the_category() ) ) {
		return $content;
	}
	if ( sqweb_check_credentials( $wsid ) == 0 ) {
		if ( get_option( 'sqw_prior_paywall' ) || ! function_exists( 'pmpro_getOption' ) ) {
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
		} else {
			add_filter( 'the_content', 'pmpro_membership_content_filter', 5 );
			$filterqueries = pmpro_getOption( 'filterqueries' );
			if ( ! empty( $filterqueries ) ) {
			    add_filter( 'pre_get_posts', 'pmpro_search_filter' );
			}
		}
	}
	return $content;
}

function sqw_filter_content( $content ) {

	global $wpdb;
	$restrictcutartperc = '<div onclick="sqw.modal_first()" class="sqw-paywall-button-container"><h5>' . __( 'The rest of this article is for subscriber only', 'sqweb' ) . '</h5><span>' . __( 'Become a subscriber now with Multipass', 'sqweb' ) . '</span><div><img src="https://www.sqweb.com/img/logo_multipass.svg"></div></div>';
	$restrictartbyday = '<div onclick="sqw.modal_first()" class="sqw-paywall-button-container"><h5>' . sprintf( _n( 'You have already read %d article for free today', 'You have already read %d articles for free today', get_option( 'artbyday' ), 'sqweb' ), get_option( 'artbyday' ) ) . '</h5><p>' . __( 'Please come back tomorrow', 'sqweb' ) . '</p><p>' . __( 'Or', 'sqweb' ) . '</p><span>' . __( 'Access immediately all the content with Multipass', 'sqweb' ) . '</span><div><img src="https://www.sqweb.com/img/logo_multipass.svg"></div></div>';
	$restrictdateart = '<div onclick="sqw.modal_first()" class="sqw-paywall-button-container"><h5>' . __( 'This content is for subscriber only', 'sqweb' ) . '</h5><p>' . sprintf( _n( 'It will be available for free in %d day', 'It will be available for free in %d days', ceil( ( get_post_time( 'U', true ) - ( time() - get_option( 'dateart' ) * 86400 ) ) / 86400 ), 'sqweb' ), ceil( ( get_post_time( 'U', true ) - ( time() - get_option( 'dateart' ) * 86400 ) ) / 86400 ) ) . '</p><span>' . __( 'Become a subscriber now with Multipass', 'sqweb' ) . '</span><div><img src="https://www.sqweb.com/img/logo_multipass.svg"></div></div>';
	if ( get_option( 'dateart' ) !== false ) {
		if ( get_post_time( 'U', true ) > time() - get_option( 'dateart' ) * 86400 ) {
			if ( get_option( 'cutartperc' ) !== false ) {
				return transparent( $content, get_option( 'cutartperc' ) ) . $restrictcutartperc;
			} else {
				return $restrictdateart;
			}
		}
	}
	if ( get_option( 'artbyday' ) !== false ) {
		$id = get_the_ID();
		$count = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}sqw_limit WHERE ip = '%s' AND time > '%d' ORDER BY id DESC", array( $_SERVER['REMOTE_ADDR'], (time() - 86400 ) ) ) );
		if ( empty( $count ) ) {
			$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}sqw_limit (ip, nbarticles, seeingart, time) VALUES ('%s', 1, '%s', %d )", array( $_SERVER['REMOTE_ADDR'], serialize( array( $id ) ), time() ) ) );
		} elseif ( ! empty( $count['0'] ) && $count['0']->nbarticles >= get_option( 'artbyday' ) ) {
			$newseeing = unserialize( $count['0']->seeingart );
			if ( ! in_array( $id, $newseeing ) ) {
				if ( get_option( 'cutartperc' ) !== false ) {
					return transparent( $content, get_option( 'cutartperc' ) ) . $restrictcutartperc;
				} else {
					return $restrictartbyday;
				}
			}
		} else {
			$newseeing = unserialize( $count['0']->seeingart );
			if ( ! in_array( $id, $newseeing ) ) {
				$newseeing = serialize( array_merge( $newseeing, array( $id ) ) );
				$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}sqw_limit SET nbarticles = nbarticles + 1, seeingart = '%s' WHERE id = %d", array( $newseeing, $count['0']->id ) ) );
			}
		}
	}
	if ( get_option( 'cutartperc' ) !== false ) {
		return transparent( $content, get_option( 'cutartperc' ) ) . $restrictcutartperc;
	}
	return $content;
}

add_filter( 'the_content', 'sqw_login_content' );

function paywall_style() {
	wp_enqueue_style(
		'sqweb-admin-style',
		'/wp-content/plugins/sqweb/resources/css/sqweb_paywall_style.css'
	);
}

if ( get_option( 'dateart' ) !== false || get_option( 'artbyday' ) !== false || get_option( 'cutartperc' ) !== false ) {
	add_action( 'wp_enqueue_scripts', 'paywall_style' );
}
