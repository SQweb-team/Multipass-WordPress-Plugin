<?php

if ( isset( $_GET['logout'] ) && 1 == $_GET['logout'] ) {
	delete_option( 'sqw_token' );
	wp_redirect( remove_query_arg( 'logout' ) );
	exit;
}

// Checking if options have yet been set
$sqw_token = (get_option( 'sqw_token' ) !== '') ? get_option( 'sqw_token' ) : '';
$wmid = (get_option( 'wmid' ) !== '') ? get_option( 'wmid' ) : '';
$wsid = (get_option( 'wsid' ) !== '') ? get_option( 'wsid' ) : '';
$flogin = (get_option( 'flogin' ) !== '') ? get_option( 'flogin' ) : 'Remove ads';
$flogout = (get_option( 'flogout' ) !== '') ? get_option( 'flogout' ) : 'Connected';
$fmes = (get_option( 'fmes' ) !== '') ? get_option( 'fmes' ) : '';
$fpubg = (get_option( 'fpubg' ) !== '') ? get_option( 'fpubg' ) : '';
$fpufc = (get_option( 'fpufc' ) !== '') ? get_option( 'fpufc' ) : '';
$btheme = (get_option( 'btheme' ) !== '') ? get_option( 'btheme' ) : 'blue';
$lang = (get_option( 'lang' ) !== '') ? get_option( 'lang' ) : 'en';
$targeting = (get_option( 'targets' ) !== '') ? get_option( 'targets' ) : 'false';

// Building the form
$errorc = 0;
$signinr = 0;
if ( isset( $_POST['sqw-emailc'] ) && isset( $_POST['sqw-passwordc'] ) ) {
	if ( ! empty( $_POST['sqw-emailc'] ) && ! empty( $_POST['sqw-passwordc'] ) ) {
		$signinr = sqweb_sign_in( $_POST['sqw-emailc'], $_POST['sqw-passwordc'] );
	} else {
		$errorc = 1;
	}
}

include_once 'head.php';

if ( ! empty( $sqw_token ) || '0' != $signinr ) {
	include_once 'setting.php';
	if ( ! empty( $wsid ) && ! empty( $wmid ) ) {
		include_once 'stats.php';
	}
	if ( ! empty( $sqw_token ) && 0 == $sqw_webmaster ) {
		delete_option( 'sqw_token' );
		wp_redirect( sqw_site_url() . $_SERVER['REQUEST_URI'] );
	}
} else {
	if ( isset( $_GET['action'] ) && 'signup' == $_GET['action'] ) {
		if ( isset( $_POST ) && ( ! empty( $_POST['sqw-firstname'] ) || ! empty( $_POST['sqw-lastname'] ) || ! empty( $_POST['sqw-email'] ) || ! empty( $_POST['sqw-password'] ) ) ) {
			$error = 0;
			$r = sqweb_sign_up( $_POST['sqw-firstname'], $_POST['sqw-lastname'], $_POST['sqw-email'], $_POST['sqw-password'] );
			if ( 1 == $r ) {
				wp_redirect( add_query_arg( array( 'action' => 'signin', 'success' => 'true' ) ) );
				exit;
			}
		} elseif ( ! empty( $_POST ) ) {
			$error = 1;
		}
		include_once 'signup.php';
	} else {
		include_once 'signin.php';
	}
}
