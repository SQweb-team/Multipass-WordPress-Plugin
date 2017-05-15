<?php

/**
* SQweb Filter
*/
class SQweb_Filter_Articles {

	function __construct() {

		add_filter( 'sqw_filter_cut_articles_by_percent', array( $this, 'filter_cut_articles_by_percent' ), 5, 2 );
		add_filter( 'sqw_filter_articles_by_day', array( $this, 'filter_articles_by_day' ), 5, 3 );
		add_filter( 'sqw_filter_date_art', array( $this, 'filter_date_art' ), 5, 3 );
		add_filter( 'sqw_filter_content', array( $this, 'filter_content' ), 5, 1 );
		if ( get_option( 'sqw_prior_paywall' ) || ! function_exists( 'pmpro_getOption' ) ) {
			add_filter( 'sqw_limited', array( $this, 'limited_sqw' ), 5, 1 );
		} else {
			add_filter( 'sqw_limited', array( $this, 'limited_pmp' ), 5, 1 );
		}
	}

	/**
	 * Limite articles with SQweb
	 * @var text
	 * @return text
	 */

	public function limited_sqw( $content ) {
		global $post;

		$ok_roles = array(
			0 => 'administrator',
			1 => 'administrator'
		);
		$user_data = wp_get_current_user();
		if ( 0 == $user_data->ID || 2 >= array_diff( $ok_roles, $user_data->roles ) ) {
			if ( get_post_meta( $post->ID, 'sqw_limited', true ) ) {
				return apply_filters( 'sqw_filter_content', $content );
			} else {
				if ( false !== get_option( 'sqw_filter_all' ) ) {
					return apply_filters( 'sqw_filter_content', $content );
				}
				$categorie = unserialize( get_option( 'categorie' ) );
				$categorie = is_array( $categorie ) ? $categorie : array();
				$category = get_the_category();
				foreach ( $category as $value ) {
					foreach ( $categorie as $cat ) {
						if ( $value->slug == $cat ) {
							return apply_filters( 'sqw_filter_content', $content );
						}
					}
				}
			}
		}
		return $content;
	}

	/**
	 * Limite articles with Paid membership pro
	 * @var text
	 * @return nothing
	 */

	public function limited_pmp( $content ) {
		if ( function_exists( 'sqw_pmp_access' ) && sqw_pmp_access( get_the_category() ) ) {
			$content = pmpro_membership_content_filter( $content );
		} elseif ( ! apply_filters( 'sqw_check_credentials', get_option( 'wsid' ) ) ) {
			$content = $this->limited_sqw( $content );
		}
		return $content;
	}

	/**
	 * First part parsing content SQweb
	 * @var text
	 * @return text
	 */

	public function filter_content( $content ) {

		$restrictcutartperc = apply_filters( 'sqw_msg_restrict_cut_art_perc', $this->msg_restrict_cut_art_perc() );
		$restrictartbyday = apply_filters( 'sqw_msg_restrict_art_by_day', $this->msg_restrict_art_by_day() );
		$restrictdateart = apply_filters( 'sqw_msg_restrict_date_art', $this->msg_restrict_date_art() );
		if ( get_option( 'dateart' ) !== false ) {
			if ( get_post_time( 'U', true ) > time() - get_option( 'dateart' ) * 86400 ) {
				return apply_filters( 'sqw_filter_date_art', $content, $restrictdateart, $restrictcutartperc );
			}
		}
		if ( get_option( 'artbyday' ) !== false ) {
			return apply_filters( 'sqw_filter_articles_by_day', $content, $restrictartbyday, $restrictcutartperc );
		}
		if ( get_option( 'cutartperc' ) !== false ) {
			return apply_filters( 'sqw_filter_cut_articles_by_percent', $content, $restrictcutartperc );
		}
		return $content;
	}

	/**
	 * Box message
	 * @return text
	 */

	public function msg_restrict_cut_art_perc() {
		return '<div onclick="sqw.modal_first()" class="sqw-paywall-button-container"><h5>' . __( 'The rest of this article is for subscribers only', 'sqweb' ) . '</h5><div><img src="' . plugin_dir_url( __FILE__ ) . '../resources/img/multipass_logo@2x.png' . '"></div><span>' . __( 'Become a subscriber now', 'sqweb' ) . '</span></div>';
	}

	public function msg_restrict_art_by_day() {
		return '<div onclick="sqw.modal_first()" class="sqw-paywall-button-container"><h5>' . sprintf( _n( 'You have already read %d premium article for free today', 'You have already read %d premium articles for free today', get_option( 'artbyday' ), 'sqweb' ), get_option( 'artbyday' ) ) . '</h5><span>' . __( 'Access immediately the premium content with Multipass', 'sqweb' ) . '</span><div><img src="' . plugin_dir_url( __FILE__ ) . '../resources/img/multipass_logo@2x.png' . '"></div><p>' . __( 'Or come back tomorrow', 'sqweb' ) . '</p></div>';
	}

	public function msg_restrict_date_art() {
		return '<div onclick="sqw.modal_first()" class="sqw-paywall-button-container"><h5>' . __( 'This premium content is for subscribers only', 'sqweb' ) . '</h5><p>' . sprintf( _n( 'It will be available for free in %d day', 'It will be available for free in %d days', ceil( ( get_post_time( 'U', true ) - ( time() - get_option( 'dateart' ) * 86400 ) ) / 86400 ), 'sqweb' ), ceil( ( get_post_time( 'U', true ) - ( time() - get_option( 'dateart' ) * 86400 ) ) / 86400 ) ) . '</p><span>' . __( 'Become a subscriber now with Multipass', 'sqweb' ) . '</span><div><img src="' . plugin_dir_url( __FILE__ ) . '../resources/img/multipass_logo@2x.png' . '"></div></div>';
	}

	/**
	 * Parsing text with a percent
	 * @var text
	 * @var text
	 * @return text
	 */

	public function filter_cut_articles_by_percent( $content, $message ) {
		return transparent( $content, get_option( 'cutartperc' ) ) . $message;
	}

	/**
	 * Parsing text limited to user by day
	 * @var text
	 * @var text
	 * @var text
	 * @return text
	 */

	public function filter_articles_by_day( $content, $message, $cutmessage ) {

		global $wpdb;

		$id = get_the_ID();
		if ( $wpdb->get_var( "SHOW TABLES LIKE '{$wpdb->prefix}sqw_limit'" ) != $wpdb->prefix . 'sqw_limit' ) {
			delete_option( 'artbyday' );
			return $content;
		}
		$count = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}sqw_limit WHERE ip = '%s' AND time > '%d' ORDER BY id DESC", array( $_SERVER['REMOTE_ADDR'], (time() - 86400 ) ) ) );
		if ( empty( $count ) ) {
			$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}sqw_limit (ip, nbarticles, seeingart, time) VALUES ('%s', 1, '%s', %d )", array( $_SERVER['REMOTE_ADDR'], serialize( array( $id ) ), time() ) ) );
		} elseif ( ! empty( $count['0'] ) && $count['0']->nbarticles >= get_option( 'artbyday' ) ) {
			$newseeing = unserialize( $count['0']->seeingart );
			if ( ! in_array( $id, $newseeing ) ) {
				if ( get_option( 'cutartperc' ) !== false ) {
					return apply_filters( 'sqw_filter_cut_articles_by_percent', $content, $cutmessage );
				} else {
					return $message;
				}
			}
		} else {
			$newseeing = unserialize( $count['0']->seeingart );
			if ( ! in_array( $id, $newseeing ) ) {
				$newseeing = serialize( array_merge( $newseeing, array( $id ) ) );
				$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}sqw_limit SET nbarticles = nbarticles + 1, seeingart = '%s' WHERE id = %d", array( $newseeing, $count['0']->id ) ) );
			}
		}
		return $content;
	}

	/**
	 * Parsing text limited by expirated date
	 * @var text
	 * @var text
	 * @var text
	 * @return text
	 */

	public function filter_date_art( $content, $message, $cutmessage ) {
		if ( get_option( 'cutartperc' ) !== false ) {
			return apply_filters( 'sqw_filter_cut_articles_by_percent', $content, $cutmessage );
		}
		return $message;
	}
}

new SQweb_Filter_Articles;
