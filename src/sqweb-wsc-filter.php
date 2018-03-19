<?php
/**
* SQweb special filter
*/
include_once( 'config.php' );
include_once( 'functions.php' );
include_once( 'class/class-sqweb-auto-config.php' );

/*
	Disabling PHPCS on this class name, following an update to WordPress' coding style.
	Otherwise, we'd break backwards compatibility.
 */
class SQweb_filter { // @codingStandardsIgnoreStart

	private static $_instance = null;
	private $_ads;
	private $_text;
	private $_wsid;
	private $_data_set = false;
	private $_type_cache = 0;

	public function __construct() {

		if ( ! defined( 'WP_CONTENT_DIR' ) ) {
			define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
		}
		if ( ! defined( 'WP_PLUGIN_DIR' ) && defined( 'WP_CONTENT_DIR' ) ) {
			define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins' );
		}
		if ( ! defined( 'WP_CONTENT_DIR' ) || ! defined( 'WP_PLUGIN_DIR' ) ) {
			deactivate_plugins( 'sqweb/sqweb.php' );
		}
		if ( function_exists( 'add_action' ) ) {
			add_action( 'sqweb_daily_event', array( $this, 'clean_data' ) );
		}
		// if ( Auto_Config::is_wpsc_enabled() ) {
		// 	$this->_type_cache = 'wp_super_cache';
		// 	add_cacheaction( 'wpsc_cachedata_safety', function ( $safety ) { return 1; } );
		// 	add_cacheaction( 'wpsc_cachedata', array( $this, 'display_content_with_wpsc' ) );
		// } elseif ( Auto_Config::is_w3tc_enabled() ) {
		// 	$this->_type_cache = 'w3tc';
		// }
	}

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new SQweb_filter();
		}
		return self::$_instance;
	}

	public function filter_option( $value ) {
		$this->add_ads( $value, null, false );
	}

	private function option_ads_check() {
		$array_option = array(
			'ads_under_post_title_320',
			'ads_post_footer_700',
			'ads_post_footer_320',
			'ads_header_320',
			'ads_header_468',
			'ads_header_700',
		);

		foreach ( $array_option as $value ) {
			add_filter( 'option_' . $value, array( $this, 'filter_get_option' ), 100 );
		}
	}

	private function set_data() {
		if ( ! $this->_data_set ) {
			$sqweb_config_path = plugin_dir_path( __FILE__ ) . 'sqweb-config.php';
			$sqweb_config = include( $sqweb_config_path );
			$this->_ads = unserialize( base64_decode( $sqweb_config['filter.ads'] ) );
			$this->_text = unserialize( base64_decode( $sqweb_config['filter.text'] ) );
			$this->_wsid = $sqweb_config['wsid'];
			$this->_data_set = true;
		}
	}

	private function generate_random_string( $length = 128 ) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $characters_length = strlen( $characters );
	    $random_string = '';
	    for ( $i = 0; $i < $length; $i++ ) {
	        $random_string .= $characters[ rand( 0, $characters_length - 1 ) ];
	    }
	    return $random_string;
	}

	public function add_ads( $ads, $text = null, $display_now = true ) {

		$this->set_data();
		if ( ! in_array( $ads, $this->_ads ) ) {
			$sqweb_config_path = plugin_dir_path( __FILE__ ) . 'sqweb-config.php';
			$key = $this->generate_random_string( rand( 32, 128 ) );
			$this->_ads[ $key ] = $ads;
			$this->_text[ $key ] = $text;
			$content = file_get_contents( $sqweb_config_path );
			$content = preg_replace( '/(?<=\'wsid\' => )\d+(?=,)/', ( get_option( 'wsid' ) != false ? get_option( 'wsid' ) : 0 ), $content );
			$content = preg_replace( '/(?<=\'filter\.ads\' => \').+(?=\',)/', base64_encode( serialize( $this->_ads ) ), $content );
			$content = preg_replace( '/(?<=\'filter\.text\' => \').+(?=\',)/', base64_encode( serialize( $this->_text ) ), $content );
			file_put_contents( $sqweb_config_path, $content );
		} else {
			$key = array_search( $ads, $this->_ads );
		}
		if ( $display_now ) {
			$this->display_ads( $key );
		}
	}

	public function use_ads( $key ) {

		$this->set_data();
		$this->display_ads( $key );
	}

	private function display_ads( $key ) {
		if ( 'wp_super_cache' === $this->_type_cache ) {
			echo $key;
		} elseif ( 'w3tc' === $this->_type_cache ) {
				?>
				<!--mfunc <?php echo W3TC_DYNAMIC_SECURITY; ?> -->
					$sqweb_config = include( '<?php echo WP_PLUGIN_DIR; ?>/sqweb/sqweb-config.php' );
					include_once( '<?php echo WP_PLUGIN_DIR; ?>/sqweb/functions.php' );
					if ( apply_filters( 'sqw_check_credentials', <?php echo $this->_wsid; ?>) > 0 ) {
						echo base64_decode('<?php echo base64_encode( $this->_text[ $key ] ); ?>');
					} else {
						echo base64_decode('<?php echo base64_encode( $this->_ads[ $key ] ); ?>');
					}
				<!--/mfunc <?php echo W3TC_DYNAMIC_SECURITY; ?> -->
				<?php
		} else {
			if ( apply_filters( 'sqw_check_credentials', $this->_wsid ) ) {
				echo $this->_text[ $key ];
			} else {
				echo $this->_ads[ $key ];
			}
		}
	}

	public function display_content_with_wpsc( &$cache ) {
		$this->set_data();
		if ( ! empty( $this->_ads ) ) {
			if ( ( function_exists( 'apply_filters' ) && apply_filters( 'sqw_check_credentials', $this->_wsid ) ) || sqweb_check_credentials( $this->_wsid ) ) {
				foreach ( $this->_text as $key => $text ) {
					$cache = str_replace( $key, $text, $cache );
				}
			} else {
				foreach ( $this->_ads as $key => $ads ) {
					$cache = str_replace( $key, $ads, $cache );
				}
			}
		}
		return $cache;
	}

	public function clean_data() {
		global $wpdb;
		if ( $wpdb->get_var( "SHOW TABLES LIKE '{$wpdb->prefix}sqw_limit'" ) == $wpdb->prefix.'sqw_limit' ) {
			$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}sqw_limit WHERE time <= %d", array( ( time() - 86400 ) ) ) );
		}
	}
}

SQweb_filter::get_instance();
