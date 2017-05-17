<?php

function curl_api( $method, $protocol ) {
	$curl = curl_init();
	if ( 'get' === $method ) {
		curl_setopt_array( $curl, array(
			CURLOPT_URL => $protocol . '://api.multipass.net/ping',
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_VERBOSE => 1,
		) );
	} elseif ( 'post' === $method ) {
		curl_setopt_array( $curl, array(
			CURLOPT_URL => $protocol . '://api.multipass.net/ping',
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_POST  => 1,
			CURLOPT_VERBOSE => 1,
		) );
	}
	return $curl;
}

/**
 * Get information about the WordPress installation, template and all installed plugins.
 */
 // url => get_site_url();
if ( ! empty( $_GET['type'] ) && 'diagnostic' == $_GET['type'] ) {
	$api_test = array(
		0 => array(
			'http',
			'get',
		),
		1 => array(
			'https',
			'get',
		),
		2 => array(
			'http',
			'post',
		),
		3 => array(
			'https',
			'post',
		),
	);
	$message = 'API Connectivity:<br><br>';
	foreach ( $api_test as $value ) {
		$curl = curl_api( $value[1], $value[0] );
		$response = curl_exec( $curl );
		$message .= 'Method: ' . $value[1] . '<br>';
		$message .= 'Protocol: ' . $value[0] . '<br>';
		$message .= 'Status: ' . ( '1' === $response ? 1 : 0 ) . '<br><br>';
	}
	$plugins = get_plugins();
	stream_context_set_default(
		array(
			'http' => array(
				'method' => 'HEAD',
			),
		)
	);
	$header_infos = get_headers( get_site_url() );
	$infos = array();
	$infos['report_website'] = array(
		'name' => get_bloginfo( 'name' ),
		'version' => get_bloginfo( 'version' ),
		'wpurl' => get_bloginfo( 'wpurl' ),
		'url' => get_bloginfo( 'url' ),
		'admin_email' => get_bloginfo( 'admin_email' ),
		'template_url' => get_bloginfo( 'template_url' ),
		'server_software' => $_SERVER['SERVER_SOFTWARE'],
		'server_signature' => $_SERVER['SERVER_SIGNATURE'],
	);
	foreach ( $plugins as $value ) {
		$infos['report_plugins'][ $value['Name'] ] = array(
			'Version' => $value['Version'],
			'PluginURI' => $value['PluginURI'],
		);
	}
	foreach ( $infos as $key => $info ) {
		if ( 'report_website' == $key ) {
			$message .= 'About WordPress:<br><br>name => ' . $info['name'] . '<br>version => ' . $info['version'];
			$message .= '<br>wpurl => ' . $info['wpurl'] . '<br>url => ' . $info['url'] . '<br>admin_email => ' . $info['admin_email'] . '<br>template url => ' . $info['template_url'];
			$message .= '<br>server_software => ' . $info['server_software'] . '<br>server_signature => ' . $info['server_signature'];
			$message .= '<br>wsid => ' . ( get_option( 'wsid' ) !== 0 ? get_option( 'wsid' ) : 'Undefined' );
			$message .= '<br><br>Header informations:<br><br>';
			foreach ( $header_infos as $key => $header_info ) {
				$message .= $key . ' => ' . $header_info . '<br>';
			}
		} else {
			$message .= '<br><br>Plugins:<br><br>';
			foreach ( $info as $key => $plugin ) {
				$message .= 'Name => ' . $key;
				$message .= '<br>Version => ' . $plugin['Version'];
				$message .= '<br>PluginURI => ' . $plugin['PluginURI'] . '<br><br>';
			}
		}
	}
	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	$verif = wp_mail( 'diagnostic@sqweb.com', $infos['report_website']['name'] . ' diagnostic', $message, $headers );
	if ( false !== $verif ) {
		SQweb_Admin::add_notice_event( 'success', __( sprintf( 'Your diagnostic has been sent to our support team and you should soon receive a receipt at: %s', get_option( 'admin_email' ) ), 'sqweb' ) );
	} else {
		SQweb_Admin::add_notice_event( 'warning', __( 'There was an error sending the diagnostic, please copy paste the diagnostic below and send it to: diagnostic@sqweb.com' , 'sqweb' ) );
	}
	wp_redirect( remove_query_arg( 'type' ) );
	exit;
} // End if().
