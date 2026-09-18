<?php
/**
 * MRI Interactive Workflow Strip block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_interactive_workflow_strip_heading' );
$steps = pardot_boostrap_get_block_field_value( $block, 'mri_interactive_workflow_strip_steps' );

if ( ! is_array( $steps ) ) {
  $steps = array();
}

/*$steps = pardot_boostrap_repeat_rows_to_count( $steps, 4 );*/

foreach ( $steps as $step_index => $step ) {
  if ( ! is_array( $step ) ) {
    continue;
  }

  $step_bullets = isset( $step['bullets'] ) && is_array( $step['bullets'] ) ? $step['bullets'] : array();
  /*$steps[ $step_index ]['bullets'] = pardot_boostrap_repeat_rows_to_count( $step_bullets, 3 );*/
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-interactive-workflow-strip' );
$tabs_id  = 'workflow-tabs-' . $block['id'];
$panes_id = 'workflow-panes-' . $block['id'];
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="workflow-strip py-2 position-relative">
  <div class="position-relative z-1">
    <p class="eyebrow mb-2">Workflow</p>
    <h2 class="mb-4"><?php echo esc_html( $heading ); ?></h2>

    <div class="row row-cols-2 row-cols-lg-4 g-2 g-md-3 mb-3 mb-md-4 nav" id="<?php echo esc_attr( $tabs_id ); ?>" role="tablist">
      <?php foreach ( $steps as $index => $step ) : ?>
        <?php
        $step_id   = isset( $step['id'] ) && '' !== $step['id'] ? sanitize_title( $step['id'] ) : 'workflow-' . ( $index + 1 );
        $label     = isset( $step['label'] ) ? $step['label'] : '';
        $icon      = isset( $step['icon'] ) ? $step['icon'] : '';
        $is_active = 0 === (int) $index;
        $button_id = $tabs_id . '-btn-' . $step_id;
        $pane_id   = $panes_id . '-pane-' . $step_id;

        if ( '' === trim( wp_strip_all_tags( $label ) ) ) {
          continue;
        }
        ?>
        <div class="col">
          <button
            type="button"
            class="workflow-step-btn btn w-100 text-start border rounded-3 p-3 <?php echo $is_active ? 'active' : ''; ?>"
            id="<?php echo esc_attr( $button_id ); ?>"
            data-bs-toggle="pill"
            data-bs-target="#<?php echo esc_attr( $pane_id ); ?>"
            role="tab"
            aria-controls="<?php echo esc_attr( $pane_id ); ?>"
            aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <span class="workflow-step-index"><?php echo esc_html( sprintf( '%02d', ( (int) $index ) + 1 ) ); ?></span>
              <i class="bi <?php echo esc_attr( $icon ); ?> workflow-step-icon" aria-hidden="true"></i>
            </div>
            <p class="mb-0 fw-semibold"><?php echo esc_html( $label ); ?></p>
          </button>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="tab-content" id="<?php echo esc_attr( $panes_id ); ?>">
      <?php foreach ( $steps as $index => $step ) : ?>
        <?php
        $step_id   = isset( $step['id'] ) && '' !== $step['id'] ? sanitize_title( $step['id'] ) : 'workflow-' . ( $index + 1 );
        $title     = isset( $step['title'] ) ? $step['title'] : '';
        $text      = isset( $step['text'] ) ? $step['text'] : '';
        $bullets   = isset( $step['bullets'] ) && is_array( $step['bullets'] ) ? $step['bullets'] : array();
        $is_active = 0 === (int) $index;
        $button_id = $tabs_id . '-btn-' . $step_id;
        $pane_id   = $panes_id . '-pane-' . $step_id;

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
          <div class="card border rounded-3 shadow-sm">
            <div class="card-body p-3 p-md-4">
              <h3 class="h4 mb-2"><?php echo esc_html( $title ); ?></h3>
              <?php if ( ! empty( $text ) ) : ?>
                <p class="text-secondary mb-3"><?php echo esc_html( $text ); ?></p>
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
                  <li class="workflow-step-tab list-group-item border-0 bg-transparent px-0 py-1 d-flex gap-2">
                    <i class="bi bi-check-circle-fill text-info mt-1" aria-hidden="true"></i>
                    <span><?php echo esc_html( $bullet_text ); ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>




