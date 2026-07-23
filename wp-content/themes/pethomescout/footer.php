  <!-- Premium Footer -->
  <footer>
    <div class="container">
      <div class="footer-columns">
        <div class="footer-col">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" style="color:#fff;">
            <img class="brand-logo brand-logo-footer" src="<?php echo esc_url( get_template_directory_uri() . '/assets/pethomescout-logo-v2.png' ); ?>" alt="PetHomeScout">
          </a>
          <p class="footer-desc">Evidence-labeled guidance for pet hair, odor and stain decisions in homes with dogs and cats.</p>
        </div>
        <div class="footer-col">
          <h2 class="footer-heading">Clean Pet Home</h2>
          <ul>
            <li><a href="<?php echo esc_url( home_url( '/pet-hair-cleaning/' ) ); ?>">Pet Hair Cleaning</a></li>
            <li><a href="<?php echo esc_url( home_url( '/pet-odor-stain-removal/' ) ); ?>">Odor &amp; Stain Removal</a></li>
            <li><a href="<?php echo esc_url( home_url( '/cleaning-odor/' ) ); ?>">Product Guides</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h2 class="footer-heading">Decision Tools</h2>
          <ul>
            <li><a href="<?php echo esc_url( home_url( '/pet-home-cleaning-selector/' ) ); ?>">Cleaning System Selector</a></li>
            <li><a href="<?php echo esc_url( home_url( '/how-we-test/' ) ); ?>">How We Test</a></li>
            <li><a href="<?php echo esc_url( home_url( '/evidence-standards/' ) ); ?>">Evidence Standards</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h2 class="footer-heading">PetHomeScout</h2>
          <?php if ( has_nav_menu( 'footer' ) ) : ?>
            <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'menu_class' => '', 'items_wrap' => '<ul>%3$s</ul>', 'fallback_cb' => false ) ); ?>
          <?php else : ?>
          <ul>
            <li><a href="<?php echo esc_url( home_url( '/how-we-test/' ) ); ?>">About Our Evidence</a></li>
            <li><a href="<?php echo esc_url( home_url( '/how-we-test/' ) ); ?>">How Evidence Works</a></li>
            <li><a href="<?php echo esc_url( home_url( '/affiliate-disclosure/' ) ); ?>">Affiliate Disclosure</a></li>
            <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></li>
            <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a></li>
            <li><a href="<?php echo esc_url( home_url( '/do-not-sell-or-share/' ) ); ?>" style="font-size: 11px; color: var(--accent);">Do Not Sell or Share My Personal Information</a></li>
          </ul>
          <?php endif; ?>
        </div>
      </div>
      <div class="footer-bottom">
        <p class="copyright">&copy; <?php echo date('Y'); ?> PetHomeScout.com. All rights reserved.</p>
        <p class="footer-disclaimer">Disclaimer: PetHomeScout.com may participate in affiliate marketing programs. Commercial pathways use internal <code>/go/</code> placeholders until approved partner destinations are configured.</p>
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
