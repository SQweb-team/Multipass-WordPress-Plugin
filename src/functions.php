<?php

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
				$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
			} else {
				$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
			}
			$return = wp_remote_post( SQW_ENDPOINT . 'token/check', array(
				'method' => 'POST',
				'sslcertificates' => plugin_dir_path(__FILE__) . 'resources/certificates/cacert.crt',
				'timeout' => 2,
				'redirection' => 3,
				'httpversion' => '1.0',
				'blocking' => true,
				'headers' => array(),
				'user-agent' => $user_agent,
				'body' => array(
				'token' => $cookiez,
				'site_id' => $site_id,
				),
				'cookies' => array(),
			    )
			);
			if ( is_wp_error( $return ) ) {
				if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
					$error_message = $return->get_error_message();
					echo 'Something went wrong: ' . $error_message;
				}
				$credentials = 0;
			} else {
				$response = json_decode( $return['body'] );
				if ( false !== $response && true === $response->status && $response->credit > 0 ) {
					$credentials = $response->credit;
					return $response->credit;
				}
			}
		}
	} else {
		return $credentials;
	}
	return ( 0 );
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
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		}
		$return = wp_remote_post( SQW_ENDPOINT . 'sqw_auth/new', array(
			'method' => 'POST',
			'sslcertificates' => plugin_dir_path(__FILE__) . 'resources/certificates/cacert.crt',
			'timeout' => 5,
			'redirection' => 3,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'user-agent' => $user_agent,
			'body' => array(
			'role' => '1',
			'first_name' => $first_name,
			'last_name' => $last_name,
			'email' => $email,
			'password' => $newpass,
			),
			'cookies' => array(),
			)
		);
		if ( is_wp_error( $return ) ) {
			if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
				$error_message = $return->get_error_message();
				echo 'Something went wrong: ' . $error_message;
			}
		} else if ( ! json_decode( $return['body'] ) == false ) {
			return ( 1 );
		}
	}
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
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		}
		$return = wp_remote_post( SQW_ENDPOINT . 'auth/login', array(
			'method' => 'POST',
			'sslcertificates' => plugin_dir_path(__FILE__) . 'resources/certificates/cacert.crt',
			'timeout' => 2,
			'redirection' => 3,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => 'Content-Type: application/x-www-form-urlencoded',
			'user-agent' => $user_agent,
			'body' => 'email=' . $email . '&password=' . $password,
			'cookies' => array(),
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
				add_option( 'sqw_token', $response->token );
				return $response->token;
			}
		}
	}
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
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		}
		$return = wp_remote_post( SQW_ENDPOINT . 'sqw_auth/is_auth_t', array(
			'method' => 'POST',
			'sslcertificates' => plugin_dir_path(__FILE__) . 'resources/certificates/cacert.crt',
			'timeout' => 2,
			'redirection' => 3,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'user-agent' => $user_agent,
			'body' => array(
			'token' => $token,
			),
			'cookies' => array(),
			)
		);

		if ( is_wp_error( $return ) ) {
			if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
				$error_message = $return->get_error_message();
				echo 'Something went wrong: ' . $error_message;
			}
		} else {
			$res = json_decode( $return['body'] );
			if ( isset( $res->id ) ) {
				return $res->id;
			}
		}
	}
	return ( 0 );
}

/**
 * @param $id
 * @return int
 */

function sqw_get_sites( $id ) {

	if ( defined( 'SQW_ENDPOINT' ) ) {

		$curl_version = curl_version();
		if ( defined( 'SQW_VERSION' ) ) {
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		}
		$token = get_option( 'sqw_token' );
		$return = wp_remote_post( SQW_ENDPOINT . 'websites', array(
			'method' => 'POST',
			'sslcertificates' => plugin_dir_path(__FILE__) . 'resources/certificates/cacert.crt',
			'timeout' => 3,
			'redirection' => 3,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'user-agent' => $user_agent,
			'body' => array(
			'token' => $token,
			),
			'cookies' => array(),
			)
		);

		if ( is_wp_error( $return ) ) {
			if ( defined( 'DEBUG_MODE' ) && DEBUG_MODE ) {
				$error_message = $return->get_error_message();
				echo 'Something went wrong: ' . $error_message;
			}
		} else {
			$response = json_decode( $return['body'] );
			if ( ! $response->status == false ) {
				return $response->websites;
			}
		}
	}
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
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		}
		$return = wp_remote_post( SQW_ENDPOINT . 'websites/add', array(
			'method' => 'POST',
			'sslcertificates' => plugin_dir_path(__FILE__) . 'resources/certificates/cacert.crt',
			'timeout' => 2,
			'redirection' => 3,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'user-agent' => $user_agent,
			'body' => array(
			'token' => $token,
			'name' => $data['sqw-ws-name'],
			'url' => $data['sqw-ws-url'],
			),
			'cookies' => array(),
			)
		);

		if ( is_wp_error( $return ) ) {
			return ( 0 );
		} else {
			$res = json_decode( $return['body'] );

			if ( $res->status != 0 ) {
				return ( 1 );
			}
		}
	}
	return ( 0 );
}

/**
 * @param $type
 * @return int
 */

function sqw_send_data( $type ) {

	if ( defined( 'SQW_ENDPOINT' ) ) {

		$data = [];
		$data['email'] = get_option( 'admin_email' );
		$data['name'] = get_option( 'blogname' );
		$data['url'] = get_option( 'siteurl' );
		$data['type'] = $type;
		$curl_version = curl_version();
		if ( defined( 'SQW_VERSION' ) ) {
			$user_agent = 'SQweb/WordPress ' . SQW_VERSION . '; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		} else {
			$user_agent = 'SQweb/WordPress Undefined; Curl ' . $curl_version['version'] . ( ! empty( $curl_version['ssl_version'] ) ? '; SSL ' . $curl_version['ssl_version'] : '');
		}
		$return = wp_remote_post( SQW_ENDPOINT . 'data/send', array(
			'method' => 'POST',
			'sslcertificates' => plugin_dir_path(__FILE__) . 'resources/certificates/cacert.crt',
			'timeout' => 1,
			'redirection' => 3,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'user-agent' => $user_agent,
			'body' => $data,
			'cookies' => array(),
			)
		);

	}
	return ( 0 );
}
