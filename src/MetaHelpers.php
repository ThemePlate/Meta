<?php

/**
 * Setup meta boxes
 *
 * @package ThemePlate
 * @since 0.1.0
 */

namespace ThemePlate\Meta;

class MetaHelpers {

	public static function default( $value, int $object_id, string $meta_key, bool $single, string $meta_type ) {

		$schema = (array) apply_filters( "themeplate_{$meta_type}_meta_{$meta_key}_schema", array() );

		if ( empty( $schema[ $meta_key ] ) || ! is_array( $schema[ $meta_key ] ) ) {
			return $value;
		}

		return $schema[ $meta_key ]['default'] ?? $value;

	}

}
