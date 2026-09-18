<?php
/**
 * MRI HR Divider block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-hr-div' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="mri-hr-div position-relative">
  <div class="position-relative z-1">
    <div class="row">
      <div class="col-12">
        <hr class="hr-gradient" />
      </div>
    </div>
  </div>
</section>


