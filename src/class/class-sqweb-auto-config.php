<?php

/**
* Auto-Config Plugin SQweb
* @since 2.2.4
*/
class Auto_Config {

	public function __construct( $auto_config = false ) {
		if ( is_admin() ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( is_plugin_active( 'wp-super-cache/wp-cache.php' ) ) {
				$this->config_wpsc( $auto_config );
			}
			if ( is_plugin_active( 'w3-total-cache/w3-total-cache.php' ) ) {
				$this->config_w3tc( $auto_config );
			}
			if ( $auto_config ) {
				if ( function_exists( 'wp_redirect' ) ) {
					wp_redirect( remove_query_arg( 'sqw-auto-config' ) );
				}
			}
		}
	}

	private function config_wpsc( $auto_config ) {
		// global $wp_cache_mfunc_enabled, $wp_cache_mod_rewrite;
		// if ( ! $wp_cache_mod_rewrite ) {
		// 	if ( ! $wp_cache_mfunc_enabled ) {
		// 		$wp_cache_config_file   = WP_CONTENT_DIR . '/wp-cache-config.php';
		// 		$wp_cache_mfunc_enabled = 1;
		// 		if ( file_exists( $wp_cache_config_file ) ) {
		// 			$file = file_get_contents( $wp_cache_config_file );
		// 			$file = str_replace( '$wp_cache_mfunc_enabled = 0; //Added by WP-Cache Manager', '$wp_cache_mfunc_enabled = 1; //Edited by SQweb', $file );
		// 			* Automatic activate late init, deprecated since 2.1.1
		// 			$file = str_replace( '$wp_super_cache_late_init = 0; //Added by WP-Cache Manager', '$wp_super_cache_late_init = 1; //Edited by SQweb', $file );

		// 			file_put_contents( $wp_cache_config_file, $file );
		// 		}
		// 	}
		// } else {
		// 	add_action( 'admin_notices', array( $this, 'notice_mod_rewrite' ) );
		// }
		// if ( ! file_exists( WP_PLUGIN_DIR . '/wp-super-cache/plugins/sqweb.php' ) ) {
		// 	/** Install plugins on WP Super Cache */
		// 	$file = file_get_contents( WP_PLUGIN_DIR . '/sqweb/plugins/wp-super-cache.php' );
		// 	file_put_contents( WP_PLUGIN_DIR . '/wp-super-cache/plugins/sqweb.php', $file );
		// }
	}

	private function config_w3tc( $auto_config ) {
		$wp_master_path = WP_CONTENT_DIR . '/w3tc-config/master.json';
		/** Check if W3TC is enabled */
		if ( file_exists( $wp_master_path ) ) {
			$this->_w3tc = json_decode( file_get_contents( $wp_master_path ), true );
			if ( $this->_w3tc['pgcache.enabled'] ) {
				if ( ! defined( 'W3TC_DYNAMIC_SECURITY' ) ) {
					/** Define W3TC DYNAMIC SECURITY */
					$wp_cache_config_file = ABSPATH . '/wp-config.php';
					if ( file_exists( $wp_cache_config_file ) ) {
						$file = file_get_contents( $wp_cache_config_file );
						$file = str_replace( '/** Enable W3 Total Cache */', '/** Dynamic content for SQweb */
	define( \'W3TC_DYNAMIC_SECURITY\', \'' . md5( rand() ) . '\');

	/** Enable W3 Total Cache */', $file );
						file_put_contents( $wp_cache_config_file, $file );
					}
				}
				if ( ! $this->_w3tc['pgcache.late_init'] ) {
					/* Active Late Init */
					$this->_w3tc['pgcache.late_init'] = true;
				}
				if ( $this->_w3tc['browsercache.enabled'] ) {
					if ( $auto_config ) {
						$this->_w3tc['browsercache.enabled'] = false;
					} else {
						add_action( 'admin_notices', array( $this, 'notice_browser_cache' ) );
					}
				}
				if ( 'file' !== $this->_w3tc['pgcache.engine'] ) {
					if ( $auto_config ) {
						$this->_w3tc['pgcache.engine'] = 'file';
					} else {
						add_action( 'admin_notices', array( $this, 'notice_engine' ) );
					}
				}
				file_put_contents( $wp_master_path, json_encode( $this->_w3tc ) );
			}
		} // End if().
	}

	public static function is_w3tc_enabled() {
		/** Check if W3TC is enabled */
		$wp_master_path = WP_CONTENT_DIR . '/w3tc-config/master.json';
		$active_plugin  = get_option( 'active_plugins' );
		if ( in_array( 'w3-total-cache/w3-total-cache.php', $active_plugin ) ) {
			if ( file_exists( $wp_master_path ) ) {
				$w3tc = json_decode( file_get_contents( $wp_master_path ), true );
				if ( $w3tc['pgcache.enabled'] ) {
					return 1;
				}
			}
		}
		return 0;
	}

	public static function is_wpsc_enabled() {
		/** Check if WPSC is enabled */
		global $cache_enabled, $super_cache_enabled;
		if ( $cache_enabled && $super_cache_enabled && function_exists( 'add_cacheaction' ) ) {
			return 1;
		}
		return 0;
	}

	public function notice_mod_rewrite() {
	?>
	<div class="notice notice-error is-dismissible">
		<p>
		<?php
		_e( '<b>SQweb notice : </b>Cache with mod_rewrite detected, please switch to PHP cache or Legacy cache, you can click ', 'sqweb' );
		echo '<a href="' . add_query_arg( 'sqw-auto-config', '1' ) . '">';
		_e( 'here</a> for automatic configuration.', 'sqweb' );
		?>
		</p>
	</div>
	<?php
	}

	public function notice_browser_cache() {
	?>
	<div class="notice notice-error is-dismissible">
		<p>
		<?php
		_e( '<b>SQweb notice : </b>Browser cache from W3TC is enabled, is not compatible with SQweb, please disabled it, you can click ', 'sqweb' );
		echo '<a href="' . add_query_arg( 'sqw-auto-config', '1' ) . '">';
		_e( 'here</a> for automatic configuration.', 'sqweb' );
		?>
		</p>
	</div>
	<?php
	}

	public function notice_engine() {
	?>
	<div class="notice notice-error is-dismissible">
		<p>
		<?php
		_e( '<b>SQweb notice : </b>Dynamic content is not available in Disk: enhanced mod, please switch to Disk: basic, you can click ', 'sqweb' );
		echo '<a href="' . add_query_arg( 'sqw-auto-config', '1' ) . '">';
		_e( 'here</a> for automatic configuration.', 'sqweb' );
		?>
		</p>
	</div>
	<?php
	}
}
