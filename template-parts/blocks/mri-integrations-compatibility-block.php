<?php
/**
 * MRI Integrations Compatibility block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_integrations_compatibility_block_heading' );
$content = pardot_boostrap_get_block_field_value( $block, 'mri_integrations_compatibility_block_content' );
$groups = pardot_boostrap_get_block_field_value( $block, 'mri_integrations_compatibility_block_groups' );

if ( ! is_array( $groups ) ) {
  $groups = array();
}

/*** Commented out to prevent duplication of items */
/*$groups = pardot_boostrap_repeat_rows_to_count( $groups, 4 );*/

foreach ( $groups as $group_index => $group ) {
  if ( ! is_array( $group ) ) {
    continue;
  }

  $group_items = isset( $group['items'] ) && is_array( $group['items'] ) ? $group['items'] : array();
  $groups[ $group_index ]['items'] = pardot_boostrap_repeat_rows_to_count( $group_items, 3 );
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-integrations-compatibility-block' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="integrations-block py-2 position-relative">
  <div class="position-relative z-1">
    <div class="row align-items-start g-4">
      <div class="col-12 col-lg-4">
        <p class="eyebrow mb-2">Integrations</p>
        <h2 class="mb-3"><?php echo esc_html( $heading ); ?></h2>
        <p class="mb-0">
          <?php echo esc_html( $content ); ?>
        </p>
      </div>

      <div class="col-12 col-lg-8">
        <div class="row row-cols-1 row-cols-md-2 g-3">
          <?php foreach ( $groups as $group ) : ?>
            <?php
            $group_title = isset( $group['title'] ) ? $group['title'] : '';
            $group_items = isset( $group['items'] ) && is_array( $group['items'] ) ? $group['items'] : array();

            if ( '' === trim( wp_strip_all_tags( $group_title ) ) ) {
              continue;
            }
            ?>
            <div class="col">
              <article class="integrations-card card border rounded-3 shadow-sm h-100 p-3 p-md-4">
                <p class="integrations-title mb-2"><?php echo esc_html( $group_title ); ?></p>
                <div class="d-flex flex-wrap gap-2">
                  <?php foreach ( $group_items as $item ) : ?>
                    <?php
                    $item_label = '';

                    if ( is_array( $item ) ) {
                      $item_label = isset( $item['label'] ) ? $item['label'] : '';
                    } elseif ( is_string( $item ) ) {
                      $item_label = $item;
                    }
                      
                    if ( '' === trim( wp_strip_all_tags( $item_label ) ) ) {
                      continue;
                    }
                    ?>
                    <span class="integrations-chip badge rounded-pill text-bg-light border px-2 py-1">
                      <?php echo esc_html( $item_label ); ?>
                    </span>
                  <?php endforeach; ?>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>




