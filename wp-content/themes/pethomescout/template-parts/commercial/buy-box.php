<?php
/**
 * Multi-merchant buy box. Destinations are always internal /go/ links.
 * Expected args: product_id, merchants.
 */
$product_id = isset( $args['product_id'] ) ? absint( $args['product_id'] ) : 0;
$merchants  = isset( $args['merchants'] ) && is_array( $args['merchants'] ) ? $args['merchants'] : array();
if ( ! $product_id || empty( $merchants ) ) {
	return;
}
?>
<section class="buy-box" aria-label="Partner availability">
	<strong>Partner availability</strong>
	<div class="merchant-pricing-grid">
		<?php foreach ( $merchants as $merchant_slug ) : $offer = pethomescout_get_offer_data( $product_id, $merchant_slug ); ?>
			<div class="merchant-row">
				<span class="merchant-name-logo"><span class="merchant-logo-dot <?php echo esc_attr( $merchant_slug ); ?>"></span><?php echo esc_html( $offer['merchant_name'] ); ?></span>
				<?php if ( $offer['approved'] && $offer['url'] ) : ?>
					<?php if ( $offer['price'] ) : ?><span class="merchant-price"><?php echo esc_html( $offer['price'] ); ?></span><?php endif; ?>
					<a class="btn-merchant-cta <?php echo esc_attr( $merchant_slug ); ?>" href="<?php echo esc_url( $offer['url'] ); ?>" rel="sponsored nofollow" data-track="buy_box_click" data-merchant="<?php echo esc_attr( $merchant_slug ); ?>" data-product="<?php echo esc_attr( get_post_field( 'post_name', $product_id ) ); ?>">Check price</a>
				<?php else : ?>
					<span class="merchant-price">Merchant pending</span><button type="button" class="btn-merchant-cta" disabled aria-disabled="true">Merchant pending</button>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>
