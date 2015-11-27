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
