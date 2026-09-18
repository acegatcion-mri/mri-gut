<?php
/**
 * MRI Testimonial Logos block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_testimonial_logos_heading' );
$logos = pardot_boostrap_get_block_field_value( $block, 'mri_testimonial_logos_items' );
$testimonial = pardot_boostrap_get_block_field_value( $block, 'mri_testimonial_client_testimonial' );
$client_name = pardot_boostrap_get_block_field_value( $block, 'mri_testimonial_client_name' );
$client_designation = pardot_boostrap_get_block_field_value( $block, 'mri_testimonial_client_designation' );


if ( ! is_array( $logos ) ) {
  $logos = array();
}

/*** Commenting out to prevent duplication of Logos */
/*$logos = pardot_boostrap_repeat_rows_to_count( $logos, 5 );*/

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

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-testimonial-logos' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="testimonial-logos py-2 position-relative">
  <div class="py-2 py-md-5 block-surface block-surface--none">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="row g-4 align-items-center">
            <div class="col-12 col-md-6">
              <div class="mb-4 mb-md-0 me-md-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#14b592" class="bi bi-quote svg-icon" viewBox="0 0 16 16">
                  <path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388q0-.527.062-1.054.093-.558.31-.992t.559-.683q.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 9 7.558V11a1 1 0 0 0 1 1zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612q0-.527.062-1.054.094-.558.31-.992.217-.434.559-.683.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 3 7.558V11a1 1 0 0 0 1 1z">
                  </path>
                </svg>
                <p class="fs-2 mb-0 pt-0 pb-4">
                  <?php echo esc_html( $testimonial ); ?>
                </p>
                <small>
                  - <?php echo esc_html( $client_name ); ?> | <?php echo esc_html( $client_designation ); ?>
                </small>
              </div>
            </div>
            <div class="quote-logos-script col-12 col-md-6 shadow grad-bg-blue rounded border d-flex align-items-center justify-content-center p-3 p-md-5">
              <section class="text-center">
                <h3 class="fs-5 mb-5">
                  <?php echo esc_html( $heading ); ?>
                </h3>
                <div class="mb-3" role="region" aria-label="Partner logos">
                  <?php foreach ( $normalized_logos as $logo ) : ?>
                    <span class="logo-mark">
                      <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ); ?>" />
                    </span>
                  <?php endforeach; ?>
                
                  <!--span class="logo-mark">
                    <img src="https://mrigut.wpenginepowered.com/style-guide-2/assets/1-CiIq31iB.png" alt="Logo 1"/>
                  </span>
                  <span class="logo-mark">
                    <img src="https://mrigut.wpenginepowered.com/style-guide-2/assets/2-Czd1uPax.png" alt="Logo 2"/>
                  </span>
                  <span class="logo-mark">
                    <img src="https://mrigut.wpenginepowered.com/style-guide-2/assets/3-BLGNUkWz.png" alt="Logo 3"/>
                  </span>
                  <span class="logo-mark">
                    <img src="https://mrigut.wpenginepowered.com/style-guide-2/assets/4-Ch7WTs0U.png" alt="Logo 4"/>
                  </span>
                  <span class="logo-mark">
                    <img src="https://mrigut.wpenginepowered.com/style-guide-2/assets/5-D0fDMJ6b.png" alt="Logo 5"/>
                  </span-->
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



