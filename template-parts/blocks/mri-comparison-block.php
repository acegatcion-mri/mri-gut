<?php
/**
 * MRI Comparison Block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_comparison_block_heading' );
$rows    = pardot_boostrap_get_block_field_value( $block, 'mri_comparison_block_rows' );

if ( ! is_array( $rows ) ) {
  $rows = array();
}

/*$rows = pardot_boostrap_repeat_rows_to_count( $rows, 4 );*/

$columns = array(
  array(
    'key'        => 'baseline',
    'label'      => 'Your Team Today',
    'head_class' => 'comparison-head-baseline',
  ),
  array(
    'key'        => 'alternative',
    'label'      => 'Typical Alternative',
    'head_class' => 'comparison-head-alternative',
  ),
  array(
    'key'        => 'product',
    'label'      => 'With Your Solution',
    'head_class' => 'comparison-head-product',
  ),
);

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-comparison-block' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="comparison-block py-2 position-relative">
  <div class="position-relative z-1">
    <p class="eyebrow mb-2">Comparison</p>
    <h2 class="mb-4"><?php echo esc_html( $heading ); ?></h2>

    <div class="comparison-grid-wrap border rounded-3 shadow-sm overflow-hidden">
      <div class="comparison-grid-head row g-0 d-none d-md-flex align-items-stretch">
        <div class="col-md-2 comparison-grid-heading-label px-3 py-3 text-uppercase small fw-bold">
          Criteria
        </div>
        <div class="col-md-10">
          <div class="row g-0">
            <?php foreach ( $columns as $column ) : ?>
              <div class="col-md-4 comparison-grid-head-pill <?php echo esc_attr( $column['head_class'] ); ?> px-3 py-3 text-uppercase fw-bold text-center">
                <?php echo esc_html( $column['label'] ); ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <?php foreach ( $rows as $row ) : ?>
        <?php
        $criteria = isset( $row['criteria'] ) ? $row['criteria'] : '';

        if ( '' === trim( wp_strip_all_tags( $criteria ) ) ) {
          continue;
        }
        ?>
        <div class="comparison-grid-row row g-0">
          <div class="col-12 col-md-2 comparison-grid-label px-3 py-3">
            <?php echo esc_html( $criteria ); ?>
          </div>
          <div class="col-12 col-md-10">
            <div class="row g-0">
              <?php foreach ( $columns as $column ) : ?>
                <?php
                $key         = $column['key'];
                $value       = isset( $row[ $key ] ) ? $row[ $key ] : '';
                $is_product  = 'product' === $key;
                $cell_class  = 'col-12 col-md-4 comparison-grid-cell px-3 py-3';

                if ( $is_product ) {
                  $cell_class .= ' comparison-grid-value-best';
                }
                ?>
                <div class="<?php echo esc_attr( trim( $cell_class ) ); ?>">
                  <p class="d-md-none text-uppercase small fw-bold text-secondary mb-1">
                    <?php echo esc_html( $column['label'] ); ?>
                  </p>
                  <span><?php echo esc_html( $value ); ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>




