<?php

/**
* Edit admin for better integration of SQweb
* @since 2.2.4
*/
class SQweb_Admin {

	function __construct() {
		if ( is_admin() ) {
			/**
			 * Check if admin choose to use SQweb auto-config feature.
			 **/
			if ( isset( $_GET['sqw-auto-config'] ) && true == $_GET['sqw-auto-config'] ) {
				new Auto_Config( true );
			} else {
				new Auto_Config( false );
			}
			if ( isset( $_GET['sqw-reset'] ) && true == $_GET['sqw-reset'] ) {
				$this->sqw_reset();
			}
			/**
			 * Check if we are in the SQweb administration page.
			 **/
			if ( isset( $_GET['page'] ) && 'SQwebAdmin' == $_GET['page'] ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'script' ) );
				/**
				 * Check if User if log in for show logout button.
				 **/
				if ( get_option( 'sqw_token' ) ) {
					add_action( 'admin_footer', array( $this, 'sqw_logout' ), 1 );
				}
				/**
				 * Check if error message need to be show and show it.
				 **/
				if ( unserialize( get_option( 'sqw_message' ) ) ) {
					add_action( 'admin_notices', array( $this, 'notice_event' ) );
				}
			}
			/**
			 * Add SQweb tab on WP administration.
			 **/
			add_action( 'admin_menu', array( $this, 'register_admin_menu' ) );
			add_action( 'admin_menu', array( $this, 'register_admin_sub_menu' ), 20 );
			/**
			 * Add post capacity to paywall limit on single article.
			 **/
			add_action( 'post_submitbox_misc_actions', array( $this, 'featured_post_field' ) );
			add_action( 'save_post', array( $this, 'save_postdata' ) );
		} // End if().
	}

	private function sqw_reset() {
		delete_option( 'wsid' );
		delete_option( 'sqw_token' );
		delete_option( 'sqw_analytics' );
		delete_option( 'sqw_multipass' );
		delete_option( 'cutartperc' );
		delete_option( 'lang' );
		delete_option( 'btheme' );
		delete_option( 'flogout' );
		delete_option( 'flogin' );
		delete_option( 'fmes' );
		delete_option( 'dateart' );
		delete_option( 'artbyday' );
		delete_option( 'categorie' );
		global $wpdb;
		$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}sqw_limit" );
		$content = '<?php

return array(
	\'wsid\' => ' . (get_option( 'wsid' ) != false ? get_option( 'wsid' ) : 0) . ',
	\'filter.ads\' => \'YTowOnt9\',
	\'filter.text\' => \'YTowOnt9\',
);
';
		file_put_contents( WP_PLUGIN_DIR . '/sqweb/sqweb-config.php', $content );
		if ( function_exists( 'wp_redirect' ) ) {
			wp_redirect( remove_query_arg( 'sqw-reset' ) );
		}
	}

	public function sqw_logout() {
		echo '<a href=' . add_query_arg( 'sqw-reset', '1' ) . " style='position: absolute; bottom: 56px; right: 20px; text-decoration: none; height: 18px'>" . __( 'Reset configuration of SQweb', 'sqweb' ) . '</p>';
		echo '<a href=' . add_query_arg( 'logout', '1' ) . " style='position: absolute; bottom: 32px; right: 20px; text-decoration: none; height: 18px'>" . __( 'Logout from SQweb', 'sqweb' ) . '</p>';
	}

	public static function notice_event() {
		/**
		 * Display notif added previously
		 */
		$message = unserialize( get_option( 'sqw_message' ) );
		foreach ( $message as $value ) {
			?>
			<div class="notice notice-<?php echo $value['type']; ?> is-dismissible">
			<p><?php _e( '<b>SQweb notice : </b>', 'sqweb' ); ?><?php echo $value['message']; ?></p>
			</div>
			<?php
		}
		delete_option( 'sqw_message' );
	}

	public static function add_notice_event( $type, $message ) {
		$messages = unserialize( get_option( 'sqw_message' ) );
		if ( empty( $messages ) ) {
			$messages = array();
		}
		array_push( $messages,
			array(
				'type' => $type,
				'message' => $message,
		) );
		update_option( 'sqw_message', serialize( $messages ) );
	}

	public function featured_post_field() {

	    global $post;

	    /* get the value current value of the custom field */
	    $check = false;
		$categorie = unserialize( get_option( 'categorie' ) );
		$categorie = is_array( $categorie ) ? $categorie : array();
		$category = get_the_category();
		foreach ( $category as $value ) {
			foreach ( $categorie as $cat ) {
				if ( $value->slug == $cat ) {
					$check = true;
				}
			}
		}
		$value = get_post_meta( $post->ID, 'sqw_limited', true );
	    ?>
	        <div class="misc-pub-section">
	            <label><input type="checkbox"<?php echo ( ! empty( $value ) ? ' checked="checked"' : null) ?> value="1" name="sqw_limited" /> <?php _e( 'Post restricted to Multipass users', 'sqweb' );?></label>
	        </div>
	    <?php
	    if ( $check ) {
		    $value = get_post_meta( $post->ID, 'sqw_unlimited', true );
		   	?>
		        <div class="misc-pub-section">
		            <label><input type="checkbox"<?php echo ( ! empty( $value ) ? ' checked="checked"' : null) ?> value="1" name="sqw_unlimited" /> <?php _e( 'Post available for every users', 'sqweb' );?></label>
		        </div>
		    <?php
		}
	}


	public function save_postdata( $postid ) {

	    /* check if this is an autosave */
	    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return false;
		}

	    /* check if the user can edit this page */
	    if ( ! current_user_can( 'edit_page', $postid ) ) {
	    	return false;
		}

	    /* check if there's a post id and check if this is a post */
	    /* make sure this is the same post type as above */
	    if ( empty( $postid ) ) {
	    	return false;
	    }

	    /* if you are going to use text fields, then you should change the part below */
	    /* use add_post_meta, update_post_meta and delete_post_meta, to control the stored value */

	    /* check if the custom field is submitted (checkboxes that aren't marked, aren't submitted) */
	    if ( isset( $_POST['sqw_limited'] ) ) {
	        /* store the value in the database */
	        add_post_meta( $postid, 'sqw_limited', 1, true );
	        delete_post_meta( $postid, 'sqw_unlimited' );
	    } else {
	    	delete_post_meta( $postid, 'sqw_limited' );
	    }
	    if ( isset( $_POST['sqw_unlimited'] ) ) {
	    	add_post_meta( $postid, 'sqw_unlimited', 1, true );
	        delete_post_meta( $postid, 'sqw_limited' );
	    } else {
	    	delete_post_meta( $postid, 'sqw_unlimited' );
	    }
	}

	public function script() {
		wp_enqueue_style(
			'sqweb-admin-style',
			'/wp-content/plugins/sqweb/resources/css/sqweb_admin_style.css'
		);
		wp_enqueue_script(
			'sqweb-admin-script',
			'/wp-content/plugins/sqweb/resources/js/sqweb.js',
			array( 'jquery' )
		);
	}

	public function register_admin_menu() {

		global $wpdb;
		if ( isset( $_GET['page'] ) && 'SQwebAdmin' == $_GET['page'] ) {
			include_once 'login.php';
			if ( isset( $_GET['logout'] ) && 1 == $_GET['logout'] ) {
				delete_option( 'sqw_token' );
				wp_redirect( remove_query_arg( 'logout' ) );
				exit;
			}
			include_once 'save.php';
			include_once 'diagnostic.php';
		}
		add_menu_page( 'Manage SQweb', 'SQweb', 'manage_options', 'SQwebAdmin', 'sqweb_display_admin_menu' );
		if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
			add_menu_page( 'Debug info', 'Debug info', 'manage_options', 'sqweb_debug', 'sqweb_display_php_info' );
		}
	}

	public function register_admin_sub_menu() {
		add_submenu_page( 'SQwebAdmin', 'SQwebAdmin', __( 'SQweb settings', 'sqweb' ), 'manage_options', 'SQwebAdmin', 'sqweb_display_admin_menu' );
		/* Added in 2.2.4 but temporary in wait for other version  */
		//add_submenu_page( 'SQwebAdmin', 'SQwebIntegration', __( 'SQweb integration', 'sqweb' ), 'manage_options', 'SQwebIntegration', 'install_help_sqw' );
	}
}

new SQweb_Admin;
