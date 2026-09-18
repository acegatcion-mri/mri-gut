<?php
/**
 * MRI Persona Use Case Selector block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_persona_use_case_selector_heading' );
$personas = pardot_boostrap_get_block_field_value( $block, 'mri_persona_use_case_selector_personas' );

if ( ! is_array( $personas ) ) {
  $personas = array();
}

/*** Commented to prevent duplication of items when there is only 1 entry */
/*$personas = pardot_boostrap_repeat_rows_to_count( $personas, 3 );*/

foreach ( $personas as $persona_index => $persona ) {
  if ( ! is_array( $persona ) ) {
    continue;
  }

  $persona_outcomes = isset( $persona['outcomes'] ) && is_array( $persona['outcomes'] ) ? $persona['outcomes'] : array();
  $personas[ $persona_index ]['outcomes'] = pardot_boostrap_repeat_rows_to_count( $persona_outcomes, 3 );
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-persona-use-case-selector' ); 
$tabs_id  = 'persona-tabs-' . $block['id'];
$pane_id  = 'persona-pane-' . $block['id'];
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="py-2 position-relative mri-persona-use-case-selector">
  <div class="position-relative z-1">
    <p class="eyebrow mb-2">Use Cases</p>
    <h2 class="mb-4"><?php echo esc_html( $heading ); ?></h2>

    <ul class="nav nav-pills persona-selector-tabs flex-wrap gap-2 mb-4" role="tablist" id="<?php echo esc_attr( $tabs_id ); ?>">
      <?php foreach ( $personas as $index => $persona ) : ?>
        <?php
        $pid       = isset( $persona['id'] ) && '' !== $persona['id'] ? sanitize_title( $persona['id'] ) : 'persona-' . ( $index + 1 );
        $label     = isset( $persona['label'] ) ? $persona['label'] : '';
        $active    = 0 === (int) $index;
        $btn_id    = $tabs_id . '-btn-' . $pid;
        $tab_pane  = $pane_id . '-' . $pid;

        if ( '' === trim( wp_strip_all_tags( $label ) ) ) {
          continue;
        }
        ?>
        <li class="nav-item" role="presentation">
          <button
            class="nav-link rounded-pill persona-selector-tab <?php echo $active ? 'active' : ''; ?>"
            id="<?php echo esc_attr( $btn_id ); ?>"
            data-bs-toggle="pill"
            data-bs-target="#<?php echo esc_attr( $tab_pane ); ?>"
            type="button"
            role="tab"
            aria-controls="<?php echo esc_attr( $tab_pane ); ?>"
            aria-selected="<?php echo $active ? 'true' : 'false'; ?>">
            <?php echo esc_html( $label ); ?>
          </button>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="tab-content" id="<?php echo esc_attr( $pane_id ); ?>">
      <?php foreach ( $personas as $index => $persona ) : ?>
        <?php
        $pid       = isset( $persona['id'] ) && '' !== $persona['id'] ? sanitize_title( $persona['id'] ) : 'persona-' . ( $index + 1 );
        $headline  = isset( $persona['headline'] ) ? $persona['headline'] : '';
        $copy      = isset( $persona['copy'] ) ? $persona['copy'] : '';
        $cta_label = isset( $persona['cta_label'] ) ? $persona['cta_label'] : '';
        $cta_href  = isset( $persona['cta_href'] ) ? $persona['cta_href'] : '';
        $outcomes  = isset( $persona['outcomes'] ) && is_array( $persona['outcomes'] ) ? $persona['outcomes'] : array();
        $active    = 0 === (int) $index;
        $btn_id    = $tabs_id . '-btn-' . $pid;
        $tab_pane  = $pane_id . '-' . $pid;
        ?>
        <div
          class="tab-pane fade <?php echo $active ? 'show active' : ''; ?>"
          id="<?php echo esc_attr( $tab_pane ); ?>"
          role="tabpanel"
          aria-labelledby="<?php echo esc_attr( $btn_id ); ?>"
          tabindex="0">
          <div class="row g-4 align-items-start">
            <div class="col-12 col-lg-7">
              <h3 class="mb-3"><?php echo esc_html( $headline ); ?></h3>
              <?php if ( ! empty( $copy ) ) : ?>
                <p class="mb-4"><?php echo esc_html( $copy ); ?></p>
              <?php endif; ?>
              <?php if ( ! empty( $cta_label ) && ! empty( $cta_href ) ) : ?>
                <a href="<?php echo esc_url( $cta_href ); ?>" class="cta-button-blue-outline text-decoration-none">
                  <?php echo esc_html( $cta_label ); ?>
                </a>
              <?php endif; ?>
            </div>

            <div class="col-12 col-lg-5">
              <div class="persona-selector-outcomes rounded p-3 p-md-4">
                <p class="persona-selector-list-label mb-2">Expected outcomes</p>
                <ul class="list-group list-group-flush mb-0">
                  <?php foreach ( $outcomes as $outcome ) : ?>
                    <?php
                    $outcome_text = '';

                    if ( is_array( $outcome ) ) {
                      $outcome_text = isset( $outcome['text'] ) ? $outcome['text'] : '';
                    } elseif ( is_string( $outcome ) ) {
                      $outcome_text = $outcome;
                    }

                    if ( '' === trim( wp_strip_all_tags( $outcome_text ) ) ) {
                      continue;
                    }
                    ?>
                    <li class="list-group-item bg-transparent border-0 px-0 py-2 d-flex gap-2 persona-selector-outcomes-bullets">
                      <span class="check-circle" aria-hidden="true">
                        <i class="bi bi-check2"></i>
                      </span>
                      <span><?php echo esc_html( $outcome_text ); ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>




