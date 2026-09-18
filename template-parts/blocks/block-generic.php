<?php
/**
 * Generic MRI block renderer.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
exit;
}

if ( ! isset( $mri_block_slug ) || '' === $mri_block_slug ) {
return;
}

$field_prefix  = 'mri_' . str_replace( '-', '_', $mri_block_slug );
$shared_fields = pardot_boostrap_get_shared_block_fields( $field_prefix, $block );

$heading      = $shared_fields['heading'];
$subheading   = $shared_fields['subheading'];
$content      = $shared_fields['content'];
$button_label = $shared_fields['button_label'];
$button_link  = $shared_fields['button_link'];
$image        = $shared_fields['image'];

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-' . $mri_block_slug );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="mri-block mri-block-<?php echo esc_attr( $mri_block_slug ); ?> position-relative">
<div class="position-relative z-1">
<div class="row g-4 align-items-center">
<div class="col-12 <?php echo ! empty( $image ) ? 'col-lg-6' : ''; ?>">
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

<?php if ( ! empty( $image ) && ! empty( $image['url'] ) ) : ?>
<div class="col-12 col-lg-6">
<img
src="<?php echo esc_url( $image['url'] ); ?>"
alt="<?php echo esc_attr( ! empty( $image['alt'] ) ? $image['alt'] : $heading ); ?>"
class="img-fluid rounded shadow-sm"
/>
</div>
<?php endif; ?>
</div>
</div>
</section>





