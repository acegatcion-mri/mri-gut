<?php
/**
 * MRI Stats block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$stats = pardot_boostrap_get_block_field_value( $block, 'mri_stats_block_items' );

if ( ! is_array( $stats ) ) {
  $stats = array();
}

/*** Remove to prevent duplication */
/*$stats = pardot_boostrap_repeat_rows_to_count( $stats, 5 );*/

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-stats-block' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="stats-block py-2 position-relative">
  <div class="position-relative z-1">
    <div class="row row-cols-2 row-cols-lg-5 g-2 g-lg-3 stats-row-edge-fix">
      <?php foreach ( $stats as $stat ) : ?>
        <?php
        $value = '';
        $label = '';
        $prefix = '';
        $number = '';
        $suffix = '';
        /*$icon = 'bi-circle';*/
        $icon = '';

        if ( is_array( $stat ) ) {
          $value = isset( $stat['value'] ) ? $stat['value'] : '';
          $prefix = isset( $stat['prefix'] ) ? $stat['prefix'] : '';
          $number = isset( $stat['number'] ) ? $stat['number'] : '';
          $suffix = isset( $stat['suffix'] ) ? $stat['suffix'] : '';
          $label = isset( $stat['label'] ) ? $stat['label'] : '';
         /*$icon  = isset( $stat['icon'] ) && '' !== trim( $stat['icon'] ) ? $stat['icon'] : $icon;*/
          $icon = isset( $stat['icon_picker'] ) ? $stat['icon_picker'] : '';
        }

        
        /*if ( '' === trim( wp_strip_all_tags( $value ) ) ) {
          continue;
        }*/

        ?>
        <div class="stats stats-item col">
          <div class="border rounded shadow p-4 text-center h-100">
            <div>
              <!--<i class="bi <?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>-->
              <i class="<?php echo esc_attr( $icon ); ?>" aria-hidden="true"></i>
            </div>
            <div>
              <b><span><?php echo esc_html( $prefix ); ?></span><span class="counter" data-target="<?php echo esc_attr( $number ); ?>"> 0 </span><span><?php echo esc_html( $suffix ); ?></span></b>
            </div>
            <div>
              <span><?php echo esc_html( $label ); ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

