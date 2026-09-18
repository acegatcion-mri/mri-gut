<?php
/**
 * MRI Interactive Feature Stack block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_interactive_feature_stack_heading' );
$items = pardot_boostrap_get_block_field_value( $block, 'mri_interactive_feature_stack_items' );

if ( ! is_array( $items ) ) {
  $items = array();
}

/*$items = pardot_boostrap_repeat_rows_to_count( $items, 3 );*/

foreach ( $items as $item_index => $item ) {
  if ( ! is_array( $item ) ) {
    continue;
  }

  $item_bullets = isset( $item['bullets'] ) && is_array( $item['bullets'] ) ? $item['bullets'] : array();
  /*$items[ $item_index ]['bullets'] = pardot_boostrap_repeat_rows_to_count( $item_bullets, 3 );*/
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-interactive-feature-stack' );
$tabs_id   = 'feature-stack-tabs-' . $block['id'];
$panes_id  = 'feature-stack-panes-' . $block['id'];
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="interactive-feature-stack py-2 position-relative">
  <div class="position-relative z-1">
    <p class="eyebrow mb-2">Feature Stack</p>
    <h2 class="mb-4"><?php echo esc_html( $heading ); ?></h2>

    <div class="row g-3 g-lg-4 align-items-stretch">
      <div class="col-12 col-lg-5">
        <div class="d-grid gap-2 nav" id="<?php echo esc_attr( $tabs_id ); ?>" role="tablist" aria-orientation="vertical">
          <?php foreach ( $items as $index => $item ) : ?>
            <?php
            $item_id    = isset( $item['id'] ) && '' !== $item['id'] ? sanitize_title( $item['id'] ) : 'stack-' . ( $index + 1 );
            $title      = isset( $item['title'] ) ? $item['title'] : '';
            $subtitle   = isset( $item['subtitle'] ) ? $item['subtitle'] : '';
            $is_active  = 0 === (int) $index;
            $button_id  = $tabs_id . '-btn-' . $item_id;
            $pane_id    = $panes_id . '-pane-' . $item_id;

            if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
              continue;
            }
            ?>
            <button
              type="button"
              class="btn text-start feature-stack-tab rounded-3 p-3 <?php echo $is_active ? 'active' : ''; ?>"
              id="<?php echo esc_attr( $button_id ); ?>"
              data-bs-toggle="pill"
              data-bs-target="#<?php echo esc_attr( $pane_id ); ?>"
              role="tab"
              aria-controls="<?php echo esc_attr( $pane_id ); ?>"
              aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
              <div class="d-flex justify-content-between align-items-start gap-2">
                <div>
                  <p class="small text-uppercase mb-1 feature-stack-index"><?php echo esc_html( sprintf( '%02d', ( (int) $index ) + 1 ) ); ?></p>
                  <h3 class="h5 mb-1"><?php echo esc_html( $title ); ?></h3>
                  <p class="mb-0 text-secondary"><?php echo esc_html( $subtitle ); ?></p>
                </div>
                <i class="bi bi-arrow-up-right-circle fs-4" aria-hidden="true"></i>
              </div>
            </button>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-12 col-lg-7">
        <div class="tab-content" id="<?php echo esc_attr( $panes_id ); ?>">
          <?php foreach ( $items as $index => $item ) : ?>
            <?php
            $item_id   = isset( $item['id'] ) && '' !== $item['id'] ? sanitize_title( $item['id'] ) : 'stack-' . ( $index + 1 );
            $title     = isset( $item['title'] ) ? $item['title'] : '';
            $detail    = isset( $item['detail'] ) ? $item['detail'] : '';
            $bullets   = isset( $item['bullets'] ) && is_array( $item['bullets'] ) ? $item['bullets'] : array();
            $is_active = 0 === (int) $index;
            $button_id = $tabs_id . '-btn-' . $item_id;
            $pane_id   = $panes_id . '-pane-' . $item_id;

            if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
              continue;
            }
            ?>
            <div
              class="tab-pane fade <?php echo $is_active ? 'show active' : ''; ?>"
              id="<?php echo esc_attr( $pane_id ); ?>"
              role="tabpanel"
              aria-labelledby="<?php echo esc_attr( $button_id ); ?>"
              tabindex="0">
              <div class="feature-stack-panel rounded-4 p-3 p-md-4 h-100">
                <p class="small text-uppercase fw-bold mb-2">Active Layer</p>
                <h3 class="h3 mb-2"><?php echo esc_html( $title ); ?></h3>
                <?php if ( ! empty( $detail ) ) : ?>
                  <p class="text-secondary mb-3"><?php echo esc_html( $detail ); ?></p>
                <?php endif; ?>
                <ul class="list-group list-group-flush">
                  <?php foreach ( $bullets as $bullet ) : ?>
                    <?php
                    $bullet_text = '';

                    if ( is_array( $bullet ) ) {
                      $bullet_text = isset( $bullet['text'] ) ? $bullet['text'] : '';
                    } elseif ( is_string( $bullet ) ) {
                      $bullet_text = $bullet;
                    }

                    if ( '' === trim( wp_strip_all_tags( $bullet_text ) ) ) {
                      continue;
                    }
                    ?>
                    <li class="list-group-item border-0 bg-transparent px-0 py-1 d-flex gap-2">
                      <i class="bi bi-stars text-info mt-1" aria-hidden="true"></i>
                      <span><?php echo esc_html( $bullet_text ); ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>




