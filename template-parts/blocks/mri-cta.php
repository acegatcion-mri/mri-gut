<?php
/**
 * MRI CTA block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$text = pardot_boostrap_get_field_with_fallbacks(
  'mri_cta_text',
  array(
    'mri_cta_heading',
    'mri_cta_content',
  ),
  $block
);
$button_link = pardot_boostrap_get_field_with_fallbacks(
  'mri_cta_button',
  array(
    'mri_cta_button_link',
  ),
  $block
);
$button_text = pardot_boostrap_get_field_with_fallbacks(
  'mri_cta_button_text',
  array(
    'mri_cta_button_label',
  ),
  $block
);

$cta_text = $text;
$cta_link = pardot_boostrap_normalize_link_value( $button_link, (string) $button_text );

$cta_button_url    = $cta_link['url'];
$cta_button_label  = $cta_link['title'];
$cta_button_target = $cta_link['target'];

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-cta' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="mri-cta-block py-2 position-relative">
  <div class="position-relative z-1">
    <div class="row align-items-center g-4">
      <div class="col-12 p-md-0">
        <div class="gradient-frame shadow">
          <div class="cta gradient-frame-inner p-3 p-md-5 rounded">
            <div class="d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start">
              <h2 class="mb-3 mb-md-0"><?php echo esc_html( $cta_text ); ?></h2>
              <a
                href="<?php echo esc_url( $cta_button_url ); ?>"
                class="fs-6 py-3 btn cta-button-green"
                <?php if ( ! empty( $cta_button_target ) ) : ?>target="<?php echo esc_attr( $cta_button_target ); ?>" rel="noopener"<?php endif; ?>
              >
                <?php echo esc_html( $cta_button_label ); ?>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


