<?php

class SampleTest extends WP_UnitTestCase {

	function test_basic_sign_in_false() {
		$result = sqweb_sign_in( 'FalseEmail', 'FalsePassword' );
		$this->assertEquals( $result, 0 );
	}

	function test_basic_sign_in_true() {
		$result = sqweb_sign_in( 'sqwebtestrole1@gmail.com', 'testrole1' );
		$this->assertNotEmpty( $result );
	}

	function test_basic_check_token_false() {
		$result = sqweb_check_token( 'Je suis un faux token' );
		$this->assertEquals( $result, 0 );
	}

	function test_basic_check_token_true() {
		$result = sqweb_check_token( sqweb_sign_in( 'sqwebtestrole1@gmail.com', 'testrole1' ) );
		$this->assertNotEquals( $result, 0 );
	}

	function test_basic_get_websites() {
		$result = sqw_get_sites( sqweb_sign_in( 'sqwebtestrole1@gmail.com', 'testrole1' ) );
		$this->assertNotEquals( $result, 0 );
	}
}

