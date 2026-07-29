<?php
/**
 * The template for displaying the Homepage (front-page.php)
 *
 * @package PetHomeScout
 */

get_header();
$home_values = pethomescout_home_values();
?>

  <main id="main-content">
  <section class="hero-split">
    <div class="container hero-grid">
      <!-- Hero Left (Text & CTAs) -->
      <div class="hero-left">
        <span class="tool-badge" style="background-color: var(--primary-light); color: var(--primary); margin-bottom: 16px;"><?php echo esc_html( $home_values['eyebrow'] ); ?></span>
        <h1 style="font-family: var(--font-display); font-size: 52px; font-weight: 700; line-height: 1.2; letter-spacing: 0; margin-bottom: 20px;"><?php echo esc_html( $home_values['title'] ); ?></h1>
        <p class="lead"><?php echo esc_html( $home_values['intro'] ); ?></p>
        <div class="hero-cta-row" aria-label="Homepage actions">
          <a class="btn btn-primary" href="<?php echo esc_url( $home_values['primary_url'] ); ?>"><?php echo esc_html( $home_values['primary_label'] ); ?> &rarr;</a>
          <a class="btn btn-secondary" href="<?php echo esc_url( $home_values['secondary_url'] ); ?>"><?php echo esc_html( $home_values['secondary_label'] ); ?></a>
        </div>
        
        <!-- Smart Filter Search Bar Widget (App style) -->
        <div class="smart-search-widget">
          <div class="widget-header">
            <span>⚙️ Decision Engine Matchmaker</span>
            <p>Find the best pet tech & services for your home specs</p>
          </div>
          <div class="widget-inputs-grid">
            <div class="widget-select-group">
              <label for="select-category">I need recommendations for:</label>
              <select id="select-category" class="widget-select">
                <option value="<?php echo esc_url( home_url( '/best-robot-vacuum-for-dog-hair/' ) ); ?>">Robot Vacuums</option>
                <option value="<?php echo esc_url( home_url( '/smart-tech/' ) ); ?>">Pet Cameras & GPS</option>
                <option value="<?php echo esc_url( home_url( '/cleaning-odor/' ) ); ?>">HEPA Filters & Cleaners</option>
                <option value="<?php echo esc_url( home_url( '/family-home/' ) ); ?>">Gates & Scratch Safety</option>
                <option value="<?php echo esc_url( home_url( '/services-insurance/' ) ); ?>">Insurance & Vets</option>
              </select>
            </div>
            <div class="widget-select-group">
              <label for="select-challenge">My main pet challenge is:</label>
              <select id="select-challenge" class="widget-select">
                <option value="husky">Husky / Heavy Shedding Hair</option>
                <option value="dander">Dander & Air Allergens</option>
                <option value="odor">Wet Dog & Litter Odors</option>
                <option value="scratch">Claw Scratches & Chewing</option>
                <option value="budget">Cost of Emergency Care</option>
              </select>
            </div>
          </div>
          <button type="button" class="btn-widget-search" onclick="handleWidgetSearch()">Find My Best Match &rarr;</button>
        </div>

        <div class="trust-badges-row">
          <div class="trust-badge-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
            </svg>
            Independent & Research-First
          </div>
          <div class="trust-badge-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            </svg>
            Evidence Labels on Every Recommendation
          </div>
          <div class="trust-badge-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="12" y1="16" x2="12" y2="12"></line>
              <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            Commercial Relationships Disclosed
          </div>
        </div>
      </div>

      <!-- Hero Right (Product Highlight Card) -->
      <div class="hero-right">
        <?php
        // Prefer an editor-selected guide; retain the legacy meta query as a
        // safe fallback for existing preview fixtures.
        $featured_guide_id = absint( pethomescout_editorial_field( 'home_featured_guide', 0, 0 ) );
        $featured_query_args = $featured_guide_id ? array(
          'post__in'       => array( $featured_guide_id ),
          'posts_per_page' => 1,
          'post_status'    => 'publish',
        ) : array(
          'posts_per_page' => 1,
          'meta_key'       => 'hero_featured_pick',
          'meta_value'     => '1',
        );
        $featured_pick = new WP_Query( $featured_query_args );

        if ( $featured_pick->have_posts() ) : $featured_pick->the_post();
          $evidence = pethomescout_get_product_evidence( get_the_ID() );
          $scout_score = $evidence['score'];
          $card_desc   = get_post_meta( get_the_ID(), 'card_description', true );
          $has_publishable_score = $evidence['publishable_score'];
        ?>
          <div class="editors-pick-card">
            <span class="ep-tag-badge">Featured Guide</span>
            
            <!-- Card Left (Content) -->
            <div class="ep-content-area">
              <span class="ep-category">Robot Vacuums</span>
              <h2 class="ep-title"><?php the_title(); ?></h2>
              <p class="ep-desc"><?php echo esc_html( $card_desc ? $card_desc : wp_trim_words(get_the_excerpt(), 15) ); ?></p>
              
              <div class="ep-score-block">
                <div class="ep-score-value">
                  <?php echo esc_html( $has_publishable_score ? $scout_score : 'Pending' ); ?>
                  <?php if ( $has_publishable_score ) : ?><span class="ep-score-max">/10</span><?php endif; ?>
                </div>
                <div class="ep-score-label">PetHome ScoutScore</div>
              </div>

          <a href="<?php echo esc_url( get_permalink() ); ?>" class="btn btn-primary" style="padding: 10px 20px; font-size: 13px; margin-top: auto; align-self: flex-start;">View Guide &rarr;</a>
            </div>

            <!-- Card Right (Image & Badges) -->
            <div class="ep-right-area">
              <div class="ep-product-image">
                <!-- Friendly robot vacuum illustration -->
                <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <ellipse cx="70" cy="118" rx="45" ry="8" fill="rgba(0,0,0,0.06)"/>
                  <circle cx="70" cy="80" r="42" fill="#f0f7ff" stroke="var(--primary)" stroke-width="2.5"/>
                  <ellipse cx="64" cy="62" rx="22" ry="10" fill="rgba(255,255,255,0.6)" transform="rotate(-15 64 62)"/>
                  <rect x="56" y="45" width="28" height="10" rx="5" fill="var(--primary)" opacity="0.9"/>
                  <circle cx="70" cy="50" r="3.5" fill="white"/>
                  <circle cx="58" cy="72" r="3" fill="#16A34A"/>
                  <circle cx="70" cy="72" r="3" fill="var(--primary)" opacity="0.5"/>
                  <circle cx="82" cy="72" r="3" fill="#f59e0b" opacity="0.7"/>
                  <g transform="translate(108, 100)" fill="var(--accent)" opacity="0.3">
                    <ellipse cx="7" cy="10" rx="5" ry="6"/>
                    <circle cx="2" cy="4" r="2.5"/>
                    <circle cx="7" cy="2" r="2.5"/>
                    <circle cx="12" cy="4" r="2.5"/>
                  </g>
                </svg>
              </div>
              <div class="ep-badges-column">
                <div class="ep-badge-item">
                  <span class="ep-badge-icon">🐾</span>
                  <div class="ep-badge-text">
                    <strong>Designed for</strong>
                    <span>Pet Homes</span>
                  </div>
                </div>
                <div class="ep-badge-item">
                  <span class="ep-badge-icon">🏆</span>
                  <div class="ep-badge-text">
                    <strong>Research-led</strong>
                    <span>2026</span>
                  </div>
                </div>
                <div class="ep-badge-item">
                  <span class="ep-badge-icon">🔄</span>
                  <div class="ep-badge-text">
                    <strong>Recently</strong>
                    <span>Updated</span>
                  </div>
                </div>
              </div>
            </div>

          </div>
        <?php else : ?>
          <!-- Fallback static mock card if no post is configured in WP dashboard -->
          <div class="editors-pick-card">
            <span class="ep-tag-badge">Research Fixture</span>
            <div class="ep-content-area">
              <span class="ep-category">Robot Vacuums</span>
              <h2 class="ep-title">Roborock Q Revo MaxV</h2>
              <p class="ep-desc">A research-led fixture for comparing double-coat hair pickup, dock upkeep, and obstacle-avoidance tradeoffs.</p>
              <div class="ep-score-block">
                <div class="ep-score-value">Pending</div>
                <div class="ep-score-label">PetHome ScoutScore</div>
              </div>
              <a href="<?php echo esc_url( home_url('/best-robot-vacuum-for-dog-hair/') ); ?>" class="btn btn-primary" style="padding: 10px 20px; font-size: 13px; margin-top: auto; align-self: flex-start;">View Guide &rarr;</a>
            </div>
            <div class="ep-right-area">
              <div class="ep-product-image">
                <svg width="140" height="140" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <ellipse cx="70" cy="118" rx="45" ry="8" fill="rgba(0,0,0,0.06)"/>
                  <circle cx="70" cy="80" r="42" fill="#f0f7ff" stroke="var(--primary)" stroke-width="2.5"/>
                  <ellipse cx="64" cy="62" rx="22" ry="10" fill="rgba(255,255,255,0.6)" transform="rotate(-15 64 62)"/>
                  <rect x="56" y="45" width="28" height="10" rx="5" fill="var(--primary)" opacity="0.9"/>
                  <circle cx="70" cy="50" r="3.5" fill="white"/>
                  <circle cx="58" cy="72" r="3" fill="#16A34A"/>
                  <circle cx="70" cy="72" r="3" fill="var(--primary)" opacity="0.5"/>
                  <circle cx="82" cy="72" r="3" fill="#f59e0b" opacity="0.7"/>
                  <g transform="translate(108, 100)" fill="var(--accent)" opacity="0.3">
                    <ellipse cx="7" cy="10" rx="5" ry="6"/>
                    <circle cx="2" cy="4" r="2.5"/>
                    <circle cx="7" cy="2" r="2.5"/>
                    <circle cx="12" cy="4" r="2.5"/>
                  </g>
                </svg>
              </div>
              <div class="ep-badges-column">
                <div class="ep-badge-item">
                  <span class="ep-badge-icon">🐾</span>
                  <div class="ep-badge-text">
                    <strong>Designed for</strong>
                    <span>Pet Homes</span>
                  </div>
                </div>
                <div class="ep-badge-item">
                  <span class="ep-badge-icon">🏆</span>
                  <div class="ep-badge-text">
                    <strong>Research-led</strong>
                    <span>Fixture</span>
                  </div>
                </div>
                <div class="ep-badge-item">
                  <span class="ep-badge-icon">🔄</span>
                  <div class="ep-badge-text">
                    <strong>Recently</strong>
                    <span>Updated</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; wp_reset_postdata(); ?>

        <!-- Cozy Pet Lifestyle Illustration Card -->
        <div class="pet-lifestyle-card" style="margin-top: 24px; background: linear-gradient(135deg, #fffcf9 0%, #fffbf2 100%); border: 1px solid rgba(251, 191, 36, 0.2); border-radius: var(--radius-lg); padding: 20px; box-shadow: var(--shadow-sm); display: flex; align-items: center; gap: 16px;">
          <div style="flex-shrink: 0; background: #fff; border-radius: var(--radius-md); padding: 4px; box-shadow: var(--shadow-sm); border: 1px solid var(--border-color); display: flex; align-items: center;">
            <svg width="120" height="90" viewBox="0 0 120 90" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect width="120" height="90" rx="6" fill="#fdfbf7"/>
              <path d="M0 65h120" stroke="#f1f5f9" stroke-width="2"/>
              <path d="M0 65v25h120V65z" fill="#FAF7F2"/>
              <ellipse cx="60" cy="74" rx="40" ry="10" fill="#fef08a" opacity="0.4"/>
              <rect x="8" y="32" width="6" height="12" rx="1" fill="#b45309"/>
              <path d="M5 32c-3-6 0-12 6-12s8 6 5 12z" fill="#10b981" opacity="0.8"/>
              <path d="M11 32c3-6 0-12-6-12s-8 6-5 12z" fill="#047857" opacity="0.9"/>
              <path d="M26 58h68v12H26z" fill="#334155"/>
              <path d="M26 38h8v20h-8zM86 38h8v20h-8z" fill="#475569"/>
              <path d="M34 32h52v26H34z" fill="#1e293b"/>
              <rect x="38" y="44" width="10" height="10" rx="1" fill="#f43f5e" transform="rotate(15 38 44)" opacity="0.8"/>
              <rect x="72" y="44" width="10" height="10" rx="1" fill="#3b82f6" transform="rotate(-15 72 44)" opacity="0.8"/>
              <path d="M52 52c0-3 3-5 6-5s6 2 6 5z" fill="#fdba74"/>
              <circle cx="55" cy="50" r="1.5" fill="#f97316"/>
              <path d="M60 52a4 4 0 0 1 4 4" stroke="#f97316" stroke-width="1.5" stroke-linecap="round"/>
              <g transform="translate(74, 52)">
                <path d="M12 18c0-4 3-7 7-7s7 3 7 7v10h-14V18z" fill="#f59e0b"/>
                <circle cx="19" cy="9" r="6" fill="#f59e0b"/>
                <path d="M14 9q0-4-3-3t-1 6" stroke="#d97706" stroke-width="2"/>
                <circle cx="17" cy="8" r="1" fill="#fff"/>
                <circle cx="17" cy="8" r="0.5" fill="#000"/>
                <ellipse cx="22" cy="11" rx="3" ry="2" fill="#d97706"/>
                <circle cx="23" cy="10" r="1" fill="#000"/>
                <path d="M22 13v2" stroke="#f43f5e" stroke-width="1.5" stroke-linecap="round"/>
                <path d="M10 24q-5-5-2-10" stroke="#f59e0b" stroke-width="3" stroke-linecap="round"/>
              </g>
              <ellipse cx="28" cy="78" rx="8" ry="3" fill="#e2e8f0" stroke="#3b82f6" stroke-width="1"/>
              <circle cx="28" cy="77" r="1.5" fill="#16A34A"/>
            </svg>
          </div>
          <div>
            <div class="mini-card-title" style="font-family: var(--font-ui); font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 4px;">Clear Evidence Labels</div>
            <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.4; margin: 0;">Each recommendation identifies whether it is founder-tested, research-led, or based on published specifications.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Warm Social Proof Ribbon -->
  <div class="warm-ribbon">
    <div class="container warm-ribbon-inner">
      <div class="warm-ribbon-item">
        <span class="warm-ribbon-emoji">🐾</span>
        <div>
          <strong>Research-first</strong>
          <span>No fake reader counts</span>
        </div>
      </div>
      <div class="warm-ribbon-divider"></div>
      <div class="warm-ribbon-item">
        <span class="warm-ribbon-emoji">🏠</span>
        <div>
          <strong>Documented testing</strong>
          <span>Only where documented</span>
        </div>
      </div>
      <div class="warm-ribbon-divider"></div>
      <div class="warm-ribbon-item">
        <span class="warm-ribbon-emoji">⭐</span>
        <div>
          <strong>Transparent</strong>
          <span>Affiliate relationships disclosed</span>
        </div>
      </div>
      <div class="warm-ribbon-divider"></div>
      <div class="warm-ribbon-item">
        <span class="warm-ribbon-emoji">🔬</span>
        <div>
          <strong>Data-Driven</strong>
          <span>No Paid Rankings, Ever</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Explore Categories Section -->
  <section class="categories-slider-section">
    <div class="container">
      <div class="section-title-area" style="margin-bottom: 24px; display:flex; justify-content:space-between; align-items:flex-end;">
        <h2 style="font-family: var(--font-display); font-size: 30px;">Explore Categories</h2>
        <span style="font-size: 13px; color: var(--text-light); font-weight:600; cursor:pointer;">Scroll Horizontal &rarr;</span>
      </div>

      <div class="categories-slider-outer" style="position: relative;">
        <button class="slider-arrow slider-arrow-left" type="button" onclick="scrollSlider(-220)" aria-label="Scroll left">&lsaquo;</button>
        
        <div class="categories-slider-wrapper" id="categories-slider">
          <!-- 1. Robot Vacuums -->
          <div class="category-pill-card" data-href="<?php echo esc_url( home_url('/smart-tech/') ); ?>">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 2v4M12 18v4M2 12h4M18 12h4"></path>
                <circle cx="12" cy="12" r="2.5" fill="currentColor"></circle>
                <circle cx="9" cy="9.5" r="1" fill="currentColor"></circle>
                <circle cx="12" cy="8.5" r="1" fill="currentColor"></circle>
                <circle cx="15" cy="9.5" r="1" fill="currentColor"></circle>
              </svg>
            </div>
            <span>Robot Vacuums</span>
            <p>Smarter cleaning for pets</p>
          </div>

          <!-- 2. Pet Tech -->
          <div class="category-pill-card" data-href="<?php echo esc_url( home_url('/smart-tech/') ); ?>">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 20h18l-1.5-6h-15z"></path>
                <path d="M9 16h6" stroke-width="2"></path>
                <circle cx="8" cy="15" r="1.5" fill="currentColor"></circle>
                <circle cx="8" cy="17" r="1.5" fill="currentColor"></circle>
                <circle cx="16" cy="15" r="1.5" fill="currentColor"></circle>
                <circle cx="16" cy="17" r="1.5" fill="currentColor"></circle>
              </svg>
            </div>
            <span>Pet Tech</span>
            <p>Care & fun for your pets</p>
          </div>

          <!-- 3. Smart Home -->
          <div class="category-pill-card" data-href="<?php echo esc_url( home_url('/family-home/') ); ?>">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <circle cx="12" cy="13.5" r="2" fill="currentColor"></circle>
                <circle cx="9.5" cy="10.5" r="1" fill="currentColor"></circle>
                <circle cx="12" cy="9.5" r="1" fill="currentColor"></circle>
                <circle cx="14.5" cy="10.5" r="1" fill="currentColor"></circle>
              </svg>
            </div>
            <span>Smart Home</span>
            <p>Safety & comfort for pet homes</p>
          </div>

          <!-- 4. Security Cameras -->
          <div class="category-pill-card" data-href="<?php echo esc_url( home_url('/smart-tech/') ); ?>">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                <circle cx="12" cy="13" r="4"></circle>
                <path d="M19 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" fill="currentColor"></path>
              </svg>
            </div>
            <span>Pet Cameras</span>
            <p>Protect what matters most</p>
          </div>

          <!-- 5. Wearables -->
          <div class="category-pill-card" data-href="<?php echo esc_url( home_url('/smart-tech/') ); ?>">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="9.5" r="2.2" fill="currentColor"></circle>
                <circle cx="9.5" cy="7" r="1" fill="currentColor"></circle>
                <circle cx="12" cy="6" r="1" fill="currentColor"></circle>
                <circle cx="14.5" cy="7" r="1" fill="currentColor"></circle>
              </svg>
            </div>
            <span>GPS Trackers</span>
            <p>Track health, live better</p>
          </div>

          <!-- 6. Grooming Tools -->
          <div class="category-pill-card" data-href="<?php echo esc_url( home_url('/cleaning-odor/') ); ?>">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 16h12a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H6a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3z"></path>
                <path d="M9 16l-4 4"></path>
                <line x1="6" y1="8" x2="6" y2="12"></line>
                <line x1="9" y1="8" x2="9" y2="12"></line>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="15" y1="8" x2="15" y2="12"></line>
                <line x1="18" y1="8" x2="18" y2="12"></line>
              </svg>
            </div>
            <span>Grooming Tech</span>
            <p>Hair & odor control</p>
          </div>

          <!-- 7. Pet Insurance -->
          <div class="category-pill-card" data-href="<?php echo esc_url( home_url('/services-insurance/') ); ?>">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                <path d="M12 14.5c-.8 0-1.5-.7-1.5-1.5 0-1.5 1.5-3 1.5-3s1.5 1.5 1.5 3c0 .8-.7 1.5-1.5 1.5z" fill="currentColor"></path>
              </svg>
            </div>
            <span>Pet Insurance</span>
            <p>Compare coverage factors</p>
          </div>

          <!-- 8. Local Services -->
          <div class="category-pill-card" data-href="<?php echo esc_url( home_url('/services-insurance/') ); ?>">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12l9-9 9 9M5 10v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V10"></path>
                <path d="M9 22v-6a3 3 0 0 1 6 0v6"></path>
              </svg>
            </div>
            <span>Dog Services</span>
            <p>Grooming & sitters</p>
          </div>
        </div>
        
        <button class="slider-arrow slider-arrow-right" type="button" onclick="scrollSlider(220)" aria-label="Scroll right">&rsaquo;</button>
      </div>
    </div>
  </section>

  <!-- Featured Selector Tools Section (Decision Engines) -->
  <section class="featured-tools-section">
    <div class="container">
      <div style="margin-bottom: 32px; display:flex; justify-content:space-between; align-items:flex-end;">
        <h2 style="font-family: var(--font-display); font-size: 30px;">Interactive Decision Tools</h2>
        <p style="color:var(--text-muted); font-size:14px; max-width: 500px; text-align: right;">Use our custom-engineered selector algorithms to find products matching your household specs.</p>
      </div>

      <div class="tools-grid">
        <div class="tool-banner-card" data-href="<?php echo esc_url( home_url('/pet-tech-selector/') ); ?>">
          <div class="tool-banner-icon">🤖</div>
          <h3 style="font-family: var(--font-ui);">Vacuum Matchmaker</h3>
          <p>Input your house size, pet shedding levels, and flooring types to preview research-led product matches.</p>
          <span class="btn-tool-banner">Launch Matchmaker &rarr;</span>
        </div>

        <div class="tool-banner-card" data-href="<?php echo esc_url( home_url('/services-insurance/') ); ?>">
          <div class="tool-banner-icon">🛡️</div>
          <h3 style="font-family: var(--font-ui);">Insurance Matcher</h3>
          <p>Review the factors that affect pet insurance pricing before using a future quote-comparison flow.</p>
          <span class="btn-tool-banner">Preview Flow &rarr;</span>
        </div>

        <div class="tool-banner-card" data-href="<?php echo esc_url( home_url('/services-insurance/') ); ?>">
          <div class="tool-banner-icon">📍</div>
          <h3 style="font-family: var(--font-ui);">Local Service Finder</h3>
          <p>Learn what to compare when evaluating local groomers, sitters, and pet-care providers.</p>
          <span class="btn-tool-banner">Compare Options &rarr;</span>
        </div>

        <div class="tool-banner-card" data-href="<?php echo esc_url( home_url('/family-home/') ); ?>">
          <div class="tool-banner-icon">🛋️</div>
          <h3 style="font-family: var(--font-ui);">Scratch-Safety Selector</h3>
          <p>Select durable fabrics and protection plans to defend your sofas and hardwood floors from cat and dog claws.</p>
          <span class="btn-tool-banner">Browse Materials &rarr;</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Research Fixtures Grid Section -->
  <section class="editors-picks-section">
    <div class="container">
      <div class="section-title-area" style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom: 32px;">
        <h2 style="font-family: var(--font-display); font-size: 30px;">Research Fixtures</h2>
        <a href="<?php echo esc_url( home_url('/best-robot-vacuum-for-dog-hair/') ); ?>" style="font-size:14px; font-weight:600;">View fixture guide &rarr;</a>
      </div>

      <div class="editors-picks-grid">
        <?php
        // Prefer editor-curated product records, then retain the safe legacy query fallback.
        $home_featured_products = pethomescout_editorial_field( 'home_featured_products', 0, array() );
        $home_featured_products = is_array( $home_featured_products ) ? array_values( array_filter( array_map( 'absint', $home_featured_products ) ) ) : array();
        $picks = new WP_Query( $home_featured_products ? array(
          'post_type'      => 'pet_product',
          'post__in'       => $home_featured_products,
          'orderby'        => 'post__in',
          'posts_per_page' => count( $home_featured_products ),
          'post_status'    => 'publish',
        ) : array(
          'post_type'      => 'pet_product',
          'posts_per_page' => 4,
          'meta_key'       => 'pick_card_index',
          'orderby'        => 'meta_value_num',
          'order'          => 'ASC'
        ) );

        $fallback_picks = array(
          array(
            'title' => 'Roborock Q Revo MaxV',
            'cat' => 'Robot Vacuums',
            'score' => 'Pending',
            'desc' => 'A leading research-led robot vacuum match for dog hair, mixed floors, and dock automation.',
            'link' => home_url('/best-robot-vacuum-for-dog-hair/')
          ),
          array(
            'title' => 'Furbo 360 Dog Camera',
            'cat' => 'Pet Tech',
            'score' => 'Pending',
            'desc' => 'Research-led notes on pet-camera features such as panning, treat workflows, and alert settings.',
            'link' => home_url('/smart-tech/')
          ),
          array(
            'title' => 'Aqara Smart Lock U100',
            'cat' => 'Smart Home',
            'score' => 'Pending',
            'desc' => 'Research-led notes on smart-lock access features, temporary codes, and pet-care routines.',
            'link' => home_url('/family-home/')
          ),
          array(
            'title' => 'Whistle Fit Tracker',
            'cat' => 'Wearables',
            'score' => 'Pending',
            'desc' => 'Research-led notes on activity, comfort, and location-tracking tradeoffs.',
            'link' => home_url('/smart-tech/')
          )
        );

        $index = 1;
        if ( $picks->have_posts() ) : while ( $picks->have_posts() ) : $picks->the_post();
          $evidence = pethomescout_get_product_evidence( get_the_ID() );
          $score = $evidence['score'];
          $has_publishable_score = $evidence['publishable_score'];
          $category = get_post_meta( get_the_ID(), 'product_category_label', true );
          $desc = get_post_meta( get_the_ID(), 'card_description', true );
        ?>
          <div class="pick-card" data-href="<?php echo esc_url( get_permalink() ); ?>">
            <div class="pick-index-badge"><?php echo $index++; ?></div>
            <div class="pick-image-container">
              <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="1.5">
                <circle cx="12" cy="12" r="9"></circle>
              </svg>
                <span class="pick-score-badge"><?php echo esc_html( $has_publishable_score ? $score . ' SCORE' : 'Pending score' ); ?></span>
            </div>
            <div class="pick-body">
              <span class="pick-category"><?php echo esc_html( $category ); ?></span>
              <h3 class="pick-title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h3>
              <p class="pick-desc"><?php echo esc_html( $desc ); ?></p>
            </div>
          </div>
        <?php endwhile; else : ?>
          <?php foreach ( $fallback_picks as $pick ) : ?>
            <div class="pick-card" data-href="<?php echo esc_url( $pick['link'] ); ?>">
              <div class="pick-index-badge"><?php echo $index++; ?></div>
              <div class="pick-image-container">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="1.5">
                  <circle cx="12" cy="12" r="9"></circle>
                </svg>
                <span class="pick-score-badge"><?php echo esc_html( is_numeric( $pick['score'] ) ? $pick['score'] . ' SCORE' : 'Pending score' ); ?></span>
              </div>
              <div class="pick-body">
                <span class="pick-category"><?php echo esc_html( $pick['cat'] ); ?></span>
                <h3 class="pick-title"><a href="<?php echo esc_url( $pick['link'] ); ?>"><?php echo esc_html( $pick['title'] ); ?></a></h3>
                <p class="pick-desc"><?php echo esc_html( $pick['desc'] ); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; wp_reset_postdata(); ?>
      </div>
    </div>
  </section>

  <!-- Three-column Info Feed Section -->
  <section class="three-col-feed-section">
    <div class="container">
      <div class="three-col-grid">
        
        <!-- Column 1: Latest Guides -->
        <div class="feed-column">
          <h3 class="feed-column-title">
            Latest Guides
            <a href="<?php echo esc_url( home_url('/smart-tech/') ); ?>">View all &rarr;</a>
          </h3>
          <div class="feed-list">
            <?php
            $reviews = new WP_Query( array(
              'category_name'  => 'reviews',
              'posts_per_page' => 3
            ) );

            if ( $reviews->have_posts() ) : while ( $reviews->have_posts() ) : $reviews->the_post();
          $evidence = pethomescout_get_product_evidence( get_the_ID() );
          $score = $evidence['score'];
          $has_publishable_score = $evidence['publishable_score'];
            ?>
              <div class="feed-item-card" data-href="<?php echo esc_url( get_permalink() ); ?>">
                <div class="feed-item-img">🐾</div>
                <div class="feed-item-info">
                  <div class="feed-item-meta">
                    <span><?php echo get_the_date('M d, Y'); ?></span>
                    <span style="font-weight:700; color:var(--success);">Evidence: <?php echo esc_html( $has_publishable_score ? 'Scored' : 'Pending' ); ?></span>
                  </div>
                  <h4 class="feed-item-title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h4>
                  <p style="font-size:12px; color:var(--text-muted);"><?php echo wp_trim_words( get_the_excerpt(), 8 ); ?></p>
                </div>
              </div>
            <?php endwhile; else : ?>
              <?php foreach ( array(
                array( 'date' => 'June 1, 2026', 'score' => 'Pending', 'title' => 'Eufy X10 Pro Omni Guide Notes', 'desc' => 'Research-led notes on mapping, dock workflow, and pet-hair cleanup factors.', 'link' => home_url('/best-robot-vacuum-for-dog-hair/') ),
                array( 'date' => 'May 28, 2026', 'score' => 'Pending', 'title' => 'Pet Camera Decision Notes', 'desc' => 'Research-led considerations for monitoring pets while away.', 'link' => home_url('/smart-tech/') ),
                array( 'date' => 'May 20, 2026', 'score' => 'Pending', 'title' => 'GPS Collar Research Notes', 'desc' => 'Research-led notes on activity and location tracking tradeoffs.', 'link' => home_url('/smart-tech/') ),
              ) as $review ) : ?>
                <div class="feed-item-card" data-href="<?php echo esc_url( $review['link'] ); ?>">
                  <div class="feed-item-img">○</div>
                  <div class="feed-item-info">
                    <div class="feed-item-meta"><span><?php echo esc_html( $review['date'] ); ?></span><span style="font-weight:700; color:var(--success);">Evidence: <?php echo esc_html( is_numeric( $review['score'] ) ? 'Scored' : 'Pending' ); ?></span></div>
                    <h4 class="feed-item-title"><a href="<?php echo esc_url( $review['link'] ); ?>"><?php echo esc_html( $review['title'] ); ?></a></h4>
                    <p style="font-size:12px; color:var(--text-muted);"> <?php echo esc_html( $review['desc'] ); ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; wp_reset_postdata(); ?>
          </div>
        </div>

        <!-- Column 2: Buying Guides -->
        <div class="feed-column">
          <h3 class="feed-column-title">
            Buying Guides
            <a href="<?php echo esc_url( home_url('/best-robot-vacuum-for-dog-hair/') ); ?>">View all &rarr;</a>
          </h3>
          <div class="feed-list">
            <?php
            $guides = new WP_Query( array(
              'category_name'  => 'buying-guides',
              'posts_per_page' => 3
            ) );

            if ( $guides->have_posts() ) : while ( $guides->have_posts() ) : $guides->the_post();
            ?>
              <div class="feed-item-card" data-href="<?php echo esc_url( get_permalink() ); ?>">
                <div class="feed-item-img">📖</div>
                <div class="feed-item-info">
                  <div class="feed-item-meta">
                    <span><?php echo get_the_date('M d, Y'); ?></span>
                  </div>
                  <h4 class="feed-item-title"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h4>
                  <p style="font-size:12px; color:var(--text-muted);"><?php echo wp_trim_words( get_the_excerpt(), 8 ); ?></p>
                </div>
              </div>
            <?php endwhile; else : ?>
              <?php foreach ( array(
                array( 'date' => 'July 2026 Update', 'title' => 'Best Robot Vacuums for Pet Hair', 'desc' => 'Research-led picks by floor type, hair level, and household friction.', 'link' => home_url('/best-robot-vacuum-for-dog-hair/') ),
                array( 'date' => 'June 2026 Update', 'title' => 'Pet Camera Buying Questions', 'desc' => 'What to compare before choosing a camera for dogs or cats.', 'link' => home_url('/smart-tech/') ),
                array( 'date' => 'May 2026 Update', 'title' => 'Smart Pet Home Starter Guide', 'desc' => 'How to prioritize automation without overbuying devices.', 'link' => home_url('/smart-tech/') ),
              ) as $guide ) : ?>
                <div class="feed-item-card" data-href="<?php echo esc_url( $guide['link'] ); ?>">
                  <div class="feed-item-img">○</div>
                  <div class="feed-item-info">
                    <div class="feed-item-meta"><span><?php echo esc_html( $guide['date'] ); ?></span></div>
                    <h4 class="feed-item-title"><a href="<?php echo esc_url( $guide['link'] ); ?>"><?php echo esc_html( $guide['title'] ); ?></a></h4>
                    <p style="font-size:12px; color:var(--text-muted);"> <?php echo esc_html( $guide['desc'] ); ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; wp_reset_postdata(); ?>
          </div>
        </div>

        <!-- Column 3: Comparisons -->
        <div class="feed-column">
          <h3 class="feed-column-title">
            Comparisons
            <a href="<?php echo esc_url( home_url('/smart-tech/') ); ?>">View all vs &rarr;</a>
          </h3>
          <div class="feed-list">
            <?php
            $comparisons = new WP_Query( array(
              'category_name'  => 'comparisons',
              'posts_per_page' => 3
            ) );

            if ( $comparisons->have_posts() ) : while ( $comparisons->have_posts() ) : $comparisons->the_post();
              $p1 = get_post_meta( get_the_ID(), 'comparison_product_1', true );
              $p2 = get_post_meta( get_the_ID(), 'comparison_product_2', true );
            ?>
              <div class="vs-row-item" data-href="<?php echo esc_url( get_permalink() ); ?>">
                <div class="vs-product">
                  <div class="vs-product-thumb">🤖</div>
                  <span><?php echo esc_html($p1 ? $p1 : 'Product A'); ?></span>
                </div>
                <span class="vs-divider">VS</span>
                <div class="vs-product">
                  <div class="vs-product-thumb">🤖</div>
                  <span><?php echo esc_html($p2 ? $p2 : 'Product B'); ?></span>
                </div>
              </div>
            <?php endwhile; else : ?>
              <?php foreach ( array(
                array( 'a' => 'Roborock Q Revo', 'b' => 'Roomba j9+', 'icon' => '🤖' ),
                array( 'a' => 'Furbo 360', 'b' => 'Eufy Pet Cam', 'icon' => '📷' ),
                array( 'a' => 'Aqara U100', 'b' => 'Yale Assure L2', 'icon' => '🔒' ),
              ) as $comparison ) : ?>
                <div class="vs-row-item" data-href="<?php echo esc_url( home_url('/best-robot-vacuum-for-dog-hair/') ); ?>">
                  <div class="vs-product"><div class="vs-product-thumb"><?php echo esc_html( $comparison['icon'] ); ?></div><span><?php echo esc_html( $comparison['a'] ); ?></span></div>
                  <span class="vs-divider">VS</span>
                  <div class="vs-product"><div class="vs-product-thumb"><?php echo esc_html( $comparison['icon'] ); ?></div><span><?php echo esc_html( $comparison['b'] ); ?></span></div>
                </div>
              <?php endforeach; ?>
            <?php endif; wp_reset_postdata(); ?>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Editorial Trust Bar -->
  <section class="trust-bar">
    <div class="container">
      <div class="trust-bar-grid">
        <div class="trust-bar-item">
          <div class="trust-bar-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
              <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
          </div>
          <div class="trust-bar-info">
            <div class="trust-bar-title" style="font-family: var(--font-ui);">Evidence-Labeled Guidance</div>
            <p>Founder-tested appears only where a completed rubric exists.</p>
          </div>
        </div>
        <div class="trust-bar-item">
          <div class="trust-bar-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
          </div>
          <div class="trust-bar-info">
            <div class="trust-bar-title" style="font-family: var(--font-ui);">Clear & Honest Reviews</div>
            <p>Pros, cons, evidence status, and limitations you need.</p>
          </div>
        </div>
        <div class="trust-bar-item">
          <div class="trust-bar-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="2" y1="12" x2="22" y2="12"></line>
              <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
            </svg>
          </div>
          <div class="trust-bar-info">
            <div class="trust-bar-title" style="font-family: var(--font-ui);">United States Focused</div>
            <p>Guidance is written for US products, services, and household terms.</p>
          </div>
        </div>
        <div class="trust-bar-item">
          <div class="trust-bar-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="12" y1="16" x2="12" y2="12"></line>
              <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
          </div>
          <div class="trust-bar-info">
            <div class="trust-bar-title" style="font-family: var(--font-ui);">Affiliate Transparency</div>
            <p>We earn a small commission from partner store links.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter signup strip -->
  <section class="newsletter-strip" id="newsletter-signup">
    <div class="container">
      <div class="newsletter-container">
        <div class="newsletter-info">
          <div class="newsletter-title" style="font-family: var(--font-ui);">Newsletter preview</div>
          <p>Email capture is disabled in the MVP until consent, delivery, and unsubscribe handling are ready.</p>
        </div>
        <form class="newsletter-form" onsubmit="event.preventDefault(); this.reset();" aria-label="Newsletter preview form">
          <input type="email" aria-label="Newsletter email preview" placeholder="Email disabled in MVP" disabled>
          <button type="submit" disabled>Coming later</button>
        </form>
      </div>
    </div>
  </section>
  </main>

  <script>
    function scrollSlider(amount) {
      const container = document.getElementById('categories-slider');
      if (container) {
        container.scrollBy({ left: amount, behavior: 'smooth' });
      }
    }

    function handleWidgetSearch() {
      const selector = document.getElementById('select-category');
      const category = selector ? selector.value : '';
      if (category) {
        window.location.href = category;
      }
    }
  </script>

<?php
get_footer();
