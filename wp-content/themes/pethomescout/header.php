<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<?php
$pethomescout_body_path         = function_exists( 'pethomescout_current_path' ) ? pethomescout_current_path() : '';
$pethomescout_body_path_parts   = array_values( array_filter( explode( '/', $pethomescout_body_path ) ) );
$pethomescout_body_content_type = '' === $pethomescout_body_path ? 'home' : ( $pethomescout_body_path_parts[0] ?? 'page' );
if ( 'go' === $pethomescout_body_content_type ) {
  $pethomescout_body_content_type = 'affiliate_pathway';
}
?>
<body <?php body_class(); ?> data-content-type="<?php echo esc_attr( $pethomescout_body_content_type ); ?>">

  <?php wp_body_open(); ?>

  <a class="skip-link" href="#main-content">Skip to main content</a>

  <!-- Top Utility Bar -->
  <div class="top-bar">
    <div class="container top-bar-container">
      <div class="top-bar-left">
        <?php bloginfo('name'); ?> &bull; INDEPENDENT GUIDANCE FOR PET-FRIENDLY HOMES
      </div>
      <div class="top-bar-right">
        <a href="<?php echo esc_url( home_url( '/pet-hair-cleaning/' ) ); ?>">Pet Hair</a>
        <a href="<?php echo esc_url( home_url( '/pet-odor-stain-removal/' ) ); ?>">Odor &amp; Stains</a>
        <a href="<?php echo esc_url( home_url( '/how-we-test/' ) ); ?>">How We Test</a>
        <div class="country-selector">
          <span style="font-size:14px;">🇺🇸</span>
          <span>United States (USD)</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Redesigned Sticky Header -->
  <header>
    <div class="container header-container">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
        <img class="brand-logo" src="<?php echo esc_url( get_template_directory_uri() . '/assets/pethomescout-logo-v2.png' ); ?>" alt="PetHomeScout">
      </a>
      
      <nav aria-label="Primary navigation">
        <?php
        if ( has_nav_menu( 'primary' ) ) {
          wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => '',
            'items_wrap'     => '<ul>%3$s</ul>',
            'fallback_cb'    => false,
          ) );
        } else {
          // Narrow Phase 1 fallback. Future hubs remain in the data model only.
          ?>
          <ul>
            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="active">Home</a></li>
            <li><a href="<?php echo esc_url( home_url( '/pet-hair-cleaning/' ) ); ?>">Pet Hair</a></li>
            <li><a href="<?php echo esc_url( home_url( '/pet-odor-stain-removal/' ) ); ?>">Odor &amp; Stains</a></li>
            <li><a href="<?php echo esc_url( home_url( '/cleaning-odor/' ) ); ?>">Product Guides</a></li>
            <li><a href="<?php echo esc_url( home_url( '/how-we-test/' ) ); ?>">How We Test</a></li>
          </ul>
          <?php
        }
        ?>
      </nav>

      <div class="header-actions">
        <a href="<?php echo esc_url( home_url( '/how-we-test/' ) ); ?>" class="btn btn-secondary">Evidence standards</a>
        <a href="<?php echo esc_url( home_url( '/pet-home-cleaning-selector/' ) ); ?>" class="btn btn-primary">Use selector</a>
      </div>
    </div>
  </header>

  <?php if ( '' !== $pethomescout_body_path ) : ?>
    <span id="main-content" tabindex="-1"></span>
  <?php endif; ?>
