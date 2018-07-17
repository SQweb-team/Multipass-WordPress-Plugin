<?php
/**
 * Compatibility with Wordpress super cache
 *
 * This method has not been updated since a long time, hence
 * the compatibility may not be complete anymore
 */
include_once( ABSPATH . 'wp-content/plugins/sqweb/sqweb-wsc-filter.php' );
$sqweb = SQweb_filter::get_instance();
