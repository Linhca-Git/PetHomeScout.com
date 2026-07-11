<?php
/**
 * PetHomeScout Functions and Definitions
 *
 * @package PetHomeScout
 */

if ( ! function_exists( 'pethomescout_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function pethomescout_setup() {
		// Add default RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Register navigation menus.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'pethomescout' ),
			'footer'  => esc_html__( 'Footer Menu', 'pethomescout' ),
		) );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		) );
	}
endif;
add_action( 'after_setup_theme', 'pethomescout_setup' );

/**
 * Enqueue scripts and styles.
 */
function pethomescout_scripts() {
	// Enqueue parent stylesheet.
	wp_enqueue_style( 'pethomescout-style', get_stylesheet_uri(), array(), '1.0.0' );

	// Enqueue global main.js.
	wp_enqueue_script( 'pethomescout-main', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true );
	wp_enqueue_script( 'pethomescout-lead-demo', get_template_directory_uri() . '/js/lead-demo.js', array(), '1.0.0', true );
	wp_enqueue_script( 'pethomescout-hub-filter', get_template_directory_uri() . '/js/hub-filter.js', array(), '1.0.0', true );
	wp_enqueue_script( 'pethomescout-selector', get_template_directory_uri() . '/js/selector.js', array(), '1.0.0', true );

	// Localize script to pass the rest API or admin ajax URLs if needed in the future.
	wp_localize_script( 'pethomescout-main', 'petHomeScoutData', array(
		'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
		'themeUri' => get_template_directory_uri(),
		'leadNonce' => wp_create_nonce( 'pethomescout_lead' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'pethomescout_scripts' );

/**
 * Keep the local preview useful before an administrator has created the Pages.
 * Real Pages still win; these mappings only run for the matching 404 routes.
 */
function pethomescout_preview_template_routes( $template ) {
	if ( ! is_404() ) {
		return $template;
	}

	$path = trim( (string) parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
	if ( 0 === strpos( $path, 'go/' ) ) {
		$candidate = get_template_directory() . '/page-go-placeholder.php';
		if ( file_exists( $candidate ) ) {
			global $wp_query;
			$wp_query->is_404 = false;
			$wp_query->is_page = true;
			status_header( 200 );
			return $candidate;
		}
	}
	$routes = array(
		'services-insurance'         => 'page-services-reference.php',
		'pet-insurance-quotes'       => 'page-pet-insurance-quotes.php',
		'mobile-dog-grooming'        => 'page-mobile-dog-grooming.php',
		'pet-odor-cleaning'          => 'page-pet-odor-cleaning.php',
		'cleaning-odor'              => 'page-cleaning-hub.php',
		'smart-tech'                => 'page-smart-tech-hub.php',
		'robot-vacuum-selector'      => 'page-robot-vacuum-selector.php',
		'tool'                       => 'page-tool-matchmaker.php',
		'matchmaker'                => 'page-matchmaker.php',
		'best-robot-vacuum-for-dog-hair' => 'page-vacuum-reviews.php',
		'robot-vacuums-for-pet-hair' => 'page-vacuum-reviews.php',
		'family-home'               => 'page-family-home.php',
		'how-we-test'               => 'page-how-we-test.php',
		'contact'                   => 'page-contact.php',
	);

	if ( isset( $routes[ $path ] ) ) {
		$candidate = get_template_directory() . '/' . $routes[ $path ];
		if ( file_exists( $candidate ) ) {
			global $wp_query;
			$wp_query->is_404 = false;
			$wp_query->is_page = true;
			status_header( 200 );
			return $candidate;
		}
	}

	return $template;
}
add_filter( 'template_include', 'pethomescout_preview_template_routes', 99 );

function pethomescout_preview_document_title( $parts ) {
	$path = trim( (string) parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
	$titles = array( 'services-insurance' => 'Get Custom Pet Insurance & Local Care Quotes - PetHomeScout', 'pet-insurance-quotes' => 'Compare Pet Insurance Quote Factors - PetHomeScout', 'mobile-dog-grooming' => 'Mobile Dog Grooming Guide - PetHomeScout', 'pet-odor-cleaning' => 'Dog Urine Odor Cleaning Guide - PetHomeScout', 'family-home' => 'Pet-Friendly Family Home & Safety Reviews - PetHomeScout', 'smart-tech' => 'Pet Smart Technology & Automated Care Reviews - PetHomeScout', 'cleaning-odor' => 'Pet Stain, Odor & Air Purifier Reviews - PetHomeScout', 'best-robot-vacuum-for-dog-hair' => 'The Best Robot Vacuums for Dog Hair (2026 Reviews) - PetHomeScout', 'robot-vacuums-for-pet-hair' => 'The Best Robot Vacuums for Dog Hair (2026 Reviews) - PetHomeScout', 'tool' => 'Robot Vacuum Matchmaker - PetHomeScout Tools', 'robot-vacuum-selector' => 'Robot Vacuum Matchmaker - PetHomeScout Tools', 'matchmaker' => 'Robot Vacuum Matchmaker - PetHomeScout Tools', 'how-we-test' => 'How PetHomeScout Tests Products - PetHomeScout', 'contact' => 'Contact Us - PetHomeScout' );
	if ( isset( $titles[ $path ] ) ) { $parts['title'] = $titles[ $path ]; $parts['site'] = 'PetHomeScout'; }
	return $parts;
}
add_filter( 'document_title_parts', 'pethomescout_preview_document_title' );

/**
 * Helper function to retrieve product affiliate link.
 * Automatically checks for custom fields and maps them to a secure local redirect pathway (/go/slug).
 */
function pethomescout_get_affiliate_link( $product_id, $merchant = 'chewy' ) {
	// Read custom field values (support standard WordPress Custom Fields or ACF)
	$custom_url = get_post_meta( $product_id, "affiliate_url_{$merchant}", true );
	if ( empty( $custom_url ) ) {
		// Fallback to standard field
		$custom_url = get_post_meta( $product_id, "{$merchant}_url", true );
	}

	if ( ! empty( $custom_url ) ) {
		// If direct link exists, we route through our local cloaked structure /go/slug
		// Pretty Links / RankMath will catch this or we can manage redirects in WP
		$post_slug = get_post_field( 'post_name', $product_id );
		return esc_url( home_url( "/go/{$post_slug}-{$merchant}/" ) );
	}

	// Fallback to general redirect if nothing is set
	return esc_url( home_url( "/go/{$merchant}/" ) );
}

/**
 * Helper to render dynamic product specifications table.
 * Retrieves custom meta keys and builds key-value lists.
 */
function pethomescout_get_product_specs( $product_id ) {
	$specs = array();
	
	// Check if ACF spec fields or standard WP custom fields are defined
	$spec_keys = array(
		'suction_power'    => 'Suction Power',
		'anti_tangle'      => 'Anti-Tangle',
		'obstacle_avoid'   => 'Obstacle Avoid',
		'mop_wash'         => 'Mop Wash',
		'material'         => 'Material',
		'claw_rating'      => 'Claw Rating',
		'sofa_length'      => 'Sofa Length',
		'warranty'         => 'Warranty',
		'height'           => 'Height',
		'width_range'      => 'Width range',
		'lock_type'        => 'Lock Type',
		'finish'           => 'Finish',
		'filter_grade'     => 'Filter Grade',
		'room_coverage'    => 'Room Coverage',
		'noise_level'      => 'Noise Level',
		'uvc_mode'         => 'UVC Mode',
	);

	foreach ( $spec_keys as $meta_key => $label ) {
		$value = get_post_meta( $product_id, $meta_key, true );
		if ( ! empty( $value ) ) {
			$specs[ $label ] = $value;
		}
	}

	// Fallback dynamic ACF repeater mapping if defined
	if ( function_exists( 'get_field' ) ) {
		$acf_specs = get_field( 'product_specifications', $product_id );
		if ( is_array( $acf_specs ) ) {
			foreach ( $acf_specs as $row ) {
				if ( ! empty( $row['label'] ) && ! empty( $row['value'] ) ) {
					$specs[ $row['label'] ] = $row['value'];
				}
			}
		}
	}

	return $specs;
}

/**
 * AJAX Handler for Multi-step Lead Form Submission
 * Integrates lead form securely with the WordPress backend database.
 */
function pethomescout_handle_lead_submission() {
	if ( ! check_ajax_referer( 'pethomescout_lead', 'nonce', false ) ) {
		wp_send_json_error( array( 'message' => 'This form session has expired. Please refresh and try again.' ), 403 );
	}

	// Require explicit TCPA consent before any lead is stored or emailed.
	if ( empty( $_POST['consentCheck'] ) ) {
		wp_send_json_error( array( 'message' => 'Please confirm consent before requesting quotes.' ), 400 );
	}

	if ( empty( $_POST['email'] ) || empty( $_POST['fullName'] ) ) {
		wp_send_json_error( array( 'message' => 'Required fields are missing.' ) );
	}

	$fullName     = sanitize_text_field( $_POST['fullName'] );
	$email        = sanitize_email( $_POST['email'] );
	$phone        = sanitize_text_field( $_POST['phone'] );
	$zipCode      = sanitize_text_field( $_POST['zipCode'] );
	$petType      = sanitize_text_field( $_POST['petType'] );
	$petAge       = sanitize_text_field( $_POST['petAge'] );
	$coverageNeed = sanitize_text_field( $_POST['coverageNeed'] );
	$consent      = 1;

	// In a real WP setup, we can write this into a custom table,
	// save it as a Custom Post Type "Lead", or dispatch via Webhook/Email.
	
	// Create custom post type record "Lead"
	$lead_id = wp_insert_post( array(
		'post_title'   => sprintf( 'Lead from %s (%s)', $fullName, $email ),
		'post_type'    => 'pet_lead',
		'post_status'  => 'private',
	) );

	if ( $lead_id && ! is_wp_error( $lead_id ) ) {
		update_post_meta( $lead_id, 'lead_full_name', $fullName );
		update_post_meta( $lead_id, 'lead_email', $email );
		update_post_meta( $lead_id, 'lead_phone', $phone );
		update_post_meta( $lead_id, 'lead_zip_code', $zipCode );
		update_post_meta( $lead_id, 'lead_pet_type', $petType );
		update_post_meta( $lead_id, 'lead_pet_age', $petAge );
		update_post_meta( $lead_id, 'lead_coverage_need', $coverageNeed );
		update_post_meta( $lead_id, 'lead_tcpa_consent', $consent );

		// Send email notifications to editor/partners
		$to      = get_option( 'admin_email' );
		$subject = 'New PetHomeScout Lead Received';
		$body    = "Name: $fullName\nEmail: $email\nPhone: $phone\nZIP: $zipCode\nPet: $petType ($petAge)\nCoverage: $coverageNeed\nTCPA Consented: Yes\n";
		wp_mail( $to, $subject, $body );

		wp_send_json_success( array( 'message' => 'Quotes generated successfully!' ) );
	}

	wp_send_json_error( array( 'message' => 'Unable to save lead. Please try again.' ) );
}
add_action( 'wp_ajax_submit_pet_lead', 'pethomescout_handle_lead_submission' );
add_action( 'wp_ajax_nopriv_submit_pet_lead', 'pethomescout_handle_lead_submission' );

/**
 * Register Custom Post Type "Leads" and "Products" for backend convenience.
 */
function pethomescout_register_post_types() {
	// Register Leads post type
	register_post_type( 'pet_lead', array(
		'labels'      => array(
			'name'          => __( 'Leads', 'pethomescout' ),
			'singular_name' => __( 'Lead', 'pethomescout' ),
		),
		'public'      => false,
		'show_ui'     => true,
		'supports'    => array( 'title' ),
		'menu_icon'   => 'dashicons-id-alt',
	) );

	// Register Products post type (Optional: if they want to manage products separately from posts)
	register_post_type( 'pet_product', array(
		'labels'      => array(
			'name'          => __( 'Products Database', 'pethomescout' ),
			'singular_name' => __( 'Product', 'pethomescout' ),
		),
		'public'      => true,
		'has_archive' => true,
		'supports'    => array( 'title', 'thumbnail', 'excerpt' ),
		'menu_icon'   => 'dashicons-products',
		'rewrite'     => array( 'slug' => 'products' ),
	) );
}
add_action( 'init', 'pethomescout_register_post_types' );
