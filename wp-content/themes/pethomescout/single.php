<?php
/**
 * The template for displaying all single posts (Reviews & Buying Guides)
 *
 * @package PetHomeScout
 */

get_header();
?>

  <!-- Buying Guide Article Container -->
  <main class="container" style="padding-top: 40px; padding-bottom: 80px; max-width: 960px;">
    
    <!-- Breadcrumbs -->
    <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:var(--text-muted);">Home</a> &gt; 
      <?php
      $categories = get_the_category();
      if ( ! empty( $categories ) ) {
        echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" style="color:var(--text-muted);">' . esc_html( $categories[0]->name ) . '</a> &gt; ';
      }
      ?>
      <span style="color: var(--text-main); font-weight:500;"><?php the_title(); ?></span>
    </div>

    <!-- Editorial Header -->
    <h1 style="font-size: 38px; line-height: 1.25; margin-bottom: 16px; font-family: var(--font-display);"><?php the_title(); ?></h1>
    
    <!-- Editorial meta -->
    <div style="display:flex; align-items:center; gap: 16px; font-size:14px; color: var(--text-muted); margin-bottom: 24px;">
      <span>By <strong><?php the_author(); ?></strong></span>
      <span>&bull;</span>
      <span>Last Updated: <?php the_modified_date('F Y'); ?></span>
    </div>

    <!-- Mandatory Affiliate Disclosure Box -->
    <div class="affiliate-disclosure-box">
      <div class="disclosure-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"></circle>
          <line x1="12" y1="16" x2="12" y2="12"></line>
          <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
      </div>
      <div>
        <strong>PetHomeScout is reader-supported.</strong> When you purchase through links on our site, we may earn an affiliate commission at no extra cost to you. This enables us to maintain our testing lab. All outbound links route securely via `/go/` tracking redirects.
      </div>
    </div>

    <?php while ( have_posts() ) : the_post(); ?>
      
      <div class="entry-content">
        <?php the_content(); ?>
      </div>

      <!-- Dynamic Product Comparison Section -->
      <?php
      // Retrieve compared products metadata (supports relational ACF post object list or manual text input fields)
      $compared_products = get_post_meta( get_the_ID(), 'compared_products', true );
      
      // If we are using relational products CPTS or an array of details:
      if ( ! empty( $compared_products ) && is_array( $compared_products ) ) :
      ?>
        <h2 style="font-size:24px; margin-top:40px; margin-bottom: 20px; font-family: var(--font-display);">Universal Comparison Matrix</h2>
        <div class="comparison-table-wrapper">
          <table class="comparison-table">
            <thead>
              <tr>
                <th>Product</th>
                <th>ScoutScore</th>
                <th>Main Feature</th>
                <th>Best For</th>
                <th>Compare Store Prices</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ( $compared_products as $prod_id ) : 
                $scout_score  = get_post_meta( $prod_id, 'scout_score', true );
                $main_feature = get_post_meta( $prod_id, 'main_feature', true );
                $best_for     = get_post_meta( $prod_id, 'best_for', true );
                $chewy_price  = get_post_meta( $prod_id, 'chewy_price', true );
                $wayfair_price = get_post_meta( $prod_id, 'wayfair_price', true );
                $amazon_price = get_post_meta( $prod_id, 'amazon_price', true );
              ?>
                <tr>
                  <td>
                    <div class="product-cell">
                      <div style="width:36px; height:36px; background:#f1f5f9; border-radius:4px; display:flex; align-items:center; justify-content:center;">🤖</div>
                      <strong><?php echo esc_html( get_the_title( $prod_id ) ); ?></strong>
                    </div>
                  </td>
                  <td><strong style="color:var(--success);"><?php echo esc_html( $scout_score ); ?> / 10</strong></td>
                  <td><?php echo esc_html( $main_feature ); ?></td>
                  <td><?php echo esc_html( $best_for ); ?></td>
                  <td>
                    <div class="uct-merchant-cell">
                      <?php if ( ! empty( $chewy_price ) ) : ?>
                        <a href="<?php echo pethomescout_get_affiliate_link( $prod_id, 'chewy' ); ?>" class="uct-merchant-link">
                          <span>Chewy</span>
                          <span class="price">$<?php echo esc_html( $chewy_price ); ?></span>
                        </a>
                      <?php endif; ?>
                      <?php if ( ! empty( $wayfair_price ) ) : ?>
                        <a href="<?php echo pethomescout_get_affiliate_link( $prod_id, 'wayfair' ); ?>" class="uct-merchant-link">
                          <span>Wayfair</span>
                          <span class="price">$<?php echo esc_html( $wayfair_price ); ?></span>
                        </a>
                      <?php endif; ?>
                      <?php if ( ! empty( $amazon_price ) ) : ?>
                        <a href="<?php echo pethomescout_get_affiliate_link( $prod_id, 'amazon' ); ?>" class="uct-merchant-link">
                          <span>Amazon</span>
                          <span class="price">$<?php echo esc_html( $amazon_price ); ?></span>
                        </a>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>

      <!-- Product deep dives using Universal Product Card layout -->
      <?php
      if ( ! empty( $compared_products ) && is_array( $compared_products ) ) :
      ?>
        <h2 style="font-size:26px; margin-top: 50px; margin-bottom: 24px; border-bottom: 2px solid var(--border-color); padding-bottom: 10px; font-family: var(--font-display);">Top Pet Gear Reviews</h2>
        
        <?php foreach ( $compared_products as $prod_id ) : 
          $scout_score = get_post_meta( $prod_id, 'scout_score', true );
          $card_badges = get_post_meta( $prod_id, 'card_badges', true ); // comma-separated strings
          $description = get_post_meta( $prod_id, 'card_description', true );
          $chewy_price = get_post_meta( $prod_id, 'chewy_price', true );
          $wayfair_price = get_post_meta( $prod_id, 'wayfair_price', true );
          $amazon_price = get_post_meta( $prod_id, 'amazon_price', true );
          $specs       = pethomescout_get_product_specs( $prod_id );
        ?>
          <div class="universal-product-card" style="margin-bottom: 40px;">
            <div class="upc-image-wrapper">
              <svg width="100" height="100" viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
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
              <span class="pick-score-badge" style="top:12px; right:12px;"><?php echo esc_html( $scout_score ); ?> Rating</span>
            </div>
            <div class="upc-info">
              <div class="upc-badge-row">
                <?php 
                if ( ! empty( $card_badges ) ) {
                  $badges_array = explode( ',', $card_badges );
                  foreach ( $badges_array as $badge ) {
                    echo '<span class="upc-badge">' . esc_html( trim( $badge ) ) . '</span>';
                  }
                }
                ?>
              </div>
              <h3 class="upc-title" style="font-family: var(--font-ui);"><?php echo esc_html( get_the_title( $prod_id ) ); ?></h3>
              <p class="upc-desc"><?php echo esc_html( $description ); ?></p>
              
              <!-- Specs table -->
              <?php if ( ! empty( $specs ) ) : ?>
                <div class="upc-specs">
                  <?php foreach ( $specs as $label => $value ) : ?>
                    <div class="upc-spec-item">
                      <span class="upc-spec-label"><?php echo esc_html( $label ); ?></span>
                      <span class="upc-spec-value"><?php echo esc_html( $value ); ?></span>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>

              <!-- Multi-merchant price links box -->
              <div class="upc-multi-merchant-box">
                <div class="upc-merchant-title">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                  </svg>
                  Compare Partner Prices
                </div>
                <div class="merchant-pricing-grid">
                  <?php if ( ! empty( $chewy_price ) ) : ?>
                    <div class="merchant-row">
                      <div class="merchant-name-logo">
                        <span class="merchant-logo-dot chewy"></span>
                        Chewy
                      </div>
                      <div class="merchant-price">$<?php echo esc_html( $chewy_price ); ?></div>
                      <a href="<?php echo pethomescout_get_affiliate_link( $prod_id, 'chewy' ); ?>" class="btn-merchant-cta chewy">Check Price</a>
                    </div>
                  <?php endif; ?>
                  <?php if ( ! empty( $wayfair_price ) ) : ?>
                    <div class="merchant-row">
                      <div class="merchant-name-logo">
                        <span class="merchant-logo-dot wayfair"></span>
                        Wayfair
                      </div>
                      <div class="merchant-price">$<?php echo esc_html( $wayfair_price ); ?></div>
                      <a href="<?php echo pethomescout_get_affiliate_link( $prod_id, 'wayfair' ); ?>" class="btn-merchant-cta wayfair">Check Price</a>
                    </div>
                  <?php endif; ?>
                  <?php if ( ! empty( $amazon_price ) ) : ?>
                    <div class="merchant-row">
                      <div class="merchant-name-logo">
                        <span class="merchant-logo-dot amazon"></span>
                        Amazon
                      </div>
                      <div class="merchant-price">$<?php echo esc_html( $amazon_price ); ?></div>
                      <a href="<?php echo pethomescout_get_affiliate_link( $prod_id, 'amazon' ); ?>" class="btn-merchant-cta amazon">Check Price</a>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

    <?php endwhile; ?>

  </main>

<?php
get_footer();
