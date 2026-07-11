<?php
/**
 * Template Name: Robot Vacuum Matchmaker
 *
 * @package PetHomeScout
 */

get_header();

// Fetch products database from WordPress backend dynamically
$query = new WP_Query( array(
	'post_type'      => 'pet_product',
	'posts_per_page' => -1,
) );

$js_products = array();

if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		$prod_id = get_the_ID();
		
		// Map floor ratings
		$hardwood_rating = get_post_meta( $prod_id, 'floor_rating_hardwood', true );
		$carpet_rating   = get_post_meta( $prod_id, 'floor_rating_carpet', true );
		$mixed_rating    = get_post_meta( $prod_id, 'floor_rating_mixed', true );

		$js_products[] = array(
			'name'         => get_the_title(),
			'price'        => intval( get_post_meta( $prod_id, 'chewy_price', true ) ),
			'maxArea'      => intval( get_post_meta( $prod_id, 'max_area', true ) ),
			'petScore'     => floatval( get_post_meta( $prod_id, 'scout_score', true ) ),
			'hasAI'        => ( get_post_meta( $prod_id, 'has_ai', true ) === '1' ),
			'floorRatings' => array(
				'hardwood' => floatval( $hardwood_rating ? $hardwood_rating : 9.0 ),
				'carpet'   => floatval( $carpet_rating ? $carpet_rating : 9.0 ),
				'mixed'    => floatval( $mixed_rating ? $mixed_rating : 9.0 ),
			),
			'merchant'     => get_post_meta( $prod_id, 'merchant_slug', true ),
			'tagline'      => get_post_meta( $prod_id, 'card_description', true ),
		);
	}
	wp_reset_postdata();
}
?>

<script>
  // Dynamic datasets injected from WP Admin dashboard custom fields/ACF metaboxes
  var wordpressVacuums = <?php echo json_encode( $js_products ); ?>;
</script>

  <!-- Hub Header Area -->
  <div class="hub-header" style="margin-bottom: 30px;">
    <div class="container">
      <span class="tool-badge">Decision Tool page</span>
      <h1 style="font-size: 38px; margin-top: 8px; margin-bottom: 12px; font-family: var(--font-display);"><?php echo esc_html( get_the_title() ? get_the_title() : 'Robot Vacuum Selector & Matchmaker' ); ?></h1>
      <div style="color: var(--text-muted); max-width: 800px; font-size: 16px;">
        <?php the_content(); ?>
      </div>
    </div>
  </div>

  <!-- Tool Split Pane Layout -->
  <div class="container" style="padding-bottom: 80px;">
    <div class="tool-grid">
      
      <!-- Control Panel (Left Pane) -->
      <aside class="tool-control-pane">
        <h3 style="font-size:18px; border-bottom:1px solid var(--border-color); padding-bottom:12px; margin-bottom:24px; font-family: var(--font-ui);">Match Parameters</h3>
        
        <!-- Budget Slider -->
        <div class="control-group">
          <label for="budgetSlider">Max Budget: <span class="value" id="budgetValue">$900</span></label>
          <input type="range" id="budgetSlider" class="slider" min="300" max="1300" step="50" value="900">
        </div>

        <!-- House Size Slider -->
        <div class="control-group">
          <label for="sizeSlider">House Size: <span class="value" id="sizeValue">1,800 sq ft</span></label>
          <input type="range" id="sizeSlider" class="slider" min="500" max="4000" step="100" value="1800">
        </div>

        <!-- Pet Count Option -->
        <div class="control-group">
          <label>Pet Count (Heavy Shedders)</label>
          <div style="display:flex; gap:10px; margin-top:8px;">
            <label style="flex:1; text-align:center; padding:10px; border:1px solid var(--border-color); border-radius:var(--radius-sm); cursor:pointer; font-size:13px; font-weight:500;" id="pet0">
              <input type="radio" name="petCount" value="0" style="display:none;"> None
            </label>
            <label style="flex:1; text-align:center; padding:10px; border:2px solid var(--primary); background:var(--primary-light); border-radius:var(--radius-sm); cursor:pointer; font-size:13px; font-weight:700;" id="pet1">
              <input type="radio" name="petCount" value="1" style="display:none;" checked> 1 Pet
            </label>
            <label style="flex:1; text-align:center; padding:10px; border:1px solid var(--border-color); border-radius:var(--radius-sm); cursor:pointer; font-size:13px; font-weight:500;" id="pet2">
              <input type="radio" name="petCount" value="2" style="display:none;"> 2+ Pets
            </label>
          </div>
        </div>

        <!-- Floor Type Option -->
        <div class="control-group">
          <label for="toolFloor">Dominant Floor Type</label>
          <select id="toolFloor" class="form-control" style="margin-top:8px;">
            <option value="hardwood">Mostly Hardwood</option>
            <option value="carpet">Mostly Carpet / Rugs</option>
            <option value="mixed" selected>Mixed (Hardwood + Rugs)</option>
          </select>
        </div>

        <!-- AI Waste Avoidance Checkbox -->
        <div class="control-group" style="margin-top: 24px;">
          <label class="filter-option" style="font-weight: 600; color: var(--text-main);">
            <input type="checkbox" id="wasteAvoidance" style="width:18px; height:18px; accent-color:var(--primary);" checked>
            <span>Waste & Toy Avoidance (AI Camera)</span>
          </label>
        </div>
      </aside>

      <!-- Results Pane (Right Pane) -->
      <main class="tool-results-pane">
        <div class="results-header">
          <h3 style="font-size:20px; font-weight:700; font-family: var(--font-ui);">Matched Candidates</h3>
          <span class="results-count" id="matchResultsCount">Calculating...</span>
        </div>

        <!-- Dynamic Results List container -->
        <div class="results-list" id="resultsContainer">
          <!-- Dynamic cards will be rendered here by tool.js -->
        </div>
      </main>

    </div>
  </div>

  <script src="<?php echo esc_url( get_template_directory_uri() . '/js/tool.js' ); ?>"></script>

<?php
get_footer();
