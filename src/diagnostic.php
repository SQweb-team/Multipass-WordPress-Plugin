<?php
/**
 * Get information about the WordPress installation, template and all installed plugins.
 */
if ( ! empty( $_GET['type'] ) && 'diagnostic' == $_GET['type'] ) {
	$plugins = get_plugins();
	$infos = array();
	$infos['report_website'] = array(
		'name' => get_bloginfo( 'name' ),
		'version' => get_bloginfo( 'version' ),
		'wpurl' => get_bloginfo( 'wpurl' ),
		'url' => get_bloginfo( 'url' ),
		'admin_email' => get_bloginfo( 'admin_email' ),
		'template_url' => get_bloginfo( 'template_url' ),
	);
	foreach ( $plugins as $value ) {
		$infos['report_plugins'][ $value['Name'] ] = array(
			'Version' => $value['Version'],
			'PluginURI' => $value['PluginURI'],
		);
	}
	$message = '';
	$headers = array( 'Content-Type: text/html; charset=UTF-8' );
	foreach ( $infos as $key => $info ) {
		if ( 'report_website' == $key ) {
			$message .= 'About WordPress:<br><br>name => ' . $info['name'] . '<br>version => ' . $info['version'];
			$message .= '<br>wpurl => ' . $info['wpurl'] . '<br>url => ' . $info['url'] . '<br>admin_email => ' . $info['admin_email'] . '<br>template url => ' . $info['template_url'];
		} else {
			$message .= '<br><br>Plugins: <br><br>';
			foreach ( $info as $key => $plugin ) {
				$message .= 'Name => ' . $key;
				$message .= '<br>Version => ' . $plugin['Version'];
				$message .= '<br>PluginURI => ' . $plugin['PluginURI'] . '<br><br>';
			}
		}
	}
	$verif = wp_mail( 'hello@sqweb.com', $infos['report_website']['name'] . ' diagnostic', $message, $headers );
	SQweb_Admin::add_notice_event( 'success', __( 'Your diagnostic has been sent to our support team.', 'sqweb' ) );
	wp_redirect( remove_query_arg( 'type' ) );
	exit;
} // End if().
