<?php

/**
 * Try apply_filter to adsense
 */

function filter_get_option( $value ) {

	if ( sqweb_check_credentials( get_option( 'wsid' ) ) > 0 ) {
		return ('');
	}
	return $value;
}

$array_option = [
					'ads',
					'ads_under_post_title_320',
					'ads_post_footer_700',
					'ads_post_footer_320',
					'ads_header_320',
				];

foreach ( $array_option as $value ) {
	add_filter( 'option_'.$value, 'filter_get_option', 100 );
}
