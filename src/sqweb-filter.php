<?php

/**
 * Try apply_filter with AdSense
 */

function filter_get_option( $value ) {
	return ('');
}

function filter_page_builder( $data = null, $object_id, $meta_key, $single ) {
	if ( 'wpi_page_builder_shortcode' == $meta_key ) {
		$meta_type = 'post';
		$meta_cache = wp_cache_get( $object_id, $meta_type . '_meta' );
		if ( ! $meta_cache ) {
			$meta_cache = update_meta_cache( $meta_type, array( $object_id ) );
			$meta_cache = $meta_cache[ $object_id ];
		}

		if ( ! $meta_key ) {
			return $meta_cache;
		}

		if ( isset( $meta_cache[ $meta_key ] ) ) {
			$meta_cache[ $meta_key ]['0'] = str_replace( '[wpi_ads_code_1]', '', $meta_cache[ $meta_key ]['0'] );
			if ( $single ) {
				return maybe_unserialize( $meta_cache[ $meta_key ][0] );
			} else {
				return array_map( 'maybe_unserialize', $meta_cache[ $meta_key ] ); }
		}

		if ( $single ) {
			return '';
		} else {
			return array();
		}
		return ('');
	}
	return null;
}

if ( sqweb_check_credentials( get_option( 'wsid' ) ) > 0 ) {

/**
 * Compatibility with most ads plugins
 */

	$array_option = [
						'ads_under_post_title_320',
						'ads_post_footer_700',
						'ads_post_footer_320',
						'ads_header_320',
						'ads_header_468',
						'ads_header_700',
					];

	foreach ( $array_option as $value ) {
		add_filter( 'option_'.$value, 'filter_get_option', 100 );
	}

/**
 * Compatibility with Page Builder
 */

	add_filter( 'get_post_metadata', 'filter_page_builder', true, 4 );
}
