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

/**
 * @SuppressWarnings(PHPMD.Superglobals)
 */
function sqw_site_url() {
	$protocol = ( ! empty( $_SERVER['HTTPS'] ) && 'off' !== $_SERVER['HTTPS'] || 443 === $_SERVER['SERVER_PORT'] ) ? 'https://' : 'http://';
	return $protocol . $_SERVER['HTTP_HOST'];
}

// Self-Explanatory
define( 'SQW_ENDPOINT', 'https://api.multipass.net/' );
define( 'DEBUG_MODE', 0 );
define( 'SQW_VERSION', '2.9.3' );
