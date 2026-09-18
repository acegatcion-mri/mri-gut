<?php
/**
 * Theme setup and assets.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'pardot_boostrap_setup' ) ) {
	/**
	 * Register theme support options.
	 */
	function pardot_boostrap_setup() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'style.css' );

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'pardot-boostrap' ),
			)
		);
	}
}
add_action( 'after_setup_theme', 'pardot_boostrap_setup' );

/**
 * Enqueue additional block editor styles to ensure overrides load.
 */
function pardot_boostrap_enqueue_block_editor_assets() {
	wp_enqueue_style(
		'pardot-boostrap-editor-bootstrap',
		'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css',
		array(),
		'5.3.8'
	);

	wp_enqueue_style(
		'pardot-boostrap-editor-style',
		get_stylesheet_uri(),
		array( 'pardot-boostrap-editor-bootstrap' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'enqueue_block_editor_assets', 'pardot_boostrap_enqueue_block_editor_assets' );

/**
 * Add Bootstrap classes to primary nav list items.
 *
 * @param string[] $classes Existing menu item classes.
 * @param WP_Post  $item    Menu item data object.
 * @param stdClass $args    Nav menu arguments.
 * @return string[]
 */
function pardot_boostrap_nav_menu_css_class( $classes, $item, $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$classes[] = 'nav-item';
	}

	return $classes;
}
add_filter( 'nav_menu_css_class', 'pardot_boostrap_nav_menu_css_class', 10, 3 );

/**
 * Add Bootstrap classes to primary nav links.
 *
 * @param array    $atts Link attributes.
 * @param WP_Post  $item Menu item data object.
 * @param stdClass $args Nav menu arguments.
 * @return array
 */
function pardot_boostrap_nav_menu_link_attributes( $atts, $item, $args ) {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$atts['class'] = 'nav-link';

		if ( in_array( 'current-menu-item', $item->classes, true ) || in_array( 'current-menu-parent', $item->classes, true ) ) {
			$atts['class'] .= ' active';
			$atts['aria-current'] = 'page';
		}
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'pardot_boostrap_nav_menu_link_attributes', 10, 3 );

/**
 * Render a Bootstrap fallback menu when no menu is assigned.
 */
function pardot_boostrap_menu_fallback() {
	?>
	<ul id="primary-menu" class="navbar-nav ms-auto mb-2 mb-lg-0">
		<li class="nav-item">
			<a class="nav-link" href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>">
				<?php esc_html_e( 'Assign a menu', 'pardot-boostrap' ); ?>
			</a>
		</li>
	</ul>
	<?php
}

/**
 * Enqueue theme stylesheet.
 */
function pardot_boostrap_enqueue_assets() {
	wp_enqueue_style(
		'pardot-boostrap-bootstrap-icons',
		'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
		array(),
		'1.11.3'
	);

	wp_enqueue_style(
		'pardot-boostrap-style',
		get_stylesheet_uri(),
		array( 'pardot-boostrap-bootstrap-icons' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'pardot_boostrap_enqueue_assets' );

/**
 * Remove default WordPress block styles on the frontend.
 */
function pardot_boostrap_dequeue_wp_block_styles() {
	if ( is_admin() ) {
		return;
	}

	wp_dequeue_style( 'wp-block-library' );
	wp_deregister_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_deregister_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'global-styles' );
	wp_deregister_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_deregister_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'pardot_boostrap_dequeue_wp_block_styles', 100 );

/**
 * Strip wp-* class tokens from HTML class attributes.
 *
 * @param string $html HTML markup.
 * @return string
 */
function pardot_boostrap_strip_wp_classes_from_html( $html ) {
	if ( ! is_string( $html ) || '' === $html ) {
		return $html;
	}

	return preg_replace_callback(
		'/class=("|\')(.*?)\\1/i',
		static function ( $matches ) {
			$quote   = $matches[1];
			$classes = preg_split( '/\s+/', trim( $matches[2] ) );

			$classes = array_filter(
				$classes,
				static function ( $class_name ) {
					return 0 !== strpos( $class_name, 'wp-' );
				}
			);

			if ( empty( $classes ) ) {
				return '';
			}

			return 'class=' . $quote . esc_attr( implode( ' ', $classes ) ) . $quote;
		},
		$html
	);
}

/**
 * Filter rendered content and strip wp-* class names.
 *
 * @param string $content Rendered post content.
 * @return string
 */
function pardot_boostrap_filter_content_classes( $content ) {
	if ( is_admin() ) {
		return $content;
	}

	return pardot_boostrap_strip_wp_classes_from_html( $content );
}
add_filter( 'the_content', 'pardot_boostrap_filter_content_classes', 20 );

if ( ! function_exists( 'pardot_boostrap_repeat_rows_to_count' ) ) {
	/**
	 * Repeat repeater rows to a fixed visual count.
	 *
	 * @param array $rows         Repeater rows.
	 * @param int   $target_count Target visual row count.
	 * @return array
	 */
	function pardot_boostrap_repeat_rows_to_count( $rows, $target_count ) {
		if ( ! is_array( $rows ) ) {
			return $rows;
		}

		$target_count = (int) $target_count;
		if ( $target_count <= 0 ) {
			return $rows;
		}

		$rows = array_values( $rows );
		$visible_rows = array();

		foreach ( $rows as $row ) {
			if ( is_array( $row ) ) {
				$has_visible_content = false;
				foreach ( $row as $row_value ) {
					if ( pardot_boostrap_value_has_content( $row_value ) ) {
						$has_visible_content = true;
						break;
					}
				}

				if ( $has_visible_content ) {
					$visible_rows[] = $row;
				}
			} elseif ( pardot_boostrap_value_has_content( $row ) ) {
				$visible_rows[] = $row;
			}
		}

		$count = count( $visible_rows );
		if ( 0 === $count ) {
			return array();
		}

		if ( $count >= $target_count ) {
			return $visible_rows;
		}

		$repeated = array();

		for ( $index = 0; $index < $target_count; $index++ ) {
			$repeated[] = $visible_rows[ $index % $count ];
		}

		return $repeated;
	}
}

if ( ! function_exists( 'pardot_boostrap_get_placeholder_image_url' ) ) {
	/**
	 * Get default placeholder image URL for template blocks.
	 *
	 * @return string
	 */
	function pardot_boostrap_get_placeholder_image_url() {
		return 'https://placehold.net/800x600.png';
	}
}


if ( ! function_exists( 'pardot_boostrap_is_image_field_name' ) ) {
	/**
	 * Determine whether a field name represents an image field.
	 *
	 * @param string $field_name ACF field name.
	 * @return bool
	 */
	function pardot_boostrap_is_image_field_name( $field_name ) {
		$field_name = (string) $field_name;

		if ( '' === $field_name ) {
			return false;
		}

		return (bool) preg_match( '/(^|_)image$/', $field_name );
	}
}


if ( ! function_exists( 'pardot_boostrap_get_image_with_placeholder' ) ) {
	/**
	 * Normalize image values and ensure a placeholder URL is always available.
	 *
	 * @param mixed  $image_value   ACF image field value.
	 * @param string $fallback_alt  Fallback alt text.
	 * @return array{url:string,alt:string}
	 */
	function pardot_boostrap_get_image_with_placeholder( $image_value, $fallback_alt = '' ) {
		$normalized = array(
			'url' => '',
			'alt' => '',
		);

		if ( is_array( $image_value ) ) {
			$normalized['url'] = isset( $image_value['url'] ) ? (string) $image_value['url'] : '';
			$normalized['alt'] = isset( $image_value['alt'] ) ? (string) $image_value['alt'] : '';
		} elseif ( is_string( $image_value ) ) {
			$normalized['url'] = trim( $image_value );
		}

		if ( '' === $normalized['url'] ) {
			$normalized['url'] = pardot_boostrap_get_placeholder_image_url();
		}

		if ( '' === trim( $normalized['alt'] ) ) {
			$normalized['alt'] = '' !== trim( (string) $fallback_alt ) ? (string) $fallback_alt : 'Placeholder image';
		}

		return $normalized;
	}
}


if ( ! function_exists( 'pardot_boostrap_get_shared_block_fields' ) ) {
	/**
	 * Get common field set used by many MRI blocks.
	 *
	 * @param string $prefix Field prefix, e.g. mri_card_grid.
	 * @return array<string, mixed>
	 */
	function pardot_boostrap_get_shared_block_fields( $prefix, $block = null ) {
		$prefix = rtrim( (string) $prefix, '_' );

		return array(
			'heading'      => pardot_boostrap_get_block_field_value( $block, $prefix . '_heading' ),
			'subheading'   => pardot_boostrap_get_block_field_value( $block, $prefix . '_subheading' ),
			'content'      => pardot_boostrap_get_block_field_value( $block, $prefix . '_content' ),
			'button_label' => pardot_boostrap_get_block_field_value( $block, $prefix . '_button_label' ),
			'button_link'  => pardot_boostrap_get_block_field_value( $block, $prefix . '_button_link' ),
			'image'        => pardot_boostrap_get_image_with_placeholder( pardot_boostrap_get_block_field_value( $block, $prefix . '_image' ), $prefix . ' image' ),
		);
	}
}

if ( ! function_exists( 'pardot_boostrap_get_block_id' ) ) {
	/**
	 * Build a block id with anchor fallback.
	 *
	 * @param array  $block      Block config.
	 * @param string $fallback   Fallback id base.
	 * @return string
	 */
	function pardot_boostrap_get_block_id( $block, $fallback ) {
		if ( is_array( $block ) && ! empty( $block['anchor'] ) ) {
			return (string) $block['anchor'];
		}

		$block_suffix = '';
		if ( is_array( $block ) && isset( $block['id'] ) ) {
			$block_suffix = (string) $block['id'];
		}

		if ( '' !== $block_suffix ) {
			return $fallback . '-' . $block_suffix;
		}

		return $fallback;
	}
}

if ( ! function_exists( 'pardot_boostrap_get_field_with_fallbacks' ) ) {
	/**
	 * Get an ACF field value with optional fallback field names.
	 *
	 * @param string              $primary_field Primary field name.
	 * @param array<int, string>  $fallbacks     Fallback field names.
	 * @return mixed
	 */
	function pardot_boostrap_get_field_with_fallbacks( $primary_field, $fallbacks = array(), $block = null ) {
		return pardot_boostrap_get_block_field_value( $block, $primary_field, $fallbacks );
	}
}

if ( ! function_exists( 'pardot_boostrap_get_block_field_value' ) ) {
	/**
	 * Normalize repeater-style row keys by stripping repeated field-name prefixes.
	 *
	 * @param array<int, array<string, mixed>> $rows       Repeater rows.
	 * @param string                           $field_name Repeater field name.
	 * @return array<int, array<string, mixed>>
	 */
	function pardot_boostrap_normalize_repeater_rows( $rows, $field_name ) {
		if ( ! is_array( $rows ) || '' === (string) $field_name ) {
			return $rows;
		}

		$prefix = (string) $field_name . '_';

		foreach ( $rows as $row_index => $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}

			$normalized_row = array();

			foreach ( $row as $key => $value ) {
				if ( ! is_string( $key ) || '' === $key ) {
					$normalized_row[ $key ] = $value;
					continue;
				}

				$normalized_key = $key;

				while ( 0 === strpos( $normalized_key, $prefix ) ) {
					$normalized_key = substr( $normalized_key, strlen( $prefix ) );
				}

				if ( '' === $normalized_key ) {
					$normalized_key = $key;
				}

				$normalized_row[ $normalized_key ] = $value;
			}

			$rows[ $row_index ] = $normalized_row;
		}

		return $rows;
	}

	/**
	 * Determine whether a value contains visible/non-empty content.
	 *
	 * @param mixed $value Field value.
	 * @return bool
	 */
	function pardot_boostrap_value_has_content( $value ) {
		if ( null === $value || false === $value ) {
			return false;
		}

		if ( is_string( $value ) ) {
			return '' !== trim( $value );
		}

		if ( is_array( $value ) ) {
			if ( empty( $value ) ) {
				return false;
			}

			foreach ( $value as $nested_value ) {
				if ( pardot_boostrap_value_has_content( $nested_value ) ) {
					return true;
				}
			}

			return false;
		}

		return true;
	}

	/**
	 * Build a single repeater fallback row from sub-field defaults.
	 *
	 * @param array<string,mixed> $field_definition Repeater field definition.
	 * @param string              $field_name       Repeater field name.
	 * @return array<int,array<string,mixed>>|null
	 */
	function pardot_boostrap_get_repeater_seed_rows_from_definition( $field_definition, $field_name ) {
		if ( ! is_array( $field_definition ) || ! isset( $field_definition['type'] ) || 'repeater' !== (string) $field_definition['type'] ) {
			return null;
		}

		if ( isset( $field_definition['default_value'] ) && is_array( $field_definition['default_value'] ) && ! empty( $field_definition['default_value'] ) ) {
			return pardot_boostrap_normalize_repeater_rows( $field_definition['default_value'], (string) $field_name );
		}

		if ( empty( $field_definition['sub_fields'] ) || ! is_array( $field_definition['sub_fields'] ) ) {
			return null;
		}

		$seed_row = array();
		$has_seed = false;

		foreach ( $field_definition['sub_fields'] as $sub_field ) {
			if ( ! is_array( $sub_field ) || empty( $sub_field['name'] ) ) {
				continue;
			}

			$sub_name = (string) $sub_field['name'];
			$sub_default = isset( $sub_field['default_value'] ) ? $sub_field['default_value'] : null;

			$sub_has_default = ! (
				null === $sub_default ||
				( is_string( $sub_default ) && '' === trim( $sub_default ) ) ||
				( is_array( $sub_default ) && empty( $sub_default ) )
			);

			if ( ! $sub_has_default ) {
				continue;
			}

			$seed_row[ $sub_name ] = $sub_default;
			$has_seed = true;
		}

		if ( ! $has_seed ) {
			return null;
		}

		return array( $seed_row );
	}

	/**
	 * Recursively find an ACF field definition by field name.
	 *
	 * @param array<int,array<string,mixed>> $fields     Field definitions.
	 * @param string                         $field_name Target field name.
	 * @return array<string,mixed>|null
	 */
	function pardot_boostrap_find_acf_field_definition_by_name( $fields, $field_name ) {
		if ( ! is_array( $fields ) || '' === $field_name ) {
			return null;
		}

		foreach ( $fields as $field ) {
			if ( ! is_array( $field ) ) {
				continue;
			}

			if ( isset( $field['name'] ) && $field_name === (string) $field['name'] ) {
				return $field;
			}

			if ( isset( $field['sub_fields'] ) && is_array( $field['sub_fields'] ) ) {
				$found = pardot_boostrap_find_acf_field_definition_by_name( $field['sub_fields'], $field_name );
				if ( is_array( $found ) ) {
					return $found;
				}
			}
		}

		return null;
	}

	/**
	 * Resolve a field default from the ACF field group attached to the current block.
	 *
	 * @param array|null $block      Block payload.
	 * @param string     $field_name Field name.
	 * @return mixed|null
	 */
	function pardot_boostrap_get_block_field_default( $block, $field_name ) {
		if ( ! is_array( $block ) || empty( $block['name'] ) || '' === (string) $field_name ) {
			return null;
		}

		if ( ! function_exists( 'acf_get_field_groups' ) || ! function_exists( 'acf_get_fields' ) ) {
			return null;
		}

		$block_name = (string) $block['name'];
		$field_groups = acf_get_field_groups(
			array(
				'block' => $block_name,
			)
		);

		if ( ! is_array( $field_groups ) || empty( $field_groups ) ) {
			return null;
		}

		foreach ( $field_groups as $field_group ) {
			if ( ! is_array( $field_group ) ) {
				continue;
			}

			$group_key = isset( $field_group['key'] ) ? (string) $field_group['key'] : '';
			if ( '' === $group_key ) {
				continue;
			}

			$fields = acf_get_fields( $group_key );
			$definition = pardot_boostrap_find_acf_field_definition_by_name( $fields, (string) $field_name );

			if ( is_array( $definition ) && array_key_exists( 'default_value', $definition ) ) {
				$default_value = $definition['default_value'];
				$has_default   = pardot_boostrap_value_has_content( $default_value );

				if ( $has_default ) {
					if ( isset( $definition['type'] ) && 'repeater' === (string) $definition['type'] && is_array( $default_value ) ) {
						$default_value = pardot_boostrap_normalize_repeater_rows( $default_value, (string) $field_name );
					}

					return $default_value;
				}
			}

			$seed_rows = pardot_boostrap_get_repeater_seed_rows_from_definition( $definition, (string) $field_name );
			if ( is_array( $seed_rows ) && ! empty( $seed_rows ) ) {
				return $seed_rows;
			}
		}

		return null;
	}

	/**
	 * Resolve a block field value from ACF first, then raw block data as fallback.
	 *
	 * @param array|null         $block      Current ACF block array.
	 * @param string             $field_name Primary field name.
	 * @param array<int, string> $fallbacks  Additional fallback field names.
	 * @return mixed
	 */
	function pardot_boostrap_get_block_field_value( $block, $field_name, $fallbacks = array() ) {
		$candidate_fields = array_merge( array( (string) $field_name ), $fallbacks );

		foreach ( $candidate_fields as $candidate_field ) {
			$candidate_field = (string) $candidate_field;
			if ( '' === $candidate_field ) {
				continue;
			}

			$value = get_field( $candidate_field );

			if ( null !== $value && false !== $value ) {
				if ( is_array( $value ) ) {
					if ( empty( $value ) ) {
						return array();
					}

					$value = pardot_boostrap_normalize_repeater_rows( $value, $candidate_field );
					return $value;
				}

				if ( is_string( $value ) ) {
					if ( '' !== trim( $value ) ) {
						return $value;
					}

					return '';
				}

				return $value;
			}

			$block_data_sources = array();
			if ( is_array( $block ) ) {
				if ( isset( $block['data'] ) && is_array( $block['data'] ) ) {
					$block_data_sources[] = $block['data'];
				}

				if ( isset( $block['attrs']['data'] ) && is_array( $block['attrs']['data'] ) ) {
					$block_data_sources[] = $block['attrs']['data'];
				}
			}

			foreach ( $block_data_sources as $block_data ) {
				if ( ! is_array( $block_data ) || ! array_key_exists( $candidate_field, $block_data ) ) {
					continue;
				}

				$raw_value = $block_data[ $candidate_field ];

				// Rebuild flattened repeater rows when raw value is a row count.
				if ( is_scalar( $raw_value ) ) {
					$count = (int) $raw_value;

					if ( $count > 0 ) {
						$repeater_rows = pardot_boostrap_rebuild_repeater_rows_from_block_data( $block_data, $candidate_field, $count );
						if ( ! empty( $repeater_rows ) ) {
							$repeater_rows = pardot_boostrap_normalize_repeater_rows( $repeater_rows, $candidate_field );
							return $repeater_rows;
						}
					}
				}

				$raw_has_value = pardot_boostrap_value_has_content( $raw_value );

				if ( $raw_has_value ) {
					return $raw_value;
				}

				if ( ! pardot_boostrap_is_image_field_name( $candidate_field ) ) {
					return $raw_value;
				}
			}
		}

		foreach ( $candidate_fields as $candidate_field ) {
			if ( pardot_boostrap_is_image_field_name( $candidate_field ) ) {
				return pardot_boostrap_get_image_with_placeholder( null, str_replace( '_', ' ', (string) $candidate_field ) );
			}
		}

		// Fall back to ACF field defaults when a block has no saved data yet so new blocks
		// can render seeded rows in the editor and on first load.
		foreach ( $candidate_fields as $candidate_field ) {
			$candidate_field = (string) $candidate_field;
			if ( '' === $candidate_field ) {
				continue;
			}

			$block_default = pardot_boostrap_get_block_field_default( $block, $candidate_field );
			if ( null !== $block_default ) {
				if ( is_array( $block_default ) ) {
					$block_default = pardot_boostrap_normalize_repeater_rows( $block_default, $candidate_field );
				}

				return $block_default;
			}
		}

		return null;
	}
}

if ( ! function_exists( 'pardot_boostrap_rebuild_repeater_rows_from_block_data' ) ) {
	/**
	 * Rebuild repeater rows from flattened Gutenberg block data keys.
	 *
	 * @param array<string, mixed> $data       Block data array.
	 * @param string               $field_name Repeater field name prefix.
	 * @param int                  $count      Row count.
	 * @return array<int, array<string, mixed>>
	 */
	function pardot_boostrap_rebuild_repeater_rows_from_block_data( $data, $field_name, $count ) {
		$rows = array();

		if ( ! is_array( $data ) || '' === $field_name || $count <= 0 ) {
			return $rows;
		}

		for ( $index = 0; $index < $count; $index++ ) {
			$prefix = $field_name . '_' . $index . '_';
			$row    = array();

			foreach ( $data as $key => $value ) {
				if ( ! is_string( $key ) || 0 !== strpos( $key, $prefix ) ) {
					continue;
				}

				$sub_key = substr( $key, strlen( $prefix ) );
				if ( '' === $sub_key || '_' === $sub_key[0] ) {
					continue;
				}

				$field_prefix = $field_name . '_';
				while ( 0 === strpos( $sub_key, $field_prefix ) ) {
					$sub_key = substr( $sub_key, strlen( $field_prefix ) );
				}

				if ( '' === $sub_key ) {
					continue;
				}

				$row[ $sub_key ] = $value;
			}

			$has_visible_row_content = false;
			foreach ( $row as $row_value ) {
				if ( pardot_boostrap_value_has_content( $row_value ) ) {
					$has_visible_row_content = true;
					break;
				}
			}

			if ( $has_visible_row_content ) {
				$rows[] = $row;
			}
		}

		return $rows;
	}
}

if ( ! function_exists( 'pardot_boostrap_normalize_link_value' ) ) {
	/**
	 * Normalize ACF link field values from array/string shapes.
	 *
	 * @param mixed  $value          Link field value.
	 * @param string $fallback_label Fallback link text.
	 * @return array{url:string,title:string,target:string}
	 */
	function pardot_boostrap_normalize_link_value( $value, $fallback_label = '' ) {
		$link = array(
			'url'    => '',
			'title'  => (string) $fallback_label,
			'target' => '',
		);

		if ( is_array( $value ) ) {
			$link['url']    = isset( $value['url'] ) ? (string) $value['url'] : '';
			$link['title']  = ! empty( $value['title'] ) ? (string) $value['title'] : $link['title'];
			$link['target'] = isset( $value['target'] ) ? (string) $value['target'] : '';
			return $link;
		}

		if ( is_string( $value ) && '' !== trim( $value ) ) {
			$link['url'] = $value;
		}

		return $link;
	}
}

if ( ! function_exists( 'pardot_boostrap_get_block_repeater_rows' ) ) {
	/**
	 * Resolve repeater rows from ACF first, then rebuild from flattened block data.
	 *
	 * @param array|null         $block      Current ACF block array.
	 * @param string             $field_name Repeater field name.
	 * @param array<int, string> $sub_fields Repeater sub field names.
	 * @return array<int, array<string, mixed>>
	 */
	function pardot_boostrap_get_block_repeater_rows( $block, $field_name, $sub_fields ) {
		$value = pardot_boostrap_get_block_field_value( $block, $field_name );

		if ( is_array( $value ) && ! empty( $value ) ) {
			return $value;
		}

		$data = null;
		if ( is_array( $block ) ) {
			if ( isset( $block['data'] ) && is_array( $block['data'] ) ) {
				$data = $block['data'];
			} elseif ( isset( $block['attrs']['data'] ) && is_array( $block['attrs']['data'] ) ) {
				$data = $block['attrs']['data'];
			}
		}

		if ( ! is_array( $data ) ) {
			return array();
		}
		$count = 0;

		if ( isset( $data[ $field_name ] ) ) {
			$count = (int) $data[ $field_name ];
		}

		if ( $count <= 0 ) {
			return array();
		}

		$rows = array();

		for ( $index = 0; $index < $count; $index++ ) {
			$row = array();

			foreach ( $sub_fields as $sub_field ) {
				$key = $field_name . '_' . $index . '_' . $sub_field;
				$row[ $sub_field ] = isset( $data[ $key ] ) ? $data[ $key ] : '';
			}

			$rows[] = $row;
		}

		return $rows;
	}
}

if ( ! function_exists( 'pardot_boostrap_use_acf_default_when_empty' ) ) {
	/**
	 * Use ACF default values when saved MRI block field values are empty.
	 *
	 * This helps existing blocks show meaningful starter copy without
	 * manually touching every block instance.
	 *
	 * @param mixed               $value   Loaded field value.
	 * @param int|string          $post_id Current post ID.
	 * @param array<string,mixed> $field   ACF field definition.
	 * @return mixed
	 */
	function pardot_boostrap_use_acf_default_when_empty( $value, $post_id, $field ) {
		return $value;
	}
}
add_filter( 'acf/load_value', 'pardot_boostrap_use_acf_default_when_empty', 20, 3 );

if ( ! function_exists( 'pardot_boostrap_render_block_preview_badge' ) ) {
	/**
	 * Render standard preview badge used in block templates.
	 *
	 * @param array $block      Block config.
	 * @param mixed $is_preview Preview flag from render callback.
	 */
	function pardot_boostrap_render_block_preview_badge( $block, $is_preview ) {
		if ( empty( $is_preview ) ) {
			return;
		}

		$title = '';
		if ( is_array( $block ) && isset( $block['title'] ) ) {
			$title = (string) $block['title'];
		}
		?>
		<div class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success m-5 text-capitalize">
			<?php echo esc_html( $title ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'pardot_boostrap_setup_block_id_and_preview' ) ) {
	/**
	 * Resolve block id and render preview badge in one call.
	 *
	 * @param array  $block      Block config.
	 * @param mixed  $is_preview Preview flag from render callback.
	 * @param string $fallback   Fallback id base.
	 * @return string
	 */
	function pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, $fallback ) {
		$block_id = pardot_boostrap_get_block_id( $block, $fallback );
		pardot_boostrap_render_block_preview_badge( $block, $is_preview );

		return $block_id;
	}
}

if ( ! function_exists( 'pardot_boostrap_is_mri_acf_block_group' ) ) {
	/**
	 * Check whether an ACF field group targets an MRI block.
	 *
	 * @param array $group ACF field group.
	 * @return bool
	 */
	function pardot_boostrap_is_mri_acf_block_group( $group ) {
		if ( ! is_array( $group ) || empty( $group['location'] ) || ! is_array( $group['location'] ) ) {
			return false;
		}

		foreach ( $group['location'] as $location_or_group ) {
			if ( ! is_array( $location_or_group ) ) {
				continue;
			}

			foreach ( $location_or_group as $rule ) {
				if ( ! is_array( $rule ) ) {
					continue;
				}

				$param    = isset( $rule['param'] ) ? (string) $rule['param'] : '';
				$operator = isset( $rule['operator'] ) ? (string) $rule['operator'] : '';
				$value    = isset( $rule['value'] ) ? (string) $rule['value'] : '';

				if ( 'block' === $param && '==' === $operator && 0 === strpos( $value, 'acf/mri-' ) ) {
					return true;
				}
			}
		}

		return false;
	}
}

if ( ! function_exists( 'pardot_boostrap_is_non_mri_acf_block_group' ) ) {
	/**
	 * Check whether an ACF field group targets a non-MRI block.
	 *
	 * @param array $group ACF field group.
	 * @return bool
	 */
	function pardot_boostrap_is_non_mri_acf_block_group( $group ) {
		if ( ! is_array( $group ) || empty( $group['location'] ) || ! is_array( $group['location'] ) ) {
			return false;
		}

		$has_block_rule = false;

		foreach ( $group['location'] as $location_or_group ) {
			if ( ! is_array( $location_or_group ) ) {
				continue;
			}

			foreach ( $location_or_group as $rule ) {
				if ( ! is_array( $rule ) ) {
					continue;
				}

				$param    = isset( $rule['param'] ) ? (string) $rule['param'] : '';
				$operator = isset( $rule['operator'] ) ? (string) $rule['operator'] : '';
				$value    = isset( $rule['value'] ) ? (string) $rule['value'] : '';

				if ( 'block' !== $param || '==' !== $operator ) {
					continue;
				}

				$has_block_rule = true;

				if ( 0 === strpos( $value, 'acf/mri-' ) ) {
					return false;
				}
			}
		}

		return $has_block_rule;
	}
}

if ( ! function_exists( 'pardot_boostrap_cleanup_non_mri_acf_block_groups' ) ) {
	/**
	 * One-time cleanup: trash non-MRI ACF block groups and their child fields.
	 */
	function pardot_boostrap_cleanup_non_mri_acf_block_groups() {
		if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! function_exists( 'acf_get_field_groups' ) ) {
			return;
		}

		$version = 'v1';
		$option_key = 'pardot_boostrap_non_mri_acf_group_cleanup_' . $version . '_done';

		if ( get_option( $option_key ) ) {
			return;
		}

		$field_groups = acf_get_field_groups();
		if ( empty( $field_groups ) || ! is_array( $field_groups ) ) {
			update_option( $option_key, gmdate( 'c' ), false );
			return;
		}

		foreach ( $field_groups as $field_group ) {
			if ( ! pardot_boostrap_is_non_mri_acf_block_group( $field_group ) ) {
				continue;
			}

			$post_id = isset( $field_group['ID'] ) ? (int) $field_group['ID'] : 0;
			if ( $post_id <= 0 ) {
				continue;
			}

			$child_fields = get_posts(
				array(
					'post_type'      => 'acf-field',
					'post_parent'    => $post_id,
					'post_status'    => 'any',
					'posts_per_page' => -1,
					'fields'         => 'ids',
				)
			);

			if ( ! empty( $child_fields ) ) {
				foreach ( $child_fields as $child_field_id ) {
					wp_trash_post( (int) $child_field_id );
				}
			}

			wp_trash_post( $post_id );
		}

		update_option( $option_key, gmdate( 'c' ), false );
	}
}

if ( ! function_exists( 'pardot_boostrap_get_acf_block_rule_value' ) ) {
	/**
	 * Get the block location rule value from an ACF field group.
	 *
	 * @param array $group ACF field group.
	 * @return string
	 */
	function pardot_boostrap_get_acf_block_rule_value( $group ) {
		if ( ! is_array( $group ) || empty( $group['location'] ) || ! is_array( $group['location'] ) ) {
			return '';
		}

		foreach ( $group['location'] as $location_or_group ) {
			if ( ! is_array( $location_or_group ) ) {
				continue;
			}

			foreach ( $location_or_group as $rule ) {
				if ( ! is_array( $rule ) ) {
					continue;
				}

				$param    = isset( $rule['param'] ) ? (string) $rule['param'] : '';
				$operator = isset( $rule['operator'] ) ? (string) $rule['operator'] : '';
				$value    = isset( $rule['value'] ) ? (string) $rule['value'] : '';

				if ( 'block' === $param && '==' === $operator ) {
					return $value;
				}
			}
		}

		return '';
	}
}

if ( ! function_exists( 'pardot_boostrap_trash_acf_group_with_children' ) ) {
	/**
	 * Trash an ACF group and all child fields.
	 *
	 * @param int $post_id ACF field group post ID.
	 */
	function pardot_boostrap_trash_acf_group_with_children( $post_id ) {
		$post_id = (int) $post_id;
		if ( $post_id <= 0 ) {
			return;
		}

		$child_fields = get_posts(
			array(
				'post_type'      => 'acf-field',
				'post_parent'    => $post_id,
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);

		if ( ! empty( $child_fields ) ) {
			foreach ( $child_fields as $child_field_id ) {
				wp_trash_post( (int) $child_field_id );
			}
		}

		wp_trash_post( $post_id );
	}
}

if ( ! function_exists( 'pardot_boostrap_get_top_level_acf_field_names' ) ) {
	/**
	 * Get top-level field names for a field group.
	 *
	 * @param array $field_group ACF field group.
	 * @return array<int, string>
	 */
	function pardot_boostrap_get_top_level_acf_field_names( $field_group ) {
		$names = array();

		if ( ! function_exists( 'acf_get_fields' ) ) {
			return $names;
		}

		$fields = acf_get_fields( $field_group );
		if ( empty( $fields ) || ! is_array( $fields ) ) {
			return $names;
		}

		foreach ( $fields as $field ) {
			if ( ! is_array( $field ) || empty( $field['name'] ) ) {
				continue;
			}

			$names[] = (string) $field['name'];
		}

		sort( $names );
		return $names;
	}
}

if ( ! function_exists( 'pardot_boostrap_cleanup_mri_feature_icons_field_group_mismatch' ) ) {
	/**
	 * One-time cleanup: remove stale MRI Feature Icons group definitions that do not match template fields.
	 */
	function pardot_boostrap_cleanup_mri_feature_icons_field_group_mismatch() {
		if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! function_exists( 'acf_get_field_groups' ) || ! function_exists( 'acf_get_fields' ) ) {
			return;
		}

		$version = 'v1';
		$option_key = 'pardot_boostrap_mri_feature_icons_group_cleanup_' . $version . '_done';

		if ( get_option( $option_key ) ) {
			return;
		}

		$expected_key         = 'group_mri_feature_icons';
		$expected_block_value = 'acf/mri-feature-icons';
		$expected_fields      = array(
			'mri_feature_icons_heading',
			'mri_feature_icons_items',
		);
		sort( $expected_fields );

		$field_groups = acf_get_field_groups();
		if ( empty( $field_groups ) || ! is_array( $field_groups ) ) {
			update_option( $option_key, gmdate( 'c' ), false );
			return;
		}

		$valid_group_id = 0;

		foreach ( $field_groups as $field_group ) {
			$block_value = pardot_boostrap_get_acf_block_rule_value( $field_group );
			if ( $expected_block_value !== $block_value ) {
				continue;
			}

			$group_id = isset( $field_group['ID'] ) ? (int) $field_group['ID'] : 0;
			if ( $group_id <= 0 ) {
				continue;
			}

			$group_key   = isset( $field_group['key'] ) ? (string) $field_group['key'] : '';
			$field_names = pardot_boostrap_get_top_level_acf_field_names( $field_group );

			$is_expected_shape = ( $group_key === $expected_key && $field_names === $expected_fields );

			if ( $is_expected_shape && 0 === $valid_group_id ) {
				$valid_group_id = $group_id;
				continue;
			}

			pardot_boostrap_trash_acf_group_with_children( $group_id );
		}

		update_option( $option_key, gmdate( 'c' ), false );
	}
}

/**
 * Load MRI ACF JSON field groups from the split import directory.
 */
function pardot_boostrap_acf_load_json_paths( $paths ) {
	$mri_json_dir = trailingslashit( get_template_directory() ) . 'acf-json/mri-import-split';

	if ( is_dir( $mri_json_dir ) ) {
		$paths[] = $mri_json_dir;
	}

	return array_values( array_unique( $paths ) );
}
add_filter( 'acf/settings/load_json', 'pardot_boostrap_acf_load_json_paths' );

require_once get_template_directory() . '/picker-page.php';

require_once get_template_directory() . '/acf-blocks.php';

function pardot_boostrap_remove_page_taxonomies() {
	unregister_taxonomy_for_object_type( 'page_region', 'page' );
	unregister_taxonomy_for_object_type( 'page_type', 'page' );
}
add_action( 'init', 'pardot_boostrap_remove_page_taxonomies', 100 );

/**
 * Register page-level ACF fields used for filtering pages.
 */
add_action( 'acf/include_fields', 'pardot_boostrap_register_global_tags_field_group' );
function pardot_boostrap_register_global_tags_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
	array(
    'key'            => 'group_6a3aaf68b64da',
    'title'          => 'Global_tags',

    'fields'         => array(

        array(
            'key'           => 'field_6a3ab2bc1001c',
            'label'         => 'Region',
            'name'          => 'global_tags_group_region',
            'type'          => 'select',
            'required'      => 1,
            'choices'       => array(
                'NA' => 'NA',
                'UK' => 'UK',
                'AU' => 'AU',
            ),
            'return_format' => 'value',
            'multiple'      => 0,
            'allow_null'    => 0,
            'ui'            => 1,
            'ajax'          => 1,
        ),

        array(
            'key'           => 'field_6a3ab3611001e',
            'label'         => 'Other',
            'name'          => 'global_tags_group_other',
            'type'          => 'select',
            'required'      => 1,
            'choices'       => array(
                'A' => 'A',
                'B' => 'B',
                'C' => 'C',
            ),
            'return_format' => 'value',
            'multiple'      => 0,
            'allow_null'    => 0,
            'ui'            => 0,
            'ajax'          => 0,
        ),

    ),

    'location' => array(
        array(
            array(
                'param'    => 'post_type',
                'operator' => '==',
                'value'    => 'page',
            ),
        ),
    ),

    'position'        => 'side',
    'style'           => 'default',
    'label_placement' => 'top',
    'active'          => true,
    'show_in_rest'    => 1,
		)
	);
}

/**
 * Render page list filters for Global Tags fields.
 */
function pardot_boostrap_render_page_global_tags_filters() {
	global $typenow;

	if ( 'page' !== $typenow ) {
		return;
	}

	$selected_region = isset( $_GET['global_tags_region'] ) ? sanitize_text_field( wp_unslash( $_GET['global_tags_region'] ) ) : '';
	$selected_other  = isset( $_GET['global_tags_other'] ) ? sanitize_text_field( wp_unslash( $_GET['global_tags_other'] ) ) : '';

	$region_choices = array(
		''   => __( 'All Regions', 'pardot-boostrap' ),
		'NA' => 'NA',
		'UK' => 'UK',
		'AU' => 'AU',
	);

	$other_choices = array(
		''  => __( 'All Types', 'pardot-boostrap' ),
		'A' => 'A',
		'B' => 'B',
		'C' => 'C',
	);

	echo '<select name="global_tags_region">';
	foreach ( $region_choices as $value => $label ) {
		echo '<option value="' . esc_attr( $value ) . '" ' . selected( $selected_region, $value, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select>';

	echo '<select name="global_tags_other">';
	foreach ( $other_choices as $value => $label ) {
		echo '<option value="' . esc_attr( $value ) . '" ' . selected( $selected_other, $value, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select>';
}
add_action( 'restrict_manage_posts', 'pardot_boostrap_render_page_global_tags_filters' );

/**
 * Filter Pages query by selected Global Tags values.
 *
 * @param WP_Query $query Current query.
 */
function pardot_boostrap_filter_pages_by_global_tags( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( 'page' !== $query->get( 'post_type' ) ) {
		return;
	}

	$region = isset( $_GET['global_tags_region'] ) ? sanitize_text_field( wp_unslash( $_GET['global_tags_region'] ) ) : '';
	$other  = isset( $_GET['global_tags_other'] ) ? sanitize_text_field( wp_unslash( $_GET['global_tags_other'] ) ) : '';

	if ( '' === $region && '' === $other ) {
		return;
	}

	$meta_query = array( 'relation' => 'AND' );

	if ( '' !== $region ) {
		$meta_query[] = array(
			'key'     => 'global_tags_group_global_tags_group_region',
			'value'   => $region,
			'compare' => '=',
		);
	}

	if ( '' !== $other ) {
		$meta_query[] = array(
			'key'     => 'global_tags_group_global_tags_group_other',
			'value'   => $other,
			'compare' => '=',
		);
	}

	$query->set( 'meta_query', $meta_query );
}
add_action( 'pre_get_posts', 'pardot_boostrap_filter_pages_by_global_tags' );

