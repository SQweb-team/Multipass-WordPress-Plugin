<?php
$errorc = 0;

include_once 'init.php';

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

include_once 'sqweb.php';
