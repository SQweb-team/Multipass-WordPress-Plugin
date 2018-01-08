<?php

/**
* SQweb Filter
*/
class SQweb_Filter_Articles {

	function __construct() {
		add_filter( 'sqw_filter_cut_articles_by_percent', array( $this, 'filter_cut_articles_by_percent' ), 5, 2 );
		add_filter( 'sqw_filter_articles_by_day', array( $this, 'filter_articles_by_day' ), 5, 3 );
		add_filter( 'sqw_filter_date_art', array( $this, 'filter_date_art' ), 5, 3 );
		add_filter( 'sqw_filter_archive_art', array( $this, 'filter_archive_art' ), 5, 3 );
		add_filter( 'sqw_filter_content', array( $this, 'filter_content' ), 5, 2 );
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

		$ok_roles  = array(
			0 => 'administrator',
			1 => 'administrator',
		);
		$user_data = wp_get_current_user();
		if ( 0 == $user_data->ID || 2 >= array_diff( $ok_roles, $user_data->roles ) ) {
			if ( get_post_meta( $post->ID, 'sqw_limited', true ) ) {
				return apply_filters( 'sqw_filter_content', $content, true );
			} else {
				if ( false !== get_option( 'sqw_filter_all' ) ) {
					return apply_filters( 'sqw_filter_content', $content );
				}
				$categorie = unserialize( get_option( 'categorie' ) );
				$categorie = is_array( $categorie ) ? $categorie : array();
				$category  = get_the_category();
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

	public function filter_content( $content, $override = false ) {
		$restrictcutartperc = apply_filters( 'sqw_msg_restrict_cut_art_perc', $this->msg_restrict_cut_art_perc() );
		if ( false !== $override ) {
			return apply_filters( 'sqw_filter_cut_articles_by_percent', $content, $restrictcutartperc );
		}
		$restrictartbyday   = apply_filters( 'sqw_msg_restrict_art_by_day', $this->msg_restrict_art_by_day() );
		$restrictdateart    = apply_filters( 'sqw_msg_restrict_date_art', $this->msg_restrict_date_art() );
		$restrictarchiveart = apply_filters( 'sqw_msg_restrict_archive_art', $this->msg_restrict_archive_art() );
		if ( get_option( 'dateart' ) !== false ) {
			if ( get_post_time( 'U', true ) > time() - get_option( 'dateart' ) * 86400 ) {
				return apply_filters( 'sqw_filter_date_art', $content, $restrictdateart, $restrictcutartperc );
			}
		}
		if ( get_option( 'archiveart' ) !== false ) {
			if ( time() - get_post_time( 'U', true ) > get_option( 'archiveart' ) * 86400 ) {
				return apply_filters( 'sqw_filter_archive_art', $content, $restrictarchiveart, $restrictcutartperc );
			}
		}
		if ( get_option( 'artbyday' ) !== false ) {
			return apply_filters( 'sqw_filter_articles_by_day', $content, $restrictartbyday, $restrictcutartperc );
		}

		if ( get_option( 'cutartperc' ) !== false && get_option( 'dateart' ) === false && get_option( 'archiveart' ) === false && get_option( 'artbyday' ) === false ) {
			return apply_filters( 'sqw_filter_cut_articles_by_percent', $content, $restrictcutartperc );
		}

		return $content;
	}

	/**
	 * Box message
	 * @return text
	 */

	public function msg_restrict_cut_art_perc() {
		//V1 bouton
		return '<div onclick="mltpss.modal_first(event)" class="sqw-paywall-button-container"><h5>' . __( 'The rest of this article is for subscribers only', 'sqweb' ) . '</h5><div><img src="' . plugin_dir_url( __FILE__ ) . '../resources/img/multipass_logo@2x.png' . '"></div><span>' . __( 'Become a subscriber now', 'sqweb' ) . '</span></div>';

		//V2 bouton
		return '<div class="footer__mp__normalize footer__mp__button_container">
					<div class="footer__mp__button_header">
						<div onclick="mltpss.modal_first(event)" class="footer__mp__button_header_title">' . __( 'The rest of this article is restricted', 'sqweb' ) . '</div>
						<div onclick="mltpss.modal_first(event)" class="footer__mp__button_signin">' . __( 'Already premium? ', 'sqweb' ) . '<span class="footer__mp__button_login footer__mp__button_strong">' . __( 'Sign in', 'sqweb' ) . '</span></div>
					</div>
					<div onclick="mltpss.modal_first(event)" class="footer__mp__normalize footer__mp__button_cta">
						<a href="#" class="footer__mp__cta_fresh">' . __( 'Unlock this article, get your', 'sqweb' ) . '</a>
					</div>
					<div class="footer__mp__normalize footer__mp__button_footer">
						<p class="footer__mp__normalize footer__mp__button_p">' . __( 'The multisite subscription, wihtout commitment.', 'sqweb' ) . '</p>
						<a target="_blank" class="footer__mp__button_discover footer__mp__button_strong" href="https://www.multipass.net/fr/sites-partenaires-premium-sans-pub-ni-limites"><span>></span> <span class="footer__mp__button_footer_txt">' . __( 'Discover our partners', 'sqweb' ) . '</span></a>
					</div>
				</div>';
	}

	public function msg_restrict_art_by_day() {
		// translators: this is to limit the number of article readable by day
		return '<div onclick="mltpss.modal_first(event)" class="sqw-paywall-button-container"><h5>' . sprintf( _n( 'You have already read %d premium article for free today', 'You have already read %d premium articles for free today', get_option( 'artbyday' ), 'sqweb' ), get_option( 'artbyday' ) ) . '</h5><span>' . __( 'Access immediately the premium content with Multipass', 'sqweb' ) . '</span><div><img src="' . plugin_dir_url( __FILE__ ) . '../resources/img/multipass_logo@2x.png' . '"></div><p>' . __( 'Or come back tomorrow', 'sqweb' ) . '</p></div>';

		// translators: this is the v2 of the above button
		return '<div class="footer__mp__normalize footer__mp__button_container">
					<div class="footer__mp__button_header">
						<div class="footer__mp__button_header_title">' . sprintf( _n( 'You have already read %d premium article for free today', 'You have already read %d premium articles for free today', get_option( 'artbyday' ), 'sqweb' ), get_option( 'artbyday' ) ) . '</div>
						<div onclick="mltpss.modal_first(event)" class="footer__mp__button_signin">' . __( 'Already premium? ', 'sqweb' ) . '<span onclick="mltpss.modal_first(event)" class="footer__mp__button_login footer__mp__button_strong">' . __( 'Sign in', 'sqweb' ) . '</span></div>
					</div>
					<div onclick="mltpss.modal_first(event)" class="footer__mp__normalize footer__mp__button_cta">
						<a href="#" class="footer__mp__cta_fresh">' . __( 'Unlock this article, get your', 'sqweb' ) . '</a>
					</div>
					<div class="footer__mp__normalize footer__mp__button_footer">
						<p class="footer__mp__normalize footer__mp__button_p">' . __( 'The multisite subscription, wihtout commitment.', 'sqweb' ) . '</p>
						<a target="_blank" class="footer__mp__button_discover footer__mp__button_strong" href="https://www.multipass.net/fr/sites-partenaires-premium-sans-pub-ni-limites"><span>></span> <span class="footer__mp__button_footer_txt">' . __( 'Discover our partners', 'sqweb' ) . '</span></a>
					</div>
				</div>';
	}

	public function msg_restrict_date_art() {
		// translators: To lock content for X days
		return '<div onclick="mltpss.modal_first(event)" class="sqw-paywall-button-container sqw-paywall-ea"><h5>' . __( 'This premium content is for subscribers only', 'sqweb' ) . '</h5><p>' . sprintf( _n( 'It will be available for free in %d day', 'It will be available for free in %d days', ceil( ( get_post_time( 'U', true ) - ( time() - get_option( 'dateart' ) * 86400 ) ) / 86400 ), 'sqweb' ), ceil( ( get_post_time( 'U', true ) - ( time() - get_option( 'dateart' ) * 86400 ) ) / 86400 ) ) . '</p><span>' . __( 'Become a subscriber now with Multipass', 'sqweb' ) . '</span><div><img src="' . plugin_dir_url( __FILE__ ) . '../resources/img/multipass_logo@2x.png' . '"></div></div>';

		// translators: To lock content for X days, V2 button
		return '<div class="footer__mp__normalize footer__mp__button_container">
					<div class="footer__mp__button_header">
						<div class="footer__mp__button_header_title">' . sprintf( _n( 'This will be available for free in %d day', 'This will be available for free in %d days', ceil( ( get_post_time( 'U', true ) - ( time() - get_option( 'dateart' ) * 86400 ) ) / 86400 ), 'sqweb' ), ceil( ( get_post_time( 'U', true ) - ( time() - get_option( 'dateart' ) * 86400 ) ) / 86400 ) ) . '</div>
						<div onclick="mltpss.modal_first(event)" class="footer__mp__button_signin">' . __( 'Already premium? ', 'sqweb' ) . '<span onclick="mltpss.modal_first(event)" class="footer__mp__button_login footer__mp__button_strong">' . __( 'Sign in', 'sqweb' ) . '</span></div>
					</div>
					<div onclick="mltpss.modal_first(event)" class="footer__mp__normalize footer__mp__button_cta">
						<a href="#" class="footer__mp__cta_fresh">' . __( 'Unlock this article, get your', 'sqweb' ) . '</a>
					</div>
					<div class="footer__mp__normalize footer__mp__button_footer">
						<p class="footer__mp__normalize footer__mp__button_p">' . __( 'The multisite subscription, wihtout commitment.', 'sqweb' ) . '</p>
						<a target="_blank" class="footer__mp__button_discover footer__mp__button_strong" href="https://www.multipass.net/fr/sites-partenaires-premium-sans-pub-ni-limites"><span>></span> <span class="footer__mp__button_footer_txt">' . __( 'Discover our partners', 'sqweb' ) . '</span></a>
					</div>
				</div>';
	}

	public function msg_restrict_archive_art() {
		//V1 bouton
		return '<div onclick="mltpss.modal_first(event)" class="sqw-paywall-button-container sqw-paywall-archives"><h5>' . __( 'This premium content is for subscribers only', 'sqweb' ) . '</h5><p>' . __( 'Archives are for subscribers only', 'sqweb' ) . '</p><span>' . __( 'Become a subscriber now with Multipass', 'sqweb' ) . '</span><div><img src="' . plugin_dir_url( __FILE__ ) . '../resources/img/multipass_logo@2x.png' . '"></div></div>';

		//V2 bouton
		return '<div class="footer__mp__normalize footer__mp__button_container">
					<div class="footer__mp__button_header">
						<div class="footer__mp__button_header_title">' . __( 'This article is restricted.', 'sqweb' ) . '</div>
						<div onclick="mltpss.modal_first(event)" class="footer__mp__button_signin">' . __( 'Already premium? ', 'sqweb' ) . '<span onclick="mltpss.modal_first(event)" class="footer__mp__button_login footer__mp__button_strong">' . __( 'Sign in', 'sqweb' ) . '</span></div>
					</div>
					<div onclick="mltpss.modal_first(event)" class="footer__mp__normalize footer__mp__button_cta">
						<a href="#" class="footer__mp__cta_fresh">' . __( 'Unlock this article, get your', 'sqweb' ) . '</a>
					</div>
					<div class="footer__mp__normalize footer__mp__button_footer">
						<p class="footer__mp__normalize footer__mp__button_p">' . __( 'The multisite subscription, wihtout commitment.', 'sqweb' ) . '</p>
						<a target="_blank" class="footer__mp__button_discover footer__mp__button_strong" href="https://www.multipass.net/fr/sites-partenaires-premium-sans-pub-ni-limites"><span>></span> <span class="footer__mp__button_footer_txt">' . __( 'Discover our partners', 'sqweb' ) . '</span></a>
					</div>
				</div>';
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
		$count = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}sqw_limit WHERE ip = %s AND time > %d ORDER BY id DESC", array( $_SERVER['REMOTE_ADDR'], ( time() - 86400 ) ) ) );
		if ( empty( $count ) ) {
			$wpdb->query( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}sqw_limit (ip, nbarticles, seeingart, time) VALUES (%s, 1, %s, %d )", array( $_SERVER['REMOTE_ADDR'], serialize( array( $id ) ), time() ) ) );
		} elseif ( ! empty( $count['0'] ) && $count['0']->nbarticles >= get_option( 'artbyday' ) ) {
			$newseeing = unserialize( $count['0']->seeingart );
			if ( ! in_array( $id, $newseeing ) ) {
				if ( get_option( 'cutartperc' ) !== false ) {
					return apply_filters( 'sqw_filter_cut_articles_by_percent', $content, $message );
				} else {
					return $message;
				}
			}
		} else {
			$newseeing = unserialize( $count['0']->seeingart );
			if ( ! in_array( $id, $newseeing ) ) {
				$newseeing = serialize( array_merge( $newseeing, array( $id ) ) );
				$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}sqw_limit SET nbarticles = nbarticles + 1, seeingart = %s WHERE id = %d", array( $newseeing, $count['0']->id ) ) );
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
			return apply_filters( 'sqw_filter_cut_articles_by_percent', $content, $message );
		}
		return $message;
	}

	public function filter_archive_art( $content, $message, $cutmessage ) {
		if ( get_option( 'cutartperc' ) !== false ) {
			return apply_filters( 'sqw_filter_cut_articles_by_percent', $content, $message );
		}
		return $message;
	}
}

new SQweb_Filter_Articles;
