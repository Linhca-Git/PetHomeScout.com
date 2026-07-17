  <!-- Premium Footer -->
  <footer>
    <div class="container">
      <div class="footer-columns">
        <div class="footer-col">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo" style="color:#fff;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="stroke:#fff; fill: var(--primary);">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
              <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            PetHome<span style="color:var(--accent);">Scout</span>
          </a>
          <p class="footer-desc">Providing transparent, evidence-labeled guidance to help pet owners build happier, cleaner, and safer homes.</p>
        </div>
        <div class="footer-col">
          <h2 class="footer-heading">Expertise Hubs</h2>
          <ul>
            <li><a href="<?php echo esc_url( home_url( '/family-home/' ) ); ?>">Family Home</a></li>
            <li><a href="<?php echo esc_url( home_url( '/smart-tech/' ) ); ?>">Smart Tech</a></li>
            <li><a href="<?php echo esc_url( home_url( '/cleaning-odor/' ) ); ?>">Cleaning & Odor</a></li>
            <li><a href="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>">Services & Insurance</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h2 class="footer-heading">Decision Tools</h2>
          <ul>
            <li><a href="<?php echo esc_url( home_url( '/pet-tech-selector/' ) ); ?>">Pet Tech Selector</a></li>
            <li><a href="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>">Pet Insurance Preview</a></li>
            <li><a href="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>">Grooming & Care Checklist</a></li>
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
