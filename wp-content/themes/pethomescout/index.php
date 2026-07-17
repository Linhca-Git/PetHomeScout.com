<?php
/**
 * Main fallback index.php template file
 *
 * @package PetHomeScout
 */

get_header();
?>

  <main class="container" style="padding-top: 40px; padding-bottom: 80px;">
    
    <div class="hub-header" style="margin-bottom: 40px; border-bottom: 1px solid var(--border-color); padding-bottom: 24px;">
      <h1 style="font-size: 38px; font-family: var(--font-display);"><?php bloginfo('name'); ?> Articles</h1>
      <p style="color: var(--text-muted); font-size: 16px; margin-top: 8px;"><?php bloginfo('description'); ?></p>
    </div>

    <div class="cards-grid">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article class="article-card" onclick="location.href='<?php the_permalink(); ?>'">
          <?php if ( has_post_thumbnail() ) : ?>
            <div class="article-image" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url() ); ?>');">
          <?php else : ?>
            <div class="article-image" style="background-color: #e2e8f0; display:flex; align-items:center; justify-content:center; font-size: 40px;">
              🐾
          <?php endif; ?>
            <span class="article-category">
              <?php
              $categories = get_the_category();
              if ( ! empty( $categories ) ) {
                echo esc_html( $categories[0]->name );
              } else {
                echo 'Pet Tech';
              }
              ?>
            </span>
          </div>
          <div class="article-body">
            <div class="article-meta">
              <span><?php echo get_the_date('F Y'); ?> Update</span>
            </div>
            <h3 style="font-family: var(--font-ui); font-size: 18px; margin-bottom: 10px;"><a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a></h3>
            <p style="font-size: 14px; color: var(--text-muted);"><?php echo wp_trim_words( get_the_excerpt(), 18 ); ?></p>
            <div class="article-footer" style="margin-top:auto; padding-top: 12px; border-top: 1px solid var(--border-color); display:flex; justify-content:space-between; align-items:center;">
              <span class="scout-score-badge top">
                <?php
                $evidence = pethomescout_get_product_evidence( get_the_ID() );
                echo esc_html( $evidence['publishable_score'] ? $evidence['score'] . ' ScoutScore' : 'Pending score' );
                ?>
              </span>
            <a href="<?php echo esc_url( get_permalink() ); ?>" style="font-size:13px; font-weight:600;">View Guide &rarr;</a>
            </div>
          </div>
        </article>
      <?php endwhile; else : ?>
        <p>No articles found matching your criteria.</p>
      <?php endif; ?>
    </div>

  </main>

<?php
get_footer();
