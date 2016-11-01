<?php
if ( ! empty( $_GET['type'] ) && 'save' == $_GET['type'] && ! empty( $_POST ) ) {

	if ( isset( $_POST['sqw_multipass'] ) ) {
		update_option( 'sqw_multipass', $_POST['sqw_multipass'] );
	}

	if ( isset( $_POST['sqw_analytics'] ) ) {
		update_option( 'sqw_analytics', $_POST['sqw_analytics'] );
	}

	if ( isset( $_POST['flogin'], $_POST['flogout'], $_POST['lang'] ) ) {
		update_option( 'flogin', $_POST['flogin'] );
		update_option( 'flogout', $_POST['flogout'] );
		update_option( 'lang', $_POST['lang'] );
	}

	if ( ! empty( $_POST['categorie'] ) ) {
		update_option( 'categorie', serialize( $_POST['categorie'] ) );
	} else {
		delete_option( 'categorie' );
	}

	if ( ! empty( $_POST['exept_role'] ) ) {
		update_option( 'sqw_exept_role', serialize( $_POST['exept_role'] ) );
	} else {
		update_option( 'sqw_exept_role', serialize( array() ) );
	}

	if ( ! empty( $_POST['sqw_prior_paywall'] ) ) {
		update_option( 'sqw_prior_paywall', true );
	} else {
		delete_option( 'sqw_prior_paywall' );
	}

	if ( ! empty( $_POST['perctart'] ) ) {
		update_option( 'cutartperc', $_POST['perctart'] );
	} else {
		delete_option( 'cutartperc' );
	}

	if ( ! empty( $_POST['artbyday'] ) ) {
		update_option( 'artbyday', $_POST['artbyday'] );
		$wpdb->query( "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}sqw_limit (id INT AUTO_INCREMENT PRIMARY KEY, ip VARCHAR(255) NOT NULL, nbarticles INT NOT NULL, seeingart TEXT NOT NULL, time BIGINT NOT NULL)" );
	} else {
		delete_option( 'artbyday' );
		$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}sqw_limit" );
	}

	if ( ! empty( $_POST['dateart'] ) ) {
		update_option( 'dateart', $_POST['dateart'] );
	} else {
		delete_option( 'dateart' );
	}

	if ( ! empty( $_POST['fmes'] ) ) {
		update_option( 'fmes', $_POST['fmes'] );
	} else {
		delete_option( 'fmes' );
	}
	SQweb_Admin::add_notice_event( 'success', __( 'Your changes have been saved.', 'sqweb' ) );
	wp_redirect( remove_query_arg( 'type' ) );
	exit;
} // End if().
