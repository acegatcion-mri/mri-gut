<?php
/**
 * MRI ROI Calculator Lite block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_roi_calculator_lite_heading' );
$copy = pardot_boostrap_get_block_field_value( $block, 'mri_roi_calculator_lite_copy' );
$bullets = pardot_boostrap_get_block_field_value( $block, 'mri_roi_calculator_lite_bullets' );
$image = pardot_boostrap_get_block_field_value( $block, 'mri_roi_calculator_lite_image' );

$locations = pardot_boostrap_get_block_field_value( $block, 'mri_roi_calculator_lite_locations' );
$avg_lease_cost = pardot_boostrap_get_block_field_value( $block, 'mri_roi_calculator_lite_avg_lease_cost' );
$avg_sales_per_location = pardot_boostrap_get_block_field_value( $block, 'mri_roi_calculator_lite_avg_sales_per_location' );

$locations = is_numeric( $locations ) ? (int) $locations : 0;
$avg_lease_cost = is_numeric( $avg_lease_cost ) ? (float) $avg_lease_cost : 0;
$avg_sales_per_location = is_numeric( $avg_sales_per_location ) ? (float) $avg_sales_per_location : 0;

if ( ! is_array( $bullets ) ) {
  $bullets = array();
}

/*$bullets = pardot_boostrap_repeat_rows_to_count( $bullets, 6 );*/

$image_url = '';
$image_alt = 'Modern data dashboard with visual metrics';

if ( is_array( $image ) ) {
  $image_url = isset( $image['url'] ) ? $image['url'] : '';
  $image_alt = isset( $image['alt'] ) && '' !== trim( $image['alt'] ) ? $image['alt'] : $image_alt;
} elseif ( is_string( $image ) ) {
  $image_url = $image;
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-roi-calculator-lite' );
?>


<section
  id="<?php echo esc_attr( $block_id ); ?>"
  class="position-relative"
  data-roi-calculator="<?php echo esc_attr( $block_id ); ?>"
>
  <div class="container position-relative z-1">
    <p class="eyebrow mb-2">Calculator</p>
    <h2 class="mb-4"><?php echo esc_html( $heading ); ?></h2>

    <div class="row g-4 align-items-start mb-4">
      <div class="col-12 col-lg-6">
        <p class="mb-3 text-secondary"><?php echo esc_html( $copy ); ?></p>
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
            <li class="list-group-item bg-transparent border-0 px-0 py-1 d-flex gap-2">
              <i class="bi bi-check-circle-fill text-info mt-1" aria-hidden="true"></i>
              <span><?php echo esc_html( $bullet_text ); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="col-12 col-lg-6">
        <img
          src="<?php echo esc_url( $image_url ); ?>"
          alt="<?php echo esc_attr( $image_alt ); ?>"
          class="img-fluid rounded shadow-sm"
        />
      </div>
    </div>

    <div class="row g-4 align-items-start">
      <div class="col-12 col-lg-5">
        <div class="card border rounded-3 shadow-sm">
          <div class="card-body p-3 p-md-4">
            <div class="mb-3">
              <label for="<?php echo esc_attr( $block_id ); ?>-locations" class="form-label mb-1">Number of lease locations</label>
              <input
                id="<?php echo esc_attr( $block_id ); ?>-locations"
                type="number"
                class="form-control"
                min="0"
                value="<?php echo esc_attr( (string) $locations ); ?>"
                data-roi-input="locations"
              />
            </div>

            <div class="mb-3">
              <label for="<?php echo esc_attr( $block_id ); ?>-lease-cost" class="form-label mb-1">Average lease cost per year</label>
              <input
                id="<?php echo esc_attr( $block_id ); ?>-lease-cost"
                type="number"
                class="form-control"
                min="0"
                step="1000"
                value="<?php echo esc_attr( (string) $avg_lease_cost ); ?>"
                data-roi-input="avgLeaseCost"
              />
            </div>

            <div>
              <label for="<?php echo esc_attr( $block_id ); ?>-sales" class="form-label mb-1">Average sales per location</label>
              <input
                id="<?php echo esc_attr( $block_id ); ?>-sales"
                type="number"
                class="form-control"
                min="0"
                step="1000"
                value="<?php echo esc_attr( (string) $avg_sales_per_location ); ?>"
                data-roi-input="avgSalesPerLocation"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-7">
        <div class="card border rounded-3 shadow-sm h-100">
          <div class="card-body p-3 p-md-4">
            <p class="text-uppercase small fw-bold text-info mb-2">Estimated annual impact</p>

            <div class="row row-cols-1 row-cols-sm-2 g-3">
              <div class="col">
                <div class="roi-result-box rounded p-3 h-100">
                  <p class="mb-1 text-secondary">Admin savings</p>
                  <p class="h5 mb-0" data-roi-output="adminSavings"></p>
                </div>
              </div>
              <div class="col">
                <div class="roi-result-box rounded p-3 h-100">
                  <p class="mb-1 text-secondary">Lease reduction</p>
                  <p class="h5 mb-0" data-roi-output="leaseCostReduction"></p>
                </div>
              </div>
              <div class="col">
                <div class="roi-result-box rounded p-3 h-100">
                  <p class="mb-1 text-secondary">Sales uplift</p>
                  <p class="h5 mb-0" data-roi-output="salesUplift"></p>
                </div>
              </div>
              <div class="col">
                <div class="roi-result-box rounded p-3 h-100">
                  <p class="mb-1 text-secondary">Platform cost</p>
                  <p class="h5 mb-0" data-roi-output="annualPlatformCost"></p>
                </div>
              </div>
            </div>

            <hr class="my-3" />

            <div class="d-flex flex-wrap gap-4">
              <div>
                <p class="small text-secondary mb-1">Net annual benefit</p>
                <p class="h4 mb-0 roi-net-value" data-roi-output="netAnnualBenefit"></p>
              </div>
              <div>
                <p class="small text-secondary mb-1">Estimated payback</p>
                <p class="h4 mb-0" data-roi-output="paybackMonths"></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
(function () {
  var root = document.querySelector('[data-roi-calculator="<?php echo esc_js( $block_id ); ?>"]');
  if (!root) {
    return;
  }

  function toNumber(value) {
    var num = Number(value);
    return Number.isFinite(num) ? num : 0;
  }

  function formatCurrency(value) {
    return new Intl.NumberFormat('en-GB', {
      style: 'currency',
      currency: 'GBP',
      maximumFractionDigits: 0
    }).format(value);
  }

  function calculate() {
    var locations = toNumber(root.querySelector('[data-roi-input="locations"]').value);
    var avgLeaseCost = toNumber(root.querySelector('[data-roi-input="avgLeaseCost"]').value);
    var avgSalesPerLocation = toNumber(root.querySelector('[data-roi-input="avgSalesPerLocation"]').value);

    var adminSavings = locations * 550;
    var leaseCostReduction = locations * avgLeaseCost * 0.03;
    var salesUplift = locations * avgSalesPerLocation * 0.01;
    var annualBenefit = adminSavings + leaseCostReduction + salesUplift;
    var annualPlatformCost = Math.max(locations * 120, 12000);
    var netAnnualBenefit = annualBenefit - annualPlatformCost;
    var paybackMonths = annualBenefit > 0 ? (annualPlatformCost / (annualBenefit / 12)) : 0;

    root.querySelector('[data-roi-output="adminSavings"]').textContent = formatCurrency(adminSavings);
    root.querySelector('[data-roi-output="leaseCostReduction"]').textContent = formatCurrency(leaseCostReduction);
    root.querySelector('[data-roi-output="salesUplift"]').textContent = formatCurrency(salesUplift);
    root.querySelector('[data-roi-output="annualPlatformCost"]').textContent = formatCurrency(annualPlatformCost);
    root.querySelector('[data-roi-output="netAnnualBenefit"]').textContent = formatCurrency(netAnnualBenefit);
    root.querySelector('[data-roi-output="paybackMonths"]').textContent = paybackMonths.toFixed(1) + ' months';
  }

  var inputs = root.querySelectorAll('[data-roi-input]');
  inputs.forEach(function (input) {
    input.addEventListener('input', calculate);
    input.addEventListener('change', calculate);
  });

  calculate();
})();
</script>




