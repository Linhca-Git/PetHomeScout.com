<?php
/**
 * PetHomeScout theme setup and shared helpers.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function pethomescout_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'pethomescout' ),
			'footer'  => __( 'Footer Menu', 'pethomescout' ),
		)
	);
}
add_action( 'after_setup_theme', 'pethomescout_setup' );

function pethomescout_assets() {
	wp_enqueue_style( 'pethomescout-fonts', 'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Nunito+Sans:wght@400;600;700;800&display=swap', array(), null );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'pethomescout-style', get_stylesheet_uri(), array( 'pethomescout-fonts', 'dashicons' ), '0.2.0' );
	wp_enqueue_style( 'pethomescout-mvp', get_template_directory_uri() . '/css/mvp.css', array( 'pethomescout-style' ), '0.1.0' );
	wp_enqueue_script( 'pethomescout-main', get_template_directory_uri() . '/js/main.js', array(), '0.2.0', true );
	wp_enqueue_script( 'pethomescout-lead-demo', get_template_directory_uri() . '/js/lead-demo.js', array( 'pethomescout-main' ), '0.1.0', true );
	wp_enqueue_script( 'pethomescout-tools', get_template_directory_uri() . '/js/tool.js', array( 'pethomescout-main' ), '0.1.0', true );
}
add_action( 'wp_enqueue_scripts', 'pethomescout_assets' );

function pethomescout_primary_fallback() {
	$items = array(
		'Robot Vacuums' => '/robot-vacuums-for-pet-hair/',
		'Cleaning' => '/pet-odor-cleaning/',
		'Smart Pet Home' => '/smart-pet-home/',
		'Dog Safety' => '/dog-safety-tech/',
		'Pet Insurance' => '/pet-insurance/',
		'Pet Services' => '/pet-services/',
		'Tools' => '/tools/',
	);
	echo '<ul>';
	foreach ( $items as $label => $path ) {
		echo '<li><a href="' . esc_url( home_url( $path ) ) . '">' . esc_html( $label ) . '</a></li>';
	}
	echo '</ul>';
}

function pethomescout_footer_fallback() {
	echo '<ul><li><a href="' . esc_url( home_url( '/about/' ) ) . '">About</a></li><li><a href="' . esc_url( home_url( '/how-we-test/' ) ) . '">How we test</a></li><li><a href="' . esc_url( home_url( '/editorial-policy/' ) ) . '">Editorial policy</a></li></ul>';
}

function pethomescout_register_content_types() {
	register_post_type( 'pet_product', array(
		'labels'       => array( 'name' => __( 'Pet Products', 'pethomescout' ), 'singular_name' => __( 'Pet Product', 'pethomescout' ) ),
		'public'       => true,
		'show_in_rest' => true,
		'menu_icon'    => 'dashicons-products',
		'supports'     => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		'rewrite'      => array( 'slug' => 'products' ),
	) );
	register_post_type( 'pet_lead', array(
		'labels'        => array( 'name' => __( 'Pet Leads', 'pethomescout' ), 'singular_name' => __( 'Pet Lead', 'pethomescout' ) ),
		'public'        => false,
		'show_ui'       => true,
		'show_in_rest'  => false,
		'menu_icon'     => 'dashicons-id-alt',
		'supports'      => array( 'title' ),
	) );
}
add_action( 'init', 'pethomescout_register_content_types' );

function pethomescout_register_product_meta() {
	$keys = array( 'scout_score', 'evidence_status', 'last_reviewed', 'test_record_id', 'max_area', 'floor_rating_carpet', 'floor_rating_hardwood', 'has_ai', 'merchant_slug', 'card_description' );
	foreach ( $keys as $key ) {
		register_post_meta( 'pet_product', $key, array( 'single' => true, 'show_in_rest' => true, 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ) );
	}
}
add_action( 'init', 'pethomescout_register_product_meta' );

function pethomescout_demo_routes( $template ) {
	if ( ! is_404() ) {
		return $template;
	}
	$path = trim( wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ), '/' );
	$routes = array(
		'services-insurance'      => 'page-services-insurance.php',
		'pet-insurance-quotes'    => 'page-pet-insurance-quotes.php',
		'mobile-dog-grooming'     => 'page-mobile-dog-grooming.php',
		'pet-odor-cleaning'       => 'page-pet-odor-cleaning.php',
		'smart-tech'              => 'page-smart-tech.php',
		'robot-vacuum-selector'   => 'page-robot-vacuum-selector.php',
		'how-we-test'             => 'page-how-we-test.php',
	);
	if ( isset( $routes[ $path ] ) ) {
		status_header( 200 );
		return get_template_directory() . '/' . $routes[ $path ];
	}
	return $template;
}
add_filter( 'template_include', 'pethomescout_demo_routes' );

function pethomescout_get_affiliate_link( $product_id, $merchant = 'chewy' ) {
	$url = get_post_meta( $product_id, $merchant . '_url', true );
	if ( empty( $url ) ) {
		return '';
	}
	$slug = get_post_field( 'post_name', $product_id );
	return esc_url( home_url( '/go/' . sanitize_title( $slug . '-' . $merchant ) . '/' ) );
}
