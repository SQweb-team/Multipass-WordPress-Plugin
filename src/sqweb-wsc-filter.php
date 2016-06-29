<?php
/**
* SQweb special filter
*/
include_once( 'config.php' );
include_once( 'functions.php' );

class SQweb_filter
{
	private static $_instance = null;
	private $_ads;
	private $_text;
	private $_wsid;
	private $_data_set = false;
	private $_w3tc;

	public function __construct() {

		if ( ! defined( 'WP_CONTENT_DIR' ) ) {
			define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content/' );
		}
		if ( ! defined( 'WP_PLUGIN_DIR' ) ) {
			define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/plugins/' );
		}
		global $wp_cache_mfunc_enabled, $cache_enabled, $super_cache_enabled;
		if ( $cache_enabled && $super_cache_enabled ) {
			if ( ! file_exists( WP_PLUGIN_DIR . '/wp-super-cache/plugins/sqweb.php' ) ) {
				/** Install plugins on WP Super Cache */
				$file = file_get_contents( WP_PLUGIN_DIR . '/sqweb/plugins/wp-super-cache.php' );
				file_put_contents( WP_PLUGIN_DIR . '/wp-super-cache/plugins/sqweb.php', $file );
			}
			if ( ! $wp_cache_mfunc_enabled ) {
				$this->enable_dynamic_cache();
			}
			add_cacheaction( 'wpsc_cachedata_safety', function ( $safety ) { return 1; } );
			add_cacheaction( 'wpsc_cachedata', array( $this, 'display_ads_with_wpsc' ) );
		}
		$this->get_w3tc_settings();
	}

	public static function get_instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new SQweb_filter();
		}
		return self::$_instance;
	}

	public function notice_mod_rewrite() {
	?>
	<div class="notice notice-error is-dismissible">
		<p><?php _e( '<b>SQweb notice : </b>Cache with mod_rewrite detected, please change to PHP cache or Legacy cache.', 'sqweb' ); ?></p>
	</div>
	<?php
	}

	public function notice_browser_cache() {
	?>
	<div class="notice notice-error is-dismissible">
		<p><?php _e( '<b>SQweb notice : </b>Browser cache from W3TC is enabled, is not compatible with page cache method : Disk: Basic, please disabled it.', 'sqweb' ); ?></p>
	</div>
	<?php
	}

	public function notice_engine() {
	?>
	<div class="notice notice-error is-dismissible">
		<p><?php _e( '<b>SQweb notice : </b>Dynamic content is not available in Disk: enhanced mod, please switch on Disk: basic.', 'sqweb' ); ?></p>
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
			/** Automatic activate late init, deprecated since 2.1.1
			$file = str_replace( '$wp_super_cache_late_init = 0; //Added by WP-Cache Manager', '$wp_super_cache_late_init = 1; //Edited by SQweb', $file );
			*/
			file_put_contents( $wp_cache_config_file, $file );
		} else {
			add_action( 'admin_notices', array( $this, 'notice_mod_rewrite' ) );
		}
	}

	public function get_w3tc_settings() {
		$wp_master_path = WP_CONTENT_DIR . '/w3tc-config/master.php';
		/** Check if W3TC is enabled */
		if ( file_exists( $wp_master_path ) ) {
			$this->_w3tc = include( $wp_master_path );
			if ( $this->_w3tc['pgcache.enabled'] ) {
				if ( ! $this->_w3tc['pgcache.late_init'] ) {
					/* Active Late Init */
					$file = file_get_contents( $wp_master_path );
					$file = str_replace( '\'pgcache.late_init\' => false', '\'pgcache.late_init\' => true', $file );
					file_put_contents( $wp_master_path, $file );
				}
				if ( ! defined( 'W3TC_DYNAMIC_SECURITY' ) ) {
					/** Define W3TC DYNAMIC SECURITY */
					$wp_cache_config_file = ABSPATH . '/wp-config.php';
					$file = file_get_contents( $wp_cache_config_file );
					$file = str_replace( '/** Enable W3 Total Cache */', '/** Dynamic content for SQweb */
define( \'W3TC_DYNAMIC_SECURITY\', \'' . md5( rand() ) . '\');

/** Enable W3 Total Cache */', $file );
					file_put_contents( $wp_cache_config_file, $file );
				}
				if (  $this->_w3tc['browsercache.enabled'] ) {
					add_action( 'admin_notices', array( $this, 'notice_browser_cache' ) );
				}
				if ( 'file' !== $this->_w3tc['pgcache.engine'] ) {
					add_action( 'admin_notices', array( $this, 'notice_engine' ) );
				}
			}
		}
	}

	public function set_data() {
		if ( ! $this->_data_set ) {
			$sqweb_config_path = WP_PLUGIN_DIR . '/sqweb/sqweb-config.php';
			$sqweb_config = include( $sqweb_config_path );
			$this->_ads = unserialize( base64_decode( $sqweb_config['filter.ads'] ) );
			$this->_text = unserialize( base64_decode( $sqweb_config['filter.text'] ) );
			$this->_wsid = $sqweb_config['wsid'];
			$this->_data_set = true;
		}
	}

	public function add_ads( $ads, $text = null ) {

		$this->set_data();
		if ( ! in_array( $ads, $this->_ads ) ) {
			$sqweb_config_path = WP_PLUGIN_DIR . '/sqweb/sqweb-config.php';
			$key = md5( rand() );
			$this->_ads[ $key ] = $ads;
			$this->_text[ $key ] = $text;
			$content = '<?php

return array(
	\'wsid\' => ' . get_option( 'wsid' ) . ',
	\'filter.ads\' => \'' . base64_encode( serialize( $this->_ads ) ) . '\',
	\'filter.text\' => \'' . base64_encode( serialize( $this->_text ) ) . '\'
);';
			file_put_contents( $sqweb_config_path, $content );
		} else {
			$key = array_search( $ads, $this->_ads );
		}
		$this->display_ads( $key );
	}

	private function display_ads( $key ) {

		global $cache_enabled, $super_cache_enabled;

		if ( $cache_enabled && $super_cache_enabled ) {
			echo $key;
		} elseif ( $this->_w3tc['pgcache.enabled'] ) {
			?>
			<!--mfunc <?php echo W3TC_DYNAMIC_SECURITY; ?> -->
				$sqweb_config = include( '<?php echo WP_PLUGIN_DIR; ?>/sqweb/sqweb-config.php' );
				include_once( '<?php echo WP_PLUGIN_DIR; ?>/sqweb/functions.php');
				if ( sqweb_check_credentials(<?php echo $this->_wsid; ?>) > 0 ) {
					echo base64_decode('<?php echo base64_encode($this->_text[$key]); ?>');
				} else {
					echo base64_decode('<?php echo base64_encode($this->_ads[$key]); ?>');
				}
			<!--/mfunc <?php echo W3TC_DYNAMIC_SECURITY; ?> -->
			<?php
		} else {
			if ( sqweb_check_credentials( $this->_wsid ) > 0 ) {
				echo $this->_text[ $key ];
			} else {
				echo $this->_ads[ $key ];
			}
		}
	}

	public function display_ads_with_wpsc( &$cache ) {
		$this->set_data();
		if ( sqweb_check_credentials( $this->_wsid ) > 0 ) {
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
}

SQweb_filter::get_instance();
