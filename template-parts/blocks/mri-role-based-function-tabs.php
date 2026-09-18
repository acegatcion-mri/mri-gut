<?php
/**
 * MRI Role Based Function Tabs block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_role_based_function_tabs_heading' );
$roles = pardot_boostrap_get_block_field_value( $block, 'mri_role_based_function_tabs_roles' );

if ( ! is_array( $roles ) ) {
  $roles = array();
}

/*** commenting this out as it forces to have 4 roles */
/*($roles = pardot_boostrap_repeat_rows_to_count( $roles, 4 );*/

foreach ( $roles as $role_index => $role ) {
  if ( ! is_array( $role ) ) {
    continue;
  }

  $role_functions = isset( $role['functions'] ) && is_array( $role['functions'] ) ? $role['functions'] : array();
  $roles[ $role_index ]['functions'] = pardot_boostrap_repeat_rows_to_count( $role_functions, 3 );
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-role-based-function-tabs' );
$tabs_id  = 'mri-role-tabs-nav-' . $block['id'];

$normalized_roles = array();

foreach ( $roles as $index => $role ) {
  if ( ! is_array( $role ) ) {
    continue;
  }

  $role_id = isset( $role['id'] ) && '' !== trim( $role['id'] ) ? sanitize_title( $role['id'] ) : 'role-' . ( $index + 1 );
  $image_url = '';
  $image_alt = '';

  if ( isset( $role['image'] ) ) {
    if ( is_array( $role['image'] ) ) {
      $image_url = isset( $role['image']['url'] ) ? $role['image']['url'] : '';
      $image_alt = isset( $role['image']['alt'] ) ? $role['image']['alt'] : '';
    } elseif ( is_string( $role['image'] ) ) {
      $image_url = $role['image'];
    }
  }

  $label = isset( $role['label'] ) ? $role['label'] : '';
  $normalized_role_image = pardot_boostrap_get_image_with_placeholder( $image_url, $label . ' workflow preview' );
  $image_url             = $normalized_role_image['url'];
  $image_alt             = $normalized_role_image['alt'];
  $functions = isset( $role['functions'] ) && is_array( $role['functions'] ) ? $role['functions'] : array();

  $normalized_roles[] = array(
    'id'          => $role_id,
    'label'       => $label,
    'eyebrow'     => isset( $role['eyebrow'] ) ? $role['eyebrow'] : '',
    'title'       => isset( $role['title'] ) ? $role['title'] : '',
    'description' => isset( $role['description'] ) ? $role['description'] : '',
    'body'        => isset( $role['body'] ) ? $role['body'] : '',
    'kpi'         => isset( $role['kpi'] ) ? $role['kpi'] : '',
    'cta_label'   => isset( $role['cta_label'] ) ? $role['cta_label'] : '',
    'cta_href'    => isset( $role['cta_href'] ) ? $role['cta_href'] : '',
    'image_url'   => $image_url,
    'image_alt'   => $image_alt,
    'functions'   => $functions,
  );
}
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="role-function-tabs py-2 position-relative">
  <div class="position-relative z-1">
    <p class="eyebrow mb-2">Functions</p>
    <h2 class="mb-4"><?php echo esc_html( $heading ); ?></h2>

    <ul class="nav nav-pills flex-wrap gap-2 mb-4" role="tablist" id="<?php echo esc_attr( $tabs_id ); ?>">
      <?php foreach ( $normalized_roles as $index => $role ) : ?>
        <li class="nav-item" role="presentation">
          <button
            type="button"
            class="nav-link rounded-pill role-tab border border-info-subtle <?php echo 0 === (int) $index ? 'active' : '' ?>"
            id="<?php echo esc_attr( $tabs_id . '-tab-' . $role['id'] ); ?>"
            data-bs-toggle="pill"
            data-bs-target="#<?php echo esc_attr( $tabs_id . '-pane-' . $role['id'] ); ?>"
            role="tab"
            aria-controls="<?php echo esc_attr( $tabs_id . '-pane-' . $role['id'] ); ?>"
            aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
          >
            <?php echo esc_html( $role['label'] ); ?>
          </button>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="tab-content">
      <?php foreach ( $normalized_roles as $index => $role ) : ?>
        <div
          class="tab-pane fade <?php echo 0 === $index ? 'show active' : ''; ?>"
          id="<?php echo esc_attr( $tabs_id . '-pane-' . $role['id'] ); ?>"
          role="tabpanel"
          aria-labelledby="<?php echo esc_attr( $tabs_id . '-tab-' . $role['id'] ); ?>"
          tabindex="0"
        >
          <div class="row g-4 align-items-start">
            <div class="col-12 col-lg-7 px-4">
              <p class="eyebrow mb-1"><?php echo esc_html( $role['eyebrow'] ); ?></p>
              <h2 class="role-tab-title h4 mb-2"><?php echo esc_html( $role['title'] ); ?></h2>
              <p class="text-secondary mb-3"><?php echo esc_html( $role['description'] ); ?></p>
              <p><?php echo esc_html( $role['body'] ); ?></p>

              <?php if ( ! empty( $role['cta_label'] ) ) : ?>
                <a href="<?php echo esc_url( $role['cta_href'] ); ?>" class="btn cta-button-blue-outline text-decoration-none mb-3">
                  <?php echo esc_html( $role['cta_label'] ); ?>
                </a>
              <?php endif; ?>

              <ul class="list-group list-group-flush">
                <?php foreach ( $role['functions'] as $func ) : ?>
                  <?php
                  $func_text = '';
                  if ( is_array( $func ) ) {
                    $func_text = isset( $func['text'] ) ? $func['text'] : '';
                  } elseif ( is_string( $func ) ) {
                    $func_text = $func;
                  }

                  if ( '' === trim( wp_strip_all_tags( $func_text ) ) ) {
                    continue;
                  }
                  ?>
                  <li class="list-group-item border-0 bg-transparent px-0 py-2 d-flex gap-2 role-tab-bullet-points">
                    <span class="check-circle role-tab-bullet mt-1" aria-hidden="true">
                      <i class="bi bi-check2"></i>
                    </span>
                    <span class="role-tab-function-text"><?php echo esc_html( $func_text ); ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>

            <div class="col-12 col-lg-5">
              <div class="card border rounded-3 shadow-sm overflow-hidden mb-3">
                <img src="<?php echo esc_url( $role['image_url'] ); ?>" alt="<?php echo esc_attr( $role['image_alt'] ); ?>" class="img-fluid role-tab-image" />
              </div>
              <div class="card border rounded-3 shadow-sm">
                <div class="card-body p-3 p-md-4">
                  <p class="small text-uppercase fw-bold text-info mb-2">Expected KPI Impact</p>
                  <p class="h5 mb-3 role-tab-kpi"><?php echo esc_html( $role['kpi'] ); ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>




