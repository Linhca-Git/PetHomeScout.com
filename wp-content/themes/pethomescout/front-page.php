<?php
/**
 * Phase 1 homepage: broad brand, narrow public launch.
 *
 * @package PetHomeScout
 */

get_header();
?>

<main id="main-content">
  <section class="hero-split">
    <div class="container hero-grid">
      <div class="hero-left">
        <span class="tool-badge">CLEAN PET HOME</span>
        <h1>Find the right solution for pet hair, odor and stains.</h1>
        <p class="lead">Evidence-led product guides and practical cleaning decisions for U.S. homes with dogs and cats.</p>
        <div class="hero-cta-row" aria-label="Homepage actions">
          <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/pet-hair-cleaning/' ) ); ?>">Solve pet hair &rarr;</a>
          <a class="btn btn-secondary" href="<?php echo esc_url( home_url( '/pet-odor-stain-removal/' ) ); ?>">Remove odor &amp; stains</a>
        </div>
        <div class="trust-badges-row" aria-label="Editorial standards">
          <div class="trust-badge-item">Independent and research-first</div>
          <div class="trust-badge-item">Evidence status shown clearly</div>
          <div class="trust-badge-item">Commercial relationships disclosed</div>
        </div>
      </div>

      <aside class="editors-pick-card" aria-labelledby="phase-one-title">
        <div class="ep-content-area">
          <span class="ep-tag-badge">Phase 1 focus</span>
          <h2 id="phase-one-title" class="ep-title">A cleaner home, one decision at a time</h2>
          <p class="ep-desc">Start with the problem in your home. We connect practical guidance to the right product category without unsupported scores or fake testing.</p>
          <a class="btn btn-primary" href="<?php echo esc_url( home_url( '/cleaning-odor/' ) ); ?>">Explore Clean Pet Home &rarr;</a>
        </div>
      </aside>
    </div>
  </section>

  <section class="featured-tools-section" aria-labelledby="start-here-title">
    <div class="container">
      <div class="section-header">
        <span class="eyebrow">START WITH YOUR PROBLEM</span>
        <h2 id="start-here-title">Focused guidance for cleaner pet homes</h2>
        <p>Phase 1 covers two closely related household problems so every guide strengthens the same topic.</p>
      </div>
      <div class="tools-grid">
        <a class="tool-banner-card" href="<?php echo esc_url( home_url( '/pet-hair-cleaning/' ) ); ?>">
          <span class="tool-banner-icon" aria-hidden="true">1</span>
          <h3>Pet Hair Cleaning</h3>
          <p>Robot vacuums, carpet performance, heavy shedding, hair wrap and practical maintenance.</p>
          <span class="btn-tool-banner">Explore pet-hair guides &rarr;</span>
        </a>
        <a class="tool-banner-card" href="<?php echo esc_url( home_url( '/pet-odor-stain-removal/' ) ); ?>">
          <span class="tool-banner-icon" aria-hidden="true">2</span>
          <h3>Odor &amp; Stain Removal</h3>
          <p>Carpet cleaners, enzyme cleaners and step-by-step decisions for persistent pet messes.</p>
          <span class="btn-tool-banner">Explore odor guides &rarr;</span>
        </a>
        <a class="tool-banner-card" href="<?php echo esc_url( home_url( '/pet-home-cleaning-selector/' ) ); ?>">
          <span class="tool-banner-icon" aria-hidden="true">3</span>
          <h3>Cleaning System Selector</h3>
          <p>Match pet type, shedding, flooring and the problem you need to solve. No personal data required.</p>
          <span class="btn-tool-banner">Use the selector &rarr;</span>
        </a>
        <a class="tool-banner-card" href="<?php echo esc_url( home_url( '/how-we-test/' ) ); ?>">
          <span class="tool-banner-icon" aria-hidden="true">4</span>
          <h3>How We Evaluate</h3>
          <p>See our evidence labels, limitations and the rules that prevent unsupported recommendations.</p>
          <span class="btn-tool-banner">Read our standards &rarr;</span>
        </a>
      </div>
    </div>
  </section>

  <section class="trust-section">
    <div class="container">
      <div class="section-header">
        <span class="eyebrow">NO FAKE PROOF</span>
        <h2>Research-led until real testing exists</h2>
        <p>We label manufacturer claims, published specifications and founder-tested evidence separately. Scores remain hidden when the evidence is insufficient.</p>
      </div>
    </div>
  </section>
</main>

<?php get_footer(); ?>
