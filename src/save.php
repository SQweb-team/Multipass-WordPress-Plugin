<?php
if ( ! isset( $wpdb ) ) {
	global $wpdb;
}

if ( ! empty( $_GET['type'] ) && 'save' == $_GET['type'] && ! empty( $_POST ) ) {

	/**
	 * Save if user have selected Multipass
	 */
	if ( isset( $_POST['sqw_multipass'] ) ) {
		update_option( 'sqw_multipass', $_POST['sqw_multipass'] );
	}

	/**
	 * Save if user have selected autologin for Multipass users
	 */
	if ( isset( $_POST['sqw_autologin'] ) ) {
		update_option( 'sqw_autologin', $_POST['sqw_autologin'] );
	}

	/**
	 * Save if an end of article button should be displayed
	 */
	if ( isset( $_POST['sqw_display_support'] ) ) {
		update_option( 'sqw_display_support', $_POST['sqw_display_support'] );
	}

	/**
	 * Save the lang of button selected by webmaster
	 */
	if ( isset( $_POST['sqw_lang'] ) ) {
		update_option( 'sqw_lang', $_POST['sqw_lang'] );
	}

	/**
	 * Save categorie affected by paywall
	 */
	if ( ! empty( $_POST['categorie'] ) ) {
		update_option( 'categorie', serialize( $_POST['categorie'] ) );
	} else {
		delete_option( 'categorie' );
	}

	/**
	 * Select all content to filter
	 */
	if ( ! empty( $_POST['sqw_filter_all'] ) ) {
		update_option( 'sqw_filter_all', true );
	} else {
		delete_option( 'sqw_filter_all' );
	}

	/**
	 * Enable php parsing in text widgets
	 */
	if ( ! empty( $_POST['sqw_php_parsing'] ) ) {
		update_option( 'sqw_php_parsing', true );
	} else {
		delete_option( 'sqw_php_parsing' );
	}


	/**
	 * Save user role can see article behind paywall in all case
	 */
	if ( ! empty( $_POST['exept_role'] ) ) {
		update_option( 'sqw_exept_role', serialize( $_POST['exept_role'] ) );
	} else {
		update_option( 'sqw_exept_role', serialize( array() ) );
	}

	/**
	 * Give priority of block to other paywall (Only compatible actually with Paid membershippro)
	 */
	if ( ! empty( $_POST['sqw_prior_paywall'] ) ) {
		update_option( 'sqw_prior_paywall', true );
	} else {
		delete_option( 'sqw_prior_paywall' );
	}

	/**
	 * Save number of pourcent can be display of article when is blocked
	 */
	if ( ! empty( $_POST['perctart'] ) ) {
		update_option( 'cutartperc', $_POST['perctart'] );
	} else {
		delete_option( 'cutartperc' );
	}

	/**
	 * Save number of article can be seen every day when is blocked
	 */
	if ( ! empty( $_POST['artbyday'] ) ) {
		update_option( 'artbyday', $_POST['artbyday'] );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}sqw_limit (id INT AUTO_INCREMENT PRIMARY KEY, ip VARCHAR(255) NOT NULL, nbarticles INT NOT NULL, seeingart TEXT NOT NULL, time BIGINT NOT NULL)" );
	} else {
		delete_option( 'artbyday' );
		$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}sqw_limit" );
	}

	/**
	 * Save number of day before an article can be see by all users.
	 */
	if ( ! empty( $_POST['dateart'] ) ) {
		update_option( 'dateart', $_POST['dateart'] );
	} else {
		delete_option( 'dateart' );
	}

	/**
	 * Save number of day before an article is considered an archive and is blocked.
	 */
	if ( ! empty( $_POST['archiveart'] ) ) {
		update_option( 'archiveart', $_POST['archiveart'] );
	} else {
		delete_option( 'archiveart' );
	}

	if ( ! empty( $_POST['sqw_popup'] ) ) {
		update_option( 'sqw_popup', 'true' );
	} else {
		delete_option( 'sqw_popup' );
	}

	/**
	 * Below are 9 saves which are used to customize the Multipass buttons
	 */

	/**
	 * Message on the tiny button when logged out
	 */
	if ( ! empty( $_POST['sqw_btn_login_tiny'] ) ) {
		update_option( 'sqw_btn_login_tiny', $_POST['sqw_btn_login_tiny'] );
	} else {
		delete_option( 'sqw_btn_login_tiny' );
	}

	/**
	 * Message on the tiny button when logged in
	 */
	if ( ! empty( $_POST['sqw_btn_connected_tiny'] ) ) {
		update_option( 'sqw_btn_connected_tiny', $_POST['sqw_btn_connected_tiny'] );
	} else {
		delete_option( 'sqw_btn_connected_tiny' );
	}

	/**
	 * Message on the regular button when logged out
	 */
	if ( ! empty( $_POST['sqw_btn_login'] ) ) {
		update_option( 'sqw_btn_login', $_POST['sqw_btn_login'] );
	} else {
		delete_option( 'sqw_btn_login' );
	}

	/**
	 * Message on the regular button when logged in
	 */
	if ( ! empty( $_POST['sqw_btn_connected'] ) ) {
		update_option( 'sqw_btn_connected', $_POST['sqw_btn_connected'] );
	} else {
		delete_option( 'sqw_btn_connected' );
	}

	/**
	 * Message on the support button when logged out
	 */
	if ( ! empty( $_POST['sqw_btn_support'] ) ) {
		update_option( 'sqw_btn_support', $_POST['sqw_btn_support'] );
	} else {
		delete_option( 'sqw_btn_support' );
	}

	/**
	 * Message on the support button when logged in
	 */
	if ( ! empty( $_POST['sqw_btn_connected_support'] ) ) {
		update_option( 'sqw_btn_connected_support', $_POST['sqw_btn_connected_support'] );
	} else {
		delete_option( 'sqw_btn_connected_support' );
	}

	/**
	 * First editable part on the large button when logged out
	 */
	if ( ! empty( $_POST['sqw_btn_unlimited'] ) ) {
		update_option( 'sqw_btn_unlimited', $_POST['sqw_btn_unlimited'] );
	} else {
		delete_option( 'sqw_btn_unlimited' );
	}

	/**
	 * Second editable part on the large button when logged out
	 */
	if ( ! empty( $_POST['sqw_btn_noads'] ) ) {
		update_option( 'sqw_btn_noads', $_POST['sqw_btn_noads'] );
	} else {
		delete_option( 'sqw_btn_noads' );
	}

	/**
	 * Message on large button when logged in
	 */
	if ( ! empty( $_POST['sqw_btn_connected_s'] ) ) {
		update_option( 'sqw_btn_connected_s', $_POST['sqw_btn_connected_s'] );
	} else {
		delete_option( 'sqw_btn_connected_s' );
	}

	SQweb_Admin::add_notice_event( 'success', __( 'Your changes have been saved.', 'sqweb' ) );
	wp_redirect( remove_query_arg( 'type' ) );
	exit;
} // End if().
