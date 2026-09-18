<?php
/**
 * MRI Hero With Asset block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$shared_fields = pardot_boostrap_get_shared_block_fields( 'mri_hero_with_asset', $block );
$heading       = $shared_fields['heading'];
$content       = $shared_fields['content'];
$logo_image = pardot_boostrap_get_block_field_value( $block, 'mri_hero_with_asset_logo_image' );
$hero_image    = $shared_fields['image'];
$button_label  = $shared_fields['button_label'];
$button_link   = $shared_fields['button_link'];
$benefits = pardot_boostrap_get_block_field_value( $block, 'mri_hero_with_asset_benefits' );

if ( ! is_array( $benefits ) ) {
  $benefits = array();
}

$benefits = pardot_boostrap_repeat_rows_to_count( $benefits, 3 );

if ( ! is_array( $logo_image ) ) {
  $logo_image = array();
}

if ( ! is_array( $hero_image ) ) {
  $hero_image = array();
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-hero-with-asset' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="hero position-relative mri-hero-with-asset">
  <div class="position-relative z-1">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <?php if ( ! empty( $logo_image['url'] ) ) : ?>
          <img
            src="<?php echo esc_url( $logo_image['url'] ); ?>"
            alt="<?php echo esc_attr( isset( $logo_image['alt'] ) ? $logo_image['alt'] : '' ); ?>"
            class="MRILogo mb-3" />
        <?php endif; ?>
         <?php /* 
        <h1><?php echo esc_html( $heading ); ?></h1>
        */
        ?>
        <h1><?php echo $heading ?></h1>

        <?php if ( ! empty( $content ) ) : ?>
          <div class="lead-copy fs-5 fw-medium my-4"><?php echo wp_kses_post( wpautop( $content ) ); ?></div>
        <?php endif; ?>

        <div class="row g-4 mt-2">
          <?php foreach ( $benefits as $benefit ) : ?>
            <?php
            $benefit_text = isset( $benefit['text'] ) ? $benefit['text'] : '';

            if ( '' === trim( wp_strip_all_tags( $benefit_text ) ) ) {
              continue;
            }
            ?>
            <div class="col-12 col-md-4">
              <div class="d-flex align-items-start">
                <div class="benefit-icon flex-shrink-0">
                  <span class="check-circle" aria-hidden="true">
                    <i class="bi bi-check-lg"></i>
                  </span>
                </div>

                <span class="ms-3 fs-5 lead-copy mb-0 mt-0 pt-0 fw-medium"><?php echo esc_html( $benefit_text ); ?></span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <?php if ( ! empty( $button_label ) && ! empty( $button_link ) ) : ?>
          <div class="my-4">
            <a href="<?php echo esc_url( $button_link ); ?>" class="cta-button-blue-outline text-decoration-none">
              <?php echo esc_html( $button_label ); ?>
            </a>
          </div>
        <?php endif; ?>
      </div>

      <div class="col-lg-5">
        <?php if ( ! empty( $hero_image['url'] ) ) : ?>
          <img
            src="<?php echo esc_url( $hero_image['url'] ); ?>"
            alt="<?php echo esc_attr( isset( $hero_image['alt'] ) ? $hero_image['alt'] : '' ); ?>"
            class="img-fluid rounded" />
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="blob" aria-hidden="true"></div>
</section>






