<?php
/**
 * MRI Card Grid block template.
 *
 * @package Pardot-boostrap
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

$shared_fields = pardot_boostrap_get_shared_block_fields( 'mri_card_grid', $block );
$heading       = $shared_fields['heading'];
$subheading    = $shared_fields['subheading'];
$content       = $shared_fields['content'];
$button_link   = $shared_fields['button_link'];
$cards = pardot_boostrap_get_block_field_value( $block, 'mri_card_grid_items' );

if ( ! is_array( $cards ) ) {
  $cards = array();
}

$block_id = pardot_boostrap_setup_block_id_and_preview( $block, $is_preview, 'mri-card-grid' );
?>


<section id="<?php echo esc_attr( $block_id ); ?>" class="py-2 mri-card-grid-block position-relative">
  <div class="position-relative z-1">
    <div class="row mb-4">
      <div class="col-12">
        <?php if ( ! empty( $subheading ) ) : ?>
          <p class="eyebrow mb-1"><?php echo esc_html( $subheading ); ?></p>
        <?php endif; ?>

        <h2 class="mb-3"><?php echo esc_html( $heading ); ?></h2>

        <?php if ( ! empty( $content ) ) : ?>
          <div class="lead mb-0"><?php echo wp_kses_post( wpautop( $content ) ); ?></div>
        <?php endif; ?>
      </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-4">
      <?php foreach ( $cards as $card ) : ?>
        <?php
        $title = isset( $card['title'] ) ? $card['title'] : '';
        $text  = isset( $card['text'] ) ? $card['text'] : '';
        $kicker = isset( $card['kicker'] ) ? $card['kicker'] : '';
        $button_text = isset( $card['button_text'] ) ? $card['button_text'] : '';
        $link  = isset( $card['primary_link'] ) ? $card['primary_link'] : '';
        $image = isset( $card['image'] ) ? pardot_boostrap_get_image_with_placeholder( $card['image'], $title ) : pardot_boostrap_get_image_with_placeholder( null, $title );

        $has_card_content = pardot_boostrap_value_has_content( $title )
          || pardot_boostrap_value_has_content( $text )
          || pardot_boostrap_value_has_content( $kicker )
          || pardot_boostrap_value_has_content( $link );

        $has_card_image = isset( $card['image'] ) && pardot_boostrap_value_has_content( $card['image'] );

        if ( ! $has_card_content && ! $has_card_image ) {
          continue;
        }
        ?>
        <div class="col mb-4">
          <div class="card h-100 mri-card-grid-card">
            <?php if ( ! empty( $image['url'] ) ) : ?>
              <img
                src="<?php echo esc_url( $image['url'] ); ?>"
                class="card-img-top mri-card-grid-image"
                alt="<?php echo esc_attr( ! empty( $image['alt'] ) ? $image['alt'] : $title ); ?>" />
            <?php endif; ?>

            <div class="card-body mri-card-grid-body">
              <p class="mri-card-grid-kicker mb-1"><?php echo esc_html( $kicker ); ?></p>
              <h5 class="card-title mri-card-grid-title"><?php echo esc_html( $title ); ?></h5>
              <?php if ( ! empty( $text ) ) : ?>
                <p class="card-text mri-card-grid-text"><?php echo esc_html( $text ); ?></p>
              <?php endif; ?>
            </div>

            <div class="card-footer p-3 px-md-4 mt-3">
              <?php if ( ! empty( $link ) ) : ?>
                <a href="<?php echo esc_url( $link ); ?>" class="green-link">
                  <?php echo esc_html( $button_text ); ?> <i class="bi bi-chevron-right" aria-hidden="true"></i>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

 
  </div>
</section>






