<?php
/**
 * Main template file.
 *
 * @package Pardot-boostrap
 */

get_header();
?>

<main class="site-main py-5">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="row row-cols-1 g-4">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'col-12' ); ?>>
						<div class="card shadow-sm h-100 border-0">
							<div class="card-body">
								<p class="text-body-secondary small mb-2">
									<?php echo esc_html( get_the_date() ); ?>
								</p>
								<h2 class="h4 card-title mb-3">
									<a class="link-dark text-decoration-none" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h2>
								<div class="card-text"><?php the_excerpt(); ?></div>
								<a class="btn btn-outline-primary mt-3" href="<?php the_permalink(); ?>">
									<?php esc_html_e( 'Read more', 'pardot-boostrap' ); ?>
								</a>
							</div>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>
			<div class="mt-4">
				<?php
				the_posts_pagination(
					array(
						'mid_size'  => 1,
						'prev_text' => __( 'Previous', 'pardot-boostrap' ),
						'next_text' => __( 'Next', 'pardot-boostrap' ),
					)
				);
				?>
			</div>
		<?php else : ?>
			<div class="alert alert-info mb-0" role="alert">
				<?php esc_html_e( 'No posts found.', 'pardot-boostrap' ); ?>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
