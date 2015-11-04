<?php

/**
 * SQweb Config file
 *
 *
 * @category Plugin
 * @package  SQwebv2
 * @author   Thibaud de La Villarmois
 * @link     https://sqweb.com
 */

global $wpdb;

function sqw_site_url() {
	$protocol = ( ! empty( $_SERVER['HTTPS'] ) && 'off' !== $_SERVER['HTTPS'] || 443 == $_SERVER['SERVER_PORT'] ) ? 'https://' : 'http://';
	return $protocol . $_SERVER['HTTP_HOST'];
}
define( 'SQW_CURRENT_URL', sqw_site_url() );

define( 'SQW_PLUGIN_NAME', 'sqweb' );

// Upload folder for upload purpose.
$upload_folder = wp_upload_dir();
define( 'SQW_UPLOAD_DIR', $upload_folder['basedir'] );

// Upload folder for display purpose.
define( 'SQW_UPLOAD_URL', $upload_folder['baseurl'] );

// Plug in directory absolute address.
define( 'SQW_PLUGIN_DIR', plugins_url( __FILE__ ) );

// Plug in directory for upload and writing purpose.
$path = plugin_dir_path( __FILE__ );
define( 'SQW_PLUGIN_DIR_U', $path );

// Salt used to hash the captcha string, customize it how you like
// even though id advise you to just execute a faceroll on your keyboard.
define( 'SQW_SALT_CAPTCHA', 'JKEIUZANEIUAZ87248732H8ENDSZ2DNS2NEND3U82ND8' );

// SQL tables.
define( 'SQW_T_SQWEB', $wpdb->prefix . 'sqweb' );

// Title for admin section.
define( 'SQW_PLUGIN_ADMIN_TITLE', 'SQwebAdmin' );

// Url the webmaster is sent to when asked to add a new website
define( 'SQW_SIGNUP_URL', 'https://www.sqweb.com/websites' );

// Self-Explanatory
define( 'SQW_ENDPOINT', 'https://api.sqweb.com/' );
