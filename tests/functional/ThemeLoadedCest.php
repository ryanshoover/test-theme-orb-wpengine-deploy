<?php
// file tests/functional/ThemeLoadedCest.php

class ThemeLoadedCest {

	public function _before( FunctionalTester $I ) {
		$I->useTheme( 'test-theme-orb-wpengine-deploy' );
	}

	public function test_site_title( FunctionalTester $I ) {
		$I->amOnPage( '/' );
		$I->see( 'Test Theme for WP Engine Deploy Orb' );
	}
}
