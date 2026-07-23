<?php
get_header();
$is_odor_pillar = 'pet-odor-stain-removal' === pethomescout_current_path();
$hub = $is_odor_pillar
	? pethomescout_hub_values( 'Odor & stain pillar', 'Pet Odor & Stain Removal', 'Compare practical product workflows for pet accidents, carpet stains, and persistent household odor.' )
	: pethomescout_hub_values( 'Clean Pet Home', 'Cleaner pet homes start with the problem.', 'Choose the focused Phase 1 path that matches pet hair, odor, or stains in your home.' );
$featured_products = pethomescout_hub_products( get_the_ID() );
$featured_guides   = pethomescout_editorial_field( 'featured_guides', get_the_ID(), array() );
$featured_guides   = is_array( $featured_guides ) ? array_filter( array_map( 'absint', $featured_guides ) ) : array();
?>
<main class="hub-page">
  <section class="hub-hero"><div class="container"><span class="eyebrow"><?php echo esc_html( $hub['eyebrow'] ); ?></span><h1><?php echo esc_html( $hub['title'] ); ?></h1><p><?php echo esc_html( $hub['intro'] ); ?></p><div class="affiliate-disclosure-box"><strong>Affiliate disclosure:</strong> Merchant buttons remain disabled until approved partner destinations are configured. PetHomeScout may earn compensation when approved commercial links go live.</div></div></section>

  <?php if ( ! $is_odor_pillar ) : ?>
  <section class="section"><div class="container"><div class="section-label"><span>Choose your cleaning path</span></div><div class="hub-guide-grid">
    <article class="hub-guide-card"><span class="hub-guide-number">01</span><span class="tag">Pet hair</span><h2>Control pet hair on floors and carpet</h2><p>Start with shedding level, flooring, hair wrap, and maintenance burden.</p><a href="/pet-hair-cleaning/">Explore pet hair cleaning →</a></article>
    <article class="hub-guide-card"><span class="hub-guide-number">02</span><span class="tag">Odor &amp; stains</span><h2>Handle pet odor and accident cleanup</h2><p>Compare spot-cleaning, enzyme, and carpet-care workflows without unsupported claims.</p><a href="/pet-odor-stain-removal/">Explore odor &amp; stain removal →</a></article>
    <article class="hub-guide-card"><span class="hub-guide-number">03</span><span class="tag">Decision tool</span><h2>Build a cleaning sequence</h2><p>Use household conditions to identify a practical category and next guide.</p><a href="/pet-home-cleaning-selector/">Use the cleaning selector →</a></article>
    <article class="hub-guide-card"><span class="hub-guide-number">04</span><span class="tag">Evidence</span><h2>See how guidance is evaluated</h2><p>Understand evidence labels, testing limits, and what remains unverified.</p><a href="/how-we-test/">Review how we test →</a></article>
  </div></div></section>
  <?php else : ?>
  <section class="section"><div class="container">
    <div class="filter-bar" data-hub-filter><button class="is-active" type="button" data-filter="all">All odor &amp; stain gear</button><button type="button" data-filter="carpet">Carpet washers</button><button type="button" data-filter="odor">Odor control</button></div>
    <div class="family-home-layout"><aside class="filter-panel"><h2>Filter options</h2><label><input type="checkbox" value="carpet" data-filter-category checked> Carpet care</label><label><input type="checkbox" value="odor" data-filter-category checked> Enzyme cleaners</label></aside>
      <div><div class="section-label"><span>Odor &amp; stain product paths</span></div>
        <?php if ( ! empty( $featured_products ) ) : foreach ( $featured_products as $product_id ) : ?>
          <?php if ( 'air' === sanitize_key( (string) pethomescout_editorial_field( 'product_category', $product_id, '' ) ) ) { continue; } ?>
          <?php get_template_part( 'template-parts/cards/hub-product', null, array( 'product_id' => $product_id, 'icon' => '◌', 'comparison_url' => home_url( '/pet-odor-stain-removal/' ), 'service_url' => '' ) ); ?>
        <?php endforeach; elseif ( ! empty( $featured_guides ) ) : foreach ( $featured_guides as $guide_id ) : $guide = get_post( $guide_id ); if ( ! $guide ) { continue; } $evidence = pethomescout_get_product_evidence( $guide_id ); ?>
          <article class="family-product-card" data-product-tags="all odor" data-product-category="guide"><div class="family-product-art" aria-hidden="true">◌</div><div><span class="tag">Curated guide</span><span class="tag"><?php echo esc_html( $evidence['status'] ); ?></span><h2><?php echo esc_html( get_the_title( $guide_id ) ); ?></h2><p><?php echo esc_html( wp_trim_words( get_the_excerpt( $guide_id ), 28 ) ); ?></p><div class="buy-box"><a class="button button-secondary" href="<?php echo esc_url( get_permalink( $guide_id ) ); ?>">Read guide</a></div></div></article>
        <?php endforeach; else : ?>
          <article class="family-product-card" data-product-tags="all carpet odor" data-product-category="carpet"><div class="family-product-art">◌</div><div><span class="tag">Research fixture</span><span class="tag">Pet stain care</span><h2>Carpet spot-cleaning workflow</h2><p>A research placeholder for comparing spot treatment, extraction, and cleanup burden. No product recommendation is active.</p><div class="spec-grid"><span>Evidence <b>Research-led</b></span><span>Commercial action <b>Disabled</b></span></div><div class="buy-box"><button type="button" disabled aria-disabled="true">Merchant pending</button></div></div></article>
        <?php endif; ?>
      </div>
    </div>
  </div></section>
  <section class="section"><div class="container trust-section-inline"><span class="dashicons dashicons-admin-tools"></span><div><h2>Continue with a product workflow.</h2><p>Professional service matching remains inactive until a buyer, coverage, consent language, and routing process are verified.</p><div class="button-row"><a class="button button-secondary" href="/pet-home-cleaning-selector/">Use the cleaning selector</a><a class="button button-secondary" href="/how-we-test/">Review evidence rules</a></div></div></div></section>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
