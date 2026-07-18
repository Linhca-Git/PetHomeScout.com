<?php
/**
 * Pet Home Cleaning System Selector.
 *
 * Local, non-PII Phase 1 decision tool. Recommendations point to solution
 * categories and editorial guides, never to unverified products or providers.
 *
 * @package PetHomeScout
 */

get_header();
?>
<main class="tool-page">
	<div class="container tool-layout">
		<section>
			<span class="eyebrow">Pet Home Cleaning Selector</span>
			<h1>Build a cleaning system around your pet and your home.</h1>
			<p>Answer four household questions. We will suggest a practical solution category and cleaning sequence using local editorial logic—without collecting personal information.</p>

			<form class="selector-form" data-cleaning-selector>
				<fieldset>
					<legend>What needs the most attention?</legend>
					<label><input type="radio" name="problem" value="hair" checked> Pet hair and shedding</label>
					<label><input type="radio" name="problem" value="odor"> Odor without a visible stain</label>
					<label><input type="radio" name="problem" value="stain"> Urine stain or recurring odor</label>
				</fieldset>

				<fieldset>
					<legend>What is your main flooring?</legend>
					<label><input type="radio" name="floor" value="carpet" checked> Mostly carpet</label>
					<label><input type="radio" name="floor" value="hard"> Mostly hard floors</label>
					<label><input type="radio" name="floor" value="mixed"> Mixed floors</label>
				</fieldset>

				<fieldset>
					<legend>How heavy is the shedding or cleanup load?</legend>
					<label><input type="radio" name="load" value="heavy" checked> Heavy or frequent</label>
					<label><input type="radio" name="load" value="moderate"> Moderate</label>
					<label><input type="radio" name="load" value="light"> Occasional</label>
				</fieldset>

				<fieldset>
					<legend>What is your preferred first step?</legend>
					<label><input type="radio" name="approach" value="automate" checked> Automate routine cleanup</label>
					<label><input type="radio" name="approach" value="deep"> Deep-clean the source</label>
					<label><input type="radio" name="approach" value="simple"> Start with a simple DIY sequence</label>
				</fieldset>

				<button class="button" type="submit">Build my cleaning sequence</button>
			</form>
		</section>

		<aside class="tool-result" data-cleaning-result aria-live="polite">
			<span class="dashicons dashicons-search" aria-hidden="true"></span>
			<h2>Your cleaning sequence will appear here.</h2>
			<p>The result will recommend a solution category and the most relevant Phase 1 guide. It will not name an unsupported product or claim guaranteed results.</p>
		</aside>
	</div>

	<section class="section tool-method">
		<div class="container narrow-layout">
			<span class="eyebrow">How the selector works</span>
			<h2>Problem first, product second.</h2>
			<p>The selector weighs the surface, cleanup load, problem type, and preferred level of effort. Recommendations are research-led and limited to the editorial guides currently available on PetHomeScout.</p>
			<p><a href="<?php echo esc_url( home_url( '/how-we-test/' ) ); ?>">Review our evidence standards →</a></p>
		</div>
	</section>
</main>
<?php get_footer(); ?>
