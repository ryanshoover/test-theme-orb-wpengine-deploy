<?php
/**
 * Functions file for the theme.
 *
 * @package TestOrb\Theme;
 */

namespace TestOrb\Theme;

define( __NAMESPACE__ . '\VERSION', '1.0.0' );

add_action(
	'after_setup_theme',
	function() {
		register_nav_menus(
			array(
				'primary'   => 'Primary Menu',
				'secondary' => 'Secondary Menu',
			)
		);

		add_theme_support( 'post-thumbnails' );

		if ( empty( $content_width ) ) {
			$content_width = 1200;
		}
	}
);

add_action(
	'wp_enqueue_scripts',
	function() {
		wp_enqueue_style(
			'test-orb-theme',
			get_stylesheet_uri(),
			[],
			VERSION,
			'all'
		);
	}
);
