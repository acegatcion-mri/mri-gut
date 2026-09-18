<?php
/**
 * MRI Before After block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_before_after_heading' );
$heading_highlight = pardot_boostrap_get_block_field_value( $block, 'mri_before_after_heading_highlight' );
$intro = pardot_boostrap_get_block_field_value( $block, 'mri_before_after_intro' );
$before_title = pardot_boostrap_get_block_field_value( $block, 'mri_before_after_before_title' );
$before_text = pardot_boostrap_get_block_field_value( $block, 'mri_before_after_before_text' );
$after_title = pardot_boostrap_get_block_field_value( $block, 'mri_before_after_after_title' );
$after_text = pardot_boostrap_get_block_field_value( $block, 'mri_before_after_after_text' );
$items = pardot_boostrap_get_block_field_value( $block, 'mri_before_after_items' );
$image = pardot_boostrap_get_block_field_value( $block, 'mri_before_after_image' );

if ( ! is_array( $items ) ) {
  $items = array();
}

/***Commented to prevent duplication of items */
/*$items = pardot_boostrap_repeat_rows_to_count( $items, 3 );*/

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-before-after' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="mri-before-after position-relative">
  <div class="position-relative z-1">
    <div class="row justify-content-center align-items-center g-5">
      <div class="col-12 col-md-6">
        <h2>
          <?php echo esc_html( $heading ); ?>
          <?php if ( ! empty( $heading_highlight ) ) : ?>
            <span> <?php echo esc_html( $heading_highlight ); ?></span>
          <?php endif; ?>
        </h2>

        <?php if ( ! empty( $intro ) ) : ?>
          <div class="mb-3"><?php echo wp_kses_post( wpautop( $intro ) ); ?></div>
        <?php endif; ?>

        <div class="ba">
          <div class="before rounded shadow p-4">
            <div class="mb-2 d-flex justify-content-end">
              <i class="bi bi-patch-minus-fill fs-1" aria-hidden="true"></i>
            </div>

            <b><?php echo esc_html( $before_title ); ?></b>
            <p><?php echo esc_html( $before_text ); ?></p>
          </div>
          <div class="after rounded shadow p-4">
            <div class="mb-2 d-flex justify-content-end">
              <i class="bi bi-patch-check-fill fs-1" aria-hidden="true"></i>
            </div>

            <b><?php echo esc_html( $after_title ); ?></b>
            <p><?php echo esc_html( $after_text ); ?></p>
          </div>
        </div>

        <div class="mt-5">
          <?php foreach ( $items as $item ) : ?>
            <?php
            $item_text = isset( $item['text'] ) ? $item['text'] : '';
            if ( '' === trim( wp_strip_all_tags( $item_text ) ) ) {
              continue;
            }
            ?>
            <div class="d-flex align-items-center mb-3">
              <span class="check-circle" aria-hidden="true">
                <i class="bi bi-check-lg"></i>
              </span>
              <span class="ms-3 fw-medium"><?php echo esc_html( $item_text ); ?></span>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-12 col-md-6">
        <?php if ( ! empty( $image['url'] ) ) : ?>
          <img
            src="<?php echo esc_url( $image['url'] ); ?>"
            alt="<?php echo esc_attr( $image['alt'] ); ?>"
            class="img-fluid" />
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>




