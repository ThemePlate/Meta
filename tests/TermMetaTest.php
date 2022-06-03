<?php

/**
 * @package ThemePlate
 */

namespace Tests;

use ThemePlate\Meta\TermMeta;
use WP_UnitTestCase;

class TermMetaTest extends WP_UnitTestCase {
	private TermMeta $meta_box;

	public function setUp(): void {
		$this->meta_box = new TermMeta( 'Test' );
	}

	public function test_firing_create_actually_add_hooks(): void {
		$location = 'test';

		$this->meta_box->location( $location );
		$this->meta_box->create();

		$this->assertSame( 10, has_filter( $location . '_add_form', array( $this->meta_box, 'add_box' ) ) );
		$this->assertSame( 10, has_filter( $location . '_edit_form', array( $this->meta_box, 'add_box' ) ) );
		$this->assertSame( 10, has_filter( 'saved_' . $location, array( $this->meta_box, 'save_data' ) ) );
		$this->assertSame( 10, has_filter( 'admin_footer', array( $this->meta_box, 'maybe_wanted_page' ) ) );
	}
}
