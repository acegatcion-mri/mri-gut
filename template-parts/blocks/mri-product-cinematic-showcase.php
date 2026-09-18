<?php
/**
 * MRI Product Cinematic Showcase block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_product_cinematic_showcase_heading' );
$copy    = pardot_boostrap_get_field_with_fallbacks(
  'mri_product_cinematic_showcase_copy',
  array(
    'mri_product_cinematic_showcase_content',
  ),
  $block
);
$chips = pardot_boostrap_get_block_field_value( $block, 'mri_product_cinematic_showcase_chips' );
$metrics = pardot_boostrap_get_block_field_value( $block, 'mri_product_cinematic_showcase_metrics' );
$image = pardot_boostrap_get_block_field_value( $block, 'mri_product_cinematic_showcase_image' );
$cta     = pardot_boostrap_get_field_with_fallbacks(
  'mri_product_cinematic_showcase_cta',
  array(
    'mri_product_cinematic_showcase_button_link',
  ),
  $block
);

$cta_fallback_label = pardot_boostrap_get_field_with_fallbacks(
  'mri_product_cinematic_showcase_button_label',
  array(),
  $block
);

if ( ! is_array( $chips ) ) {
  $chips = array();
}

/*$chips = pardot_boostrap_repeat_rows_to_count( $chips, 3 );*/

if ( ! is_array( $metrics ) ) {
  $metrics = array();
}

/*$metrics = pardot_boostrap_repeat_rows_to_count( $metrics, 3 );*/

$image_url = '';
$image_alt = 'Product command center preview';

if ( is_array( $image ) ) {
  $image_url = isset( $image['url'] ) ? $image['url'] : '';
  $image_alt = isset( $image['alt'] ) && '' !== trim( $image['alt'] ) ? $image['alt'] : $image_alt;
} elseif ( is_string( $image ) ) {
  $image_url = $image;
}
$cta_link = pardot_boostrap_normalize_link_value( $cta, (string) $cta_fallback_label );

$cta_url    = $cta_link['url'];
$cta_label  = $cta_link['title'];
$cta_target = $cta_link['target'];

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-product-cinematic-showcase' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="product-cinematic py-2 position-relative">
  <div class=" position-relative z-1">
    <div class="row align-items-center g-4 g-lg-5">
      <div class="col-12 col-lg-5">
        <p class="eyebrow mb-2">Product Showcase</p>
        <h2 class="mb-3"><?php echo esc_html( $heading ); ?></h2>
        <p class="text-secondary mb-4"><?php echo esc_html( $copy ); ?></p>

        <div class="d-flex flex-wrap gap-2 mb-3">
          <?php foreach ( $chips as $chip ) : ?>
            <?php
            $chip_label = '';

            if ( is_array( $chip ) ) {
              $chip_label = isset( $chip['label'] ) ? $chip['label'] : '';
            } elseif ( is_string( $chip ) ) {
              $chip_label = $chip;
            }

            if ( '' === trim( wp_strip_all_tags( $chip_label ) ) ) {
              continue;
            }
            ?>
            <span class="badge rounded-pill text-bg-light border px-3 py-2"><?php echo esc_html( $chip_label ); ?></span>
          <?php endforeach; ?>
        </div>

        <a
          href="<?php echo esc_url( $cta_url ); ?>"
          <?php if ( ! empty( $cta_target ) ) : ?>target="<?php echo esc_attr( $cta_target ); ?>" rel="noopener"<?php endif; ?>
          class="btn cta-button-blue-outline text-decoration-none">
          <?php echo esc_html( $cta_label ); ?>
        </a>
      </div>

      <div class="col-12 col-lg-7">
        <div class="product-cinematic-stage rounded-4 p-3 p-md-4 shadow-sm">
          <img
            src="<?php echo esc_url( $image_url ); ?>"
            alt="<?php echo esc_attr( $image_alt ); ?>"
            class="img-fluid rounded-4 product-cinematic-image"
          />

          <div class="row g-2 mt-2 mt-md-3">
            <?php foreach ( $metrics as $metric ) : ?>
              <?php
              $metric_label = '';
              $metric_value = '';

              if ( is_array( $metric ) ) {
                $metric_label = isset( $metric['label'] ) ? $metric['label'] : '';
                $metric_value = isset( $metric['value'] ) ? $metric['value'] : '';
              }

              if ( '' === trim( wp_strip_all_tags( $metric_label ) ) ) {
                continue;
              }
              ?>
              <div class="col-4">
                <div class="product-cinematic-chip rounded-3 p-2 p-md-3 text-center h-100">
                  <p class="small mb-1 text-uppercase fw-semibold"><?php echo esc_html( $metric_label ); ?></p>
                  <p class="h5 mb-0"><?php echo esc_attr( $metric_value ); ?></p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
