<?php
/**
 * Picker page logic.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return available design definitions sourced from local design HTML files.
 *
 * @return array[]
 */
function pardot_boostrap_get_design_definitions() {
	$design_files = array(
		'case-studies' => array(
			'label'       => __( 'Case Studies', 'pardot-boostrap' ),
			'description' => __( 'Customer success-focused page layout.', 'pardot-boostrap' ),
		),
		'ebooks'       => array(
			'label'       => __( 'Ebooks', 'pardot-boostrap' ),
			'description' => __( 'Long-form resource landing page layout.', 'pardot-boostrap' ),
		),
		'guides'       => array(
			'label'       => __( 'Guides', 'pardot-boostrap' ),
			'description' => __( 'Educational guide page layout.', 'pardot-boostrap' ),
		),
		'products'     => array(
			'label'       => __( 'Products', 'pardot-boostrap' ),
			'description' => __( 'Product overview and feature page layout.', 'pardot-boostrap' ),
		),
		'reports'      => array(
			'label'       => __( 'Reports', 'pardot-boostrap' ),
			'description' => __( 'Research report landing page layout.', 'pardot-boostrap' ),
		),
		'videos'       => array(
			'label'       => __( 'Videos', 'pardot-boostrap' ),
			'description' => __( 'Video content hub page layout.', 'pardot-boostrap' ),
		),
		'webinars'     => array(
			'label'       => __( 'Webinars', 'pardot-boostrap' ),
			'description' => __( 'Webinar registration page layout.', 'pardot-boostrap' ),
		),
	);

	$definitions = array();

	foreach ( $design_files as $slug => $meta ) {
		$definitions[ $slug ] = array(
			'label'       => $meta['label'],
			'description' => $meta['description'],
			'image'       => get_template_directory_uri() . '/assets/images/placeholder.png',
			'pattern'     => $slug,
		);
	}

	return $definitions;
}

/**
 * Read pattern content from the theme designs directory.
 *
 * @param string $pattern_name Pattern key.
 * @return string
 */
function pardot_boostrap_get_pattern_content( $pattern_name ) {
	$pattern_name = sanitize_key( $pattern_name );

	if ( '' === $pattern_name ) {
		return '';
	}

	$pattern_file = trailingslashit( get_template_directory() ) . 'designs/' . $pattern_name . '.html';

	if ( ! file_exists( $pattern_file ) || ! is_readable( $pattern_file ) ) {
		return '';
	}

	$content = file_get_contents( $pattern_file );

	return false === $content ? '' : $content;
}

/**
 * Build design options used by the page picker.
 *
 * @return array[]
 */
function pardot_boostrap_get_design_options() {
	$definitions = pardot_boostrap_get_design_definitions();
	$options     = array();

	foreach ( $definitions as $key => $definition ) {
		$options[ $key ] = array(
			'label'       => $definition['label'],
			'description' => $definition['description'],
			'image'       => isset( $definition['image'] ) ? $definition['image'] : 'https://placehold.net/1-800x600.png',
			'pattern'     => $definition['pattern'],
		);
	}

	return $options;
}

/**
 * Return selected design key from the request if valid.
 *
 * @return string
 */

function pardot_boostrap_get_selected_design_key() {
	if ( ! is_admin() || ! isset( $_GET['pardot_design'] ) ) {
		return '';
	}

	$design_key = sanitize_key( wp_unslash( $_GET['pardot_design'] ) );
	$options    = pardot_boostrap_get_design_options();

	return isset( $options[ $design_key ] ) ? $design_key : '';
}

/**
 * Add a PHP-based design picker page under Pages.
 */
function pardot_boostrap_register_design_picker_admin_page() {
	add_submenu_page(
		'edit.php?post_type=page',
		__( 'New Page Design Picker', 'pardot-boostrap' ),
		__( 'Design Picker', 'pardot-boostrap' ),
		'edit_pages',
		'pardot-boostrap-design-picker',
		'pardot_boostrap_render_design_picker_admin_page'
	);
}
add_action( 'admin_menu', 'pardot_boostrap_register_design_picker_admin_page' );

/**
 * Render design picker admin page.
 */
function pardot_boostrap_render_design_picker_admin_page() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	$options = pardot_boostrap_get_design_options();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Pick a Page Design', 'pardot-boostrap' ); ?></h1>
		<p><?php esc_html_e( 'Choose a design to create a new page with matching starter blocks and template.', 'pardot-boostrap' ); ?></p>
		<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:16px;max-width:1200px;">
			<?php foreach ( $options as $key => $option ) : ?>
				<a style="display:block;text-decoration:none;color:inherit;background:#fff;border:1px solid #dcdcde;border-radius:8px;overflow:hidden;box-shadow:0 1px 2px rgba(0,0,0,.04);" href="<?php echo esc_url( add_query_arg( array( 'post_type' => 'page', 'pardot_design' => $key ), admin_url( 'post-new.php' ) ) ); ?>">
					<img src="<?php echo esc_url( $option['image'] ); ?>" alt="<?php echo esc_attr( $option['label'] ); ?>" style="display:block;width:100%;height:180px;object-fit:cover;background:#f6f7f7;" />
					<div style="padding:12px 14px;">
						<h3 style="margin:0 0 8px 0;font-size:16px;line-height:1.3;"><?php echo esc_html( $option['label'] ); ?></h3>
						<p style="margin:0;color:#50575e;font-size:13px;line-height:1.45;"><?php echo esc_html( $option['description'] ); ?></p>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
	<?php
}

/**
 * Prefill page content with pattern content based on selected design.
 *
 * @param string  $content Default content.
 * @param WP_Post $post    Post object.
 * @return string
 */
function pardot_boostrap_prefill_content_from_design( $content, $post ) {
	if ( ! is_admin() || ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return $content;
	}

	$design_key = pardot_boostrap_get_selected_design_key();

	if ( '' === $design_key ) {
		return $content;
	}

	$options       = pardot_boostrap_get_design_options();
	$pattern_name  = $options[ $design_key ]['pattern'];
	$pattern       = pardot_boostrap_get_pattern_content( $pattern_name );

	return '' !== $pattern ? $pattern : $content;
}
add_filter( 'default_content', 'pardot_boostrap_prefill_content_from_design', 10, 2 );

/**
 * Output hidden template field for selected design on new page form.
 *
 * @param WP_Post $post Post object.
 */
function pardot_boostrap_output_selected_design_fields( $post ) {
	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return;
	}

	$design_key = pardot_boostrap_get_selected_design_key();

	if ( '' === $design_key ) {
		return;
	}

	$options = pardot_boostrap_get_design_options();

	wp_nonce_field( 'pardot_boostrap_apply_selected_design', 'pardot_boostrap_design_nonce' );
	?>
	<input type="hidden" name="_pardot_boostrap_selected_design" value="<?php echo esc_attr( $design_key ); ?>" />
	<div class="notice notice-info inline" style="margin:8px 0 16px 0;">
		<p><?php echo esc_html( sprintf( __( 'Selected design: %s', 'pardot-boostrap' ), $options[ $design_key ]['label'] ) ); ?></p>
	</div>
	<?php
}
add_action( 'edit_form_after_title', 'pardot_boostrap_output_selected_design_fields' );

/**
 * Apply selected design template on save for new pages.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 */
function pardot_boostrap_apply_selected_template_on_save( $post_id, $post ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( ! isset( $_POST['pardot_boostrap_design_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pardot_boostrap_design_nonce'] ) ), 'pardot_boostrap_apply_selected_design' ) ) {
		return;
	}

	if ( ! isset( $_POST['_pardot_boostrap_selected_design'] ) ) {
		return;
	}

	$design_key = sanitize_key( wp_unslash( $_POST['_pardot_boostrap_selected_design'] ) );
	$options    = pardot_boostrap_get_design_options();

	if ( ! isset( $options[ $design_key ] ) ) {
		return;
	}
}
add_action( 'save_post_page', 'pardot_boostrap_apply_selected_template_on_save', 15, 2 );

/**
 * Render design picker screen on new page before editor loads.
 */
function pardot_boostrap_redirect_new_page_to_design_picker() {
	if ( ! is_admin() || ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	$post_type = isset( $_GET['post_type'] ) ? sanitize_key( wp_unslash( $_GET['post_type'] ) ) : 'post';

	if ( 'page' !== $post_type ) {
		return;
	}

	if ( isset( $_GET['pardot_design'] ) || isset( $_GET['pardot_skip_design_picker'] ) ) {
		return;
	}

	$picker_url = add_query_arg(
		array(
			'post_type' => 'page',
			'page'      => 'pardot-boostrap-design-picker',
		),
		admin_url( 'edit.php' )
	);

	wp_safe_redirect( $picker_url );
	exit;
}
add_action( 'load-post-new.php', 'pardot_boostrap_redirect_new_page_to_design_picker' );
