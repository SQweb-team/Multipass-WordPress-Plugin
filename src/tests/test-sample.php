<?php

class SampleTest extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_basic_sign_in() {
		$result = sqweb_sign_in( 'sqwebtestrole1@gmail.com', 'testrole1' );
		$this->assertNotEmpty( $result );

		$result = sqweb_sign_in( 'FalseEmail', 'FalsePassword' );
		$this->assertEquals( $result, 0 );
	}

}

