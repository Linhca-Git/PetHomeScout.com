<?php
$url          = isset( $args['url'] ) ? $args['url'] : '';
$service_type = isset( $args['service_type'] ) ? $args['service_type'] : 'service';
$copy         = isset( $args['copy'] ) ? $args['copy'] : '';
$reason       = isset( $args['reason'] ) ? $args['reason'] : '';
if ( ! $url || ! $copy ) {
	return;
}
?>
<aside class="service-fallback-cta" aria-label="Contextual service option">
  <span class="eyebrow">DIY or professional help</span>
  <h2>When a service may make sense</h2>
  <p><?php echo esc_html( $copy ); ?></p>
  <?php if ( $reason ) : ?><p class="service-fallback-reason"><strong>Why this appears:</strong> <?php echo esc_html( $reason ); ?></p><?php endif; ?>
  <a class="button button-secondary" href="<?php echo esc_url( $url ); ?>" data-track="lead_form_view" data-service="<?php echo esc_attr( $service_type ); ?>">Review service options</a>
</aside>
