<?php

/**
 * SQweb Config file
 *
 * @category Plugin
 * @package  SQweb
 * @author   SQweb Team
 * @link     https://www.sqweb.com
 */

global $wpdb;

if ( ! empty( $_GET['page'] ) && is_admin() && 'SQwebAdmin' == $_GET['page'] ) {
	ob_start();
}

function sqw_site_url() {

	$protocol = ( ! empty( $_SERVER['HTTPS'] ) && 'off' !== $_SERVER['HTTPS'] || 443 == $_SERVER['SERVER_PORT'] ) ? 'https://' : 'http://';
	return $protocol . $_SERVER['HTTP_HOST'];
}

// Self-Explanatory
define( 'SQW_ENDPOINT', 'https://api.sqweb.com/' );
define( 'DEBUG_MODE', 0);
