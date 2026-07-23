<?php
/**
 * Editor-curated product record card for hub pages.
 * Expected args: product_id, icon, comparison_url, service_url.
 */
$product_id = isset( $args['product_id'] ) ? absint( $args['product_id'] ) : 0;
if ( ! $product_id || 'pet_product' !== get_post_type( $product_id ) ) {
	return;
}
$evidence      = pethomescout_get_product_evidence( $product_id );
$category      = sanitize_key( (string) pethomescout_editorial_field( 'product_category', $product_id, 'product' ) );
$merchant      = sanitize_key( (string) pethomescout_editorial_field( 'merchant_slug', $product_id, '' ) );
$description   = pethomescout_editorial_field( 'card_description', $product_id, '' );
$guide_id      = absint( pethomescout_editorial_field( 'primary_guide', $product_id, 0 ) );
$comparison    = isset( $args['comparison_url'] ) ? $args['comparison_url'] : '';
$service       = isset( $args['service_url'] ) ? $args['service_url'] : '';
$icon          = isset( $args['icon'] ) ? $args['icon'] : '◉';
?>
<article class="family-product-card" data-product-tags="all <?php echo esc_attr( $category ); ?>" data-product-category="<?php echo esc_attr( $category ); ?>"<?php if ( $merchant ) : ?> data-merchants="<?php echo esc_attr( $merchant ); ?>"<?php endif; ?> >
	<div class="family-product-art" aria-hidden="true"><?php echo esc_html( $icon ); ?></div>
	<div>
		<span class="tag">Editor-curated product</span>
		<span class="tag"><?php echo esc_html( ucwords( str_replace( '_', ' ', $evidence['status'] ) ) ); ?></span>
		<h2><?php echo esc_html( get_the_title( $product_id ) ); ?></h2>
		<p><?php echo esc_html( $description ? $description : 'Product record awaiting an editorial description.' ); ?></p>
		<div class="spec-grid">
			<span>Evidence <b><?php echo esc_html( ucwords( str_replace( '_', ' ', $evidence['status'] ) ) ); ?></b></span>
			<span>ScoutScore <b><?php echo esc_html( $evidence['publishable_score'] ? number_format_i18n( $evidence['score'], 1 ) . ' / 10' : 'Pending evidence' ); ?></b></span>
			<span>Last reviewed <b><?php echo esc_html( $evidence['last_reviewed'] ? $evidence['last_reviewed'] : 'Not set' ); ?></b></span>
		</div>
		<?php if ( $merchant ) : ?>
			<?php get_template_part( 'template-parts/commercial/buy-box', null, array( 'product_id' => $product_id, 'merchants' => array( $merchant ) ) ); ?>
		<?php else : ?>
			<div class="buy-box"><strong>Partner pathway</strong><button type="button" disabled aria-disabled="true">Merchant pending</button></div>
		<?php endif; ?>
		<div class="button-row">
			<?php if ( $guide_id && 'publish' === get_post_status( $guide_id ) ) : ?><a class="button button-secondary" href="<?php echo esc_url( get_permalink( $guide_id ) ); ?>">Read guide</a><?php endif; ?>
			<?php if ( $comparison ) : ?><a class="button button-secondary" href="<?php echo esc_url( $comparison ); ?>">Compare options</a><?php endif; ?>
			<?php if ( $service ) : ?><a class="button button-secondary" href="<?php echo esc_url( $service ); ?>">Review service path</a><?php endif; ?>
		</div>
	</div>
</article>
