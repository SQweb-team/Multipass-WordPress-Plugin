<?php
/* ------------------------------------------------------------------------------------
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2008-2016 Arnan de Gans. All Rights Reserved.
*  ADROTATE is a trademark of Arnan de Gans.

*  COPYRIGHT NOTICES AND ALL THE COMMENTS SHOULD REMAIN INTACT.
*  By using this code you agree to indemnify Arnan de Gans from any
*  liability that might arise from it's use.
------------------------------------------------------------------------------------ */

/*-------------------------------------------------------------
Name:      adrotate_shortcode

Purpose:   Prepare function requests for calls on shortcodes
Receive:   $atts, $content
Return:    Function()
Since:     0.7
-------------------------------------------------------------*/
function adrotate_shortcode_sqw_compatibility( $atts, $content = null ) {
	global $adrotate_config;

	$banner_id = 0;
	$group_ids = 0;

	if ( ! empty( $atts['banner'] ) ) {
		$banner_id = trim( $atts['banner'], "\r\t " );
	}
	if ( ! empty( $atts['group'] ) ) {
		$group_ids = trim( $atts['group'], "\r\t " );
	}
	if ( ! empty( $atts['fallback'] ) ) {
		$fallback = 0;
	}
	if ( ! empty( $atts['weight'] ) ) {
		$weight = 0;
	}
	if ( ! empty( $atts['site'] ) ) {
		$site = 0;
	}
	if ( $banner_id > 0 and ( 0 == $group_ids or $group_ids > 0 ) ) { // Show one Ad
		SQweb_filter::get_instance()->add_ads( adrotate_ad( $banner_id, true, 0, 0 ) );
	}
	if ( 0 == $banner_id and $group_ids > 0 ) { // Show group
		SQweb_filter::get_instance()->add_ads( adrotate_group( $group_ids, 0, 0, 0 ) );
	}
}
