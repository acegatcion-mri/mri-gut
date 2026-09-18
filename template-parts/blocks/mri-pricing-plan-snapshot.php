<?php
/**
 * MRI Pricing Plan Snapshot block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_pricing_plan_snapshot_heading' );
$plans = pardot_boostrap_get_block_field_value( $block, 'mri_pricing_plan_snapshot_plans' );

if ( ! is_array( $plans ) ) {
  $plans = array();
}

/*$plans = pardot_boostrap_repeat_rows_to_count( $plans, 3 );*/

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-pricing-plan-snapshot' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="pricing-snapshot py-2 position-relative">
  <div class="position-relative z-1">
    <p class="eyebrow mb-2">Pricing</p>
    <h2 class="mb-4"><?php echo esc_html( $heading ); ?></h2>

    <div class="row g-4 row-cols-1 row-cols-lg-3">
      <?php foreach ( $plans as $plan ) : ?>
        <?php
        $name        = isset( $plan['name'] ) ? $plan['name'] : '';
        $price       = isset( $plan['price'] ) ? $plan['price'] : '';
        $cadence     = isset( $plan['cadence'] ) ? $plan['cadence'] : '';
        $description = isset( $plan['description'] ) ? $plan['description'] : '';
        $cta_label   = isset( $plan['cta_label'] ) ? $plan['cta_label'] : '';
        $cta_href    = isset( $plan['cta_href'] ) ? $plan['cta_href'] : '';
        $features    = isset( $plan['features'] ) && is_array( $plan['features'] ) ? $plan['features'] : array();
        $featured    = ! empty( $plan['featured'] );

        if ( '' === trim( wp_strip_all_tags( $name ) ) ) {
          continue;
        }
        ?>
        <div class="col">
          <article class="pricing-card card h-100 border rounded-3 shadow-sm <?php echo $featured ? 'pricing-card-featured' : ''; ?>">
            <div class="card-body d-flex flex-column p-3 p-md-4">
              <?php if ( $featured ) : ?>
                <span class="pricing-badge badge rounded-pill px-2 py-1">Most Popular</span>
              <?php endif; ?>

              <p class="pricing-plan-name mb-1"><?php echo esc_html( $name ); ?></p>
              <h3 class="pricing-plan-price mb-3">
                <?php echo esc_html( $price ); ?>
                <?php if ( ! empty( $cadence ) ) : ?>
                  <span class="pricing-plan-cadence ms-1"><?php echo esc_html( $cadence ); ?></span>
                <?php endif; ?>
              </h3>

              <?php if ( ! empty( $description ) ) : ?>
                <p class="text-secondary mb-3"><?php echo esc_html( $description ); ?></p>
              <?php endif; ?>

              <ul class="list-group list-group-flush mb-4">
                <?php foreach ( $features as $feature ) : ?>
                  <?php
                  $feature_text = '';

                  if ( is_array( $feature ) ) {
                    $feature_text = isset( $feature['text'] ) ? $feature['text'] : '';
                  } elseif ( is_string( $feature ) ) {
                    $feature_text = $feature;
                  }

                  if ( '' === trim( wp_strip_all_tags( $feature_text ) ) ) {
                    continue;
                  }
                  ?>
                  <li class="list-group-item border-0 bg-transparent px-0 py-2 d-flex align-items-start gap-2">
                    <i class="bi bi-check-circle-fill mt-1" aria-hidden="true"></i>
                    <span><?php echo esc_html( $feature_text ); ?></span>
                  </li>
                <?php endforeach; ?>
              </ul>

              <?php if ( ! empty( $cta_label ) && ! empty( $cta_href ) ) : ?>
                <a
                  href="<?php echo esc_url( $cta_href ); ?>"
                  class="btn text-decoration-none mt-auto align-self-start <?php echo $featured ? 'cta-button-blue' : 'cta-button-blue-outline'; ?>">
                  <?php echo esc_html( $cta_label ); ?>
                </a>
              <?php endif; ?>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>




