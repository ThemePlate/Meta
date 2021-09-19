<?php

/**
 * Setup user meta boxes
 *
 * @package ThemePlate
 * @since 0.1.0
 */

namespace ThemePlate\Meta;

use ThemePlate\Column;
use ThemePlate\Core\Helper\Box;
use ThemePlate\Core\Helper\Main;
use ThemePlate\Core\Helper\Meta;

class User extends Base {

	public function __construct( array $config ) {

		$config['object_type'] = 'user';

		try {
			parent::__construct( $config );
		} catch ( \Exception $e ) {
			throw new \Exception( $e );
		}

		$defaults = array(
			'priority' => 'default',
		);

		$this->config = Main::fool_proof( $defaults, $this->config );

		$priority = Box::get_priority( $this->config );

		add_action( 'show_user_profile', array( $this, 'create' ), $priority );
		add_action( 'edit_user_profile', array( $this, 'create' ), $priority );
		add_action( 'user_new_form', array( $this, 'create' ), $priority );
		add_action( 'personal_options_update', array( $this, 'save' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save' ) );
		add_action( 'user_register', array( $this, 'save' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts_styles' ), 11 );

		$this->columns();

	}


	public function create( $user ): void {

		if ( ! $this->is_valid_screen() ) {
			return;
		}

		$user_id = is_object( $user ) ? $user->ID : 0;

		$this->form->layout_postbox( $user_id );

	}


	public function save( int $user_id ): void {

		if ( ! $this->can_save() ) {
			return;
		}

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return;
		}

		parent::save( $user_id );

	}


	public function scripts_styles(): void {

		if ( ! $this->is_valid_screen() ) {
			return;
		}

		$this->form->enqueue( 'user' );

	}


	private function is_valid_screen(): bool {

		$screen = get_current_screen();

		if ( null === $screen || ! in_array( $screen->base, array( 'user', 'user-edit', 'profile' ), true ) ) {
			return false;
		}

		$meta_box = $this->config;

		if ( 'user-edit' === $screen->base && ! Meta::should_display( $meta_box, $_REQUEST['user_id'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			return false;
		}

		if ( 'profile' === $screen->base && ! Meta::should_display( $meta_box, get_current_user_id() ) ) {
			return false;
		}

		return true;

	}


	protected function column_data( array $args ): void {

		$args['users'] = true;

		new Column( $args );

	}

}
