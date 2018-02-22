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
		'ads'     => 'ad',
		'premium' => '',
	), $atts, $tag);

	$premium = preg_replace( '/&#093;/', ']', $wporg_atts['premium'] );
	$ads     = preg_replace( '/&#093;/', ']', $wporg_atts['ads'] );

	if ( apply_filters( 'sqw_check_credentials', get_option( 'wsid' ) ) ) {
		echo $premium;
	} else {
		echo $ads;
	}
}

function sqweb_support_button_short_code( $atts = array(), $content = null, $tag = '' ) {
	if ( sqweb_check_credentials( get_option( 'wsid' ) ) === false ) {
		echo sqw_support_button_html();
	}
}

add_shortcode( 'sqweb_support_us', 'sqweb_support_button_short_code' );

add_shortcode( 'sqweb_button', 'sqweb_button_short_code' );

add_shortcode( 'sqweb_add_filter', 'sqweb_add_filter_short_code' );
