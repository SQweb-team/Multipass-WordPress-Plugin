<?php

if ( isset( $_GET['logout'] ) && 1 == $_GET['logout'] ) {
	delete_option( 'sqw_token' );
	wp_redirect( remove_query_arg( 'logout' ) );
	exit;
}

if ( isset( $_POST['wmid'], $_POST['wsid'], $_POST['flogin'], $_POST['flogout'], $_POST['fmes'], $_POST['btheme'], $_POST['lang'], $_POST['targets'] ) ) {
	update_option( 'wmid', $_POST['wmid'] );
	update_option( 'wsid', $_POST['wsid'] );
	update_option( 'flogin', $_POST['flogin'] );
	update_option( 'flogout', $_POST['flogout'] );
	update_option( 'fmes', $_POST['fmes'] );
	update_option( 'btheme', $_POST['btheme'] );
	update_option( 'lang', $_POST['lang'] );
	update_option( 'targets', $_POST['targets'] );
	$updated = true;
}
// Checking if options have yet been set
$sqw_token = (get_option( 'sqw_token' ) != false) ? get_option( 'sqw_token' ) : '';
$wmid = (get_option( 'wmid' ) != false) ? get_option( 'wmid' ) : '';
$wsid = (get_option( 'wsid' ) != false) ? get_option( 'wsid' ) : '';
$flogin = (get_option( 'flogin' ) != false) ? get_option( 'flogin' ) : 'Remove ads';
$flogout = (get_option( 'flogout' ) != false) ? get_option( 'flogout' ) : 'Connected';
$fmes = (get_option( 'fmes' ) != false) ? get_option( 'fmes' ) : '';
$btheme = (get_option( 'btheme' ) != false) ? get_option( 'btheme' ) : 'blue';
$lang = (get_option( 'lang' ) != false) ? get_option( 'lang' ) : 'en';
$targeting = (get_option( 'targets' ) != false) ? get_option( 'targets' ) : 'false';

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

if ( ! empty( $wsid ) ) {
	include_once 'tutoriel.php';
} elseif ( ! empty( $sqw_token ) || '0' != $signinr ) {
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
include_once 'footer.php';
