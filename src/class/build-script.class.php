<?php

/**
 * Building javascript
 */

class BuildScript
{
	private static $_wmid;
	private static $_wsid;
	private static $_flogin;
	private static $_flogout;
	private static $_fmes;
	private static $_lang;
	private static $_targets;

	/**
	 * Generating script
	 * @return string
	 */
	public function generate() {

		// Getting the options
		self::$_wmid = (get_option( 'wmid' ) !== '') ? get_option( 'wmid' ) : '0';
		self::$_wsid = (get_option( 'wsid' ) !== '') ? get_option( 'wsid' ) : '0';
		self::$_targets = (get_option( 'targets' ) !== '' && get_option( 'targets' ) != 'oa') ? get_option( 'targets' ) : 'false';
		self::$_fmes = (get_option( 'fmes' ) !== '') ? get_option( 'fmes' ) : '';
		self::$_lang = (get_option( 'lang' ) !== '') ? get_option( 'lang' ) : 'en';
		self::$_flogin = (get_option( 'flogin' ) !== '') ? get_option( 'flogin' ) : 'Remove ads';
		self::$_flogout = (get_option( 'flogout' ) !== '') ? get_option( 'flogout' ) : 'Connected';
		// Assembling
		echo '<script data-cfasync="false">var _sqw = {
					id_webmaster: ' . self::$_wmid . ',
					id_site: ' . self::$_wsid . ',
					debug: false,
					targeting: ' . self::$_targets . ',
					msg: "' . addslashes( self::$_fmes ) . '",
					i18n: "' . self::$_lang . '"
				};
				var _sqw_i18n = {
					login: "' . self::$_flogin . '",
					register: "Signup",
					logout: "' . self::$_flogout . '"
				};
				var script = document.createElement("script");
				script.type = "text/javascript";
				script.src = "//cdn.sqweb.com/sqweb-beta.js";
				document.getElementsByTagName("head")[0].appendChild(script);</script>';
	}

	/**
	 * Saving custom script to file
	 * @return int
	 */
	public static function save() {
		$script = new BuildScript;
		add_action( 'wp_footer', array( $script, 'generate' ) );
		return ( 0 );
	}
}
