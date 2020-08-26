<?php
// file tests/unit/ThemeLoadedTest.php

class ThemeLoadedTest extends \Codeception\Test\Unit {

	public function test_namespaced_slug() {
		require_once 'functions.php';

		$this->assertEqual( '1.0.0', \TestOrb\Theme\VERSION );
	}
}
