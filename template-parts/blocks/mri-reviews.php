<?php
/**
 * MRI Reviews block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$award_image = pardot_boostrap_get_block_field_value( $block, 'mri_reviews_award_image' );
$award_title = pardot_boostrap_get_block_field_value( $block, 'mri_reviews_award_title' );
$award_subtitle = pardot_boostrap_get_block_field_value( $block, 'mri_reviews_award_subtitle' );
$reviews = pardot_boostrap_get_block_field_value( $block, 'mri_reviews_items' );

$award_image_src = get_template_directory_uri() . '/assets/images/medal1-D3t4GQlX.svg';
$award_image_alt = 'Award badge';

if ( is_array( $award_image ) ) {
  $award_image_src = ! empty( $award_image['url'] ) ? $award_image['url'] : $award_image_src;
  $award_image_alt = ! empty( $award_image['alt'] ) ? $award_image['alt'] : $award_image_alt;
} elseif ( is_string( $award_image ) && '' !== trim( $award_image ) ) {
  $award_image_src = $award_image;
}

if ( ! is_array( $reviews ) ) {
  $reviews = array();
}

/*$reviews = pardot_boostrap_repeat_rows_to_count( $reviews, 3 );*/

if ( empty( $award_title ) ) {
  $award_title = 'Awarded Best Real Estate Software Products & Momentum Leader';
}

if ( empty( $award_subtitle ) ) {
  $award_subtitle = 'Property Management Spring';
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-reviews' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="reviews py-2 position-relative">
  <div class="position-relative z-1">
    <div class="row align-items-center g-4">
      <div class="col-lg-4">
        <div class="text-center">
          <div class="reviews-award-logo me-4">
            <img
              src="<?php echo esc_url( $award_image_src ); ?>"
              class="reviews-award-image img-fluid"
              alt="<?php echo esc_attr( $award_image_alt ); ?>"
            />
          </div>

          <div>
            <div class="reviews-award-title mt-3">
              <?php if ( false !== strpos( $award_title, 'Products' ) ) : ?>
                Awarded <span>Best Real Estate Software</span><br />Products &amp; Momentum Leader
              <?php else : ?>
                <?php echo esc_html( $award_title ); ?>
              <?php endif; ?>
            </div>

            <div class="reviews-award-subtitle mt-2"><?php echo esc_html( $award_subtitle ); ?></div>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="row g-3">
          <?php foreach ( $reviews as $review ) : ?>
            <?php
            $rating = '';
            $text   = '';
            $author = '';

            if ( is_array( $review ) ) {
              $rating = isset( $review['rating'] ) ? $review['rating'] : '';
              $text   = isset( $review['text'] ) ? $review['text'] : '';
              $author = isset( $review['author'] ) ? $review['author'] : '';
            }

            if ( '' === trim( wp_strip_all_tags( $text ) ) ) {
              continue;
            }
            ?>
            <div class="col-md-4">
              <div class="card review-card h-100">
                <div class="card-body">
                  <div class="review-rating">
                    <i class="bi bi-star-fill" aria-hidden="true"></i>
                    <?php echo esc_html( $rating ); ?>
                  </div>

                  <div class="review-text">&quot;<?php echo esc_html( $text ); ?>&quot;</div>

                  <div class="review-author">- <?php echo esc_html( $author ); ?></div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>




