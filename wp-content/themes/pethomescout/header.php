<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
	<div class="utility-bar"><div class="container"><span>Independent guidance for pet-friendly homes</span><span>US Edition · USD</span></div></div>
	<div class="container site-header-main">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="PetHomeScout home">PetHome<em>Scout</em></a>
		<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-navigation">Menu</button>
		<nav id="primary-navigation" class="primary-nav" aria-label="Primary navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'fallback_cb' => 'pethomescout_primary_fallback', 'container' => false ) ); ?>
		</nav>
	</div>
</header>
