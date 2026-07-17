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
        <a href="<?php echo esc_url( home_url( '/smart-tech/' ) ); ?>">Smart Tech</a>
        <a href="<?php echo esc_url( home_url( '/cleaning-odor/' ) ); ?>">Cleaning & Odor</a>
        <a href="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>">Services & Insurance</a>
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
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
          <polyline points="9 22 9 12 15 12 15 22"></polyline>
        </svg>
        PetHome<span>Scout</span>
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
          // Fallback static list matching prototype hierarchy
          ?>
          <ul>
            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="active">Home</a></li>
            <li><a href="<?php echo esc_url( home_url( '/family-home/' ) ); ?>">Family Home</a></li>
            <li><a href="<?php echo esc_url( home_url( '/smart-tech/' ) ); ?>">Smart Tech</a></li>
            <li><a href="<?php echo esc_url( home_url( '/cleaning-odor/' ) ); ?>">Cleaning & Odor</a></li>
            <li><a href="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>">Services & Insurance</a></li>
          </ul>
          <?php
        }
        ?>
      </nav>

      <div class="header-actions">
        <a href="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>" class="btn btn-secondary">Preview service flow</a>
        <a href="<?php echo esc_url( home_url( '/pet-tech-selector/' ) ); ?>" class="btn btn-primary">Use selector</a>
      </div>
    </div>
  </header>

  <?php if ( '' !== $pethomescout_body_path ) : ?>
    <span id="main-content" tabindex="-1"></span>
  <?php endif; ?>
