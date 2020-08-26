<?php
// file tests/acceptance/ThemeLoadedCest.php

class ThemeLoadedCest {

	public function _before( AcceptanceTester $I ) {
		$I->useTheme( 'test-theme-orb-wpengine-deploy' );
	}

	public function test_site_title( AcceptanceTester $I ) {
		$I->amOnPage( '/' );
		$I->see( 'Test Theme for WP Engine Deploy Orb' );
	}
}
