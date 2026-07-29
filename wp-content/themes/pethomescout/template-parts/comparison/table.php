<?php
$rows = isset( $args['rows'] ) && is_array( $args['rows'] ) ? $args['rows'] : array();
if ( empty( $rows ) ) { return; }
?>
<div class="comparison-table-wrapper" role="region" tabindex="0" aria-label="Product comparison table">
	<table class="comparison-table">
		<thead><tr><th scope="col">Factor</th><?php foreach ( $rows as $row ) : ?><th scope="col"><?php echo esc_html( $row['name'] ?? 'Product' ); ?></th><?php endforeach; ?></tr></thead>
		<tbody>
		<?php foreach ( array( 'best_for' => 'Best suited for', 'evidence' => 'Evidence status', 'score' => 'ScoutScore' ) as $key => $label ) : ?>
			<tr><th scope="row"><?php echo esc_html( $label ); ?></th><?php foreach ( $rows as $row ) : ?><td><?php echo esc_html( $row[ $key ] ?? 'Not yet verified' ); ?></td><?php endforeach; ?></tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>
