<?php
/**
 * MRI Steps block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$eyebrow = pardot_boostrap_get_block_field_value( $block, 'mri_steps_eyebrow' );
$heading = pardot_boostrap_get_block_field_value( $block, 'mri_steps_heading' );
$heading_highlight = pardot_boostrap_get_block_field_value( $block, 'mri_steps_heading_highlight' );
$heading_suffix = pardot_boostrap_get_block_field_value( $block, 'mri_steps_heading_suffix' );
$image = pardot_boostrap_get_block_field_value( $block, 'mri_steps_image' );
$items = pardot_boostrap_get_block_field_value( $block, 'mri_steps_items' );

if ( ! is_array( $items ) ) {
  $items = array();
}

/*$items = pardot_boostrap_repeat_rows_to_count( $items, 4 );*/

$image_url = '';
$image_alt = 'icon';

if ( is_array( $image ) ) {
  $image_url = isset( $image['url'] ) ? $image['url'] : '';
  $image_alt = isset( $image['alt'] ) && '' !== trim( $image['alt'] ) ? $image['alt'] : $image_alt;
} elseif ( is_string( $image ) ) {
  $image_url = $image;
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-steps' );
$allowed_header_tags = pardot_boostrap_get_allowed_header_tags();
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="mri-steps py-2 position-relative">
  <div class="position-relative z-1">
    <div class="row">
      <section class="col-12">
        <div class="row g-4 align-items-center">
     
          
        <div class="col-12 col-md-5 d-flex align-items-center mb-4">
          <img
            src="<?php echo esc_url( $image_url ); ?>"
            alt="<?php echo esc_attr( $image_alt ); ?>"
            class="img-fluid max-w-fixed rounded mt-3"
          />
          </div>
          <div class="col-12 col-md-7 d-flex align-items-center mb-4">
          <h2 class="mb-0 ">
            <span class="eyebrow mb-1"><?php echo wp_kses( $eyebrow, $allowed_header_tags ); ?></span>
            <br />
            <?php echo wp_kses( $heading, $allowed_header_tags ); ?>
          </h2>
        </div>
        

        <div class="row g-4">
          <?php foreach ( $items as $index => $item ) : ?>
            <?php
            $title = '';
            $body = '';

            if ( is_array( $item ) ) {
              $title = isset( $item['title'] ) ? $item['title'] : '';
              $body = isset( $item['body'] ) && '' !== trim( $item['body'] ) ? $item['body'] : $body;
            } elseif ( is_string( $item ) ) {
              $title = $item;
            }

            if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
              continue;
            }
            ?>
            <div class="col-md-3">
              <b class="border-bottom light-green"><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></b>
              <h4 class="my-3"><?php echo esc_html( $title ); ?></h4>
              <p><?php echo esc_html( $body ); ?></p>
            </div>
          <?php endforeach; ?>
        </div>
      </section>
    </div>
  </div>
</section>




