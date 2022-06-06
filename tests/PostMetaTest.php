<?php

/**
 * @package ThemePlate
 */

namespace Tests;

use ThemePlate\Meta\PostMeta;
use WP_UnitTestCase;

class PostMetaTest extends WP_UnitTestCase {
	private PostMeta $meta_box;

	public function setUp(): void {
		$this->meta_box = new PostMeta( 'Test' );
	}

	public function test_firing_create_actually_add_hooks(): void {
		$location = 'test';

		$this->meta_box->location( $location );
		$this->meta_box->create();

		$this->assertSame( 10, has_filter( 'add_meta_boxes_' . $location, array( $this->meta_box, 'add_box' ) ) );
		$this->assertSame( 10, has_filter( 'save_post_' . $location, array( $this->meta_box, 'save_data' ) ) );
		$this->assertSame( 10, has_filter( 'admin_footer', array( $this->meta_box, 'maybe_wanted_page' ) ) );
	}

	public function test_get_config(): void {
		$config = $this->meta_box->get_config();

		$this->assertSame( '', $config->get_prefix() );
		$this->assertSame( array( 'post' ), $config->get_types() );
		$this->assertSame( null, $config->get_fields() );
	}
}
