<?php
/**
 * MRI Logo Strip block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_logo_strip_heading' );
$logos = pardot_boostrap_get_block_field_value( $block, 'mri_logo_strip_items' );
$static_mode = pardot_boostrap_get_block_field_value( $block, 'mri_logo_strip_static_mode' );
$block_frame = pardot_boostrap_get_block_field_value( $block, 'mri_logo_strip_block_frame' );

if ( ! is_array( $logos ) ) {
  $logos = array();
}

$logos = pardot_boostrap_repeat_rows_to_count( $logos, 5 );

$normalized_logos = array();

foreach ( $logos as $index => $logo ) {
  $url = '';
  $alt = 'Logo ' . ( $index + 1 );

  if ( is_array( $logo ) ) {
    if ( isset( $logo['image'] ) ) {
      if ( is_array( $logo['image'] ) ) {
        $url = isset( $logo['image']['url'] ) ? $logo['image']['url'] : '';
        $alt = isset( $logo['image']['alt'] ) && '' !== trim( $logo['image']['alt'] ) ? $logo['image']['alt'] : $alt;
      } elseif ( is_string( $logo['image'] ) ) {
        $url = $logo['image'];
      }
    }

    if ( isset( $logo['alt'] ) && '' !== trim( $logo['alt'] ) ) {
      $alt = $logo['alt'];
    }
  } elseif ( is_string( $logo ) ) {
    $url = $logo;
  }

  $normalized_logo_image = pardot_boostrap_get_image_with_placeholder( $url, $alt );

  $normalized_logos[] = array(
    'url' => $normalized_logo_image['url'],
    'alt' => $normalized_logo_image['alt'],
  );
}

$use_static = ! empty( $static_mode ) || ! empty( $block_frame );
$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-logo-strip' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="logo-strip py-2 position-relative text-center">
  <div class="position-relative z-1">
    <h3 class="fs-5 mb-5"><?php echo esc_html( $heading ); ?></h3>

    <?php if ( $use_static ) : ?>
      <div class="mb-3" role="region" aria-label="Partner logos">
        <?php foreach ( $normalized_logos as $logo ) : ?>
          <span class="logo-mark">
            <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ); ?>" />
          </span>
        <?php endforeach; ?>
      </div>
    <?php else : ?>
      <div class="logo-strip-marquee mb-3" role="region" aria-label="Partner logos">
        <div class="logo-strip-track">
          <?php for ( $group = 0; $group < 3; $group++ ) : ?>
            <div class="logo-strip-group" <?php echo 0 === $group ? '' : 'aria-hidden="true"'; ?>>
              <?php foreach ( $normalized_logos as $logo ) : ?>
                <span class="logo-mark">
                  <img
                    src="<?php echo esc_url( $logo['url'] ); ?>"
                    alt="<?php echo 0 === $group ? esc_attr( $logo['alt'] ) : ''; ?>"
                  />
                </span>
              <?php endforeach; ?>
            </div>
          <?php endfor; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>




