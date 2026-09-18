<?php
/**
 * ACF block registrations.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add a custom block category for theme blocks.
 *
 * @param array[] $categories Existing block categories.
 * @return array[]
 */
function pardot_boostrap_register_block_category( $categories ) {
	$categories[] = array(
		'slug'  => 'pardot-boostrap',
		'title' => __( 'Pardot Blocks', 'pardot-boostrap' ),
	);

	return $categories;
}
add_filter( 'block_categories_all', 'pardot_boostrap_register_block_category' );

/**
 * Return a safe allowlist for inline heading markup.
 *
 * @return array<string, array<string, array<string>>> 
 */
function pardot_boostrap_get_allowed_header_tags() {
	return array(
		'span' => array(
			'class' => array(),
			'style' => array(),
			'id'    => array(),
		),
		'br' => array(),
	);
}

/**
 * Enqueue Bootstrap Icons in ACF input contexts (editor/admin).
 */
function pardot_boostrap_enqueue_bootstrap_icons_for_acf() {
	wp_enqueue_style(
		'pardot-boostrap-bootstrap-icons',
		'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
		array(),
		'1.11.3'
	);
}
add_action( 'acf/input/admin_enqueue_scripts', 'pardot_boostrap_enqueue_bootstrap_icons_for_acf' );

/**
 * Add a Bootstrap Icons tab to ACF icon picker.
 *
 * @param array $tabs Existing icon picker tabs.
 * @return array
 */
function pardot_boostrap_add_icon_picker_bootstrap_tab( $tabs ) {
	$tabs['bi'] = __( 'Bootstrap Icons', 'pardot-boostrap' );

	return $tabs;
}
add_filter( 'acf/fields/icon_picker/tabs', 'pardot_boostrap_add_icon_picker_bootstrap_tab' );

/**
 * Build and cache Bootstrap Icons list used by ACF icon picker.
 *
 * @return array<int, array<string, string>>
 */
function pardot_boostrap_get_bootstrap_icons_list() {
	$cache_key   = 'pardot_boostrap_bi_icons_list';
	$cached_list = get_transient( $cache_key );

	if ( is_array( $cached_list ) && ! empty( $cached_list ) && count( $cached_list ) <= 120 ) {
		return $cached_list;
	}

	$icon_slugs = array(
		'alarm',
		'arrow-right',
		'arrow-left',
		'arrow-up',
		'arrow-down',
		'check',
		'check-circle',
		'check-circle-fill',
		'x',
		'x-circle',
		'plus',
		'dash',
		'plus-circle',
		'dash-circle',
		'info-circle',
		'exclamation-circle',
		'exclamation-triangle',
		'question-circle',
		'star',
		'star-fill',
		'heart',
		'heart-fill',
		'bookmark',
		'bookmark-fill',
		'calendar',
		'clock',
		'chat',
		'chat-dots',
		'chat-quote',
		'telephone',
		'envelope',
		'geo-alt',
		'globe',
		'house',
		'building',
		'briefcase',
		'person',
		'people',
		'image',
		'images',
		'camera',
		'play-circle',
		'pause-circle',
		'link-45deg',
		'download',
		'upload',
		'search',
		'filter',
		'gear',
		'sliders',
		'list',
		'grid',
		'bag',
		'cart',
		'gift',
		'lightning',
		'shield-check',
		'award',
		'trophy',
		'graph-up',
		'bar-chart',
		'pie-chart',
		'clipboard',
		'file-earmark-text',
		'file-earmark-richtext',
		'folder',
		'folder2-open',
		'wifi',
		'cpu',
		'cloud',
		'cloud-arrow-down',
		'cloud-arrow-up',
		'moon',
		'sun',
		'palette',
		'brush',
		'pen',
		'type',
		'flag',
		'map',
		'pin-map',
		'truck',
		'airplane',
		'rocket',
		'box',
		'boxes',
		'credit-card',
		'cash',
		'currency-dollar',
		'lock',
		'unlock',
		'key',
		'eye',
		'eye-slash',
		'hand-thumbs-up',
		'hand-thumbs-down',
		'emoji-smile',
		'emoji-frown',
		'tools',
		'wrench',
		'hammer',
	);

	$icons = array();

	foreach ( $icon_slugs as $slug ) {
		$icons[] = array(
			'key'   => 'bi-' . sanitize_html_class( $slug ),
			'label' => ucwords( str_replace( array( '-', '_' ), ' ', $slug ) ),
			'url'   => '',
		);
	}

	if ( empty( $icons ) ) {
		$icons = array(
			array(
				'key'   => 'bi-alarm',
				'label' => 'Alarm',
				'url'   => '',
			),
			array(
				'key'   => 'bi-check-circle-fill',
				'label' => 'Check Circle Fill',
				'url'   => '',
			),
		);
	}

	set_transient( $cache_key, $icons, MONTH_IN_SECONDS );

	return $icons;
}

/**
 * Provide Bootstrap Icons entries to the custom ACF icon picker tab.
 *
 * @param array $icons Existing icons.
 * @return array
 */
function pardot_boostrap_add_bootstrap_icons_to_picker( $icons ) {
	return pardot_boostrap_get_bootstrap_icons_list();
}
add_filter( 'acf/fields/icon_picker/bi/icons', 'pardot_boostrap_add_bootstrap_icons_to_picker', 10, 1 );

/**
 * Register ACF blocks used by the theme.
 */
function pardot_boostrap_register_acf_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}
}
add_action( 'acf/init', 'pardot_boostrap_register_acf_blocks' );

function pardot_boostrap_register_mri_acf_blocks() {
	if ( ! function_exists( 'acf_register_block_type' ) ) {
		return;
	}

	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$mri_template_dir = get_template_directory() . '/template-parts/blocks';
	$discovered_templates = glob( $mri_template_dir . '/mri-*.php' );

	if ( ! is_array( $discovered_templates ) || empty( $discovered_templates ) ) {
		return;
	}

	foreach ( $discovered_templates as $template_path ) {
		$template_name = basename( $template_path );
		$block_name = substr( $template_name, 0, -4 );
		$slug = substr( $block_name, 4 );
		$title = __( 'MRI ' . ucwords( str_replace( '-', ' ', $slug ) ), 'pardot-boostrap' );
		$description = __( 'A block template rendered from ' . $template_name . '.', 'pardot-boostrap' );

		acf_register_block_type(
			array(
				'name'            => $block_name,
				'title'           => $title,
				'description'     => $description,
				'render_template' => $template_path,
				'category'        => 'pardot-boostrap',
				'icon'            => 'cover-image',
				'keywords'        => array( 'mri', 'block', str_replace( '-', ' ', $block_name ) ),
				'mode'            => 'preview',
				'supports'        => array(
					'align'  => false,
					'anchor' => true,
					'mode'   => true,
				),
			)
		);

		acf_add_local_field_group(
			array(
				'key'      => 'group_mri_wrapper_' . sanitize_title( $block_name ),
				'title'    => 'Wrapper Styling',
				'fields'   => array(
					array(
						'key'           => 'field_mri_wrapper_' . sanitize_title( $block_name ),
						'label'         => 'Wrapper Style',
						'name'          => 'mri_block_wrapper_class',
						'type'          => 'select',
						'choices'       => array(
							'default'               => 'Default',
							'mri-block-shell'       => 'Soft shell',
							'mri-block-shell-accent' => 'Accent shell',
							'mri-block-shell-border' => 'Border shell',
						),
						'default_value' => 'default',
					),
					array(
						'key'           => 'field_mri_block_style_' . sanitize_title( $block_name ),
						'label'         => 'Block Style',
						'name'          => 'mri_block_style',
						'type'          => 'select',
						'choices'       => array(
						'none'                  => 'None',
						'border py-5 rounded p-5' => 'Border',
						'bg-dark text-white'    => 'Dark',
						'bg-primary text-white' => 'Accent',
						),
						'default_value' => 'none',
					),
				),
				'location' => array(
					array(
						array(
							'param'    => 'block',
							'operator' => '==',
							'value'    => 'acf/' . $block_name,
						),
					),
				),
				'position' => 'side',
			)
		);
	}
}
add_action( 'acf/init', 'pardot_boostrap_register_mri_acf_blocks' );

function pardot_boostrap_get_mri_block_setting( $block, $setting_name ) {
	if ( ! is_array( $block ) ) {
		return '';
	}

	$paths = array(
		array( 'attrs', 'data', $setting_name ),
		array( 'attrs', $setting_name ),
		array( 'data', $setting_name ),
	);

	foreach ( $paths as $path ) {
		$value = $block;
		$found = true;

		foreach ( $path as $segment ) {
			if ( ! is_array( $value ) || ! array_key_exists( $segment, $value ) ) {
				$found = false;
				break;
			}
			$value = $value[ $segment ];
		}

		if ( $found && null !== $value ) {
			return trim( (string) $value );
		}
	}

	return '';
}

function pardot_boostrap_get_mri_style_classes( $block_style ) {
	$style_map = array(
		'border'                => array( 'border', 'my-5', 'rounded', 'p-3', 'shadow-sm' ),
		'dark'                  => array( 'bg-dark', 'text-white' ),
		'accent'                => array( 'bg-primary', 'text-white' ),
		'bg-dark text-white'    => array( 'bg-dark', 'text-white' ),
		'bg-primary text-white' => array( 'bg-primary', 'text-white' ),
		'border py-5 rounded p-5' => array( 'border', 'py-5', 'rounded', 'p-5' ),
	);

	if ( isset( $style_map[ $block_style ] ) ) {
		return $style_map[ $block_style ];
	}

	$tokens = preg_split( '/\s+/', trim( $block_style ) );
	if ( ! is_array( $tokens ) ) {
		return array();
	}

	return array_values( array_filter( array_map( 'trim', $tokens ) ) );
}

function pardot_boostrap_get_mri_preview_class( $block_style ) {
	if ( 'bg-dark text-white' === $block_style || 'dark' === $block_style ) {
		return 'mri-block-style-dark';
	}

	if ( 'bg-primary text-white' === $block_style || 'accent' === $block_style ) {
		return 'mri-block-style-accent';
	}

	if ( 'border py-5 rounded p-5' === $block_style || 'border' === $block_style ) {
		return 'mri-block-style-border';
	}

	return '';
}

function pardot_boostrap_wrap_mri_block_output( $block_content, $block ) {
	if ( ! is_array( $block ) || empty( $block['blockName'] ) || 0 !== strpos( $block['blockName'], 'acf/mri-' ) ) {
		return $block_content;
	}

	$wrapper_class = pardot_boostrap_get_mri_block_setting( $block, 'mri_block_wrapper_class' );
	$block_style   = pardot_boostrap_get_mri_block_setting( $block, 'mri_block_style' );
	$wrapper_class = trim( $wrapper_class );
	$block_style   = trim( $block_style );

	$wrapper_classes = array( 'mri-block-wrapper' );
	$container_classes = array( 'container', 'mri-block-container' );
	$content_classes = array( 'col-12', 'mri-block-content' );

	if ( '' !== $wrapper_class && 'default' !== $wrapper_class ) {
		$wrapper_classes[] = sanitize_html_class( $wrapper_class );
	}

	if ( '' !== $block_style && 'none' !== $block_style ) {
		$preview_class = pardot_boostrap_get_mri_preview_class( $block_style );
		if ( '' !== $preview_class ) {
			$wrapper_classes[] = sanitize_html_class( $preview_class );
		}

		foreach ( pardot_boostrap_get_mri_style_classes( $block_style ) as $style_token ) {
			$style_token = trim( (string) $style_token );
			if ( '' !== $style_token ) {
				$wrapper_classes[] = sanitize_html_class( $style_token );
				$container_classes[] = sanitize_html_class( $style_token );
			}
		}
	}

	$wrapper_markup = '<div class="' . esc_attr( implode( ' ', $wrapper_classes ) ) . '">';
	$wrapper_markup .= '<div class="' . esc_attr( implode( ' ', $container_classes ) ) . '"><div class="row"><div class="' . esc_attr( implode( ' ', $content_classes ) ) . '">' . $block_content . '</div></div></div></div>';

	if ( is_admin() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return $wrapper_markup;
	}

	return $wrapper_markup;
}
add_filter( 'render_block', 'pardot_boostrap_wrap_mri_block_output', 10, 2 );

/**
 * Register ACF fields for the Before After block.
 */
function pardot_boostrap_register_before_after_field_group() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'      => 'group_pardot_before_after',
			'title'    => 'Before After Block',
			'fields'   => array(
				array(
					'key'   => 'field_pardot_before_after_heading',
					'label' => 'Heading',
					'name'  => 'before_after_heading',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_pardot_before_after_heading_highlight',
					'label' => 'Heading Highlight',
					'name'  => 'before_after_heading_highlight',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_pardot_before_after_intro',
					'label' => 'Intro Text',
					'name'  => 'before_after_intro',
					'type'  => 'textarea',
				),
				array(
					'key'   => 'field_pardot_before_after_before_title',
					'label' => 'Before Title',
					'name'  => 'before_after_before_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_pardot_before_after_before_text',
					'label' => 'Before Text',
					'name'  => 'before_after_before_text',
					'type'  => 'textarea',
				),
				array(
					'key'   => 'field_pardot_before_after_after_title',
					'label' => 'After Title',
					'name'  => 'before_after_after_title',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_pardot_before_after_after_text',
					'label' => 'After Text',
					'name'  => 'before_after_after_text',
					'type'  => 'textarea',
				),
				array(
					'key'   => 'field_pardot_before_after_quote_text',
					'label' => 'Quote Text',
					'name'  => 'before_after_quote_text',
					'type'  => 'textarea',
				),
				array(
					'key'   => 'field_pardot_before_after_quote_author',
					'label' => 'Quote Author',
					'name'  => 'before_after_quote_author',
					'type'  => 'text',
				),
				array(
					'key'          => 'field_pardot_before_after_ticks',
					'label'        => 'Tick List',
					'name'         => 'before_after_ticks',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => 'Add Tick Item',
					'sub_fields'   => array(
						array(
							'key'   => 'field_pardot_before_after_tick_text',
							'label' => 'Text',
							'name'  => 'text',
							'type'  => 'text',
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'block',
						'operator' => '==',
						'value'    => 'acf/before-after',
					),
				),
			),
		)
	);
}
add_action( 'acf/include_fields', 'pardot_boostrap_register_before_after_field_group' );

/**
 * Hide all core/default WordPress blocks from the block editor.
 * Only show custom ACF blocks.
 */
function pardot_boostrap_get_allowed_blocks() {
	$allowed_blocks = array();

	$mri_template_dir = get_template_directory() . '/template-parts/blocks';
	$discovered_templates = glob( $mri_template_dir . '/mri-*.php' );

	if ( is_array( $discovered_templates ) ) {
		foreach ( $discovered_templates as $template_path ) {
			$template_name = basename( $template_path );
			$block_name = substr( $template_name, 0, -4 );
			$allowed_blocks[] = 'acf/' . $block_name;
		}
	}

	return array_values( array_unique( $allowed_blocks ) );
}

function pardot_boostrap_hide_core_blocks() {
	add_filter(
		'allowed_block_types_all',
		function ( $allowed_blocks_param, $editor_context ) {
			return pardot_boostrap_get_allowed_blocks();
		},
		10,
		2
	);
}
add_action( 'init', 'pardot_boostrap_hide_core_blocks' );
