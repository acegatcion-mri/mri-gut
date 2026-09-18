<?php
/**
 * MRI Product Cards Section block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = pardot_boostrap_get_block_field_value( $block, 'mri_product_cards_section_heading' );
$cards   = pardot_boostrap_get_block_field_value( $block, 'mri_product_cards_section_cards' );

if ( ! is_array( $cards ) ) {
	$cards = array();
}

$cards = pardot_boostrap_repeat_rows_to_count( $cards, 6 );

$normalized_cards = array();

foreach ( $cards as $index => $card ) {

	if ( is_string( $card ) ) {
		$normalized_cards[] = array(
			'title'      => $card,
			'text'       => '',
			'image'      => '',
			'link'       => '',
			'link_label' => '',
		);
		continue;
	}

	$image = '';

	if ( isset( $card['image'] ) ) {
		if ( is_array( $card['image'] ) ) {
			$image = isset( $card['image']['url'] ) ? $card['image']['url'] : '';
		} elseif ( is_string( $card['image'] ) ) {
			$image = $card['image'];
		}
	}

	$image = pardot_boostrap_get_image_with_placeholder(
		$image,
		isset( $card['title'] ) ? $card['title'] : ''
	)['url'];

	$normalized_cards[] = array(
		'title'      => isset( $card['title'] ) ? $card['title'] : '',
		'text'       => isset( $card['text'] ) ? $card['text'] : '',
		'image'      => $image,
		'link'       => isset( $card['link'] ) ? $card['link'] : '',
		'link_label' => isset( $card['link_label'] ) ? $card['link_label'] : '',
	);
}

$total_cards = count( $normalized_cards );

$carousel_id = 'mri-product-cards-carousel-' . $block['id'];
$block_id    = pardot_boostrap_setup_block_id_and_preview(
	$block,
	$is_preview,
	'mri-product-cards-section'
);
?>

<section
	id="<?php echo esc_attr( $block_id ); ?>"
	class="product-card-carousel position-relative"
	data-product-carousel="<?php echo esc_attr( $carousel_id ); ?>"
>
	<div class="position-relative z-1">
		<div class="row">
			<div class="col-12">
				<div class="w-100">

					<div class="d-flex align-items-center justify-content-between gap-3 mb-4">
						<div>
							<p class="eyebrow mb-2">Card Grid</p>
							<h2 class="mb-0"><?php echo esc_html( $heading ); ?></h2>
						</div>
						<div class="carousel-controls d-none d-md-flex gap-2">
							<button
								type="button"
								class="btn btn-light shadow-sm"
								aria-label="Previous card"
							>
								<i class="bi bi-arrow-left"></i>
							</button>

							<button
								type="button"
								class="btn btn-light shadow-sm"
								aria-label="Next card"
							>
								<i class="bi bi-arrow-right"></i>
							</button>
						</div>
					</div>

					<?php if ( ! empty( $normalized_cards ) ) : ?>

						<div class="row g-4">

							<div class="col-12">
								<div class="product-card-stage" aria-live="polite">

									<?php foreach ( $normalized_cards as $index => $card ) : ?>

										<article class="product-card-slide card border-0 shadow-sm" data-card-index="<?php echo esc_attr( $index ); ?>">
											<div class="product-card-media">
												<div class="product-card-media-bg"></div>
												<div class="product-card-media-image" style="background-image:url('<?php echo esc_url( $card['image'] ); ?>');"></div>
											</div>
											<div class="card-body p-4 p-lg-5">
												<h5 class="card-title"><?php echo esc_html( $card['title'] ); ?></h5>
												<p class="card-text"><?php echo esc_html( $card['text'] ); ?></p>

												<?php if ( ! empty( $card['link'] ) ) : ?>

													<a class="stretched-link" href="<?php echo esc_url( $card['link'] ); ?>"> 
														<?php echo ! empty( $card['link_label'] ) ? $card['link_label'] : 'Learn more'; ?>	
														<i class="bi bi-chevron-right" aria-hidden="true"></i>
													</a>

												<?php endif; ?>

											</div>

										</article>

									<?php endforeach; ?>

								</div>
							</div>

							<?php $dot_count = max( $total_cards - 2, 1 ); ?>

							<div class="col-12">
								<div
									class="carousel-dots mt-4"
									role="tablist"
									aria-label="Carousel pagination"
								>

									<?php for ( $i = 0; $i < $dot_count; $i++ ) : ?>

										<button
											type="button"
											class="<?php echo 0 === $i ? 'active' : ''; ?>"
											data-slide-index="<?php echo esc_attr( $i ); ?>"
											aria-label="Show cards starting at card <?php echo esc_attr( $i + 1 ); ?>"
											aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>"
											role="tab"
										></button>

									<?php endfor; ?>

								</div>
							</div>

						</div>

					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
	const carousel = document.getElementById(
		<?php echo wp_json_encode( $block_id ); ?>
	);

	if (!carousel) {
		return;
	}

	const cards = Array.from(
		carousel.querySelectorAll('.product-card-slide')
	);

	const dots = Array.from(
		carousel.querySelectorAll('.carousel-dots button')
	);
	
	const prevButton = carousel.querySelector(
	'.carousel-controls button[aria-label="Previous card"]'
	);

	const nextButton = carousel.querySelector(
		'.carousel-controls button[aria-label="Next card"]'
	);
	
	let currentIndex = 0;
	const maxIndex = Math.max(cards.length - 3, 0);

	if (!cards.length) {
		return;
	}

	const positionClasses = [
		'product-card-slide---1',
		'product-card-slide--0',
		'product-card-slide--1'
	];

	function updateCarousel(startIndex) {
		currentIndex = Math.max(
			0,
			Math.min(startIndex, maxIndex)
		);

		cards.forEach(function (card) {
			card.classList.remove(...positionClasses);
			card.setAttribute('aria-hidden', 'true');
		});

		positionClasses.forEach(function (positionClass, offset) {
			const card = cards[currentIndex + offset];

			if (card) {
				card.classList.add(positionClass);
				card.setAttribute('aria-hidden', 'false');
			}
		});

		dots.forEach(function (dot, index) {
			const isActive = index === currentIndex;

			dot.classList.toggle('active', isActive);
			dot.setAttribute(
				'aria-selected',
				isActive ? 'true' : 'false'
			);
		});
	}

	if (prevButton) {
		prevButton.addEventListener('click', function () {
			updateCarousel(
				currentIndex <= 0
					? maxIndex
					: currentIndex - 1
			);
		});
	}

	if (nextButton) {
		nextButton.addEventListener('click', function () {
			updateCarousel(
				currentIndex >= maxIndex
					? 0
					: currentIndex + 1
			);
		});
	}

	dots.forEach(function (dot) {
		dot.addEventListener('click', function () {
			const startIndex = Number.parseInt(
				dot.dataset.slideIndex,
				10
			);

			if (!Number.isNaN(startIndex)) {
				updateCarousel(startIndex);
			}
		});
	});

	updateCarousel(0);
});
</script>