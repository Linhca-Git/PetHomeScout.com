<?php get_header(); ?>
<main class="entry-shell"><div class="container">
	<header class="section-heading"><div><span class="eyebrow">PetHomeScout guides</span><h1><?php single_post_title(); ?></h1></div></header>
	<?php if ( have_posts() ) : ?><div class="card-grid">
		<?php while ( have_posts() ) : the_post(); ?><article class="card"><span class="tag"><?php echo esc_html( get_the_date() ); ?></span><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><p><?php echo esc_html( get_the_excerpt() ); ?></p></article><?php endwhile; ?>
	</div><?php else : ?><p class="empty-state">New PetHomeScout guides are coming soon.</p><?php endif; ?>
</div></main>
<?php get_footer(); ?>
