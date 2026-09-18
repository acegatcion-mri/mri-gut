<?php
/**
 * Hero with form block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$afc_hero_banner_form = get_field( 'hero_banner_form' );

$afc_hero_content = isset( $afc_hero_banner_form['hero_content'] ) && is_array( $afc_hero_banner_form['hero_content'] )
	? $afc_hero_banner_form['hero_content']
	: array();

$afc_pardot_form = isset( $afc_hero_banner_form['pardot_form'] ) && is_array( $afc_hero_banner_form['pardot_form'] )
	? $afc_hero_banner_form['pardot_form']
	: array();

$afc_hero_h1      = isset( $afc_hero_content['hero_h1'] ) ? $afc_hero_content['hero_h1'] : '';
$afc_header_text  = isset( $afc_hero_content['header_text'] ) ? $afc_hero_content['header_text'] : '';
$afc_hero_bullets = isset( $afc_hero_content['hero_bullets'] ) && is_array( $afc_hero_content['hero_bullets'] )
	? $afc_hero_content['hero_bullets']
	: array();

$afc_pardot_header        = isset( $afc_pardot_form['pardot_header'] ) ? $afc_pardot_form['pardot_header'] : '';
$afc_pardot_link          = isset( $afc_pardot_form['pardot_link'] ) ? $afc_pardot_form['pardot_link'] : '';
$afc_pardot_tracking_code = isset( $afc_pardot_form['pardot_tracking_code'] ) ? $afc_pardot_form['pardot_tracking_code'] : '';
$afc_pardot_footer        = isset( $afc_pardot_form['pardot_footer'] ) ? $afc_pardot_form['pardot_footer'] : '';

$afc_block_id = ! empty( $block['anchor'] ) ? $block['anchor'] : 'hero-with-form-' . $block['id'];

if (!empty($afc_pardot_link) && filter_var($afc_pardot_link, FILTER_VALIDATE_URL)) {

    $host = parse_url($afc_pardot_link, PHP_URL_HOST);

    if ($host === 'info-emea.mrisoftware.com') {

        $html = @file_get_contents($afc_pardot_link);

        if ($html !== false) {

            preg_match("/piAId\s*=\s*['\"]?(\d+)['\"]?/", $html, $a);
            preg_match("/piCId\s*=\s*['\"]?(\d+)['\"]?/", $html, $c);

            $piAId = $a[1] ?? '';
            $piCId = $c[1] ?? '';


			switch ($piAId) {

					case '904661':
						$piRegion = 'EMEA';
						break;

					case '905123':
						$piRegion = 'North America';
						break;

					case '906789':
						$piRegion = 'AU';
						break;

					default:
						$piRegion = 'Unknown';
						break;
				}


             } else {

            error_log('Unable to load Pardot URL: ' . $afc_pardot_link);

        }

    } else {

        error_log('Invalid Pardot host: ' . $host);

    }

}

?>
<?php if ( $is_preview ) : ?>
<div class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success m-5 text-capitalize ">
  <div class="p-2"> <?php echo $block['title']; ?><Br>Region: <?php echo $piRegion ?> || Campaign ID:<?php echo $piCId; ?></div>
	</div>
<?php endif; ?>





<div class="position-relative">

  <img
    src="<?php echo get_template_directory_uri(); ?>/assets/images/background-blue.svg"
    alt=""
    class="position-absolute"
    style="z-index: 0; max-width: 900px;  left: -400px !important;  top: -255 !important;"
  >
<div class="position-relative z-1">

		<div class="hero-with-form">
			<div class="row g-4 mb-1 align-items-center">
				<div class="col-lg-6">

                       <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mri-logo.svg" alt="Logo" width="120" height="auto" class="mb-3"	>

					<?php if ( $afc_hero_h1 ) : ?>
						<h1 class="display-5 fw-semibold mb-3"><?php echo esc_html( $afc_hero_h1 ); ?></h1>
					<?php endif; ?>

					<?php if ( $afc_header_text ) : ?>
						<div class="lead my-4 MRI-blue fw-semibold"><?php echo wp_kses_post( wpautop( $afc_header_text ) ); ?></div>
					<?php endif; ?>

					<?php if ( ! empty( $afc_hero_bullets ) ) : ?>
						<div class="row">
							<?php foreach ( $afc_hero_bullets as $bullet ) : ?>
								<?php
								$afc_bullet_text = isset( $bullet['hero_bullets_text'] ) ? $bullet['hero_bullets_text'] : '';
								if ( '' === trim( wp_strip_all_tags( $afc_bullet_text ) ) ) {
									continue;
								}
								?>
								<div class="col my-2">
									<ul class="custom-list">
   									 <li class="MRI-blue">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="MRI-greenlight-bg" class="MRI-greenlight-bg bi bi-check-circle-fill flex-shrink-0" viewBox="0 0 16 16">
										<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
									</svg>
									<?php echo nl2br( esc_html( $afc_bullet_text ) ); ?>
									    </li>
									</ul>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="col-lg-6">
					<div class="card shadow-sm border-0 mri-ligh-blue-bg">
						<div class="card-body p-md-5 ">
							<?php if ( $afc_pardot_header ) : ?>
								<div class="mb-3 hero-form-title"><h3 class="MRI-blue fw-normal"><?php echo wp_kses_post( $afc_pardot_header ); ?></h3></div>
							<?php endif; ?>

							<?php if ( $afc_pardot_link ) : ?>



								<iframe title="Pardot Form" class="pardotform" src="<?php echo esc_url( $afc_pardot_link ); ?>" width="100%" height="500" type="text/html" frameborder="0" allowtransparency="true" style="border: 0px; overflow: hidden; height: 240px;" id="iFrameResizer0" scrolling="no"></iframe>

							<?php endif; ?>



							<?php if ( $afc_pardot_footer ) : ?>
								<div class="mt-3 small text-muted text-center"><?php echo wp_kses_post( $afc_pardot_footer ); ?>
							</div>
							<div class="mt-3 small text-muted text-start">
								<p><small><strong>Terms of use</strong><br>
								By clicking submit, I acknowledge MRI Software’s Privacy Policy.</small></p>
							</div>

							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
 </div>

</div>
