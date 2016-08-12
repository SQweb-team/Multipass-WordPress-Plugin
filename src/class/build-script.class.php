<?php

/**
 * Building javascript
 */

class BuildScript {

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
		self::$_wsid = (get_option( 'wsid' ) != false) ? get_option( 'wsid' ) : '0';
		self::$_targets = 'false';
		self::$_fmes = (get_option( 'fmes' ) != false) ? get_option( 'fmes' ) : '';
		self::$_lang = (get_option( 'lang' ) != false) ? get_option( 'lang' ) : 'en';
		self::$_flogin = (get_option( 'flogin' ) != false) ? get_option( 'flogin' ) : 'Remove ads';
		self::$_flogout = (get_option( 'flogout' ) != false) ? get_option( 'flogout' ) : 'Connected';
		// Assembling
		echo '
			<script data-cfasync="false">
				/**
				 * SQweb v' . ( defined( 'SQW_VERSION' ) ? SQW_VERSION : '1.0.0' ) . '
				 **/
				var _sqw = {
					id_site: ' . self::$_wsid . ',
					debug: false,
					targeting: ' . self::$_targets . ',
					msg: "' . self::$_fmes . '",
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
				document.getElementsByTagName("head")[0].appendChild(script);
			</script>';
	}

	/**
	 * Saving custom script to file
	 * @return int
	 */
	public static function save() {
		if ( get_option( 'wsid' ) ) {
			$script = new BuildScript;
			add_action( 'wp_footer', array( $script, 'generate' ) );
		}
		return ( 0 );
	}
}
