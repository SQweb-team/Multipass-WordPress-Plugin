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

	/**
	 * Generating script
	 * @return string
	 */
	private static function assemble() {
		// Getting the options
		self::$wmid = (get_option( 'wmid' ) !== '') ? get_option( 'wmid' ) : '';
		self::$wsid = (get_option( 'wsid' ) !== '') ? get_option( 'wsid' ) : '';
		self::$flogin = (get_option( 'flogin' ) !== '') ? get_option( 'flogin' ) : 'Remove ads';
		self::$flogout = (get_option( 'flogout' ) !== '') ? get_option( 'flogout' ) : 'Connected';
		self::$fmes = (get_option( 'fmes' ) !== '') ? get_option( 'fmes' ) : '';

		// Assembling
		$script = 'var _sqw = {
					id_webmaster: ' . self::$wmid . ',
					id_site: ' . self::$wsid . ",
					debug: true,
					widget: 'Use SQweb to surf without ads',
					widget_link: 'https://www.sqweb.com',
					msg: '" . addcslashes( self::$fmes, '\'' ) . "'
				};
				var _sqw_i18n = {
					login: '" . self::$flogin . "',
					register: 'Signup',
					logout: '" . self::$flogout . "'
				};
				var script = document.createElement(\"script\");
				script.type = \"text/javascript\";
				script.src = '//cdn.sqweb.com/sqweb-beta.js';
				document.getElementsByTagName(\"head\")[0].appendChild(script);";
		return $script;
	}

	/**
	 * Saving custom script to file
	 * @return int
	 */
	public static function save() {
		$script = self::assemble();
		if ( file_put_contents( plugin_dir_path( dirname( __FILE__ ) ) . 'resources/js/sqweb.js' , $script ) ) {
			return ( 1 );
		} else {
			return ( 0 );
		}
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
