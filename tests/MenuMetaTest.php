<?php

/**
 * @package ThemePlate
 */

namespace Tests;

use ThemePlate\Meta\MenuMeta;
use WP_UnitTestCase;

class MenuMetaTest extends WP_UnitTestCase {
	private MenuMeta $meta_box;

	public function setUp(): void {
		$this->meta_box = new MenuMeta( 'Test' );
	}

	public function test_firing_create_actually_add_hooks(): void {
		$this->meta_box->create();

		$this->assertSame( 10, has_filter( 'wp_nav_menu_item_custom_fields', array( $this->meta_box, 'add_box' ) ) );
		$this->assertSame( 10, has_filter( 'save_post_nav_menu_item', array( $this->meta_box, 'save_data' ) ) );
		$this->assertSame( 10, has_filter( 'admin_footer', array( $this->meta_box, 'maybe_wanted_page' ) ) );
	}
}
