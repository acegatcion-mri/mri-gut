<?php
/**
 * MRI Solution Grid block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$eyebrow = pardot_boostrap_get_block_field_value( $block, 'mri_solution_grid_eyebrow' );
$heading = pardot_boostrap_get_block_field_value( $block, 'mri_solution_grid_heading' );
$heading_highlight = pardot_boostrap_get_block_field_value( $block, 'mri_solution_grid_heading_highlight' );
$items = pardot_boostrap_get_block_field_value( $block, 'mri_solution_grid_items' );

if ( ! is_array( $items ) ) {
  $items = array();
}

$items = pardot_boostrap_repeat_rows_to_count( $items, 4 );

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-solution-grid' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="solution-grid py-2 position-relative">
  <div class="position-relative z-1">
    <div class="row gx-4">
      <div class="col-12">
        <p class="eyebrow mb-1"><?php echo esc_html( $eyebrow ); ?></p>
        <h2>
          <?php echo esc_html( $heading ); ?>
          <span><?php echo esc_html( $heading_highlight ); ?></span>
        </h2>
      </div>

      <?php foreach ( $items as $item ) : ?>
        <?php
        $title = '';
        $subtitle = '';
        $icon = '';
        $body = '';
        $link_url = '';
        $link_label = '';

        if ( is_array( $item ) ) {
          $title = isset( $item['title'] ) ? $item['title'] : $title;
          $subtitle = isset( $item['subtitle'] ) ? $item['subtitle'] : $subtitle;
          $icon = isset( $item['icon'] ) && '' !== trim( $item['icon'] ) ? $item['icon'] : $icon;
          $body = isset( $item['body'] ) && '' !== trim( $item['body'] ) ? $item['body'] : $body;
          $link_url = isset( $item['link_url'] ) && '' !== trim( $item['link_url'] ) ? $item['link_url'] : $link_url;
          $link_label = isset( $item['link_label'] ) && '' !== trim( $item['link_label'] ) ? $item['link_label'] : $link_label;
        }

        if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
          continue;
        }
        ?>
        <div class="solution-grid-item col-12 col-md-6 text-start gy-4">
          <article class="solution-card p-4 p-lg-5">
            <div class="solution-card-head mb-3">
              <i class="solution-icon bi <?php echo esc_attr( $icon ); ?> me-3" aria-hidden="true"></i>
              <h6 class="mb-0"><?php echo esc_html( $title ); ?></h6>
            </div>

            <hr />

            <h3><?php echo esc_html( $subtitle ); ?></h3>
            <p><?php echo esc_html( $body ); ?></p>
            <a href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_label ); ?></a>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>




