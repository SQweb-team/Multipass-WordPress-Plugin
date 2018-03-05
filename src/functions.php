<?php

// function sqw_php_execute( $html ) {
// 	if ( strpos( $html, '<' . '?php' ) !== false ) {
// 		ob_start();
// 		eval( '?' . '>' . $html );
// 		$html = ob_get_contents();
// 		ob_end_clean();
// 	}
// 	return $html;
// }

/**
 * Send an http request to the api
 * returns true if logged, 0 if not
 * @param null $site_id
 * @return int
 */

function sqweb_check_credentials( $site_id = null ) {

	static $credentials;
	if ( ! isset( $credentials ) ) {
		if ( isset( $_COOKIE['sqw_z'] ) && null !== $site_id ) {
			$cookiez = $_COOKIE['sqw_z'];
		}
		if ( isset( $cookiez ) && defined( 'SQW_ENDPOINT' ) ) {
			$curl_version = curl_version();
			if ( defined( 'SQW_VERSION' ) ) {
				$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
			} else {
				$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
			}
			if ( function_exists( 'wp_remote_post' ) ) {
				$return = wp_remote_post( SQW_ENDPOINT . 'token/check',
					array(
						'method'      => 'POST',
						'timeout'     => 2,
						'redirection' => 3,
						'httpversion' => '1.0',
						'blocking'    => true,
						'headers'     => array(),
						'user-agent'  => $user_agent,
						'body'        => array(
							'token'   => $cookiez,
							'site_id' => $site_id,
						),
						'cookies'     => array(),
					)
				);
			} else {
				$curl = curl_init();
				curl_setopt_array(
					$curl, array(
						CURLOPT_URL               => SQW_ENDPOINT . 'token/check',
						CURLOPT_CONNECTTIMEOUT_MS => 2000,
						CURLOPT_TIMEOUT_MS        => 2000,
						CURLOPT_RETURNTRANSFER    => true,
						CURLOPT_USERAGENT         => $user_agent,
						CURLOPT_POSTFIELDS        => array(
							'token'   => $cookiez,
							'site_id' => $site_id,
						),
					)
				);
				$return = curl_exec( $curl );
			}
			if ( function_exists( 'is_wp_error' ) && is_wp_error( $return ) ) {
				if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
					$error_message = $return->get_error_message();
					echo 'Something went wrong: ' . $error_message;
				}
				$credentials = false;
			} else {
				$credentials = false;
				$response    = json_decode( isset( $return['body'] ) ? $return['body'] : $return );
				if ( false !== $response && true === $response->status && $response->credit > 0 ) {
					$credentials = true;
				}
			}
		} else {
			$credentials = false;
		} // End if().
	} // End if().
	return $credentials;
}

// Add filter check credentials for more flexibility in usage of function.
if ( function_exists( 'add_filter' ) ) {
	// Check if user is on the SQW_Exept_role, can be set on SQweb admin.
	if ( function_exists( 'get_option' ) && function_exists( 'wp_get_current_user' ) && unserialize( get_option( 'sqw_exept_role' ) ) && count( array_intersect( wp_get_current_user()->roles, unserialize( get_option( 'sqw_exept_role' ) ) ) ) ) {
		add_filter( 'sqw_check_credentials', function () {
			return true;
		}, 5, 1 );
	} else {
		add_filter( 'sqw_check_credentials', 'sqweb_check_credentials', 5, 1 );
	}
}

/**
 * @param $first_name
 * @param $last_name
 * @param $email
 * @param $newpass
 * @return int
 */

function sqweb_sign_up( $first_name, $last_name, $email, $newpass ) {

	if ( defined( 'SQW_ENDPOINT' ) ) {
		$curl_version = curl_version();
		if ( defined( 'SQW_VERSION' ) ) {
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		}
		$return = wp_remote_post( SQW_ENDPOINT . 'sqw_auth/new',
			array(
				'method'      => 'POST',
				'timeout'     => 5,
				'redirection' => 3,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'user-agent'  => $user_agent,
				'body'        => array(
					'role'       => '1',
					'first_name' => $first_name,
					'last_name'  => $last_name,
					'email'      => $email,
					'password'   => $newpass,
				),
				'cookies'     => array(),
			)
		);
		if ( is_wp_error( $return ) ) {
			if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
				$error_message = $return->get_error_message();
				echo 'Something went wrong: ' . $error_message;
			}
			return ( 0 );
		}
		$response = json_decode( $return['body'] );
		if ( isset( $response->token ) ) {
			update_option( 'sqw_token', $response->token );
			return ( 1 );
		} elseif ( isset( $response->errors ) ) {
			if ( isset( $response->errors->email ) ) {
				SQweb_Admin::add_notice_event( 'error', __( 'Email already used.', 'sqweb' ) );
			}
			if ( isset( $response->errors->password ) ) {
				SQweb_Admin::add_notice_event( 'error', __( 'Password must be 8 characters.', 'sqweb' ) );
			}
		}
	} // End if().
	return ( 0 );
}

/**
 * @param $email
 * @param $password
 * @return int
 */

function sqweb_sign_in( $email, $password ) {

	if ( defined( 'SQW_ENDPOINT' ) ) {

		$curl_version = curl_version();
		if ( defined( 'SQW_VERSION' ) ) {
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		}
		$return = wp_remote_post( SQW_ENDPOINT . 'auth/login',
			array(
				'method'      => 'POST',
				'timeout'     => 2,
				'redirection' => 3,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'user-agent'  => $user_agent,
				'body'        => array(
					'email'    => $email,
					'password' => $password,
				),
				'cookies'     => array(),
			)
		);
		if ( is_wp_error( $return ) ) {
			if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
				$error_message = $return->get_error_message();
				echo 'Something went wrong: ' . $error_message;
			}
		} else {
			$response = json_decode( $return['body'] );
			if ( isset( $response->token ) ) {
				update_option( 'sqw_token', $response->token );
				return ( 1 );
			} elseif ( isset( $response->errors ) ) {
				if ( isset( $response->errors->email ) ) {
					SQweb_Admin::add_notice_event( 'error', __( 'Email invalid.', 'sqweb' ) );
				}
				if ( isset( $response->errors->password ) ) {
					SQweb_Admin::add_notice_event( 'error', __( 'Password invalid.', 'sqweb' ) );
				}
			}
		}
	} // End if().
	return ( 0 );
}

/**
 * @param $token
 * @return int
 */

function sqweb_check_token( $token ) {

	if ( defined( 'SQW_ENDPOINT' ) ) {

		$curl_version = curl_version();
		if ( defined( 'SQW_VERSION' ) ) {
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		}
		$return = wp_remote_post( SQW_ENDPOINT . 'sqw_auth/is_auth_t',
			array(
				'method'      => 'POST',
				'timeout'     => 2,
				'redirection' => 3,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'user-agent'  => $user_agent,
				'body'        => array(
					'token' => $token,
				),
				'cookies'     => array(),
			)
		);
		if ( is_wp_error( $return ) ) {
			if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
				$error_message = $return->get_error_message();
				echo 'Something went wrong: ' . $error_message;
			}
		} else {
			$res = json_decode( $return['body'] );
			if ( isset( $res->token ) ) {
				update_option( 'sqw_token', $res->token );
			}
			if ( isset( $res->user->id ) ) {
				return $res->user->id;
			}
		}
	} // End if().
	return ( 0 );
}

/**
 * @param $id
 * @return int
 */

function sqw_get_sites() {

	if ( defined( 'SQW_ENDPOINT' ) ) {

		$curl_version = curl_version();
		if ( defined( 'SQW_VERSION' ) ) {
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		}
		$return = wp_remote_post( SQW_ENDPOINT . 'websites',
			array(
				'method'      => 'POST',
				'timeout'     => 3,
				'redirection' => 3,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'user-agent'  => $user_agent,
				'body'        => array(
					'token' => get_option( 'sqw_token' ),
				),
				'cookies'     => array(),
			)
		);
		if ( is_wp_error( $return ) ) {
			if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
				$error_message = $return->get_error_message();
				echo 'Something went wrong: ' . $error_message;
			}
		} else {
			$response = json_decode( $return['body'] );
			if ( ! false == $response->status ) {
				return $response->websites;
			}
		}
	} // End if().
	return ( 0 );
}

/**
 * @param $data
 * @param $token
 * @return int
 */

function sqw_add_website( $data, $token ) {

	if ( defined( 'SQW_ENDPOINT' ) ) {

		$curl_version = curl_version();
		if ( defined( 'SQW_VERSION' ) ) {
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		}
		$return = wp_remote_post( SQW_ENDPOINT . 'websites/add',
			array(
				'method'      => 'POST',
				'timeout'     => 2,
				'redirection' => 3,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'user-agent'  => $user_agent,
				'body'        => array(
					'token' => $token,
					'name'  => $data['sqw-ws-name'],
					'url'   => $data['sqw-ws-url'],
					'from'  => 'WordPress',
				),
				'cookies'     => array(),
			)
		);
		if ( is_wp_error( $return ) ) {
			return ( 0 );
		} else {
			$res = json_decode( $return['body'] );

			if ( 1 == $res->status ) {
				return ( $res->website );
			}
		}
	} // End if().
	return ( 0 );
}

/**
 * @param $type
 * @return int
 */

function sqw_send_data( $type ) {

	if ( defined( 'SQW_ENDPOINT' ) ) {

		$data          = array();
		$data['email'] = get_option( 'admin_email' );
		$data['name']  = get_option( 'blogname' );
		$data['url']   = get_option( 'siteurl' );
		$data['type']  = $type;
		$curl_version  = curl_version();
		if ( defined( 'SQW_VERSION' ) ) {
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '' );
		}
		wp_remote_post( SQW_ENDPOINT . 'data/send',
			array(
				'method'      => 'POST',
				'timeout'     => 1,
				'redirection' => 3,
				'httpversion' => '1.0',
				'blocking'    => false,
				'headers'     => array(),
				'user-agent'  => $user_agent,
				'body'        => $data,
				'cookies'     => array(),
			)
		);
	}
	return ( 0 );
}

function sqw_support_button_html() {
	return '<table class="sqw-table-footer sqw-support-us-footer">
				<tr class="sqw-table-footer-text-tr">
					<td class="sqw-table-footer-title">
						<span>'
							. __( 'Continue reading...', 'sqweb' )
						. '</span>
					</td>
				</tr>
				<tr class="sqw-table-footer-text-tr">
					<td class="sqw-table-footer-content">
						<span>'
							. __( '...we need you to hear this: More people are reading our website than ever but advertising revenues across the media are falling fast.', 'sqweb' )
						. '</span>
					</td>
				</tr>
				<tr class="sqw-table-footer-text-tr">
					<td class="sqw-table-footer-content">
						<span>'
							. __( 'We want to keep our content as open as we can. We are independent, and our quality work takes a lot of time, money and hard work to produce.', 'sqweb' )
						. '</span>
					</td>
				</tr>
				<tr class="sqw-table-footer-text-tr">
					<td class="sqw-table-footer-content sqw-table-footer-content-3">
						<span>'
							. __( 'You can support us with Multipass which enables you to pay for a bundle of websites: you can finance the work of journalists and content creators you love.', 'sqweb' )
						. '</span>
					</td>
				</tr>
				<tr>
					<td onclick="mltpss.modal_first(event)" class="sqw-table-footer-footer">
						<span class="sqw-table-footer-footer-text">'
							. __( 'Support us with', 'sqweb' )
						. '</span>
						<div class="sqw-table-footer-footer-img"></div>
					</td>
				</tr>
			</table>';
}
