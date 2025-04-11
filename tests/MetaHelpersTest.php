<?php

/**
 * @package ThemePlate
 */

namespace Tests;

use ThemePlate\Meta\MetaHelpers;
use WP_UnitTestCase;

class MetaHelpersTest extends WP_UnitTestCase {
	/** @return array<string, array<int, mixed>> */
	public static function for_default_values(): array {
		return array(
			'empty'      => array( '', '' ),
			'missing'    => array(
				array( 'test' => array( 'default' => '' ) ),
				'',
			),
			'no_default' => array(
				array( 'key' => array( 'test' => 'value' ) ),
				'',
			),
			'custom'     => array(
				array( 'key' => array( 'default' => 'value' ) ),
				'value',
			),
			'invalid'    => array(
				array( 'key' => (object) array( 'default' => 'value' ) ),
				'',
			),
		);
	}

	/**
	 * @param array<mixed> $schema
	 * @dataProvider for_default_values
	 */
	public function test_default_values( $schema, string $expected ): void {
		$meta_type = 'post';
		$meta_key  = 'key';

		add_filter(
			'themeplate_' . $meta_type . '_meta_' . $meta_key . '_schema',
			fn() => $schema
		);

		$this->assertSame( $expected, MetaHelpers::default( '', 1, $meta_key, true, $meta_type ) );
	}
}
