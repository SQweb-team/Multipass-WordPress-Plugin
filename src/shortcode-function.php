<?php
/**
 * Shortcode Function
 */

function sqweb_button_short_code( $atts = array(), $content = null, $tag = '' ) {

	$wporg_atts = shortcode_atts( array(
		'type' => 'normal',
	), $atts, $tag );

	echo '<div class="sqweb-button' . ( 'normal' !== $wporg_atts['type'] ? ' multipass-' . $wporg_atts['type'] : '' ) . '"></div>';
}

function sqweb_add_filter_short_code( $atts = array(), $content = null, $tag = '' ) {

	$wporg_atts = shortcode_atts( array(
		'ads' => 'ad',
		'premium' => ""
	), $atts, $tag);

	if ( apply_filters( 'sqw_check_credentials', get_option( 'wsid' ) ) ) {
		echo $wporg_atts['premium'];
	} else {
		echo $wporg_atts['ads'];
	}
}

add_shortcode( 'sqweb_button', 'sqweb_button_short_code' );

add_shortcode( 'sqweb_add_filter', 'sqweb_add_filter_short_code' );
