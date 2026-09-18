<?php
/**
 * Theme footer.
 *
 * @package Pardot-boostrap
 */
?>

<footer class="py-4 mt-auto border-top bg-white app-footer">
	<!--div class="container">
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 small text-muted">
			<p class="mb-0">
				&copy; 
			</p>
			<p class="mb-0">
				<?php esc_html_e( 'Built with Bootstrap 5', 'pardot-boostrap' ); ?>
			</p>
		</div>
	</div-->
	<div class="container test-class">
		<div class="row g-3 align-items-start align-items-md-center">
			<div class="col-12 col-md-8">
			<p>
				<small>
				Privacy Policy (Americas) | Terms of Use OnLocation | Terms Sitemap | Cookies | Don&#x27;t Sell My Personal Info
				</small>
			</p>
			<p>
				<small>
				<?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>
				<br/>
				MRI Software LLC is a registered ISO of Wells Fargo Bank, N.A., Concord, CA.
				</small>
			</p>
			</div>
			<div class="col-12 col-md-4 text-md-end">
			<div>
				<img src="https://mrigut.wpenginepowered.com/style-guide-2/assets/MRI_Software_logo-Bs31PHGw.svg" alt="MRI Software" class="MRILogo mri-logo--small"/>
			</div>
			</div>
		</div>
	</div>
</footer>

<link rel="preload" as="image" href="https://mrigut.wpenginepowered.com/style-guide-2/assets/MRI_Software_logo-Bs31PHGw.svg"/>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<?php wp_footer(); ?>
</body>
</html>
