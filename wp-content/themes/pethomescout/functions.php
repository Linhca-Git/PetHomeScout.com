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
	wp_enqueue_style( 'pethomescout-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap', array(), null );
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'pethomescout-style', get_stylesheet_uri(), array( 'pethomescout-fonts', 'dashicons' ), '0.2.0' );
	wp_enqueue_script( 'pethomescout-main', get_template_directory_uri() . '/js/main.js', array(), '0.2.0', true );
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

function pethomescout_get_affiliate_link( $product_id, $merchant = 'chewy' ) {
	$url = get_post_meta( $product_id, $merchant . '_url', true );
	if ( empty( $url ) ) {
		return '';
	}
	$slug = get_post_field( 'post_name', $product_id );
	return esc_url( home_url( '/go/' . sanitize_title( $slug . '-' . $merchant ) . '/' ) );
}
