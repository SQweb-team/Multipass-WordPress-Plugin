<?php
$errorc = 0;
if ( ! empty( $_POST['sqw-emailc'] ) || ! empty( $_POST['sqw-passwordc'] ) ) {
	if ( sqweb_sign_in( $_POST['sqw-emailc'], $_POST['sqw-passwordc'] ) ) {
		if ( function_exists( 'get_blog_details' ) ) {
			$current_site = get_blog_details();
			$blogname = $current_site->blogname;
			$siteurl = $current_site->siteurl;
		} else {
			$blogname = get_option( 'blogname' );
			$siteurl = get_option( 'siteurl' );
		}
		if ( $websites = sqw_get_sites() ) {
			foreach ( $websites as $key => $value ) {
				if ( $value->url == $siteurl ) {
					update_option( 'wsid', $value->id );
					break;
				}
			}
		}
		if ( ! get_option( 'wsid' ) ) {
			$website = sqw_add_website( array( 'sqw-ws-name' => $blogname, 'sqw-ws-url' => $siteurl ), get_option( 'sqw_token' ) );
			if ( $website ) {
				update_option( 'wsid', $website->id );
			}
		}
	} else {
		update_option( 'sqw_error', 1 );
	}
} else {
	$errorc = 1;
}

$sqw_token = (get_option( 'sqw_token' ) != false) ? get_option( 'sqw_token' ) : '';
$wsid = (get_option( 'wsid' ) != false) ? get_option( 'wsid' ) : '';
$flogin = (get_option( 'flogin' ) != false) ? get_option( 'flogin' ) : '';
$flogout = (get_option( 'flogout' ) != false) ? get_option( 'flogout' ) : '';
$fmes = (get_option( 'fmes' ) != false) ? get_option( 'fmes' ) : '';
$btheme = (get_option( 'btheme' ) != false) ? get_option( 'btheme' ) : 'blue';
$lang = (get_option( 'lang' ) != false) ? get_option( 'lang' ) : 'en';
$targeting = (get_option( 'targets' ) != false) ? get_option( 'targets' ) : 'false';

if ( ! empty( $sqw_token ) ) {
	$sqw_webmaster = sqweb_check_token( $sqw_token );
	if ( ! sqweb_check_token( $sqw_token ) ) {
		delete_option( 'sqw_token' );
		wp_redirect( remove_query_arg( 'logout' ) );
		exit;
	}
} else {
	$sqw_webmaster = 0;
}

include_once 'head.php';
include_once 'tutoriel.php';
include_once 'footer.php';
