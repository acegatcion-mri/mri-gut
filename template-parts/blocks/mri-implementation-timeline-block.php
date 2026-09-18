<?php
/**
 * MRI Implementation Timeline block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_implementation_timeline_block_heading' );
$steps = pardot_boostrap_get_block_field_value( $block, 'mri_implementation_timeline_block_steps' );

if ( ! is_array( $steps ) ) {
  $steps = array();
}

/*$steps = pardot_boostrap_repeat_rows_to_count( $steps, 4 );*/

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-implementation-timeline-block' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="implementation-timeline py-2 position-relative">
  <div class=" position-relative z-1">
    <p class="eyebrow mb-2">Timeline</p>
    <h2 class="mb-4"><?php echo esc_html( $heading ); ?></h2>

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3">
      <?php foreach ( $steps as $index => $step ) : ?>
        <?php
        $phase = isset( $step['phase'] ) ? $step['phase'] : '';
        $title = isset( $step['title'] ) ? $step['title'] : '';
        $text  = isset( $step['text'] ) ? $step['text'] : '';

        if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
          continue;
        }
        ?>
        <div class="col">
          <article class="timeline-card card h-100 border rounded-3 shadow-sm">
            <div class="card-body d-flex flex-column p-3 p-lg-4">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="badge text-bg-light border timeline-phase"><?php echo esc_html( $phase ); ?></span>
                <span class="timeline-index"><?php echo esc_html( sprintf( '%02d', ( (int) $index ) + 1 ) ); ?></span>
              </div>
              <h3 class="h5 mb-2"><?php echo esc_html( $title ); ?></h3>
              <?php if ( ! empty( $text ) ) : ?>
                <p class="mb-0 text-secondary"><?php echo esc_html( $text ); ?></p>
              <?php endif; ?>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>




