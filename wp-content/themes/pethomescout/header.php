<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

  <?php wp_body_open(); ?>

  <!-- Top Utility Bar -->
  <div class="top-bar">
    <div class="container top-bar-container">
      <div class="top-bar-left">
        <?php bloginfo('name'); ?> &bull; INDEPENDENT PET TECHNOLOGY AUTHORITY
      </div>
      <div class="top-bar-right">
        <a href="<?php echo esc_url( home_url( '/smart-tech/' ) ); ?>">Reviews</a>
        <a href="<?php echo esc_url( home_url( '/best-robot-vacuum-for-dog-hair/' ) ); ?>">Buying Guides</a>
        <a href="<?php echo esc_url( home_url( '/tool/' ) ); ?>">Product Database</a>
        <a href="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>">Deals</a>
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
      
      <nav>
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
        <a href="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>" class="btn btn-secondary">Get Quotes</a>
        <a href="#newsletter-signup" class="btn btn-primary">Newsletter</a>
      </div>
    </div>
  </header>
