<?php
/**
 * Shortcode Function
 */

function sqweb_button_short_code() {
	$get_options['btheme'] = get_option( 'btheme' );
	if ( 'grey' == $get_options['btheme'] ) {
		echo '<div class="sqweb-button sqweb-grey"></div>';
	} else {
		echo '<div class="sqweb-button"></div>';
	}
}

/*
remove because bugued
function sqweb_ad_control_short_code( $atts ) {
	$arg = shortcode_atts( array(
		'ads' => '',
		'content' => '',
		), $atts );
	$ads = $arg['ads'];
	$text = $arg['content'];
	$wsid = get_option( 'wsid' );
	if ( sqweb_check_credentials( $wsid ) > 0 ) {
		echo $text;
	} else {
		echo $ads;
	}
}*/
