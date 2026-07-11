<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<footer class="site-footer">
	<div class="container">
		<div class="footer-grid">
			<div><h2>PetHomeScout</h2><p>Practical product research and service guides for cleaner, safer, pet-friendly homes.</p></div>
			<div><h3>Explore</h3><?php wp_nav_menu( array( 'theme_location' => 'footer', 'fallback_cb' => 'pethomescout_footer_fallback', 'container' => false ) ); ?></div>
			<div><h3>Trust &amp; policies</h3><p><a href="<?php echo esc_url( home_url( '/affiliate-disclosure/' ) ); ?>">Affiliate disclosure</a><br><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy policy</a><br><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact PetHomeScout</a></p></div>
		</div>
		<div class="footer-bottom"><span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> PetHomeScout.com</span><span>Editorial guidance, not financial, medical, or insurance advice.</span></div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
