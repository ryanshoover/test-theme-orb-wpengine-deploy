<?php
// file tests/wpunit/ThemeLoadedTest.php

class ThemeLoadedTest extends \Codeception\TestCase\WPTestCase {

	public function test_namespaced_slug() {
		$this->assertEqual( '1.0.0', \TestOrb\Theme\VERSION );
	}
}
