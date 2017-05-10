<?php
if ( ! empty( $_GET['type'] ) && 'save' == $_GET['type'] && ! empty( $_POST ) ) {

	/**
	 * Save if user have select Multipass
	 */
	if ( isset( $_POST['sqw_multipass'] ) ) {
		update_option( 'sqw_multipass', $_POST['sqw_multipass'] );
	}

	/**
	 * Save if user have select Adblock manager
	 */
	if ( isset( $_POST['sqw_analytics'] ) ) {
		update_option( 'sqw_analytics', $_POST['sqw_analytics'] );
	}

	/**
	 * Save the lang of button selected by webmaster
	 */
	if ( isset( $_POST['lang'] ) ) {
		update_option( 'lang', $_POST['lang'] );
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

	if ( ! empty( $_POST['sqw_popup'] ) ) {
		update_option( 'sqw_popup', 'true' );
	} else {
		delete_option( 'sqw_popup' );
	}

	/**
	 * Save message display for adblockers.
	 */
	if ( ! empty( $_POST['fmes'] ) ) {
		update_option( 'fmes', $_POST['fmes'] );
	} else {
		delete_option( 'fmes' );
	}
	SQweb_Admin::add_notice_event( 'success', __( 'Your changes have been saved.', 'sqweb' ) );
	wp_redirect( remove_query_arg( 'type' ) );
	exit;
} // End if().
