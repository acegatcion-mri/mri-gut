<?php
/**
 * MRI Hero With Form block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$shared_fields  = pardot_boostrap_get_shared_block_fields( 'mri_hero_with_form', $block );
$heading        = $shared_fields['heading'];
$content        = $shared_fields['content'];
$logo_image = pardot_boostrap_get_block_field_value( $block, 'mri_hero_with_form_logo_image' );
$benefits = pardot_boostrap_get_block_field_value( $block, 'mri_hero_with_form_benefits' );
$form_title = pardot_boostrap_get_block_field_value( $block, 'mri_hero_with_form_form_title' );
$form_type = pardot_boostrap_get_block_field_value( $block, 'mri_hero_with_form_form_type' );
$form_embed = pardot_boostrap_get_block_field_value( $block, 'mri_hero_with_form_embed_code' );
$pardot_form = pardot_boostrap_get_block_field_value( $block, 'mri_hero_with_form_pardot_form' );
$form_footer = pardot_boostrap_get_block_field_value( $block, 'mri_hero_with_form_footer' );
$terms_copy = pardot_boostrap_get_block_field_value( $block, 'mri_hero_with_form_terms_copy' );

/*
 * The Form Type select was added after the first blocks were built, so blocks
 * saved before it exists have an empty value. Anything other than an explicit
 * 'pardot' keeps the original pasted-embed behaviour.
 */
$use_pardot = ( 'pardot' === $form_type );
$form_markup = $use_pardot ? $pardot_form : $form_embed;

if ( ! is_array( $benefits ) ) {
  $benefits = array();
}

$benefits = pardot_boostrap_repeat_rows_to_count( $benefits, 3 );

if ( ! is_array( $logo_image ) ) {
  $logo_image = array();
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-hero-with-form' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="hero position-relative mri-hero-with-form mri-block-wrapper <?php echo esc_attr($block_style); ?>">
  <div class="blob" aria-hidden="true"></div>
  <div class="position-relative z-1">
    <div class="row align-items-center g-5">
      <div class="col-lg-7">
        <?php if ( ! empty( $logo_image['url'] ) ) : ?>
          <img
            src="<?php echo esc_url( $logo_image['url'] ); ?>"
            alt="<?php echo esc_attr( isset( $logo_image['alt'] ) ? $logo_image['alt'] : '' ); ?>"
            class="MRILogo mb-3" />
        <?php endif; ?>

        <!--h1><?php echo esc_html( $heading ); ?></h1-->

        <h1><?php echo $heading; ?></h1>
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
      </div>

      <div class="col-lg-5">
        <div class="card border-0 mri-white-bg  hero-form-shadow">
          <div class="card-body p-md-5">
            <?php if ( ! empty( $form_title ) ) : ?>
              <div class="mb-3 hero-form-title"><h3 class="MRI-blue fw-normal"><?php echo wp_kses_post( $form_title ); ?></h3></div>
            <?php endif; ?>

            <?php if ( ! empty( $form_markup ) ) : ?>
              <?php // Pardot markup is sanitised by the ACF MRI Pardot Forms plugin; pasted embed code is trusted editor input, as before. ?>
              <div class="mri-hero-with-form-embed"><?php echo $form_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
            <?php elseif ( ! empty( $is_preview ) ) : ?>
              <div class="mri-form-placeholder text-muted small">
                <?php
                echo esc_html(
                  $use_pardot
                    ? __( 'No Pardot form selected yet.', 'pardot-boostrap' )
                    : __( 'No form embed code added yet.', 'pardot-boostrap' )
                );
                ?>
              </div>
            <?php endif; ?>

            <?php if ( ! empty( $form_footer ) ) : ?>
              <div class="mt-3 small text-muted text-center"><?php echo wp_kses_post( $form_footer ); ?></div>
            <?php endif; ?>

            <div class="mt-3 small text-muted text-start">
              <p><small><strong>Terms of use</strong><br><?php echo esc_html( $terms_copy ); ?></small></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>