<?php
/**
 * MRI Outcome Pulse Strip block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_outcome_pulse_strip_heading' );
$items = pardot_boostrap_get_block_field_value( $block, 'mri_outcome_pulse_strip_items' );

if ( ! is_array( $items ) ) {
  $items = array();
}

$items = pardot_boostrap_repeat_rows_to_count( $items, 6 );

$pulse_items = array();

foreach ( $items as $item ) {
  $text = '';

  if ( is_array( $item ) ) {
    $text = isset( $item['text'] ) ? $item['text'] : '';
  } elseif ( is_string( $item ) ) {
    $text = $item;
  }

  if ( '' === trim( wp_strip_all_tags( $text ) ) ) {
    continue;
  }

  $pulse_items[] = $text;
}

if ( empty( $pulse_items ) ) {
  $pulse_items[] = 'Outcome metric';
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-outcome-pulse-strip' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="outcome-pulse py-2 position-relative">
  <div class="position-relative z-1">
    <div class="row align-items-center g-3">
      <div class="col-12 col-lg-3">
        <p class="eyebrow mb-1">Momentum</p>
        <h2 class="h4 mb-0"><?php echo esc_html( $heading ); ?></h2>
      </div>

      <div class="col-12 col-lg-9">
        <div class="outcome-pulse-track-wrap rounded-4 p-2 p-md-3">
          <div class="outcome-pulse-track">
            <?php foreach ( $pulse_items as $index => $item_text ) : ?>
              <span class="outcome-pulse-pill rounded-pill px-3 py-2" data-item-index="<?php echo esc_attr( (string) $index ); ?>">
                <?php echo esc_html( $item_text ); ?>
              </span>
            <?php endforeach; ?>
            <?php foreach ( $pulse_items as $index => $item_text ) : ?>
              <span class="outcome-pulse-pill rounded-pill px-3 py-2" data-item-clone-index="<?php echo esc_attr( (string) $index ); ?>" aria-hidden="true">
                <?php echo esc_html( $item_text ); ?>
              </span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>




