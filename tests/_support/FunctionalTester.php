<?php
// phpcs:ignoreFile Disabling IDE linting

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
	use _generated\FunctionalTesterActions;

	/**
	 * Add our permalink structure and setup rewrite rules
	 *
	 * @link https://github.com/lucatume/wp-browser/issues/190
	 */
	public function haveRewriteRules() {
		$this->haveOptionInDatabase(
			'permalink_structure',
			'/blog/%postname%/'
		);

		$this->loginAsAdmin();
		$this->amOnAdminPage( 'options-permalink.php' );
		$this->seeOptionInDatabase(
			[
				'option_name' => 'rewrite_rules',
			]
		);
	}

	/**
	 * Inserts a page in the database that has Beaver Builder content
	 *
	 * Accepts two extra overrides: modules and settings
	 *
	 * <code>
	 * $overrides['modules'] = [
	 *     'module_type' => [
	 *         'array' => 'of',
	 *         'custom' => 'settings'
	 *     ]
	 * ];
	 *
	 * $overrides['settings] = [
	 *     'css' => 'page-specific css',
	 *     'js'  => 'page-specific js',
	 * ];
	 * </code>
	 *
	 * @param array $overrides An array of values to override the default ones.
	 *
	 * @return int The inserted page post ID.
	 * @see \Codeception\Module\WPDb::havePageInDatabase()
	 */
	public function haveBBPageInDatabase( $overrides ) {
		$default_settings = [
			'css' => '',
			'js'  => '',
		];

		$overrides['meta']     = $overrides['meta'] ?? [];
		$overrides['modules']  = $overrides['modules'] ?? [];
		$overrides['settings'] = $overrides['settings'] ?? [];

		$settings = array_merge( $default_settings, $overrides['settings'] );

		$data = [
			'5bb62d872f48a' => (object) [
				'node'     => '5bb62d872f48a',
				'type'     => 'row',
				'parent'   => null,
				'position' => 0,
				'settings' => (object) [],
			],
			'5bb62d8731dbf' => (object) [
				'node'     => '5bb62d8731dbf',
				'type'     => 'column-group',
				'parent'   => '5bb62d872f48a',
				'position' => 0,
				'settings' => (object) [],
			],
			'5bb62d8731e32' => (object) [
				'node'     => '5bb62d8731e32',
				'type'     => 'column',
				'parent'   => '5bb62d8731dbf',
				'position' => 0,
				'settings' => (object) [
					'size' => 100,
				],
			],
		];

		$count = 0;

		foreach ( $overrides['modules'] as $type => $settings ) {
			$node = uniqid();

			$settings['type'] = $type;

			$data[ $node ] = (object) [
				'node'     => $node,
				'type'     => 'module',
				'parent'   => '5bb62d8731e32',
				'position' => $count,
				'settings' => (object) $settings,
			];

			$count++;
		}

		$overrides['meta']['_fl_builder_enabled']       = 1;
		$overrides['meta']['_fl_builder_data']          = $overrides['meta']['_fl_builder_data'] ?? $data;
		$overrides['meta']['_fl_builder_data_settings'] = $overrides['meta']['_fl_builder_data_settings'] ?? (object) $settings;

		// Enable needed modules in the options.
		$this->haveOptionInDatabase( '_fl_builder_enabled_modules', array_keys( $overrides['modules'] ) );

		unset( $overrides['modules'] );
		unset( $overrides['settings'] );

		return $this->havePageInDatabase( $overrides );
	}

	/**
	 * Activate a plugin in the database.
	 *
	 * @param string $plugin Pass in the plugin as `plugin-folder/plugin-file.php`.
	 */
	public function activatePluginInDB( $plugin ) {
		$plugins = (array) $this->grabOptionFromDatabase( 'active_plugins' );
		$plugins[] = $plugin;
		$this->haveOptionInDatabase( 'active_plugins', $plugins );
	}
}
