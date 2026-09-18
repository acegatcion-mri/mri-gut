<?php
/**
 * MRI Feature Block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$shared_fields  = pardot_boostrap_get_shared_block_fields( 'mri_feature_block', $block );
$heading        = $shared_fields['heading'];
$subheading     = $shared_fields['subheading'];
$content        = $shared_fields['content'];
$button_label   = $shared_fields['button_label'];
$button_link    = $shared_fields['button_link'];
$image          = $shared_fields['image'];
$reverse_fields = pardot_boostrap_get_block_field_value( $block, 'mri_feature_block_reverse_columns' );
$feature_points = pardot_boostrap_get_block_field_value( $block, 'mri_feature_block_feature_points' );

$reverse_columns = ! empty( $reverse_fields );

if ( ! is_array( $feature_points ) ) {
  $feature_points = array();
}

/*$feature_points = pardot_boostrap_repeat_rows_to_count( $feature_points, 4 );*/

$text_column_order  = $reverse_columns ? 'order-md-last' : 'order-md-first';
$media_column_order = $reverse_columns ? 'order-md-first' : 'order-md-last';

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-feature-block' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="position-relative mri-feature-block">
  <div class="position-relative z-1">
    <div class="row align-items-center g-4">
      <div class="col-12 col-md-6 <?php echo esc_attr( $text_column_order ); ?>">
        <div class="me-md-5">
          <p class="eyebrow mb-1"><?php echo esc_html( $subheading ); ?></p>
          <h2><?php echo esc_html( $heading ); ?></h2>

          <?php if ( ! empty( $content ) ) : ?>
            <div><?php echo wp_kses_post( wpautop( $content ) ); ?></div>
          <?php endif; ?>

          <ul class="feature-points list-unstyled my-3 pb-4">
            <?php foreach ( $feature_points as $point ) : ?>
              <?php
              $point_icon = isset( $point['icon_class'] ) ? $point['icon_class'] : '';
              $point_text = isset( $point['text'] ) ? $point['text'] : '';

              if ( '' === trim( wp_strip_all_tags( $point_text ) ) ) {
                continue;
              }
              ?>
              <li class="feature-point">
                <span class="feature-point-icon" aria-hidden="true">
                  <i class="<?php echo esc_attr( $point_icon ); ?>"></i>
                </span>
                <span class="feature-point-text"><?php echo esc_html( $point_text ); ?></span>
              </li>
            <?php endforeach; ?>
          </ul>

          <?php if ( ! empty( $button_label ) && ! empty( $button_link ) ) : ?>
            <div class="my-2 my-md-4">
              <a href="<?php echo esc_url( $button_link ); ?>" class="btm cta-button-blue-outline text-decoration-none">
                <?php echo esc_html( $button_label ); ?>
              </a>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-12 col-md-6 d-md-flex <?php echo esc_attr( $media_column_order ); ?>">
        <?php if ( ! empty( $image['url'] ) ) : ?>
          <img
            src="<?php echo esc_url( $image['url'] ); ?>"
            alt="<?php echo esc_attr( $image['alt'] ); ?>"
            class="feature-block-image w-100 h-100 my-3" />
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>






