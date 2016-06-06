<?php
/**
* SQweb special filter
*/

class SQweb_filter
{
	private static $_instance = null;
	private $_ads;
	private $_text;
	private $_data_set = false;

	public function __construct() {

		global $wp_cache_mfunc_enabled, $cache_enabled, $super_cache_enabled;
		if ( $cache_enabled && $super_cache_enabled ) {
			if ( ! $wp_cache_mfunc_enabled ) {
				$this->enable_dynamic_cache();
			}
			add_cacheaction( 'wpsc_cachedata_safety', function ( $safety ) { return 1; } );
			add_cacheaction( 'wpsc_cachedata', array( $this, 'display_ads_with_wpsc' ) );
		}
	}

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new SQweb_filter();
		}
		return self::$_instance;
	}

	public function notice() {
	?>
	<div class="notice notice-error is-dismissible">
		<p><?php _e( '<b>SQweb notice : </b>Cache with mod_rewrite detected, please change to PHP cache or Legacy cache.', 'sqweb' ); ?></p>
	</div>
	<?php
	}

	public function enable_dynamic_cache() {
		global $wp_cache_mfunc_enabled, $wp_cache_mod_rewrite, $wp_super_cache_late_init;
		if ( ! $wp_cache_mod_rewrite || ! $wp_super_cache_late_init ) {
			$wp_cache_config_file = WP_CONTENT_DIR . '/wp-cache-config.php';
			$wp_cache_mfunc_enabled = 1;
			$file = file_get_contents( $wp_cache_config_file );
			$file = str_replace( '$wp_cache_mfunc_enabled = 0; //Added by WP-Cache Manager', '$wp_cache_mfunc_enabled = 1; //Edited by SQweb', $file );
			$file = str_replace( '$wp_super_cache_late_init = 0; //Added by WP-Cache Manager', '$wp_super_cache_late_init = 1; //Edited by SQweb', $file );
			file_put_contents( $wp_cache_config_file, $file );
		} else {
			add_action( 'admin_notices', array( $this, 'notice' ) );
		}
	}

	public function set_data() {
		if ( ! $this->_data_set ) {
			$this->_ads = unserialize( get_option( 'sqw_ads' ) );
			$this->_text = unserialize( get_option( ' sqw_text' ) );
			$this->_ads = $this->_ads ? $this->_ads : array();
			$this->_text = $this->_text ? $this->_text : array();
			$this->_data_set = true;
		}
	}

	public function add_ads( $ads, $text = null ) {

		$this->set_data();
		if ( ! in_array( $ads, $this->_ads ) ) {
			$key = md5( rand() );
			$this->_ads[ $key ] = $ads;
			$this->_text[ $key ] = $text;
			update_option( 'sqw_ads', serialize( $this->_ads ) );
			update_option( 'sqw_text', serialize( $this->_text ) );
		} else {
			$key = array_search( $ads, $this->_ads );
		}
		$this->display_ads( $key );
	}

	private function display_ads( $key ) {

		global $cache_enabled, $super_cache_enabled;
		if ( $cache_enabled && $super_cache_enabled ) {
			echo $key;
		} else {
			if ( sqweb_check_credentials() > 0 ) {
				echo $this->_text[ $key ];
			} else {
				echo $this->_ads[ $key ];
			}
		}
	}

	public function display_ads_with_wpsc( &$cache ) {
		$this->set_data();
		if ( sqweb_check_credentials() > 0 ) {
			foreach ( $this->_text as $key => $text ) {
				$cache = str_replace( $key, $text, $cache );
			}
		} else {
			foreach ( $this->_ads as $key => $ads ) {
				$cache = str_replace( $key, $ads, $cache );
			}
		}
		return $cache;
	}

	public function reset_ads() {

		delete_option( 'sqw_ads' );
		delete_option( 'sqw_text' );
	}
}

SQweb_filter::get_instance();
