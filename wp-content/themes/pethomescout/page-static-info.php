<?php
/**
 * Static trust/legal page template for preview routes.
 *
 * @package PetHomeScout
 */

get_header();

$path  = pethomescout_current_path();
$pages = array(
	'about' => array(
		'eyebrow' => 'About',
		'title'   => 'About PetHomeScout',
		'intro'   => 'PetHomeScout is being built as an independent decision engine for U.S. households with dogs and cats.',
		'items'   => array(
			'We focus on cleaner, safer, pet-friendly homes rather than generic pet news.',
			'Recommendations must identify their evidence level: founder-tested, research-led, specification-reviewed, or not yet verified.',
			'Commercial relationships are disclosed and must not override editorial logic.',
		),
	),
	'methodology' => array(
		'eyebrow' => 'Methodology',
		'title'   => 'PetHomeScout Methodology',
		'intro'   => 'Our MVP separates decision logic from commercial placement so readers can see why a product or service path appears.',
		'items'   => array(
			'ScoutScore-style labels require visible criteria, limitations, and last-reviewed context.',
			'Founder-tested labels are only allowed when a completed test record exists.',
			'Research-led pages use published specifications, clear caveats, and no fake ratings.',
		),
	),
	'affiliate-disclosure' => array(
		'eyebrow' => 'Disclosure',
		'title'   => 'Affiliate Disclosure',
		'intro'   => 'PetHomeScout may earn compensation when readers use approved commercial links.',
		'items'   => array(
			'Affiliate disclosure must appear before the first commercial CTA on buying pages.',
			'All affiliate pathways are routed through internal /go/ placeholders until merchant approval is complete.',
			'Compensation does not change evidence labels or recommendation methodology.',
		),
	),
	'advertising-disclosure' => array(
		'eyebrow' => 'Disclosure',
		'title'   => 'Advertising Disclosure',
		'intro'   => 'PetHomeScout may work with service, insurance, or affiliate partners in future production workflows.',
		'items'   => array(
			'Partner relationships must be disclosed near relevant CTAs.',
			'Advertising status must not be presented as independent testing.',
			'Service and insurance flows remain demos until approved partners, consent logging, and routing are implemented.',
		),
	),
	'privacy-policy' => array(
		'eyebrow' => 'Privacy',
		'title'   => 'Privacy Policy',
		'intro'   => 'The MVP lead forms are demo-only and do not submit, store, email, or share personal information.',
		'items'   => array(
			'Production lead routing requires explicit consent, logging, and partner review before launch.',
			'Analytics credentials are deferred until consent and staging review are ready.',
			'Privacy requests can be sent through the official contact page.',
		),
	),
	'terms' => array(
		'eyebrow' => 'Terms',
		'title'   => 'Terms of Use',
		'intro'   => 'PetHomeScout content is informational and designed to support product and service comparison decisions.',
		'items'   => array(
			'Readers should verify current prices, availability, policy details, and service terms with providers.',
			'Demo tools do not create quotes, bookings, insurance applications, or provider relationships.',
			'No product or service outcome is promised.',
		),
	),
	'do-not-sell-or-share' => array(
		'eyebrow' => 'Privacy choice',
		'title'   => 'Do Not Sell or Share',
		'intro'   => 'PetHomeScout is preparing privacy-first workflows before any production lead sharing goes live.',
		'items'   => array(
			'The current MVP does not sell, share, submit, store, or email demo lead-form data.',
			'Future workflows must include clear opt-out handling and provider-sharing disclosure.',
			'Privacy requests can be sent through the contact page.',
		),
	),
);

$page = $pages[ $path ] ?? $pages['about'];
?>

<main class="methodology-page">
	<div class="container narrow-layout">
		<span class="eyebrow"><?php echo esc_html( $page['eyebrow'] ); ?></span>
		<h1><?php echo esc_html( $page['title'] ); ?></h1>
		<p class="page-intro"><?php echo esc_html( $page['intro'] ); ?></p>

		<section class="rubric-panel">
			<h2>Current MVP standard</h2>
			<ul class="check-list">
				<?php foreach ( $page['items'] as $item ) : ?>
					<li><?php echo esc_html( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
		</section>

		<section class="rubric-panel">
			<h2>Need help?</h2>
			<p>Use the contact page for support, editorial questions, partner inquiries, or privacy requests.</p>
			<a class="button button-secondary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Contact PetHomeScout</a>
		</section>
	</div>
</main>

<?php
get_footer();
