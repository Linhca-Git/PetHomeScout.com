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
          <p class="footer-desc">Providing transparent, data-driven decisions and reviews to help pet owners build happier, cleaner, and safer homes.</p>
        </div>
        <div class="footer-col">
          <h4>Expertise Hubs</h4>
          <ul>
            <li><a href="<?php echo esc_url( home_url( '/family-home/' ) ); ?>">Family Home</a></li>
            <li><a href="<?php echo esc_url( home_url( '/smart-tech/' ) ); ?>">Smart Tech</a></li>
            <li><a href="<?php echo esc_url( home_url( '/cleaning-odor/' ) ); ?>">Cleaning & Odor</a></li>
            <li><a href="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>">Services & Insurance</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Decision Tools</h4>
          <ul>
            <li><a href="<?php echo esc_url( home_url( '/tool/' ) ); ?>">Vacuum Matchmaker</a></li>
            <li><a href="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>">Pet Insurance Finder</a></li>
            <li><a href="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>">Grooming & Care Quote</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>PetHomeScout</h4>
          <ul>
            <li><a href="#">About Our Tests</a></li>
            <li><a href="#">How We Rate</a></li>
            <li><a href="<?php echo esc_url( home_url( '/best-robot-vacuum-for-dog-hair/' ) ); ?>">Affiliate Disclosure</a></li>
            <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact Us</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#" style="font-size: 11px; color: var(--accent);">Do Not Sell or Share My Personal Information</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p class="copyright">&copy; <?php echo date('Y'); ?> PetHomeScout.com. All rights reserved.</p>
        <p style="font-size:12px; color:#64748b;">Disclaimer: PetHomeScout.com is a participant in affiliate marketing programs, designed to provide a means for sites to earn advertising fees by linking to partner sites. Internal links are processed securely via internal tracking headers.</p>
      </div>
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
