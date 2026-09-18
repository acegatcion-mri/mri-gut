<?php
/**
 * MRI Proof Metrics Strip block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_proof_metrics_strip_heading' );
$items = pardot_boostrap_get_block_field_value( $block, 'mri_proof_metrics_strip_items' );

if ( ! is_array( $items ) ) {
  $items = array();
}

/*$items = pardot_boostrap_repeat_rows_to_count( $items, 4 );*/

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-proof-metrics-strip' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="proof-metrics py-2 position-relative">
  <div class="position-relative z-1">
    <div class="row g-3 align-items-center">
      <div class="col-12 col-lg-4">
        <p class="eyebrow mb-2">Proof</p>
        <h2 class="mb-0"><?php echo esc_html( $heading ); ?></h2>
      </div>

      <div class="col-12 col-lg-8">
        <div class="row row-cols-2 row-cols-md-4 g-3">
          <?php foreach ( $items as $item ) : ?>
            <?php
            $value = '';
            $label = '';

            if ( is_array( $item ) ) {
              $value = isset( $item['value'] ) ? $item['value'] : '';
              $prefix = isset( $item['prefix'] ) ? $item['prefix'] : '';
              $number = isset( $item['number'] ) ? $item['number'] : '';
              $suffix = isset( $item['suffix'] ) ? $item['suffix'] : '';
              $label = isset( $item['label'] ) ? $item['label'] : '';
              /*$icon  = isset( $item['icon'] ) && '' !== trim( $item['icon'] ) ? $item['icon'] : $icon;
              $icon = isset( $item['icon_picker'] ) ? $item['icon_picker'] : '';*/
              
            }

            if ( '' === trim( wp_strip_all_tags( $label ) ) ) {
              continue;
            }
            ?>
            <div class="col">
              <div class="proof-metrics-card card h-100 border rounded-3 shadow-sm p-3">
                <p class="proof-metrics-value mb-1"><span><?php echo esc_html( $prefix ); ?></span><span class="counter" data-target="<?php echo esc_attr( $number ); ?>"> 0 </span><span><?php echo esc_html( $suffix ); ?></span></p>
                <p class="proof-metrics-label mb-0"><?php echo esc_html( $label ); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
const counters = document.querySelectorAll('.counter');

const animateCounter = (counter) => {
    const target = parseFloat(counter.dataset.target);
    const duration = 2000;
    const startTime = performance.now();

    // Determine how many decimals the target has
    const decimals = (target.toString().split('.')[1] || '').length;

    const update = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);

        const current = target * progress;

        counter.textContent = current.toLocaleString('en-US', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });

        if (progress < 1) {
            requestAnimationFrame(update);
        } else {
            counter.textContent = target.toLocaleString('en-US', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            });
        }
    };

    requestAnimationFrame(update);
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
            entry.target.classList.add('counted');
            animateCounter(entry.target);
        }
    });
}, {
    threshold: 0.5
});

counters.forEach(counter => observer.observe(counter));
</script>
