<?php
/**
 * MRI Accordion Agenda block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$shared_fields = pardot_boostrap_get_shared_block_fields( 'mri_accordion_agenda', $block );
$heading       = $shared_fields['heading'];
$subheading    = $shared_fields['subheading'];
$content       = $shared_fields['content'];
$button_label  = $shared_fields['button_label'];
$button_link   = $shared_fields['button_link'];
$image         = $shared_fields['image'];

$agenda_items = pardot_boostrap_get_block_field_value( $block, 'mri_accordion_agenda_items' );

if ( ! is_array( $agenda_items ) ) {
  $agenda_items = array();
}

$agenda_items = pardot_boostrap_repeat_rows_to_count( $agenda_items, 3 );

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-accordion-agenda' );
$accordion_uid = 'agenda-accordion-' . $block['id'];
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="position-relative mri-accordion-agenda">
	<div class="position-relative z-1">
		<div class="row g-4 align-items-start">
			<div class="col-12 <?php echo ! empty( $image ) ? 'col-lg-5' : 'col-lg-6'; ?>">
				<?php if ( ! empty( $subheading ) ) : ?>
					<p class="accordion-panel-kicker mb-2"><?php echo esc_html( $subheading ); ?></p>
				<?php endif; ?>

				<h2 class="accordion-panel-title mb-3">
					<?php echo esc_html( $heading ); ?>
				</h2>

				<?php if ( ! empty( $content ) ) : ?>
					<div class="mb-3"><?php echo wp_kses_post( wpautop( $content ) ); ?></div>
				<?php endif; ?>

				<?php if ( ! empty( $button_label ) && ! empty( $button_link ) ) : ?>
					<a class="cta-button-blue-outline text-decoration-none" href="<?php echo esc_url( $button_link ); ?>">
						<?php echo esc_html( $button_label ); ?>
					</a>
				<?php endif; ?>
					<?php if ( ! empty( $image['url'] ) ) : ?>
			<div class="row mt-4">
				<div class="col-12">
					<img
						src="<?php echo esc_url( $image['url'] ); ?>"
						alt="<?php echo esc_attr( ! empty( $image['alt'] ) ? $image['alt'] : $heading ); ?>"
						class="img-fluid rounded shadow-sm" />
				</div>
			</div>
		<?php endif; ?>
			</div>

			<div class="col-12 <?php echo ! empty( $image ) ? 'col-lg-7' : 'col-lg-6'; ?>">
				<div class="accordion accordion-brand" id="<?php echo esc_attr( $accordion_uid ); ?>">
					<?php foreach ( $agenda_items as $index => $item ) : ?>
						<?php
						$time        = isset( $item['time'] ) ? $item['time'] : '';
						$title       = isset( $item['title'] ) ? $item['title'] : '';
						$body        = isset( $item['body'] ) ? $item['body'] : '';
						$is_open     = 0 === (int) $index;
						$collapse_id = 'agenda-collapse-' . $block['id'] . '-' . $index;
						$heading_id  = 'agenda-heading-' . $block['id'] . '-' . $index;
						?>
						<div class="accordion-item">
							<h3 class="accordion-header" id="<?php echo esc_attr( $heading_id ); ?>">
								<button
									class="accordion-button <?php echo $is_open ? '' : 'collapsed'; ?>"
									type="button"
									data-bs-toggle="collapse"
									data-bs-target="#<?php echo esc_attr( $collapse_id ); ?>"
									aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>"
									aria-controls="<?php echo esc_attr( $collapse_id ); ?>">
									<span class="accordion-agenda-button-content">
										<span class="accordion-agenda-icon" aria-hidden="true">
											<i class="bi bi-clock"></i>
										</span>
										<?php if ( ! empty( $time ) ) : ?>
											<span class="accordion-agenda-time"><?php echo esc_html( $time ); ?></span>
											<span class="accordion-agenda-separator" aria-hidden="true">|</span>
										<?php endif; ?>
										<span class="accordion-agenda-title"><?php echo esc_html( $title ); ?></span>
									</span>
								</button>
							</h3>
							<div
								id="<?php echo esc_attr( $collapse_id ); ?>"
								class="accordion-collapse collapse <?php echo $is_open ? 'show' : ''; ?>"
								aria-labelledby="<?php echo esc_attr( $heading_id ); ?>"
								data-bs-parent="#<?php echo esc_attr( $accordion_uid ); ?>">
								<div class="accordion-body"><?php echo wp_kses_post( wpautop( $body ) ); ?></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

	
	</div>
</section>






