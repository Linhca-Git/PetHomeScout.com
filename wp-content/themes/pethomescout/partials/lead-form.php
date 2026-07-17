<?php
/**
 * Demo-only multi-step lead form.
 *
 * This form intentionally does not persist, email, or route personal data in
 * the MVP. JavaScript reads data-service for event hooks only.
 *
 * @package PetHomeScout
 */

$request_path = function_exists( 'pethomescout_current_path' ) ? pethomescout_current_path() : '';
$current_slug = basename( $request_path );
$service_map  = array(
	'pet-insurance'              => array(
		'service'  => 'insurance',
		'question' => 'Who needs coverage?',
		'step_two' => 'Pet insurance details',
	),
	'mobile-pet-grooming'        => array(
		'service'  => 'mobile_grooming',
		'question' => 'Who needs grooming?',
		'step_two' => 'Local grooming details',
	),
	'pet-odor-carpet-cleaning'   => array(
		'service'  => 'pet_odor_cleaning',
		'question' => 'Who needs cleaning help?',
		'step_two' => 'Local cleaning details',
	),
	'pet-sitting'                => array(
		'service'  => 'sitting_walking',
		'question' => 'Who needs care?',
		'step_two' => 'Local care details',
	),
);

$form_config = isset( $service_map[ $current_slug ] )
	? $service_map[ $current_slug ]
	: array(
		'service'  => 'local_pet_service',
		'question' => 'Who needs support?',
		'step_two' => 'Local details',
	);
?>
<form class="lead-demo-form compact-form" data-lead-demo data-service="<?php echo esc_attr( $form_config['service'] ); ?>" novalidate>
	<div class="lead-step is-active" data-step="1">
		<span class="step-count">Step 1 of 3</span>
		<h2 tabindex="-1"><?php echo esc_html( $form_config['question'] ); ?></h2>
		<div class="choice-grid">
			<button type="button" data-choice="Dog"><span class="dashicons dashicons-pets"></span>Dog</button>
			<button type="button" data-choice="Cat"><span class="dashicons dashicons-pets"></span>Cat</button>
			<button type="button" data-choice="Other"><span class="dashicons dashicons-heart"></span>Other</button>
		</div>
		<p class="form-error" aria-live="polite"></p>
		<button class="button step-next" type="button">Continue</button>
	</div>

	<div class="lead-step" data-step="2">
		<span class="step-count">Step 2 of 3</span>
		<h2 tabindex="-1"><?php echo esc_html( $form_config['step_two'] ); ?></h2>
		<label>ZIP code<input name="zip" inputmode="numeric" autocomplete="postal-code" maxlength="5" placeholder="e.g. 98101"></label>
		<label>Breed or mix<input name="breed" placeholder="e.g. Golden Retriever"></label>
		<p class="form-error" aria-live="polite"></p>
		<div class="form-nav">
			<button class="text-button step-back" type="button">Back</button>
			<button class="button step-next" type="button">Continue</button>
		</div>
	</div>

	<div class="lead-step" data-step="3">
		<span class="step-count">Step 3 of 3</span>
		<h2 tabindex="-1">Preview your next steps</h2>
		<label>Name<input name="name" autocomplete="name" placeholder="Your name"></label>
		<label>Email<input name="email" type="email" autocomplete="email" placeholder="you@example.com"></label>
		<label>Phone<input name="phone" inputmode="tel" autocomplete="tel" placeholder="(555) 555-5555"></label>
		<p class="demo-form-note">Demo quote flow. No information is submitted or stored.</p>
		<label class="consent"><input name="consent" type="checkbox"> <span>By clicking “Show my next steps,” I provide my express written consent to receive automated marketing calls/text messages from PetHomeScout and its service partners at the number provided. Consent is not required to purchase goods or services.</span></label>
		<p class="demo-form-note form-privacy-note">Review our <a href="/privacy-policy/">Privacy Policy</a> before continuing.</p>
		<p class="form-error" aria-live="polite"></p>
		<div class="form-nav">
			<button class="text-button step-back" type="button">Back</button>
			<button class="button lead-submit" type="submit">Show my next steps</button>
		</div>
	</div>

	<div class="lead-success" hidden tabindex="-1">
		<span class="dashicons dashicons-yes-alt"></span>
		<h2>Demo complete</h2>
		<p>No information was submitted, stored, emailed, or shared.</p>
		<a class="button" href="/services-insurance/">Explore more services</a>
	</div>
</form>
