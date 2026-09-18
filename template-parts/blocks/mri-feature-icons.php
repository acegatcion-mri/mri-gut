<?php
/**
 * MRI Feature Icons block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_feature_icons_heading' );
$items = pardot_boostrap_get_block_field_value( $block, 'mri_feature_icons_items' );

if ( ! is_array( $items ) ) {
  $items = array();
}

$items = pardot_boostrap_repeat_rows_to_count( $items, 4 );

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-feature-icons' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="mri-feature-icons position-relative">
  <div class="position-relative z-1">
    <div class="row">
      <h2 class="text-center mb-5"><?php echo esc_html( $heading ); ?></h2>
      <div class="row g-4 text-center">
        <?php foreach ( $items as $item ) : ?>
          <?php
          $title      = isset( $item['title'] ) ? $item['title'] : '';
          $text       = isset( $item['text'] ) ? $item['text'] : '';
          $icon_class = isset( $item['icon_class'] ) ? $item['icon_class'] : '';

          if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
            continue;
          }
          ?>
          <div class="col-12 col-md-6 col-lg-3">
            <div class="h-100 px-2 px-lg-3">
              <div class="feature-icons-badge mx-auto rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi <?php echo esc_attr( $icon_class ); ?>" aria-hidden="true"></i>
              </div>
              <h3 class="mt-3 mb-3"><?php echo esc_html( $title ); ?></h3>
              <?php if ( ! empty( $text ) ) : ?>
                <p class="mx-auto mb-0"><?php echo esc_html( $text ); ?></p>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>




