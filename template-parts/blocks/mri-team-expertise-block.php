<?php
/**
 * MRI team-expertise-block block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_team_expertise_block_heading' );
$copy = pardot_boostrap_get_block_field_value( $block, 'mri_team_expertise_block_copy' );
$items = pardot_boostrap_get_block_field_value( $block, 'mri_team_expertise_block_items' );

if ( ! is_array( $items ) ) {
  $items = array();
}

/*$items = pardot_boostrap_repeat_rows_to_count( $items, 4 );*/

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-team-expertise-block' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="team-expertise py-2 position-relative">
	<div class="position-relative z-1">
		<div class="row align-items-start g-4">
			<div class="col-12 col-lg-4">
				<p class="eyebrow mb-2">Expertise</p>
				<h2 class="mb-3"><?php echo esc_html( $heading ); ?></h2>
				<p class="mb-0 text-secondary"><?php echo esc_html( $copy ); ?></p>
			</div>

			<div class="col-12 col-lg-8">
				<div class="row row-cols-1 row-cols-md-2 g-3">
					<?php foreach ( $items as $item ) : ?>
						<?php
						$metric = '';
						$title  = '';
						$text   = '';

						if ( is_array( $item ) ) {
							$metric = isset( $item['metric'] ) ? $item['metric'] : '';
							$title  = isset( $item['title'] ) ? $item['title'] : '';
							$text   = isset( $item['text'] ) ? $item['text'] : '';
						}

						if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
							continue;
						}
						?>
						<div class="col">
							<article class="expertise-card card h-100 border rounded-3 shadow-sm">
								<div class="card-body p-3 p-md-4">
									<p class="expertise-metric mb-1"><?php echo esc_html( $metric ); ?></p>
									<h3 class="h5 mb-2"><?php echo esc_html( $title ); ?></h3>
									<p class="mb-0 text-secondary"><?php echo esc_html( $text ); ?></p>
								</div>
							</article>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>




