<?php
/**
 * MRI Video block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$eyebrow = pardot_boostrap_get_block_field_value( $block, 'mri_video_block_eyebrow' );
$heading = pardot_boostrap_get_block_field_value( $block, 'mri_video_block_heading' );
$heading_highlight = pardot_boostrap_get_block_field_value( $block, 'mri_video_block_heading_highlight' );
$description = pardot_boostrap_get_block_field_value( $block, 'mri_video_block_description' );
$items = pardot_boostrap_get_block_field_value( $block, 'mri_video_block_items' );
$video_url = pardot_boostrap_get_block_field_value( $block, 'mri_video_block_video_url' );

if ( ! is_array( $items ) ) {
  $items = array();
}

/*$items = pardot_boostrap_repeat_rows_to_count( $items, 3 );*/

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-video-block' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="mri-video-block py-2 position-relative">
  <div class="position-relative z-1">
    <div class="video-card row align-items-center g-2 m-0">
      <div class="col-12 col-md-6">
        <div class="me-md-5">
          <div>
            <p class="eyebrow mb-2"><?php echo esc_html( $eyebrow ); ?></p>
            <h2>
              <?php echo esc_html( $heading ); ?><span><?php echo esc_html( $heading_highlight ); ?></span>
            </h2>
            <p><?php echo esc_html( $description ); ?></p>

            <ul class="list-unstyled d-grid gap-2 mt-3 mb-0">
              <?php foreach ( $items as $item ) : ?>
                <?php
                $text = '';
                if ( is_array( $item ) ) {
                  $text = isset( $item['text'] ) ? $item['text'] : '';
                } elseif ( is_string( $item ) ) {
                  $text = $item;
                }

                if ( '' === trim( wp_strip_all_tags( $text ) ) ) {
                  continue;
                }
                ?>
                <li class="d-flex align-items-center gap-2">
                  <span class="check-circle" aria-hidden="true">
                    <i class="bi bi-check-lg"></i>
                  </span>
                  <span><?php echo esc_html( $text ); ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 rounded shadow">
        <div class="ratio ratio-16x9">
          <iframe
            class="w-100 rounded shadow-sm"
            src="<?php echo esc_url( $video_url ); ?>"
            allowfullscreen
            title="Video block embed"
          ></iframe>
        </div>
      </div>
    </div>
  </div>
</section>




