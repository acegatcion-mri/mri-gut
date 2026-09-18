<?php
/**
 * MRI Image Block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$image = pardot_boostrap_get_block_field_value( $block, 'mri_image_block_image' );
$image_alt = pardot_boostrap_get_block_field_value( $block, 'mri_image_block_image_alt' );

if ( ! is_array( $image ) ) {
  $image = array();
}

$alt_text = ! empty( $image_alt ) ? $image_alt : ( $image['alt'] );
$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-image-block' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="mri-image-block position-relative">
  <div class="`position-relative z-1">
    <div class="row justify-content-center align-items-center">
      <div class="col-8 mt-md-n5">
        <?php if ( ! empty( $image['url'] ) ) : ?>
          <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $alt_text ); ?>" class="w-100" />
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>




