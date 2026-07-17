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
 * Disable WordPress emoji assets for a leaner front-end.
 */
function pethomescout_disable_emoji_assets() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'init', 'pethomescout_disable_emoji_assets' );

/**
 * Remove unused WordPress discovery links from the public head.
 */
function pethomescout_disable_discovery_links() {
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'template_redirect', 'rest_output_link_header', 11 );
}
add_action( 'init', 'pethomescout_disable_discovery_links' );

/**
 * Remove block-editor front-end CSS from custom template pages.
 *
 * PetHomeScout MVP pages are rendered by theme templates rather than core
 * blocks, so the block library adds payload without supporting visible UI.
 * Admin/editor screens are untouched.
 */
function pethomescout_dequeue_block_frontend_assets() {
	if ( is_admin() ) {
		return;
	}

	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'pethomescout_dequeue_block_frontend_assets', 20 );

/**
 * Return the current request path for preview-only route handling.
 */
function pethomescout_current_path() {
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
	$path        = wp_parse_url( $request_uri, PHP_URL_PATH );

	if ( ! is_string( $path ) ) {
		return '';
	}

	// WordPress Playground exposes the temporary site scope in REQUEST_URI.
	// Remove that runtime-only prefix before route matching and canonical paths;
	// normal production/staging hosts are unchanged.
	if ( preg_match( '#^/?scope:[^/]+/?#', $path ) ) {
		$path = preg_replace( '#^/?scope:[^/]+/?#', '/', $path );
	}

	return trim( sanitize_text_field( $path ), '/' );
}

/**
 * Enqueue scripts and styles.
 */
function pethomescout_scripts() {
	$path = pethomescout_current_path();

	// Load the display and UI fonts as a direct stylesheet instead of a CSS @import.
	wp_enqueue_style(
		'pethomescout-fonts',
		'https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700;9..144,800&family=Nunito+Sans:wght@400;600;700;800&display=swap',
		array(),
		null
	);

	// Enqueue parent stylesheet.
	wp_enqueue_style( 'pethomescout-style', get_stylesheet_uri(), array(), '1.0.1' );

	// Enqueue global main.js.
	wp_enqueue_script( 'pethomescout-main', get_template_directory_uri() . '/js/main.js', array(), '1.0.1', true );
	wp_add_inline_script(
		'pethomescout-main',
		"window.petHomeScoutTrack=window.petHomeScoutTrack||function(eventName,details){var path=window.location.pathname||'/';var pageType=path==='/'?'home':(path.split('/').filter(Boolean)[0]||'page');var payload=Object.assign({event:eventName,page_path:path,page_type:pageType,content_type:document.body?document.body.getAttribute('data-content-type')||pageType:pageType},details||{});window.dataLayer=window.dataLayer||[];window.dataLayer.push(payload);window.dispatchEvent(new CustomEvent('pethomescout:event',{detail:payload}));};",
		'before'
	);
	$lead_demo_routes = array(
		'pet-insurance',
		'mobile-pet-grooming',
		'pet-odor-carpet-cleaning',
		'pet-sitting',
	);
	if ( in_array( $path, $lead_demo_routes, true ) ) {
		wp_enqueue_script( 'pethomescout-lead-demo', get_template_directory_uri() . '/js/lead-demo.js', array(), '1.0.1', true );
	}

	$hub_filter_routes = array(
		'cleaning-odor',
		'family-home',
		'smart-tech',
		'best-robot-vacuum-for-dog-hair',
		'robot-vacuums-for-pet-hair',
	);
	if ( in_array( $path, $hub_filter_routes, true ) ) {
		wp_enqueue_script( 'pethomescout-hub-filter', get_template_directory_uri() . '/js/hub-filter.js', array(), '1.0.1', true );
	}

	if ( 'pet-tech-selector' === $path ) {
		wp_enqueue_script( 'pethomescout-selector', get_template_directory_uri() . '/js/selector.js', array(), '1.0.1', true );
	}

	// Front-end config only. MVP lead forms are demo-only and do not submit PII.
	wp_localize_script( 'pethomescout-main', 'petHomeScoutData', array(
		'themeUri' => get_template_directory_uri(),
	) );
}
add_action( 'wp_enqueue_scripts', 'pethomescout_scripts' );

/**
 * Establish early connections for the font stylesheet and font files.
 */
function pethomescout_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' !== $relation_type ) {
		return $urls;
	}

	$urls[] = 'https://fonts.googleapis.com';
	$urls[] = array(
		'href'        => 'https://fonts.gstatic.com',
		'crossorigin' => 'anonymous',
	);

	return $urls;
}
add_filter( 'wp_resource_hints', 'pethomescout_resource_hints', 10, 2 );

/**
 * Serve plain robots.txt in local previews where pretty permalink routing may
 * otherwise fall through to the theme preview template.
 */
function pethomescout_plain_preview_robots_txt() {
	$path = pethomescout_current_path();
	if ( 'robots.txt' !== $path ) {
		return;
	}

	while ( ob_get_level() > 0 ) {
		ob_end_clean();
	}

	header( 'Content-Type: text/plain; charset=utf-8' );
	if ( pethomescout_is_preview_host() ) {
		echo "User-agent: *\nDisallow: /\n";
	} else {
		echo "User-agent: *\nDisallow:\nSitemap: " . esc_url_raw( home_url( '/wp-sitemap.xml' ) ) . "\n";
	}
	exit;
}
add_action( 'template_redirect', 'pethomescout_plain_preview_robots_txt', 0 );

/**
 * Provide a lightweight XML sitemap in local previews before WP permalink
 * routing and SEO plugins are fully configured.
 */
function pethomescout_plain_preview_sitemap_xml() {
	$path = pethomescout_current_path();
	if ( ! in_array( $path, array( 'wp-sitemap.xml', 'sitemap.xml' ), true ) ) {
		return;
	}

	while ( ob_get_level() > 0 ) {
		ob_end_clean();
	}

	$paths = array(
		'/',
		'/family-home/',
		'/smart-tech/',
		'/smart-tech-comparison/',
		'/cleaning-odor/',
		'/services-insurance/',
		'/robot-vacuums-for-pet-hair/',
		'/best-robot-vacuum-for-dog-hair/',
		'/pet-tech-selector/',
		'/pet-insurance/',
		'/mobile-pet-grooming/',
		'/pet-odor-carpet-cleaning/',
		'/pet-sitting/',
		'/about/',
		'/methodology/',
		'/how-we-test/',
		'/affiliate-disclosure/',
		'/advertising-disclosure/',
		'/privacy-policy/',
		'/terms/',
		'/do-not-sell-or-share/',
		'/contact/',
	);

	header( 'Content-Type: application/xml; charset=utf-8' );
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
	foreach ( $paths as $url_path ) {
		echo "\t<url><loc>" . esc_url( home_url( $url_path ) ) . "</loc></url>\n";
	}
	echo "</urlset>\n";
	exit;
}
add_action( 'template_redirect', 'pethomescout_plain_preview_sitemap_xml', 0 );

/**
 * Redirect legacy selector URLs to the canonical Pet Tech Selector route.
 */
function pethomescout_redirect_legacy_selector_routes() {
	$path = pethomescout_current_path();
	if ( in_array( $path, array( 'tool', 'matchmaker', 'robot-vacuum-selector' ), true ) ) {
		wp_safe_redirect( home_url( '/pet-tech-selector/' ), 301 );
		exit;
	}

	if ( in_array( $path, array( 'lead-form', 'services-reference' ), true ) ) {
		wp_safe_redirect( home_url( '/services-insurance/' ), 301 );
		exit;
	}

	if ( 'products' === $path ) {
		wp_safe_redirect( home_url( '/smart-tech/' ), 301 );
		exit;
	}

	$service_route_redirects = array(
		'pet-insurance-quotes' => '/pet-insurance/',
		'mobile-dog-grooming'  => '/mobile-pet-grooming/',
		'pet-odor-cleaning'    => '/pet-odor-carpet-cleaning/',
	);
	if ( isset( $service_route_redirects[ $path ] ) ) {
		wp_safe_redirect( home_url( $service_route_redirects[ $path ] ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'pethomescout_redirect_legacy_selector_routes', 1 );

/**
 * Preview routes are rendered by theme templates even when no real Page
 * record exists. Prevent WordPress canonical guessing from bouncing those
 * routes to stale legacy slugs and back into the canonical route.
 */
function pethomescout_disable_preview_route_canonical( $redirect_url ) {
	$preview_routes = array(
		'services-insurance', 'pet-insurance', 'mobile-pet-grooming',
		'pet-sitting', 'pet-odor-carpet-cleaning', 'cleaning-odor',
		'smart-tech', 'smart-tech-comparison', 'pet-tech-selector',
		'best-robot-vacuum-for-dog-hair', 'robot-vacuums-for-pet-hair',
		'family-home', 'about', 'methodology', 'affiliate-disclosure',
		'advertising-disclosure', 'privacy-policy', 'terms',
		'do-not-sell-or-share', 'how-we-test', 'contact',
	);
	return in_array( pethomescout_current_path(), $preview_routes, true ) ? false : $redirect_url;
}
add_filter( 'redirect_canonical', 'pethomescout_disable_preview_route_canonical', 10, 1 );

/**
 * Keep backend-only CPT slugs out of the public preview surface.
 */
function pethomescout_block_backend_public_routes() {
	$path       = pethomescout_current_path();
	$first_slug = '' !== $path ? strtok( $path, '/' ) : '';
	$backend_slugs = array( 'product_test', 'merchant', 'offer', 'service', 'insurance_provider' );

	if ( in_array( $first_slug, $backend_slugs, true ) ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		nocache_headers();
	}
}
add_action( 'template_redirect', 'pethomescout_block_backend_public_routes', 2 );

/**
 * Keep the local preview useful before an administrator has created the Pages.
 * Real Pages still win; these mappings only run for the matching 404 routes.
 */
function pethomescout_preview_template_routes( $template ) {
	$path = pethomescout_current_path();
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
		'services-insurance'         => 'page-services-insurance.php',
		'pet-insurance'              => 'page-pet-insurance-quotes.php',
		'pet-insurance-for-french-bulldogs' => 'page-pet-insurance-quotes.php',
		'mobile-pet-grooming'        => 'page-mobile-dog-grooming.php',
		'pet-sitting'                => 'page-pet-sitting.php',
		'pet-odor-carpet-cleaning'   => 'page-pet-odor-cleaning.php',
		'cleaning-odor'              => 'page-cleaning-hub.php',
		'smart-tech'                => 'page-smart-tech-hub.php',
		'smart-tech-comparison'     => 'page-smart-tech.php',
		'pet-tech-selector'          => 'page-robot-vacuum-selector.php',
		'best-robot-vacuum-for-dog-hair' => 'page-vacuum-reviews.php',
		'robot-vacuums-for-pet-hair' => 'page-robot-vacuums-for-pet-hair.php',
		'family-home'               => 'page-family-home.php',
		'about'                     => 'page-static-info.php',
		'methodology'               => 'page-static-info.php',
		'affiliate-disclosure'      => 'page-static-info.php',
		'advertising-disclosure'    => 'page-static-info.php',
		'privacy-policy'            => 'page-static-info.php',
		'terms'                     => 'page-static-info.php',
		'do-not-sell-or-share'      => 'page-static-info.php',
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
	$path = pethomescout_current_path();
	$titles = array(
		''                              => 'PetHomeScout: Product Research & Services for Pet-Friendly Homes',
		'services-insurance'            => 'Pet Insurance & Local Pet Care Guides | PetHomeScout',
		'pet-insurance'                 => 'Compare Pet Insurance Quote Factors | PetHomeScout',
		'pet-insurance-for-french-bulldogs' => 'Pet Insurance for French Bulldogs | PetHomeScout',
		'mobile-pet-grooming'           => 'Mobile Pet Grooming Guide | PetHomeScout',
		'pet-sitting'                   => 'Pet Sitting & Dog Walking Checklist | PetHomeScout',
		'pet-odor-carpet-cleaning'      => 'Pet Odor Carpet Cleaning Guide | PetHomeScout',
		'family-home'                   => 'Pet-Friendly Furniture, Flooring & Home Safety | PetHomeScout',
		'smart-tech'                    => 'Smart Pet Technology Reviews & Comparisons | PetHomeScout',
		'smart-tech-comparison'         => 'Smart Pet Tech Comparison: Research-Led Fixtures | PetHomeScout',
		'cleaning-odor'                 => 'Pet Stain, Odor & Air Quality Guides | PetHomeScout',
		'best-robot-vacuum-for-dog-hair' => 'Best Robot Vacuums for Dog Hair: Research-Led Picks | PetHomeScout',
		'robot-vacuums-for-pet-hair'    => 'Robot Vacuums for Pet Hair: Research-Led Hub | PetHomeScout',
		'pet-tech-selector'             => 'Pet Tech Selector for Pet-Friendly Homes | PetHomeScout',
		'about'                         => 'About PetHomeScout | Independent Pet-Friendly Home Guidance',
		'methodology'                   => 'PetHomeScout Methodology | Evidence & Decision Standards',
		'how-we-test'                   => 'How We Review Evidence | PetHomeScout',
		'affiliate-disclosure'          => 'Affiliate Disclosure | PetHomeScout',
		'advertising-disclosure'        => 'Advertising Disclosure | PetHomeScout',
		'privacy-policy'                => 'Privacy Policy | PetHomeScout',
		'terms'                         => 'Terms of Use | PetHomeScout',
		'do-not-sell-or-share'          => 'Do Not Sell or Share | PetHomeScout',
		'contact'                       => 'Contact PetHomeScout Editorial & Partner Teams',
	);
	if ( isset( $titles[ $path ] ) ) {
		$parts['title'] = $titles[ $path ];
		unset( $parts['site'] );
	} elseif ( 0 === strpos( $path, 'go/' ) ) {
		$parts['title'] = 'Merchant Destination Pending | PetHomeScout';
		unset( $parts['site'] );
	}
	return $parts;
}
add_filter( 'document_title_parts', 'pethomescout_preview_document_title' );

/**
 * Supply route metadata to Rank Math for custom preview templates.
 * Real Posts/Pages remain controlled by Rank Math's editor fields.
 */
function pethomescout_rank_math_preview_metadata() {
	$path = pethomescout_current_path();
	if ( ! pethomescout_is_preview_host() ) {
		return array();
	}

	$descriptions = array(
		''                                => 'Compare pet-home products, smart technology, cleaning solutions, insurance factors, and local care services for U.S. households with dogs and cats.',
		'services-insurance'             => 'Explore pet insurance factors and local pet-care service guides for U.S. households, with privacy-first demo quote flows.',
		'pet-insurance'                  => 'Review policy factors, exclusions, waiting periods, and consent details before requesting pet insurance quotes.',
		'mobile-pet-grooming'            => 'Learn what to compare when evaluating mobile pet grooming services, including price factors and provider questions.',
		'pet-sitting'                    => 'Use a privacy-first checklist to compare pet sitting, dog walking, and boarding routines before sharing information.',
		'pet-odor-carpet-cleaning'       => 'Compare DIY and professional paths for dog urine odor and pet carpet cleaning problems in U.S. homes.',
		'family-home'                    => 'Research-led guidance for pet-friendly furniture, flooring, gates, and home-safety decisions.',
		'smart-tech'                    => 'Research-led smart pet technology comparisons for robot vacuums, pet automation, and cleaner pet-friendly homes.',
		'smart-tech-comparison'          => 'Compare smart pet technology by household fit, pet-hair handling, ownership friction, and evidence status.',
		'cleaning-odor'                  => 'Pet stain, odor, air quality, and carpet-cleaning guides for households with dogs and cats.',
		'best-robot-vacuum-for-dog-hair' => 'Research-led robot vacuum picks for homes with dog hair, carpet, and mixed floors.',
		'robot-vacuums-for-pet-hair'     => 'Start with pet hair, flooring, maintenance, and evidence status before comparing robot vacuum fixtures.',
		'pet-tech-selector'              => 'Preview a fixture-based pet tech selector for matching household, pet, and floor conditions.',
	);
	return isset( $descriptions[ $path ] ) ? array( 'description' => $descriptions[ $path ] ) : array();
}

function pethomescout_rank_math_preview_title( $title ) {
	if ( ! pethomescout_is_preview_host() ) {
		return $title;
	}
	$parts = pethomescout_preview_document_title( array( 'title' => $title, 'site' => get_bloginfo( 'name' ) ) );
	return isset( $parts['title'] ) ? $parts['title'] : $title;
}
add_filter( 'rank_math/frontend/title', 'pethomescout_rank_math_preview_title' );

function pethomescout_rank_math_preview_description( $description ) {
	$metadata = pethomescout_rank_math_preview_metadata();
	return isset( $metadata['description'] ) ? $metadata['description'] : $description;
}
add_filter( 'rank_math/frontend/description', 'pethomescout_rank_math_preview_description' );

function pethomescout_rank_math_preview_canonical( $canonical ) {
	if ( ! empty( $canonical ) ) {
		$GLOBALS['pethomescout_rank_math_has_canonical'] = true;
	}
	if ( ! pethomescout_is_preview_host() ) {
		return $canonical;
	}
	$path = pethomescout_current_path();
	return '' === $path ? home_url( '/' ) : home_url( '/' . trailingslashit( $path ) );
}
add_filter( 'rank_math/frontend/canonical', 'pethomescout_rank_math_preview_canonical' );
add_filter( 'rank_math/opengraph/facebook/og_title', 'pethomescout_rank_math_preview_title' );
add_filter( 'rank_math/opengraph/facebook/og_description', 'pethomescout_rank_math_preview_description' );

function pethomescout_rank_math_preview_image( $image ) {
	if ( ! pethomescout_is_preview_host() ) {
		return $image;
	}
	return home_url( '/wp-content/themes/pethomescout/assets/hero-pet-home.webp' );
}
add_filter( 'rank_math/opengraph/facebook/image', 'pethomescout_rank_math_preview_image' );
add_filter( 'rank_math/opengraph/twitter/image', 'pethomescout_rank_math_preview_image' );

function pethomescout_rank_math_schema_probe( $data ) {
	if ( ! empty( $data ) ) {
		$GLOBALS['pethomescout_rank_math_has_schema'] = true;
	}
	return $data;
}
add_filter( 'rank_math/json_ld', 'pethomescout_rank_math_schema_probe', 5 );

/**
 * Rank Math does not emit description tags for the theme's synthetic preview
 * routes because they have no persisted Page/Post object. Fill that narrow
 * gap only when the query has no object ID; real editor-managed content stays
 * fully owned by Rank Math.
 */
function pethomescout_rank_math_preview_head_fallback() {
	if ( ! pethomescout_is_preview_host() ) {
		return;
	}
	$metadata = pethomescout_rank_math_preview_metadata();
	$queried_id = get_queried_object_id();
	$stored_description = $queried_id ? get_post_meta( $queried_id, 'rank_math_description', true ) : '';
	if ( empty( $metadata['description'] ) || $stored_description ) {
		return;
	}
	if ( ! $queried_id && empty( $GLOBALS['pethomescout_rank_math_has_canonical'] ) ) {
		$path = pethomescout_current_path();
		$canonical = '' === $path ? home_url( '/' ) : home_url( '/' . trailingslashit( $path ) );
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $canonical ) );
	}
	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $metadata['description'] ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $metadata['description'] ) );
	$image = pethomescout_rank_math_preview_image( '' );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $image ) );
	// This fixture route uses a normal Page object but its synthetic review
	// presentation may not receive Rank Math's JSON-LD output. Keep the
	// fallback explicit for that route so preview audits see a complete head.
	if ( ! empty( $GLOBALS['pethomescout_rank_math_has_schema'] ) && 'pet-insurance-for-french-bulldogs' !== $path ) {
		return;
	}
	$path       = pethomescout_current_path();
	$site_url   = home_url( '/' );
	$page_url   = home_url( '/' . trailingslashit( $path ) );
	$schema     = array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array( '@type' => 'Organization', '@id' => $site_url . '#organization', 'name' => 'PetHomeScout', 'url' => $site_url ),
			array( '@type' => 'WebSite', '@id' => $site_url . '#website', 'url' => $site_url, 'name' => 'PetHomeScout', 'publisher' => array( '@id' => $site_url . '#organization' ) ),
			array( '@type' => 'WebPage', '@id' => $page_url . '#webpage', 'url' => $page_url, 'name' => pethomescout_rank_math_preview_title( get_bloginfo( 'name' ) ), 'description' => $metadata['description'], 'isPartOf' => array( '@id' => $site_url . '#website' ) ),
			array( '@type' => 'BreadcrumbList', 'itemListElement' => array( array( '@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site_url ), array( '@type' => 'ListItem', 'position' => 2, 'name' => ucwords( str_replace( '-', ' ', basename( $path ) ) ), 'item' => $page_url ) ) ),
		),
	);
	printf( '<script type="application/ld+json">%s</script>' . "\n", wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
}
add_action( 'wp_head', 'pethomescout_rank_math_preview_head_fallback', 99 );

/**
 * Ensure the breed-specific fixture route has a visible WebPage graph in
 * preview audits even when Rank Math has no persisted schema configuration
 * for the fixture Page.
 */
function pethomescout_preview_french_bulldog_schema() {
	if ( ! pethomescout_is_preview_host() || 'pet-insurance-for-french-bulldogs' !== pethomescout_current_path() ) {
		return;
	}
	$site_url = home_url( '/' );
	$page_url = home_url( '/pet-insurance-for-french-bulldogs/' );
	$schema   = array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array( '@type' => 'Organization', '@id' => $site_url . '#organization', 'name' => 'PetHomeScout', 'url' => $site_url ),
			array( '@type' => 'WebSite', '@id' => $site_url . '#website', 'url' => $site_url, 'name' => 'PetHomeScout', 'publisher' => array( '@id' => $site_url . '#organization' ) ),
			array( '@type' => 'WebPage', '@id' => $page_url . '#webpage', 'url' => $page_url, 'name' => 'Pet Insurance for French Bulldogs | PetHomeScout', 'description' => 'Compare pet insurance factors, exclusions, waiting periods, and reimbursement details for French Bulldog households.', 'isPartOf' => array( '@id' => $site_url . '#website' ) ),
			array( '@type' => 'BreadcrumbList', 'itemListElement' => array( array( '@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $site_url ), array( '@type' => 'ListItem', 'position' => 2, 'name' => 'Pet Insurance for French Bulldogs', 'item' => $page_url ) ) ),
		),
	);
	printf( '<script type="application/ld+json">%s</script>' . "\n", wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
}
add_action( 'wp_head', 'pethomescout_preview_french_bulldog_schema', 1000 );

/**
 * Lightweight metadata for local preview routes before SEO plugins are configured.
 */
function pethomescout_preview_head_meta() {
	// Rank Math and Yoast own canonical, robots, social, and standard schema
	// output when either plugin is active. Keep this fallback plugin-free only.
	if ( function_exists( 'rank_math' ) || defined( 'WPSEO_VERSION' ) || class_exists( 'WPSEO_Options' ) ) {
		return;
	}

	$path = pethomescout_current_path();
	$titles = array(
		''                              => 'PetHomeScout: Product Research & Services for Pet-Friendly Homes',
		'services-insurance'            => 'Pet Insurance & Local Pet Care Guides | PetHomeScout',
		'pet-insurance'                 => 'Compare Pet Insurance Quote Factors | PetHomeScout',
		'mobile-pet-grooming'           => 'Mobile Pet Grooming Guide | PetHomeScout',
		'pet-sitting'                   => 'Pet Sitting & Dog Walking Checklist | PetHomeScout',
		'pet-odor-carpet-cleaning'      => 'Pet Odor Carpet Cleaning Guide | PetHomeScout',
		'family-home'                   => 'Pet-Friendly Furniture, Flooring & Home Safety | PetHomeScout',
		'smart-tech'                    => 'Smart Pet Technology Reviews & Comparisons | PetHomeScout',
		'smart-tech-comparison'         => 'Smart Pet Tech Comparison: Research-Led Fixtures | PetHomeScout',
		'cleaning-odor'                 => 'Pet Stain, Odor & Air Quality Guides | PetHomeScout',
		'best-robot-vacuum-for-dog-hair' => 'Best Robot Vacuums for Dog Hair: Research-Led Picks | PetHomeScout',
		'robot-vacuums-for-pet-hair'    => 'Robot Vacuums for Pet Hair: Research-Led Hub | PetHomeScout',
		'pet-tech-selector'             => 'Pet Tech Selector for Pet-Friendly Homes | PetHomeScout',
		'about'                         => 'About PetHomeScout | Independent Pet-Friendly Home Guidance',
		'methodology'                   => 'PetHomeScout Methodology | Evidence & Decision Standards',
		'how-we-test'                   => 'How We Review Evidence | PetHomeScout',
		'affiliate-disclosure'          => 'Affiliate Disclosure | PetHomeScout',
		'advertising-disclosure'        => 'Advertising Disclosure | PetHomeScout',
		'privacy-policy'                => 'Privacy Policy | PetHomeScout',
		'terms'                         => 'Terms of Use | PetHomeScout',
		'do-not-sell-or-share'          => 'Do Not Sell or Share | PetHomeScout',
		'contact'                       => 'Contact PetHomeScout Editorial & Partner Teams',
	);
	$descriptions = array(
		''                              => 'Compare pet-home products, smart technology, cleaning solutions, insurance factors, and local care services for U.S. households with dogs and cats.',
		'services-insurance'            => 'Explore pet insurance factors and local pet-care service guides for U.S. households, with privacy-first demo quote flows.',
		'pet-insurance'                 => 'Review the policy factors, exclusions, waiting periods, and consent details pet owners should compare before requesting pet insurance quotes.',
		'pet-insurance-for-french-bulldogs' => 'Compare pet insurance factors, exclusions, waiting periods, and reimbursement details for French Bulldog households.',
		'mobile-pet-grooming'           => 'Learn what to compare when evaluating mobile pet grooming services, from price factors to provider questions and demo quote flow details.',
		'pet-sitting'                   => 'Use a privacy-first checklist to compare pet sitting, dog walking, boarding routines, and provider questions before sharing personal information.',
		'pet-odor-carpet-cleaning'      => 'Compare DIY and professional paths for dog urine odor and pet carpet cleaning problems in U.S. homes.',
		'family-home'                   => 'Research-led guidance for pet-friendly furniture, flooring, gates, and home-safety decisions.',
		'smart-tech'                    => 'Research-led smart pet technology comparisons for robot vacuums, pet automation, and cleaner pet-friendly homes.',
		'smart-tech-comparison'         => 'Compare research-led smart pet technology fixtures by household fit, pet-hair handling, ownership friction, and evidence status.',
		'cleaning-odor'                 => 'Pet stain, odor, air quality, and carpet-cleaning guides for households with dogs and cats.',
		'best-robot-vacuum-for-dog-hair' => 'Research-led robot vacuum picks and comparison factors for homes with dog hair, carpet, and mixed floors.',
		'robot-vacuums-for-pet-hair'    => 'Start with pet hair, flooring, maintenance, and evidence status before comparing robot vacuum fixtures.',
		'pet-tech-selector'             => 'Preview a fixture-based pet tech selector for matching robot vacuum needs to household, pet, and floor conditions.',
		'about'                         => 'Learn what PetHomeScout is building: independent, evidence-labeled product and service guidance for U.S. pet-friendly homes.',
		'methodology'                   => 'Review the PetHomeScout decision standards for evidence labels, ScoutScore logic, limitations, and research-led recommendations.',
		'how-we-test'                   => 'See how PetHomeScout labels evidence, separates founder-tested records from research-led guidance, and documents product limitations.',
		'affiliate-disclosure'          => 'Understand how PetHomeScout may earn affiliate compensation and how commercial relationships are separated from editorial guidance.',
		'advertising-disclosure'        => 'Review PetHomeScout advertising and partner disclosure standards for service, insurance, and affiliate experiences.',
		'privacy-policy'                => 'Read how PetHomeScout handles privacy, demo form data, and future service-matching information.',
		'terms'                         => 'Review the terms for using PetHomeScout product research, tools, demo flows, and service information.',
		'do-not-sell-or-share'          => 'Learn how PetHomeScout handles do-not-sell or share requests and privacy choices for future data-sharing workflows.',
		'contact'                       => 'Contact PetHomeScout for support, editorial questions, partner inquiries, and privacy requests.',
	);
	if ( isset( $descriptions[ $path ] ) ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $descriptions[ $path ] ) );
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $descriptions[ $path ] ) );
	} elseif ( 0 === strpos( $path, 'go/' ) ) {
		$description = 'Internal merchant placeholder for PetHomeScout preview environments. No external affiliate destination is opened.';
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) );
	}

	$canonical_path = '' === $path ? '/' : '/' . trailingslashit( $path );
	$page_title = $titles[ $path ] ?? ( 0 === strpos( $path, 'go/' ) ? 'Merchant Destination Pending | PetHomeScout' : get_bloginfo( 'name' ) );
	$og_type    = is_singular( 'post' ) ? 'article' : 'website';
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $page_title ) );
	printf( '<meta property="og:type" content="%s">' . "\n", esc_attr( $og_type ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( home_url( $canonical_path ) ) );
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	printf( '<link rel="canonical" href="%s">' . "\n", esc_url( home_url( $canonical_path ) ) );

	$site_url = home_url( '/' );
	$schema = array(
		'@context' => 'https://schema.org',
		'@graph'   => array(
			array(
				'@type' => 'Organization',
				'@id'   => $site_url . '#organization',
				'name'  => 'PetHomeScout',
				'url'   => $site_url,
			),
			array(
				'@type'     => 'WebSite',
				'@id'       => $site_url . '#website',
				'url'       => $site_url,
				'name'      => 'PetHomeScout',
				'publisher' => array( '@id' => $site_url . '#organization' ),
			),
		),
	);

	$collection_paths = array(
		'family-home',
		'smart-tech',
		'cleaning-odor',
		'services-insurance',
		'robot-vacuums-for-pet-hair',
	);

	$schema['@graph'][] = array(
		'@type'       => in_array( $path, $collection_paths, true ) || '' === $path ? 'CollectionPage' : 'WebPage',
		'@id'         => home_url( $canonical_path ) . '#webpage',
		'url'         => home_url( $canonical_path ),
		'name'        => $page_title,
		'description' => $descriptions[ $path ] ?? '',
		'isPartOf'    => array( '@id' => $site_url . '#website' ),
	);

	if ( '' !== $path ) {
		$schema['@graph'][] = array(
			'@type'           => 'BreadcrumbList',
			'itemListElement' => array(
				array(
					'@type'    => 'ListItem',
					'position' => 1,
					'name'     => 'Home',
					'item'     => $site_url,
				),
				array(
					'@type'    => 'ListItem',
					'position' => 2,
					'name'     => ucwords( str_replace( '-', ' ', basename( $path ) ) ),
					'item'     => home_url( $canonical_path ),
				),
			),
		);
	}

	printf( '<script type="application/ld+json">%s</script>' . "\n", wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
}
add_action( 'wp_head', 'pethomescout_preview_head_meta', 1 );

function pethomescout_is_preview_host() {
	$host = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : '';
	return (bool) preg_match( '/(127\.0\.0\.1|localhost|\.loca\.lt|trycloudflare\.com|ngrok)/i', $host );
}

function pethomescout_preview_robots( $robots ) {
	if ( pethomescout_is_preview_host() ) {
		$robots['noindex']  = true;
		$robots['nofollow'] = true;
		unset( $robots['index'], $robots['follow'] );
	}
	return $robots;
}
add_filter( 'wp_robots', 'pethomescout_preview_robots' );

function pethomescout_preview_robots_txt( $output, $public ) {
	if ( pethomescout_is_preview_host() ) {
		return "User-agent: *\nDisallow: /\n";
	}
	return $output . "\nSitemap: " . esc_url_raw( home_url( '/wp-sitemap.xml' ) ) . "\n";
}
add_filter( 'robots_txt', 'pethomescout_preview_robots_txt', 10, 2 );

/**
 * Add a HTTP-level noindex guard for local/staging previews and /go/ routes.
 */
function pethomescout_send_x_robots_tag() {
	if ( pethomescout_is_preview_host() || 0 === strpos( pethomescout_current_path(), 'go/' ) ) {
		header( 'X-Robots-Tag: noindex, nofollow', false );
	}
}
add_action( 'send_headers', 'pethomescout_send_x_robots_tag' );

/**
 * Helper function to retrieve product affiliate link.
 * Automatically checks for custom fields and maps them to a secure local redirect pathway (/go/slug).
 */
function pethomescout_get_affiliate_link( $product_id, $merchant = 'chewy' ) {
	$merchant  = sanitize_key( $merchant );
	$post_slug = sanitize_title( get_post_field( 'post_name', absint( $product_id ) ) );
	return esc_url( home_url( "/go/{$merchant}/{$post_slug}/" ) );
}

/**
 * Return whether a product has a completed founder-test record.
 */
function pethomescout_has_completed_product_test( $product_id ) {
	$product_id = absint( $product_id );
	if ( ! $product_id || ! post_type_exists( 'product_test' ) ) {
		return false;
	}

	$tests = get_posts( array(
		'post_type'      => 'product_test',
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'meta_query'     => array(
			'relation' => 'AND',
			array(
				'key'     => 'related_product',
				'value'   => (string) $product_id,
				'compare' => '=',
			),
			array(
				'key'     => 'completed_rubric',
				'value'   => '1',
				'compare' => '=',
			),
		),
	) );

	return ! empty( $tests );
}

/**
 * Normalize product evidence fields for templates, tools, and future APIs.
 */
function pethomescout_get_product_evidence( $product_id ) {
	$product_id      = absint( $product_id );
	$evidence_status = sanitize_key( (string) pethomescout_editorial_field( 'evidence_status', $product_id, '' ) );
	$status_aliases  = array(
		'research-led'          => 'research_led',
		'specification-reviewed' => 'specification_reviewed',
		'not-yet-verified'      => 'not_yet_verified',
		'founder-tested'        => 'founder_tested',
	);
	if ( isset( $status_aliases[ $evidence_status ] ) ) {
		$evidence_status = $status_aliases[ $evidence_status ];
	}

	$score         = pethomescout_editorial_field( 'scout_score', $product_id, '' );
	$last_reviewed = pethomescout_editorial_field( 'last_reviewed', $product_id, '' );
	$founder_tested = 'founder_tested' === $evidence_status && pethomescout_has_completed_product_test( $product_id );
	$publishable_score = is_numeric( $score )
		&& in_array( $evidence_status, array( 'founder_tested', 'research_led', 'specification_reviewed' ), true )
		&& ! empty( $last_reviewed )
		&& ( 'founder_tested' !== $evidence_status || $founder_tested );

	return array(
		'status'            => $evidence_status ?: 'not_yet_verified',
		'score'             => is_numeric( $score ) ? (float) $score : null,
		'last_reviewed'     => sanitize_text_field( (string) $last_reviewed ),
		'founder_tested'    => $founder_tested,
		'publishable_score' => $publishable_score,
		'methodology_url'   => home_url( '/how-we-test/' ),
		'limitations'       => sanitize_text_field( (string) pethomescout_editorial_field( 'limitations', $product_id, 'Evidence is limited to the documented research or test record.' ) ),
	);
}

/**
 * Return a stable score breakdown for the ScoutScore UI.
 */
function pethomescout_get_scout_score_breakdown( $product_id ) {
	$evidence = pethomescout_get_product_evidence( $product_id );
	$weights  = array(
		'Pet hair handling'   => 30,
		'Floor compatibility' => 20,
		'Ownership friction'  => 20,
		'Pet safety'          => 15,
		'Value'               => 15,
	);
	return array( 'score' => $evidence['publishable_score'] ? $evidence['score'] : null, 'weights' => $weights, 'evidence' => $evidence );
}

/**
 * Resolve a backend merchant record by its stable slug.
 */
function pethomescout_get_merchant_record_id( $merchant_slug ) {
	$merchant_slug = sanitize_key( $merchant_slug );
	if ( '' === $merchant_slug || ! post_type_exists( 'merchant' ) ) {
		return 0;
	}

	$merchants = get_posts( array(
		'post_type'      => 'merchant',
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'meta_key'       => 'merchant_slug',
		'meta_value'     => $merchant_slug,
	) );

	return ! empty( $merchants ) ? absint( $merchants[0] ) : 0;
}

/**
 * Resolve a product/merchant offer record without exposing its destination.
 */
function pethomescout_get_offer_record_id( $product_id, $merchant_slug ) {
	$product_id  = absint( $product_id );
	$merchant_id = pethomescout_get_merchant_record_id( $merchant_slug );
	if ( ! $product_id || ! $merchant_id || ! post_type_exists( 'offer' ) ) {
		return 0;
	}

	$offers = get_posts( array(
		'post_type'      => 'offer',
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'meta_query'     => array(
			'relation' => 'AND',
			array( 'key' => 'related_product', 'value' => (string) $product_id, 'compare' => '=' ),
			array( 'key' => 'related_merchant', 'value' => (string) $merchant_id, 'compare' => '=' ),
		),
	) );

	return ! empty( $offers ) ? absint( $offers[0] ) : 0;
}

/**
 * Return normalized merchant/offer data for commercial UI components.
 */
function pethomescout_get_offer_data( $product_id, $merchant_slug ) {
	$merchant_slug = sanitize_key( $merchant_slug );
	$offer_id      = pethomescout_get_offer_record_id( $product_id, $merchant_slug );
	$merchant_id   = pethomescout_get_merchant_record_id( $merchant_slug );
	$offer_status  = $offer_id ? sanitize_key( (string) get_post_meta( $offer_id, 'offer_status', true ) ) : 'pending';
	$program_status = $merchant_id ? sanitize_key( (string) get_post_meta( $merchant_id, 'program_status', true ) ) : 'pending';
	$approved = $offer_id && in_array( $offer_status, array( 'approved', 'active', 'live' ), true ) && in_array( $program_status, array( 'approved', 'active', 'live' ), true );
	return array(
		'offer_id'       => $offer_id,
		'merchant_id'    => $merchant_id,
		'merchant_slug'  => $merchant_slug,
		'merchant_name'  => $merchant_id ? get_the_title( $merchant_id ) : ucwords( str_replace( '-', ' ', $merchant_slug ) ),
		'offer_status'   => $offer_status,
		'program_status' => $program_status,
		'approved'       => (bool) $approved,
		'price'          => $offer_id ? sanitize_text_field( (string) get_post_meta( $offer_id, 'display_price', true ) ) : '',
		'last_checked'   => $offer_id ? sanitize_text_field( (string) get_post_meta( $offer_id, 'last_checked', true ) ) : '',
		'url'            => $approved ? pethomescout_get_affiliate_link( $product_id, $merchant_slug ) : '',
	);
}

/**
 * Check whether a product/merchant offer is approved for live commercial CTA output.
 *
 * MVP rule: prices and "Check price" links stay disabled unless an editor explicitly
 * marks the merchant offer as approved in product metadata.
 */
function pethomescout_offer_is_approved( $product_id, $merchant = 'chewy' ) {
	$offer_id = pethomescout_get_offer_record_id( $product_id, $merchant );
	if ( $offer_id ) {
		$offer_status = sanitize_key( (string) get_post_meta( $offer_id, 'offer_status', true ) );
		$merchant_id  = pethomescout_get_merchant_record_id( $merchant );
		$program_status = $merchant_id ? sanitize_key( (string) get_post_meta( $merchant_id, 'program_status', true ) ) : '';

		return in_array( $offer_status, array( 'approved', 'active', 'live' ), true )
			&& in_array( $program_status, array( 'approved', 'active', 'live' ), true );
	}

	$status = get_post_meta( $product_id, "offer_status_{$merchant}", true );
	if ( empty( $status ) ) {
		$status = get_post_meta( $product_id, "{$merchant}_offer_status", true );
	}

	return in_array( strtolower( (string) $status ), array( 'approved', 'active', 'live' ), true );
}

/**
 * Live offers stay disabled until an owner explicitly enables them in config.
 */
function pethomescout_live_offers_enabled() {
	return defined( 'PETHOMESCOUT_ENABLE_LIVE_OFFERS' ) && true === PETHOMESCOUT_ENABLE_LIVE_OFFERS;
}

/**
 * Return an approved external destination only when the live-offer flag is on.
 * This helper is intentionally not wired into the preview `/go/` route yet.
 */
function pethomescout_get_approved_offer_destination( $product_id, $merchant_slug ) {
	if ( ! pethomescout_live_offers_enabled() ) {
		return '';
	}

	$offer_id = pethomescout_get_offer_record_id( $product_id, $merchant_slug );
	if ( ! $offer_id || ! pethomescout_offer_is_approved( $product_id, $merchant_slug ) ) {
		return '';
	}

	$destination = esc_url_raw( (string) get_post_meta( $offer_id, 'destination_url', true ) );
	$scheme      = strtolower( (string) wp_parse_url( $destination, PHP_URL_SCHEME ) );
	if ( '' === $destination || ! in_array( $scheme, array( 'http', 'https' ), true ) || ! wp_http_validate_url( $destination ) ) {
		return '';
	}

	return $destination;
}

/**
 * Resolve /go/{merchant}/{product}/ without exposing raw destinations in content.
 */
function pethomescout_handle_go_route() {
	$path  = trim( pethomescout_current_path(), '/' );
	$parts = array_values( array_filter( explode( '/', $path ) ) );
	if ( count( $parts ) < 2 || 'go' !== $parts[0] ) {
		return;
	}
	$merchant = sanitize_key( $parts[1] );
	$product  = isset( $parts[2] ) ? sanitize_title( $parts[2] ) : '';
	$product_record = $product ? get_page_by_path( $product, OBJECT, 'pet_product' ) : null;
	$product_id = ( $product_record instanceof WP_Post ) ? absint( $product_record->ID ) : 0;
	$destination = $product_id ? pethomescout_get_approved_offer_destination( $product_id, $merchant ) : '';
	if ( $destination ) {
		wp_redirect( $destination, 302, 'PetHomeScout Offer Router' );
		exit;
	}
	// The placeholder template remains the safe default for pending, missing, or disabled offers.
}
add_action( 'template_redirect', 'pethomescout_handle_go_route', 3 );

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
		'claw_rating'      => 'Scratch-resistance evidence',
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
 * Read an editorial field while remaining usable before ACF is activated.
 */
function pethomescout_editorial_field( $field, $post_id = 0, $default = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$value   = function_exists( 'get_field' ) ? get_field( $field, $post_id ) : get_post_meta( $post_id, $field, true );
	return ( null === $value || '' === $value || false === $value ) ? $default : $value;
}

/**
 * Return hub display values with safe fallbacks for existing fixture pages.
 */
function pethomescout_hub_values( $eyebrow, $title, $intro, $post_id = 0 ) {
	return array(
		'eyebrow' => pethomescout_editorial_field( 'hub_eyebrow', $post_id, $eyebrow ),
		'title'   => pethomescout_editorial_field( 'hub_title', $post_id, $title ),
		'intro'   => pethomescout_editorial_field( 'hub_intro', $post_id, $intro ),
	);
}

/**
 * Return curated backend product records selected for a hub.
 * Empty selections intentionally preserve the approved fixture fallback.
 */
function pethomescout_hub_products( $post_id = 0 ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	$products = pethomescout_editorial_field( 'featured_products', $post_id, array() );
	$products = is_array( $products ) ? $products : ( $products ? array( $products ) : array() );
	return array_values( array_filter( array_map( 'absint', $products ), static function ( $product_id ) {
		return $product_id && 'pet_product' === get_post_type( $product_id );
	} ) );
}

/**
 * Return editable homepage copy with safe defaults for preview/install states.
 */
function pethomescout_home_values( $post_id = 0 ) {
	return array(
		'eyebrow'       => pethomescout_editorial_field( 'home_eyebrow', $post_id, 'INDEPENDENT GUIDANCE FOR PET-FRIENDLY HOMES' ),
		'title'         => pethomescout_editorial_field( 'home_title', $post_id, 'Make Smarter Choices. Build a Better Pet Home.' ),
		'intro'         => pethomescout_editorial_field( 'home_intro', $post_id, 'Independent product research, evidence labels, and interactive tools to help pet parents build a cleaner, safer, and happier home environment.' ),
		'primary_label' => pethomescout_editorial_field( 'home_primary_cta_label', $post_id, 'Explore buying guides' ),
		'primary_url'   => pethomescout_editorial_field( 'home_primary_cta_url', $post_id, home_url( '/smart-tech/' ) ),
		'secondary_label' => pethomescout_editorial_field( 'home_secondary_cta_label', $post_id, 'Find pet services' ),
		'secondary_url'   => pethomescout_editorial_field( 'home_secondary_cta_url', $post_id, home_url( '/services-insurance/' ) ),
	);
}

/**
 * Render curated internal links selected in the article editor.
 */
function pethomescout_render_related_links( $post_id = 0 ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$links   = array();
	$fields  = array( 'related_guides', 'related_comparison', 'related_tool', 'related_service' );
	foreach ( $fields as $field ) {
		$value = pethomescout_editorial_field( $field, $post_id, array() );
		$value = is_array( $value ) ? $value : ( $value ? array( $value ) : array() );
		foreach ( $value as $linked ) {
			$linked_id = is_object( $linked ) && isset( $linked->ID ) ? $linked->ID : absint( $linked );
			if ( $linked_id && $linked_id !== (int) $post_id ) {
				$links[ $linked_id ] = get_the_title( $linked_id );
			}
		}
	}
	if ( empty( $links ) ) {
		return;
	}
	?>
	<section class="related-guides" aria-labelledby="related-guides-title">
		<h2 id="related-guides-title">Continue the decision path</h2>
		<div class="related-guides-grid">
			<?php foreach ( $links as $linked_id => $label ) : ?>
				<a class="related-guide-card" href="<?php echo esc_url( get_permalink( $linked_id ) ); ?>">
					<span><?php echo esc_html( get_post_type( $linked_id ) === 'page' ? 'Resource' : 'Guide' ); ?></span>
					<strong><?php echo esc_html( $label ); ?></strong>
				</a>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

/**
 * Normalize article intent, household context, and monetization controls.
 */
function pethomescout_get_article_context( $post_id = 0 ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	$read    = static function ( $field, $default = '' ) use ( $post_id ) {
		return pethomescout_editorial_field( $field, $post_id, $default );
	};
	return array(
		'primary_hub'              => absint( $read( 'primary_hub', 0 ) ),
		'primary_intent'            => sanitize_key( (string) $read( 'commercial_intent', 'informational' ) ),
		'primary_monetization_type' => sanitize_key( (string) $read( 'primary_monetization_type', 'none' ) ),
		'affiliate_cta_enabled'     => (bool) $read( 'affiliate_cta_enabled', false ),
		'service_fallback_enabled'  => (bool) $read( 'service_fallback_enabled', false ),
		'related_service_type'      => sanitize_key( (string) $read( 'related_service_type', '' ) ),
		'related_service'           => absint( $read( 'related_service', 0 ) ),
		'related_service_cta_copy'  => sanitize_text_field( (string) $read( 'related_service_cta_copy', '' ) ),
		'cross_monetization_reason' => sanitize_textarea_field( (string) $read( 'cross_monetization_reason', '' ) ),
		'problem_type'              => array_filter( array_map( 'sanitize_key', (array) $read( 'problem_type', array() ) ) ),
		'pet_type'                  => array_filter( array_map( 'sanitize_key', (array) $read( 'pet_type', array() ) ) ),
		'breed'                     => sanitize_text_field( (string) $read( 'breed', '' ) ),
	);
}

/**
 * Service fallback is opt-in and requires an explicit user-problem rationale.
 */
function pethomescout_should_render_service_fallback( $post_id = 0 ) {
	$context = pethomescout_get_article_context( $post_id );
	return (bool) ( $context['service_fallback_enabled']
		&& $context['related_service']
		&& $context['related_service_type']
		&& $context['cross_monetization_reason']
		&& ! empty( $context['problem_type'] )
		&& 'service' !== $context['primary_intent'] );
}

/**
 * Render a contextual secondary service CTA after the article content.
 */
function pethomescout_render_service_fallback_cta( $post_id = 0 ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	if ( ! pethomescout_should_render_service_fallback( $post_id ) ) {
		return;
	}
	$context = pethomescout_get_article_context( $post_id );
	$copy    = $context['related_service_cta_copy'] ? $context['related_service_cta_copy'] : 'Need help beyond the DIY path? Review the local service checklist before sharing any information.';
	get_template_part( 'template-parts/commercial/service-fallback-cta', null, array(
		'url'         => get_permalink( $context['related_service'] ),
		'service_type' => $context['related_service_type'],
		'copy'        => $copy,
		'reason'      => $context['cross_monetization_reason'],
	) );
}

/**
 * Register native Gutenberg patterns for repeated editorial blocks.
 */
function pethomescout_register_block_patterns() {
	if ( ! function_exists( 'register_block_pattern' ) ) {
		return;
	}
	register_block_pattern_category( 'pethomescout', array( 'label' => __( 'PetHomeScout', 'pethomescout' ) ) );
	register_block_pattern( 'pethomescout/affiliate-disclosure', array(
		'title'      => __( 'Affiliate Disclosure', 'pethomescout' ),
		'categories' => array( 'pethomescout' ),
		'content'    => '<!-- wp:group {"className":"affiliate-disclosure-box"} --><div class="wp-block-group affiliate-disclosure-box"><!-- wp:paragraph --><p><strong>Affiliate disclosure:</strong> PetHomeScout may earn a commission when you purchase through links on this page. This does not affect our research process or recommendations.</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
	) );
	register_block_pattern( 'pethomescout/quick-verdict', array(
		'title'      => __( 'Quick Verdict', 'pethomescout' ),
		'categories' => array( 'pethomescout' ),
		'content'    => '<!-- wp:group {"className":"quick-verdict-box"} --><div class="wp-block-group quick-verdict-box"><!-- wp:heading {"level":2} --><h2>Quick verdict</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Summarize who this option suits, what evidence supports the recommendation, and the most important limitation.</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
	) );
	register_block_pattern( 'pethomescout/comparison-table', array(
		'title'      => __( 'Comparison Table', 'pethomescout' ),
		'categories' => array( 'pethomescout' ),
		'content'    => '<!-- wp:table {"className":"comparison-table","hasFixedLayout":false} --><figure class="wp-block-table comparison-table"><table><thead><tr><th>Decision factor</th><th>Option A</th><th>Option B</th></tr></thead><tbody><tr><td>Best suited for</td><td>Add evidence-led fit</td><td>Add evidence-led fit</td></tr><tr><td>Important limitation</td><td>Add limitation</td><td>Add limitation</td></tr><tr><td>Evidence status</td><td>Research-led</td><td>Research-led</td></tr></tbody></table></figure><!-- /wp:table -->',
	) );
	register_block_pattern( 'pethomescout/evidence-badge', array(
		'title'      => __( 'Evidence Badge', 'pethomescout' ),
		'categories' => array( 'pethomescout' ),
		'content'    => '<!-- wp:group {"className":"evidence-badge"} --><div class="wp-block-group evidence-badge"><!-- wp:paragraph --><p><strong>Evidence status:</strong> Research-led · <strong>Last reviewed:</strong> Add date · <strong>Limitations:</strong> Add what has not been independently verified.</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
	) );
	register_block_pattern( 'pethomescout/service-cta', array(
		'title'      => __( 'Service CTA', 'pethomescout' ),
		'categories' => array( 'pethomescout' ),
		'content'    => '<!-- wp:group {"className":"service-cta"} --><div class="wp-block-group service-cta"><!-- wp:heading {"level":2} --><h2>Need help from a local provider?</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Use this demo flow to compare what to ask a provider. No information is submitted or stored.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/services-insurance/">Explore service options</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->',
	) );
	register_block_pattern( 'pethomescout/buy-box', array(
		'title'      => __( 'Multi-Merchant Buy Box', 'pethomescout' ),
		'categories' => array( 'pethomescout' ),
		'content'    => '<!-- wp:group {"className":"buy-box"} --><div class="wp-block-group buy-box"><!-- wp:heading {"level":3} --><h3>Where to check availability</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Choose an approved merchant below. Replace these pending controls only after the corresponding Offer record is approved.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#" aria-disabled="true">Merchant pending</a></div><!-- /wp:button --><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#" aria-disabled="true">Merchant pending</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->',
	) );
	register_block_pattern( 'pethomescout/scout-score', array(
		'title'      => __( 'ScoutScore Methodology', 'pethomescout' ),
		'categories' => array( 'pethomescout' ),
		'content'    => '<!-- wp:group {"className":"scout-score-box"} --><div class="wp-block-group scout-score-box"><!-- wp:heading {"level":3} --><h3>ScoutScore</h3><!-- /wp:heading --><!-- wp:list --><ul><li>Pet hair handling — 30%</li><li>Floor compatibility — 20%</li><li>Ownership friction — 20%</li><li>Pet safety — 15%</li><li>Value — 15%</li></ul><!-- /wp:list --><!-- wp:paragraph --><p><strong>Evidence status:</strong> Research-led. Add a last-reviewed date and limitations before publishing a numeric score.</p><!-- /wp:paragraph --></div><!-- /wp:group -->',
	) );
	register_block_pattern( 'pethomescout/faq', array(
		'title'      => __( 'FAQ Section', 'pethomescout' ),
		'categories' => array( 'pethomescout' ),
		'content'    => '<!-- wp:heading {"level":2} --><h2>Frequently asked questions</h2><!-- /wp:heading --><!-- wp:details --><details class="wp-block-details"><summary>What evidence supports this guide?</summary><!-- wp:paragraph --><p>Explain whether the recommendation is founder-tested, research-led, or based on published specifications.</p><!-- /wp:paragraph --></details><!-- /wp:details -->',
	) );
}
add_action( 'init', 'pethomescout_register_block_patterns' );

/**
 * Register product records for backend convenience.
 */
function pethomescout_register_post_types() {
	register_post_type( 'pet_product', array(
		'labels'      => array(
			'name'          => __( 'Products Database', 'pethomescout' ),
			'singular_name' => __( 'Product', 'pethomescout' ),
		),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_rest'        => false,
		'publicly_queryable'  => false,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'supports'    => array( 'title', 'thumbnail', 'excerpt' ),
		'menu_icon'   => 'dashicons-products',
		'rewrite'     => false,
	) );

	// Backend-first records. These types intentionally have no public archive,
	// front-end permalink, navigation placement, or REST exposure in the MVP.
	$backend_types = array(
		'product_test' => array(
			'name'          => __( 'Product Tests', 'pethomescout' ),
			'singular_name' => __( 'Product Test', 'pethomescout' ),
			'menu_icon'     => 'dashicons-clipboard',
		),
		'merchant' => array(
			'name'          => __( 'Merchants', 'pethomescout' ),
			'singular_name' => __( 'Merchant', 'pethomescout' ),
			'menu_icon'     => 'dashicons-store',
		),
		'offer' => array(
			'name'          => __( 'Offers', 'pethomescout' ),
			'singular_name' => __( 'Offer', 'pethomescout' ),
			'menu_icon'     => 'dashicons-tag',
		),
		'service' => array(
			'name'          => __( 'Services', 'pethomescout' ),
			'singular_name' => __( 'Service', 'pethomescout' ),
			'menu_icon'     => 'dashicons-admin-tools',
		),
		'insurance_provider' => array(
			'name'          => __( 'Insurance Providers', 'pethomescout' ),
			'singular_name' => __( 'Insurance Provider', 'pethomescout' ),
			'menu_icon'     => 'dashicons-shield',
		),
	);

	foreach ( $backend_types as $post_type => $labels ) {
		register_post_type( $post_type, array(
			'labels'              => $labels,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'show_in_nav_menus'   => false,
			'supports'            => array( 'title', 'editor' ),
			'rewrite'             => false,
		) );
	}
}
add_action( 'init', 'pethomescout_register_post_types' );
