<?php
/**
 * MRI Footer block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$policy_text = pardot_boostrap_get_block_field_value( $block, 'mri_footer_policy_text' );
$company_text = pardot_boostrap_get_block_field_value( $block, 'mri_footer_company_text' );
$logo_image = pardot_boostrap_get_block_field_value( $block, 'mri_footer_logo_image' );
$logo_alt = pardot_boostrap_get_block_field_value( $block, 'mri_footer_logo_alt' );

if ( empty( $policy_text ) ) {
  $policy_text = 'Privacy Policy (Americas) | Terms of Use OnLocation | Terms Sitemap | Cookies | Don\'t Sell My Personal Info';
}

if ( empty( $company_text ) ) {
  $company_text = "© 2027 MRI Software LLC - All Rights Reserved.\nMRI Software LLC is a registered ISO of Wells Fargo Bank, N.A., Concord, CA.";
}

if ( empty( $logo_image ) || ! is_array( $logo_image ) || empty( $logo_image['url'] ) ) {
  $logo_image = array(
    'url' => get_template_directory_uri() . '/assets/images/MRI_Software_logo-Bs31PHGw.svg',
    'alt' => 'MRI Software',
  );
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-footer' );
?>


<footer id="<?php echo esc_attr( $block_id ); ?>" class="app-footer position-relative">
  <div class="position-relative z-1">
    <div class="row g-3 align-items-start align-items-md-center">
      <div class="col-12 col-md-8">
        <p>
          <small><?php echo esc_html( $policy_text ); ?></small>
        </p>
        <p>
          <small><?php echo nl2br( esc_html( $company_text ) ); ?></small>
        </p>
      </div>
      <div class="col-12 col-md-4 text-md-end">
        <img
          src="<?php echo esc_url( $logo_image['url'] ); ?>"
          alt="<?php echo esc_attr( ! empty( $logo_alt ) ? $logo_alt : $logo_image['alt'] ); ?>"
          class="MRILogo mri-logo--small" />
      </div>
    </div>
  </div>
</footer>




