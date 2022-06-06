<?php

/**
 * Setup post meta boxes
 *
 * @package ThemePlate
 * @since 0.1.0
 */

namespace ThemePlate\Meta;

use ThemePlate\Core\Helper\BoxHelper;
use ThemePlate\Core\Helper\FormHelper;
use ThemePlate\Core\Helper\MetaHelper;
use ThemePlate\Meta\Traits\HasLocation;
use WP_Term;

class TermMeta extends BaseMeta {

	use HasLocation;


	protected function initialize( array &$config ): void {

		$config['object_type'] = 'term';

	}


	public function create(): void {

		$priority = BoxHelper::get_priority( $this->config );

		foreach ( $this->locations as $taxonomy ) {
			add_action( $taxonomy . '_add_form', array( $this, 'add_box' ), $priority );
			add_action( $taxonomy . '_edit_form', array( $this, 'add_box' ), $priority );
			add_action( 'saved_' . $taxonomy, array( $this, 'save_data' ), 10, 3 );
		}

		add_action( 'admin_footer', array( $this, 'maybe_wanted_page' ) );

	}


	public function add_box( $tag ) {

		$this->current_id = $tag instanceof WP_Term ? $tag->term_id : 0;

		$this->layout_postbox( $this->current_id );

	}


	public function save_data( int $term_id, int $tt_id, bool $update ): void {

		if ( ! $update ) {
			$term_id = 0;
		}

		if ( ! $this->can_save( $term_id ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_term', $tt_id ) ) {
			return;
		}

		$this->save( $tt_id );

	}


	public function maybe_wanted_page( string $hook_suffix ): void {

		$screen = get_current_screen();

		if ( null === $screen || ! in_array( $screen->base, array( 'edit-tags', 'term' ), true ) ) {
			return;
		}

		if ( ! in_array( $screen->taxonomy, $this->locations, true ) ) {
			return;
		}

		if ( ! MetaHelper::should_display( $this->config, $this->current_id ) ) {
			return;
		}

		FormHelper::enqueue_assets( $hook_suffix );

	}

}
