<?php

/**
 * Building javascript
 */

class BuildScript {

	private static $_wsid;
	private static $_fmes;
	private static $_lang;
	private static $_targets;
	private static $_blogname;
	private static $_login;
	private static $_support;
	private static $_autologin;
	private static $_connected;
	private static $_btn_noads;
	private static $_login_tiny;
	private static $_connected_s;
	private static $_btn_unlimited;
	private static $_connected_tiny;
	private static $_connected_support;

	/**
	 * Generating script
	 * @return string
	 */
	public function generate() {

		// phpcs:disable

		// Getting the options
		self::$_targets           = 'false';
		self::$_wsid              = ( get_option( 'wsid' ) != false ) ? get_option( 'wsid' ) : '0';
		self::$_fmes              = ( get_option( 'fmes' ) != false ) ? get_option( 'fmes' ) : '';
		self::$_lang              = ( get_option( 'sqw_lang' ) != false ) ? get_option( 'sqw_lang' ) : 'en';
		self::$_login             = ( get_option( 'sqw_btn_login' ) != false ) ? get_option( 'sqw_btn_login' ) : '';
		self::$_support           = ( get_option( 'sqw_btn_support' ) != false ) ? get_option( 'sqw_btn_support' ) : '';
		self::$_connected         = ( get_option( 'sqw_btn_connected' ) != false ) ? get_option( 'sqw_btn_connected' ) : '';
		self::$_btn_noads         = ( get_option( 'sqw_btn_noads' ) != false ) ? get_option( 'sqw_btn_noads' ) : '';
		self::$_autologin         = ( get_option( 'sqw_autologin' ) != false ) ? false : true;
		self::$_login_tiny        = ( get_option( 'sqw_btn_login_tiny' ) != false ) ? get_option( 'sqw_btn_login_tiny' ) : '';
		self::$_connected_s       = ( get_option( 'sqw_btn_connected_s' ) != false ) ? get_option( 'sqw_btn_connected_s' ) : '';
		self::$_btn_unlimited     = ( get_option( 'sqw_btn_unlimited' ) != false ) ? get_option( 'sqw_btn_unlimited' ) : '';
		self::$_connected_tiny    = ( get_option( 'sqw_btn_connected_tiny' ) != false ) ? get_option( 'sqw_btn_connected_tiny' ) : '';
		self::$_connected_support = ( get_option( 'sqw_btn_connected_support' ) != false ) ? get_option( 'sqw_btn_connected_support' ) : '';

		if ( function_exists( 'get_blog_details' ) ) {
			$current_site    = get_blog_details();
			self::$_blogname = $current_site->blogname;
		} else {
			self::$_blogname = get_option( 'blogname' );
		}

		// Assembling
		$settings = json_encode(array(
			'wsid'         => self::$_wsid,
			'sitename'     => self::$_blogname,
			'debug'        => false,
			'targeting'    => self::$_targets,
			'locale'       => self::$_lang,
			'autologin'    => self::$_autologin,
			'user_strings' => array(
				'login'             => self::$_login,
				'login_tiny'        => self::$_login_tiny,
				'connected'         => self::$_connected,
				'connected_tiny'    => self::$_connected_tiny,
				'connected_s'       => self::$_connected_s,
				'btn_unlimited'     => self::$_btn_unlimited,
				'btn_noads'         => self::$_btn_noads,
				'support'           => self::$_support,
				'connected_support' => self::$_connected_support,
			),
		));

		// phpcs:enable

		$output  = '<script src="https://cdn.multipass.net/mltpss.min.js" type="text/javascript"></script>' . PHP_EOL;
		$output .= '<script>/* SQweb v' . ( defined( 'SQW_VERSION' ) ? SQW_VERSION : '2.9.3' ) . ' */ var mltpss = new Multipass.default(' . $settings . ');</script>';

		echo $output;
	}

	/**
	 * Saving custom script to file
	 * @return 0
	 */
	public static function save() {
		if ( get_option( 'wsid' ) ) {
			$script = new BuildScript;
			add_action( 'wp_footer', array( $script, 'generate' ) );
		}
		return ( 0 );
	}
}
