<?php
/**
 * The template for displaying the Homepage (front-page.php)
 *
 * @package PetHomeScout
 */

get_header();
?>

  <section class="hero-split">
    <div class="container hero-grid">
      <!-- Hero Left (Text & CTAs) -->
      <div class="hero-left">
        <span class="tool-badge" style="background-color: var(--primary-light); color: var(--primary); margin-bottom: 16px;">AMERICA'S INDEPENDENT PET TECH AUTHORITY</span>
        <h1 style="font-family: var(--font-display); font-size: 52px; font-weight: 700; line-height: 1.2; letter-spacing: 0; margin-bottom: 20px;">Make <span style="color: var(--primary);">Smarter</span> Choices.<br>Build a <span style="color: var(--primary);">Better</span> Pet Home.</h1>
        <p class="lead">Independent, data-driven reviews and interactive tools to help pet parents build a cleaner, safer, and happier home environment.</p>
        
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
            Tested in Real American Homes
          </div>
          <div class="trust-badge-item">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"></circle>
              <line x1="12" y1="16" x2="12" y2="12"></line>
              <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            Transparent Affiliate Disclosure
          </div>
        </div>
      </div>

      <!-- Hero Right (Product Highlight Card) -->
      <div class="hero-right">
        <?php
        // Dynamically query the current featured Editor's Pick
        $featured_pick = new WP_Query( array(
          'posts_per_page' => 1,
          'meta_key'       => 'hero_featured_pick',
          'meta_value'     => '1'
        ) );

        if ( $featured_pick->have_posts() ) : $featured_pick->the_post();
          $scout_score = get_post_meta( get_the_ID(), 'scout_score', true );
          $card_desc   = get_post_meta( get_the_ID(), 'card_description', true );
        ?>
          <div class="editors-pick-card">
            <span class="ep-tag-badge">Editor's Pick</span>
            
            <!-- Card Left (Content) -->
            <div class="ep-content-area">
              <span class="ep-category">Robot Vacuums</span>
              <h3 class="ep-title"><?php the_title(); ?></h3>
              <p class="ep-desc"><?php echo esc_html( $card_desc ? $card_desc : wp_trim_words(get_the_excerpt(), 15) ); ?></p>
              
              <div class="ep-score-block">
                <div class="ep-score-value"><?php echo esc_html( $scout_score ? $scout_score : '9.4' ); ?><span class="ep-score-max">/10</span></div>
                <div class="ep-score-label">PetHome ScoutScore</div>
              </div>

              <a href="<?php the_permalink(); ?>" class="btn btn-primary" style="padding: 10px 20px; font-size: 13px; margin-top: auto; align-self: flex-start;">Read Review &rarr;</a>
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
                    <strong>Best for</strong>
                    <span>Pet Owners</span>
                  </div>
                </div>
                <div class="ep-badge-item">
                  <span class="ep-badge-icon">🏆</span>
                  <div class="ep-badge-text">
                    <strong>Top Rated</strong>
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
            <span class="ep-tag-badge">Editor's Pick</span>
            <div class="ep-content-area">
              <span class="ep-category">Robot Vacuums</span>
              <h3 class="ep-title">Roborock Q Revo MaxV</h3>
              <p class="ep-desc">The ultimate automated vacuum for double-coat hair extraction and pet waste avoidance.</p>
              <div class="ep-score-block">
                <div class="ep-score-value">9.4<span class="ep-score-max">/10</span></div>
                <div class="ep-score-label">PetHome ScoutScore</div>
              </div>
              <a href="<?php echo esc_url( home_url('/best-robot-vacuum-for-dog-hair/') ); ?>" class="btn btn-primary" style="padding: 10px 20px; font-size: 13px; margin-top: auto; align-self: flex-start;">Read Review &rarr;</a>
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
                    <strong>Best for</strong>
                    <span>Pet Owners</span>
                  </div>
                </div>
                <div class="ep-badge-item">
                  <span class="ep-badge-icon">🏆</span>
                  <div class="ep-badge-text">
                    <strong>Top Rated</strong>
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
            <h4 style="font-family: var(--font-ui); font-size: 15px; font-weight: 700; color: var(--text-main); margin-bottom: 4px;">Tested in Real Homes</h4>
            <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.4; margin: 0;">Every review and rating is backed by hands-on testing in active household environments with real pets.</p>
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
          <strong>87,000+</strong>
          <span>Pet Families Helped</span>
        </div>
      </div>
      <div class="warm-ribbon-divider"></div>
      <div class="warm-ribbon-item">
        <span class="warm-ribbon-emoji">🏠</span>
        <div>
          <strong>Real Home Testing</strong>
          <span>Across 12 US States</span>
        </div>
      </div>
      <div class="warm-ribbon-divider"></div>
      <div class="warm-ribbon-item">
        <span class="warm-ribbon-emoji">⭐</span>
        <div>
          <strong>4.9 / 5.0</strong>
          <span>Average Reader Rating</span>
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
        <button class="slider-arrow slider-arrow-left" onclick="scrollSlider(-220)" aria-label="Scroll left">&lsaquo;</button>
        
        <div class="categories-slider-wrapper" id="categories-slider">
          <!-- 1. Robot Vacuums -->
          <div class="category-pill-card" onclick="location.href='<?php echo esc_url( home_url('/smart-tech/') ); ?>'">
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
          <div class="category-pill-card" onclick="location.href='<?php echo esc_url( home_url('/smart-tech/') ); ?>'">
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
          <div class="category-pill-card" onclick="location.href='<?php echo esc_url( home_url('/family-home/') ); ?>'">
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
          <div class="category-pill-card" onclick="location.href='<?php echo esc_url( home_url('/smart-tech/') ); ?>'">
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
          <div class="category-pill-card" onclick="location.href='<?php echo esc_url( home_url('/smart-tech/') ); ?>'">
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
          <div class="category-pill-card" onclick="location.href='<?php echo esc_url( home_url('/cleaning-odor/') ); ?>'">
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
          <div class="category-pill-card" onclick="location.href='<?php echo esc_url( home_url('/services-insurance/') ); ?>'">
            <div class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                <path d="M12 14.5c-.8 0-1.5-.7-1.5-1.5 0-1.5 1.5-3 1.5-3s1.5 1.5 1.5 3c0 .8-.7 1.5-1.5 1.5z" fill="currentColor"></path>
              </svg>
            </div>
            <span>Pet Insurance</span>
            <p>Compare custom rates</p>
          </div>

          <!-- 8. Local Services -->
          <div class="category-pill-card" onclick="location.href='<?php echo esc_url( home_url('/services-insurance/') ); ?>'">
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
        
        <button class="slider-arrow slider-arrow-right" onclick="scrollSlider(220)" aria-label="Scroll right">&rsaquo;</button>
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
        <div class="tool-banner-card" onclick="location.href='<?php echo esc_url( home_url('/tool/') ); ?>'">
          <div class="tool-banner-icon">🤖</div>
          <h3 style="font-family: var(--font-ui);">Vacuum Matchmaker</h3>
          <p>Input your house size, pet shedding levels, and flooring types to get real-time ScoutScores for top vacuums.</p>
          <span class="btn-tool-banner">Launch Matchmaker &rarr;</span>
        </div>

        <div class="tool-banner-card" onclick="location.href='<?php echo esc_url( home_url('/services-insurance/') ); ?>'">
          <div class="tool-banner-icon">🛡️</div>
          <h3 style="font-family: var(--font-ui);">Insurance Matcher</h3>
          <p>Generate real-time policy premium estimates from Embrace, Lemonade, and Pumpkin pet coverage programs.</p>
          <span class="btn-tool-banner">Calculate Rates &rarr;</span>
        </div>

        <div class="tool-banner-card" onclick="location.href='<?php echo esc_url( home_url('/services-insurance/') ); ?>'">
          <div class="tool-banner-icon">📍</div>
          <h3 style="font-family: var(--font-ui);">Local Service Finder</h3>
          <p>Find background-checked dog walkers, pet boarding sitters, and professional groomers in your zip code.</p>
          <span class="btn-tool-banner">Find Services &rarr;</span>
        </div>

        <div class="tool-banner-card" onclick="location.href='<?php echo esc_url( home_url('/family-home/') ); ?>'">
          <div class="tool-banner-icon">🛋️</div>
          <h3 style="font-family: var(--font-ui);">Scratch-Safety Selector</h3>
          <p>Select durable fabrics and protection plans to defend your sofas and hardwood floors from cat and dog claws.</p>
          <span class="btn-tool-banner">Browse Materials &rarr;</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Editor's Picks Grid Section -->
  <section class="editors-picks-section">
    <div class="container">
      <div class="section-title-area" style="display:flex; justify-content:space-between; align-items:flex-end; margin-bottom: 32px;">
        <h2 style="font-family: var(--font-display); font-size: 30px;">Editor's Picks</h2>
        <a href="<?php echo esc_url( home_url('/best-robot-vacuum-for-dog-hair/') ); ?>" style="font-size:14px; font-weight:600;">View all editor's picks &rarr;</a>
      </div>

      <div class="editors-picks-grid">
        <?php
        // Query the top 4 products
        $picks = new WP_Query( array(
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
            'score' => '9.4',
            'desc' => 'The absolute best robot vacuum tested for dog hair detangling and corner sweeps.',
            'link' => home_url('/best-robot-vacuum-for-dog-hair/')
          ),
          array(
            'title' => 'Furbo 360 Dog Camera',
            'cat' => 'Pet Tech',
            'score' => '8.9',
            'desc' => 'Best pet camera with automatic panning, treat-tossing, and dynamic bark alerts.',
            'link' => home_url('/smart-tech/')
          ),
          array(
            'title' => 'Aqara Smart Lock U100',
            'cat' => 'Smart Home',
            'score' => '8.8',
            'desc' => 'Highly secure entry system supporting Apple Home Keys and temporary dog-walker codes.',
            'link' => home_url('/family-home/')
          ),
          array(
            'title' => 'Whistle Fit Tracker',
            'cat' => 'Wearables',
            'score' => '8.6',
            'desc' => 'Premium dog fitness tracker offering metrics on sleep patterns, scratching, and heart rates.',
            'link' => home_url('/smart-tech/')
          )
        );

        $index = 1;
        if ( $picks->have_posts() ) : while ( $picks->have_posts() ) : $picks->the_post();
          $score = get_post_meta( get_the_ID(), 'scout_score', true );
          $category = get_post_meta( get_the_ID(), 'product_category_label', true );
          $desc = get_post_meta( get_the_ID(), 'card_description', true );
        ?>
          <div class="pick-card" onclick="location.href='<?php the_permalink(); ?>'">
            <div class="pick-index-badge"><?php echo $index++; ?></div>
            <div class="pick-image-container">
              <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="1.5">
                <circle cx="12" cy="12" r="9"></circle>
              </svg>
              <span class="pick-score-badge"><?php echo esc_html( $score ); ?> SCORE</span>
            </div>
            <div class="pick-body">
              <span class="pick-category"><?php echo esc_html( $category ); ?></span>
              <h4 class="pick-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
              <p class="pick-desc"><?php echo esc_html( $desc ); ?></p>
            </div>
          </div>
        <?php endwhile; else : ?>
          <?php foreach ( $fallback_picks as $pick ) : ?>
            <div class="pick-card" onclick="location.href='<?php echo esc_url( $pick['link'] ); ?>'">
              <div class="pick-index-badge"><?php echo $index++; ?></div>
              <div class="pick-image-container">
                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="1.5">
                  <circle cx="12" cy="12" r="9"></circle>
                </svg>
                <span class="pick-score-badge"><?php echo esc_html( $pick['score'] ); ?> SCORE</span>
              </div>
              <div class="pick-body">
                <span class="pick-category"><?php echo esc_html( $pick['cat'] ); ?></span>
                <h4 class="pick-title"><a href="<?php echo esc_url( $pick['link'] ); ?>"><?php echo esc_html( $pick['title'] ); ?></a></h4>
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
        
        <!-- Column 1: Latest Reviews -->
        <div class="feed-column">
          <h3 class="feed-column-title">
            Latest Reviews
            <a href="<?php echo esc_url( home_url('/smart-tech/') ); ?>">View all &rarr;</a>
          </h3>
          <div class="feed-list">
            <?php
            $reviews = new WP_Query( array(
              'category_name'  => 'reviews',
              'posts_per_page' => 3
            ) );

            if ( $reviews->have_posts() ) : while ( $reviews->have_posts() ) : $reviews->the_post();
              $score = get_post_meta( get_the_ID(), 'scout_score', true );
            ?>
              <div class="feed-item-card" onclick="location.href='<?php the_permalink(); ?>'">
                <div class="feed-item-img">🐾</div>
                <div class="feed-item-info">
                  <div class="feed-item-meta">
                    <span><?php echo get_the_date('M d, Y'); ?></span>
                    <span style="font-weight:700; color:var(--success);">Score: <?php echo esc_html( $score ); ?></span>
                  </div>
                  <h4 class="feed-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                  <p style="font-size:12px; color:var(--text-muted);"><?php echo wp_trim_words( get_the_excerpt(), 8 ); ?></p>
                </div>
              </div>
            <?php endwhile; else : ?>
              <?php foreach ( array(
                array( 'date' => 'June 1, 2026', 'score' => '8.7', 'title' => 'Eufy X10 Pro Omni Review', 'desc' => 'A powerful all-rounder with smart mapping.', 'link' => home_url('/best-robot-vacuum-for-dog-hair/') ),
                array( 'date' => 'May 28, 2026', 'score' => '8.9', 'title' => 'Furbo Dog Camera 360 Review', 'desc' => 'The best companion camera for pet parents.', 'link' => '#' ),
                array( 'date' => 'May 20, 2026', 'score' => '8.3', 'title' => 'Whistle GPS Collar Review', 'desc' => 'Fitness and location tracking system tested.', 'link' => '#' ),
              ) as $review ) : ?>
                <div class="feed-item-card" onclick="location.href='<?php echo esc_url( $review['link'] ); ?>'">
                  <div class="feed-item-img">○</div>
                  <div class="feed-item-info">
                    <div class="feed-item-meta"><span><?php echo esc_html( $review['date'] ); ?></span><span style="font-weight:700; color:var(--success);">Score: <?php echo esc_html( $review['score'] ); ?></span></div>
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
              <div class="feed-item-card" onclick="location.href='<?php the_permalink(); ?>'">
                <div class="feed-item-img">📖</div>
                <div class="feed-item-info">
                  <div class="feed-item-meta">
                    <span><?php echo get_the_date('M d, Y'); ?></span>
                  </div>
                  <h4 class="feed-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                  <p style="font-size:12px; color:var(--text-muted);"><?php echo wp_trim_words( get_the_excerpt(), 8 ); ?></p>
                </div>
              </div>
            <?php endwhile; else : ?>
              <?php foreach ( array(
                array( 'date' => 'July 2026 Update', 'title' => 'Best Robot Vacuums in America (2026)', 'desc' => 'Our top picks for every home and budget tier.', 'link' => home_url('/best-robot-vacuum-for-dog-hair/') ),
                array( 'date' => 'June 2026 Update', 'title' => 'Best Pet Cameras for Peace of Mind', 'desc' => 'Keep an eye on dogs and cats from anywhere.', 'link' => '#' ),
                array( 'date' => 'May 2026 Update', 'title' => 'Smart Pet Home Starter Guide', 'desc' => 'Everything you need to automate pet care.', 'link' => '#' ),
              ) as $guide ) : ?>
                <div class="feed-item-card" onclick="location.href='<?php echo esc_url( $guide['link'] ); ?>'">
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
              <div class="vs-row-item" onclick="location.href='<?php the_permalink(); ?>'">
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
                <div class="vs-row-item" onclick="location.href='<?php echo esc_url( home_url('/best-robot-vacuum-for-dog-hair/') ); ?>'">
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
            <h5 style="font-family: var(--font-ui);">Real-World Testing</h5>
            <p>We test in US pet homes so you get real insights.</p>
          </div>
        </div>
        <div class="trust-bar-item">
          <div class="trust-bar-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
          </div>
          <div class="trust-bar-info">
            <h5 style="font-family: var(--font-ui);">Clear & Honest Reviews</h5>
            <p>Pros, cons, ratings, and raw facts you need.</p>
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
            <h5 style="font-family: var(--font-ui);">United States Focused</h5>
            <p>Local pricing, stock levels, and warranty cover.</p>
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
            <h5 style="font-family: var(--font-ui);">Affiliate Transparency</h5>
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
          <h4 style="font-family: var(--font-ui);">Get smarter every week.</h4>
          <p>New reviews, buying guides, and pet household deals - straight to your inbox.</p>
        </div>
        <form class="newsletter-form" onsubmit="event.preventDefault(); alert('Subscribed successfully! Thank you.'); this.reset();">
          <input type="email" placeholder="Your email address" required>
          <button type="submit">Subscribe</button>
        </form>
      </div>
    </div>
  </section>

  <script>
    function scrollSlider(amount) {
      const container = document.getElementById('categories-slider');
      container.scrollBy({ left: amount, behavior: 'smooth' });
    }

    function handleWidgetSearch() {
      const category = document.getElementById('select-category').value;
      if (category) {
        window.location.href = category;
      }
    }
  </script>

<?php
get_footer();
