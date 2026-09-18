<?php
/**
 * MRI lead-form block template.
 *
 * Mirrors block-generic.php, with a Pardot form taking the right-hand column.
 * It no longer delegates to the generic renderer because that file is shared
 * with other blocks that must not grow a form.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
exit;
}

$shared_fields = pardot_boostrap_get_shared_block_fields( 'mri_lead_form', $block );

$heading      = $shared_fields['heading'];
$subheading   = $shared_fields['subheading'];
$content      = $shared_fields['content'];
$button_label = $shared_fields['button_label'];
$button_link  = $shared_fields['button_link'];
$image        = $shared_fields['image'];

$pardot_form = pardot_boostrap_get_block_field_value( $block, 'mri_lead_form_pardot_form' );

$has_form  = ! empty( $pardot_form );
$has_image = ! empty( $image ) && ! empty( $image['url'] );

/*
 * The form takes the visual slot when one is selected. The shared field helper
 * falls back to demo content, so $image is almost always populated — showing it
 * alongside a form would just be clutter.
 */
$show_placeholder = ! $has_form && ! $has_image && ! empty( $is_preview );
$has_side_column  = $has_form || $has_image || $show_placeholder;

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-lead-form' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="mri-block mri-block-lead-form position-relative">
<div class="position-relative z-1">
<div class="row g-4 align-items-center">
<div class="col-12 <?php echo $has_side_column ? 'col-lg-6' : ''; ?>">
<?php if ( ! empty( $subheading ) ) : ?>
<p class="eyebrow mb-2"><?php echo esc_html( $subheading ); ?></p>
<?php endif; ?>

<?php if ( ! empty( $heading ) ) : ?>
<h2 class="mb-3"><?php echo esc_html( $heading ); ?></h2>
<?php endif; ?>

<?php if ( ! empty( $content ) ) : ?>
<div class="lead mb-3"><?php echo wp_kses_post( wpautop( $content ) ); ?></div>
<?php endif; ?>

<?php if ( ! empty( $button_label ) && ! empty( $button_link ) ) : ?>
<a class="cta-button-blue-outline text-decoration-none" href="<?php echo esc_url( $button_link ); ?>">
<?php echo esc_html( $button_label ); ?>
</a>
<?php endif; ?>

</div>

<?php if ( $has_form ) : ?>
<div class="col-12 col-lg-6">
<div class="card shadow-sm border-0 mri-ligh-blue-bg">
<div class="card-body p-md-5">
<?php // Sanitised by the ACF MRI Pardot Forms plugin before it is stored. ?>
<div class="mri-lead-form-embed"><?php echo $pardot_form; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
</div>
</div>
</div>
<?php elseif ( $has_image ) : ?>
<div class="col-12 col-lg-6">
<img
src="<?php echo esc_url( $image['url'] ); ?>"
alt="<?php echo esc_attr( ! empty( $image['alt'] ) ? $image['alt'] : $heading ); ?>"
class="img-fluid rounded shadow-sm"
/>
</div>
<?php elseif ( $show_placeholder ) : ?>
<div class="col-12 col-lg-6">
<div class="mri-form-placeholder text-muted small"><?php esc_html_e( 'No Pardot form selected yet.', 'pardot-boostrap' ); ?></div>
</div>
<?php endif; ?>
</div>
</div>
</section>
