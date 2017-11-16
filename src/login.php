<?php

/**
 * signin
 */
if ( ! empty( $_GET['type'] ) && 'login' === $_GET['type'] && ! empty( $_POST['sqw-emailc'] ) && ! empty( $_POST['sqw-passwordc'] ) ) {
	if ( sqweb_sign_in( $_POST['sqw-emailc'], $_POST['sqw-passwordc'] ) ) {
		if ( function_exists( 'get_blog_details' ) ) {
			$current_site = get_blog_details();
			$blogname     = $current_site->blogname;
			$siteurl      = $current_site->siteurl;
		} else {
			$blogname = get_option( 'blogname' );
			$siteurl  = get_option( 'siteurl' );
		}
		$websites = sqw_get_sites();
		if ( 0 != $websites ) {
			foreach ( $websites as $key => $value ) {
				if ( $value->url == $siteurl ) {
					update_option( 'wsid', $value->id );
					break;
				}
			}
		}
		if ( ! get_option( 'wsid' ) ) {
			$website = sqw_add_website( array(
				'sqw-ws-name' => $blogname,
				'sqw-ws-url'  => $siteurl,
			), get_option( 'sqw_token' ) );
			if ( $website ) {
				update_option( 'wsid', $website->id );
			}
		}
	}
	wp_redirect( remove_query_arg( 'type' ) );
	exit;
}

/**
 * signup
 */

if ( ! empty( $_GET['type'] ) && 'subscribe' === $_GET['type'] ) {
	if ( isset( $_POST ) && ( ! empty( $_POST['sqw-firstname'] ) || ! empty( $_POST['sqw-lastname'] ) || ! empty( $_POST['sqw-email'] ) || ! empty( $_POST['sqw-password'] ) ) ) {
		$error = 0;
		$r     = sqweb_sign_up( $_POST['sqw-firstname'], $_POST['sqw-lastname'], $_POST['sqw-email'], $_POST['sqw-password'] );
		if ( 1 == $r ) {
			if ( function_exists( 'get_blog_details' ) ) {
				$current_site = get_blog_details();
				$blogname     = $current_site->blogname;
				$siteurl      = $current_site->siteurl;
			} else {
				$blogname = get_option( 'blogname' );
				$siteurl  = get_option( 'siteurl' );
			}
			$website = sqw_add_website( array(
				'sqw-ws-name' => $blogname,
				'sqw-ws-url'  => $siteurl,
			), get_option( 'sqw_token' ) );
			update_option( 'wsid', $website->id );
			wp_redirect( add_query_arg( array(
				'action'  => 'signin',
				'success' => 'true',
			) ) );
			exit;
		}
	} else {
		SQweb_Admin::add_notice_event( 'error', __( 'All fields need to be filled.', 'sqweb' ) );
	}
	wp_redirect( remove_query_arg( 'type' ) );
	exit;
}
