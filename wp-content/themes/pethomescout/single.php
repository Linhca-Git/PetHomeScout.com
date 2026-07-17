<?php
/**
 * The template for displaying all single posts (Guides & Buying Guides)
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
      <?php $article_evidence = pethomescout_editorial_field( 'evidence_status', get_the_ID(), 'research_led' ); ?>
      <span class="evidence-badge"><?php echo esc_html( ucwords( str_replace( '_', ' ', $article_evidence ) ) ); ?></span>
    </div>

    <?php get_template_part( 'template-parts/disclosures/affiliate' ); ?>

    <?php while ( have_posts() ) : the_post(); ?>
      
      <div class="entry-content">
        <?php the_content(); ?>
      </div>

      <?php pethomescout_render_related_links( get_the_ID() ); ?>
      <?php pethomescout_render_service_fallback_cta( get_the_ID() ); ?>

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
                <th>Partner Availability</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ( $compared_products as $prod_id ) : 
                $evidence = pethomescout_get_product_evidence( $prod_id );
                $scout_score  = $evidence['score'];
                $main_feature = get_post_meta( $prod_id, 'main_feature', true );
                $best_for     = get_post_meta( $prod_id, 'best_for', true );
                $evidence_status = $evidence['status'];
                $score_label  = $evidence['publishable_score'] ? esc_html( $scout_score ) . ' / 10' : 'Pending test record';
                $chewy_price  = get_post_meta( $prod_id, 'chewy_price', true );
                $wayfair_price = get_post_meta( $prod_id, 'wayfair_price', true );
                $amazon_price = get_post_meta( $prod_id, 'amazon_price', true );
                $merchant_rows = array(
                  'chewy'   => array( 'label' => 'Chewy', 'price' => $chewy_price ),
                  'wayfair' => array( 'label' => 'Wayfair', 'price' => $wayfair_price ),
                  'amazon'  => array( 'label' => 'Amazon', 'price' => $amazon_price ),
                );
              ?>
                <tr>
                  <td>
                    <div class="product-cell">
                      <div style="width:36px; height:36px; background:#f1f5f9; border-radius:4px; display:flex; align-items:center; justify-content:center;">🤖</div>
                      <strong><?php echo esc_html( get_the_title( $prod_id ) ); ?></strong>
                    </div>
                  </td>
                  <td><strong style="color:var(--success);"><?php echo esc_html( $score_label ); ?></strong></td>
                  <td><?php echo esc_html( $main_feature ); ?></td>
                  <td><?php echo esc_html( $best_for ); ?></td>
                  <td>
                    <div class="uct-merchant-cell">
                      <?php foreach ( $merchant_rows as $merchant_slug => $merchant ) : ?>
                        <?php if ( ! empty( $merchant['price'] ) && pethomescout_offer_is_approved( $prod_id, $merchant_slug ) ) : ?>
                          <a href="<?php echo esc_url( pethomescout_get_affiliate_link( $prod_id, $merchant_slug ) ); ?>" class="uct-merchant-link" rel="sponsored nofollow" data-track="buy_box_click" data-merchant="<?php echo esc_attr( $merchant_slug ); ?>" data-product="<?php echo esc_attr( get_post_field( 'post_name', $prod_id ) ); ?>" data-cta-position="comparison_table" data-evidence-status="<?php echo esc_attr( $evidence_status ); ?>">
                            <span><?php echo esc_html( $merchant['label'] ); ?></span>
                            <span class="price">$<?php echo esc_html( $merchant['price'] ); ?></span>
                          </a>
                        <?php else : ?>
                          <button type="button" class="uct-merchant-link" disabled aria-disabled="true">
                            <span><?php echo esc_html( $merchant['label'] ); ?></span>
                            <span class="price">Merchant pending</span>
                          </button>
                        <?php endif; ?>
                      <?php endforeach; ?>
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
        <h2 style="font-size:26px; margin-top: 50px; margin-bottom: 24px; border-bottom: 2px solid var(--border-color); padding-bottom: 10px; font-family: var(--font-display);">Product Guidance Notes</h2>
        
        <?php foreach ( $compared_products as $prod_id ) : 
          $evidence = pethomescout_get_product_evidence( $prod_id );
          $scout_score = $evidence['score'];
          $score_label = $evidence['publishable_score'] ? esc_html( $scout_score ) . ' ScoutScore' : 'Pending test record';
          $card_badges = get_post_meta( $prod_id, 'card_badges', true ); // comma-separated strings
          $description = get_post_meta( $prod_id, 'card_description', true );
          $chewy_price = get_post_meta( $prod_id, 'chewy_price', true );
          $wayfair_price = get_post_meta( $prod_id, 'wayfair_price', true );
          $amazon_price = get_post_meta( $prod_id, 'amazon_price', true );
          $merchant_rows = array(
            'chewy'   => array( 'label' => 'Chewy', 'price' => $chewy_price ),
            'wayfair' => array( 'label' => 'Wayfair', 'price' => $wayfair_price ),
            'amazon'  => array( 'label' => 'Amazon', 'price' => $amazon_price ),
          );
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
              <span class="pick-score-badge" style="top:12px; right:12px;"><?php echo esc_html( $score_label ); ?></span>
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

              <?php get_template_part( 'template-parts/commercial/scout-score', null, array( 'product_id' => $prod_id ) ); ?>

              <?php get_template_part( 'template-parts/commercial/buy-box', null, array( 'product_id' => $prod_id, 'merchants' => array_keys( $merchant_rows ) ) ); ?>

            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

    <?php endwhile; ?>

  </main>

<?php
get_footer();
