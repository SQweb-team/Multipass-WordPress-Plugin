<?php

/**
 * Building javascript
 */

class BuildScript
{
	private static $wmid;
	private static $wsid;
	private static $flogin;
	private static $flogout;
	private static $fmes;
	private static $lang;
	private static $targets;

	/**
	 * Generating script
	 * @return string
	 */
	public function generate() {

		// Getting the options
		self::$wmid = (get_option( 'wmid' ) !== '') ? get_option( 'wmid' ) : '0';
		self::$wsid = (get_option( 'wsid' ) !== '') ? get_option( 'wsid' ) : '0';
		self::$targets = (get_option( 'targets' ) !== '') ? get_option( 'targets' ) : 'false';
		self::$fmes = addcslashes( ((get_option( 'fmes' ) !== '') ? get_option( 'fmes' ) : ''), '\'' );
		self::$lang = (get_option( 'lang' ) !== '') ? get_option( 'lang' ) : 'en';
		self::$flogin = (get_option( 'flogin' ) !== '') ? get_option( 'flogin' ) : 'Remove ads';
		self::$flogout = (get_option( 'flogout' ) !== '') ? get_option( 'flogout' ) : 'Connected';
		// Assembling
		echo '<script>var _sqw = {
					id_webmaster: ' . self::$wmid . ',
					id_site: ' . self::$wsid . ',
					debug: false,
					targeting: ' . self::$targets . ',
					msg: "' . self::$fmes . '",
					i18n: "' . self::$lang . '"
				};
				var _sqw_i18n = {
					login: "' . self::$flogin . '",
					register: "Signup",
					logout: "' . self::$flogout . '"
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
		$t = new BuildScript;
		add_action( 'wp_footer', array( $t, 'generate' ) );
		return ( 0 );
	}

	// Adding script to the page
	public static function add_script() {

		self::save();
		wp_enqueue_script(
			'sqweb-script',
			plugin_dir_path( dirname( __FILE__ ) ) . 'resources/js/sqweb.js',
			array(),
			'1.0.0',
			true
		);
	}
}
