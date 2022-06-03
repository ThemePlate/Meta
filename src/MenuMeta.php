<?php

/**
 * Setup post meta boxes
 *
 * @package ThemePlate
 * @since 0.1.0
 */

namespace ThemePlate\Meta;

use ThemePlate\Core\Helper\Box;
use ThemePlate\Core\Helper\Form;
use ThemePlate\Core\Helper\Meta;

class MenuMeta extends BaseMeta {

	protected function initialize( array &$config ): void {

		$config['object_type'] = 'post';

	}


	public function create(): void {

		$priority = Box::get_priority( $this->config );

		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'add_box' ), $priority );
		add_action( 'save_post_nav_menu_item', array( $this, 'save_data' ) );
		add_action( 'admin_footer', array( $this, 'maybe_wanted_page' ) );

	}


	public function add_box( string $item_id ) {

		$this->current_id = $item_id;

		$this->layout_postbox( $this->current_id );

	}


	public function save_data( int $object_id ): void {

		if ( ! $this->can_save( $object_id ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_theme_options', $object_id ) ) {
			return;
		}

		$this->save( $object_id );

	}


	public function maybe_wanted_page( string $hook_suffix ): void {

		$screen = get_current_screen();

		if ( null === $screen || 'nav-menus' !== $screen->base ) {
			return;
		}

		if ( ! Meta::should_display( $this->config, $this->current_id ) ) {
			return;
		}

		Form::enqueue_assets( $hook_suffix );

	}

}
