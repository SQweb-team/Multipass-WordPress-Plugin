<?php

/**
 * Building javascript
 */

class BuildScript {

	private static $_wsid;
	private static $_fmes;
	private static $_lang;
	private static $_popup;
	private static $_targets;
	private static $_blogname;
	private static $_login;
	private static $_support;
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

		// Getting the options
		self::$_targets           = 'false';
		self::$_wsid              = ( get_option( 'wsid' ) != false ) ? get_option( 'wsid' ) : '0';
		self::$_fmes              = ( get_option( 'fmes' ) != false ) ? get_option( 'fmes' ) : '';
		self::$_lang              = ( get_option( 'sqw_lang' ) != false ) ? get_option( 'sqw_lang' ) : 'en';
		self::$_popup             = ( get_option( 'sqw_popup' ) != false ) ? get_option( 'sqw_popup' ) : 'false';
		self::$_login             = ( get_option( 'sqw_btn_login' ) != false ) ? get_option( 'sqw_btn_login' ) : '';
		self::$_support           = ( get_option( 'sqw_btn_support' ) != false ) ? get_option( 'sqw_btn_support' ) : '';
		self::$_connected         = ( get_option( 'sqw_btn_connected' ) != false ) ? get_option( 'sqw_btn_connected' ) : '';
		self::$_btn_noads         = ( get_option( 'sqw_btn_noads' ) != false ) ? get_option( 'sqw_btn_noads' ) : '';
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
		echo '
			<script data-cfasync="false">
				/**
				 * SQweb v' . ( defined( 'SQW_VERSION' ) ? SQW_VERSION : '2.7.8' ) . '
				 **/
				var _sqw = {
					id_site: ' . self::$_wsid . ',
					debug: false,
					adblock_modal: ' . self::$_popup . ',
					targeting: ' . self::$_targets . ',
					sitename: "' . self::$_blogname . '",
					msg: "' . self::$_fmes . '",
					i18n: "' . self::$_lang . '",
					login: "' . self::$_login . '",
					connected: "' . self::$_connected . '",
					support: "' . self::$_support . '",
					btn_noads: "' . self::$_btn_noads . '",
					login_tiny: "' . self::$_login_tiny . '",
					connected_s: "' . self::$_connected_s . '",
					btn_unlimited: "' . self::$_btn_unlimited . '",
					connected_tiny: "' . self::$_connected_tiny . '"
				};
				var _sqw_i18n = {
					register: "Signup",
				};
				var script = document.createElement("script");
				script.type = "text/javascript";
				script.src = "https://cdn.multipass.net/multipass.js";
				document.getElementsByTagName("head")[0].appendChild(script);
			</script>';
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
