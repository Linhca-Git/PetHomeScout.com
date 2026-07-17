<?php
$product_id = isset( $args['product_id'] ) ? absint( $args['product_id'] ) : 0;
if ( ! $product_id ) { return; }
$scout = pethomescout_get_scout_score_breakdown( $product_id );
$label = null !== $scout['score'] ? number_format_i18n( $scout['score'], 1 ) . ' / 10' : 'Pending evidence';
?>
<section class="scout-score-panel" aria-label="ScoutScore methodology">
	<span class="eyebrow">ScoutScore</span>
	<strong><?php echo esc_html( $label ); ?></strong>
	<span class="evidence-badge"><?php echo esc_html( ucwords( str_replace( '_', ' ', $scout['evidence']['status'] ) ) ); ?></span>
	<p>Weighted across pet-hair handling, floor compatibility, ownership friction, pet safety, and value.</p>
	<a href="<?php echo esc_url( $scout['evidence']['methodology_url'] ); ?>">How we score</a>
</section>
