<?php
/**
 * Template Name: Multi-Step Lead Form
 *
 * @package PetHomeScout
 */

get_header();
?>

  <!-- Multi-step Form Page Wrapper -->
  <div class="lead-page-container">
    <div class="container lead-grid">
      
      <!-- Left Column: Trust & Social Proof -->
      <aside class="lead-left-content">
        <span class="tool-badge" style="background-color: var(--accent-light); color: var(--accent); margin-bottom: 16px;">100% Free Service</span>
        <h1 style="font-size: 34px; margin-top: 8px; margin-bottom: 20px; font-family: var(--font-display);"><?php the_title(); ?></h1>
        <div style="font-size: 15px; line-height: 1.7; color: var(--text-muted); margin-bottom: 30px;">
          <?php the_content(); ?>
        </div>

        <div class="trust-bullets">
          <div class="trust-bullet">
            <span class="bullet-icon">🛡️</span>
            <div>
              <strong>Secure & Encrypted</strong>
              <span>Your private data is protected using 256-bit SSL protocols.</span>
            </div>
          </div>
          <div class="trust-bullet">
            <span class="bullet-icon">💵</span>
            <div>
              <strong>No Obligations</strong>
              <span>Quotes are 100% free with no hidden billing policies.</span>
            </div>
          </div>
          <div class="trust-bullet">
            <span class="bullet-icon">⭐</span>
            <div>
              <strong>US Licensed Providers Only</strong>
              <span>We match you with top-tier, background-checked partners.</span>
            </div>
          </div>
        </div>
      </aside>

      <!-- Right Column: Interactive Multi-Step Form App -->
      <main class="lead-right-form">
        
        <!-- Progress Tracker Bar -->
        <div class="progress-container">
          <div class="progress-track">
            <div class="progress-bar" id="progressBar"></div>
          </div>
          <div class="progress-steps">
            <div class="progress-step active" data-step="1">1</div>
            <div class="progress-step" data-step="2">2</div>
            <div class="progress-step" data-step="3">3</div>
          </div>
        </div>

        <!-- The Interactive Multi-step Form -->
        <form class="lead-form-app" id="leadForm">
          
          <!-- Step 1 -->
          <div class="form-step active" id="step1">
            <h3 style="font-family: var(--font-ui);">Select your pet type:</h3>
            <div class="card-selectors">
              <!-- Dog selector: friendly dog face silhouette -->
              <div class="selector-card" data-value="dog">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <ellipse cx="32" cy="34" rx="18" ry="16" fill="currentColor" fill-opacity="0.08"/>
                  <ellipse cx="16" cy="28" rx="7" ry="11" transform="rotate(-12 16 28)" fill="currentColor" fill-opacity="0.15"/>
                  <ellipse cx="48" cy="28" rx="7" ry="11" transform="rotate(12 48 28)" fill="currentColor" fill-opacity="0.15"/>
                  <circle cx="26" cy="31" r="2.5" fill="currentColor"/>
                  <circle cx="38" cy="31" r="2.5" fill="currentColor"/>
                  <ellipse cx="32" cy="38" rx="7" ry="5" fill="currentColor" fill-opacity="0.12"/>
                  <ellipse cx="32" cy="36" rx="3" ry="2" fill="currentColor"/>
                  <path d="M29 40 Q32 43 35 40"/>
                  <path d="M14 30 Q15 16 32 18 Q49 16 50 30"/>
                </svg>
                <span>Dog</span>
              </div>
              <!-- Cat selector: cat face with pointed ears and whiskers -->
              <div class="selector-card" data-value="cat">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <ellipse cx="32" cy="36" rx="17" ry="15" fill="currentColor" fill-opacity="0.08"/>
                  <polygon points="16,26 11,12 24,22" fill="currentColor" fill-opacity="0.18"/>
                  <polygon points="48,26 53,12 40,22" fill="currentColor" fill-opacity="0.18"/>
                  <polygon points="17,25 13,15 23,22" fill="currentColor" fill-opacity="0.06"/>
                  <polygon points="47,25 51,15 41,22" fill="currentColor" fill-opacity="0.06"/>
                  <ellipse cx="25" cy="33" rx="3" ry="2.5" fill="currentColor"/>
                  <ellipse cx="39" cy="33" rx="3" ry="2.5" fill="currentColor"/>
                  <polygon points="32,38 30,40 34,40" fill="currentColor"/>
                  <path d="M30,40 Q32,43 34,40"/>
                  <line x1="15" y1="38" x2="27" y2="40"/>
                  <line x1="15" y1="41" x2="27" y2="41.5"/>
                  <line x1="37" y1="40" x2="49" y2="38"/>
                  <line x1="37" y1="41.5" x2="49" y2="41"/>
                </svg>
                <span>Cat</span>
              </div>
              <!-- Small Pet / Other selector: rabbit/bird face -->
              <div class="selector-card" data-value="other">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <ellipse cx="32" cy="38" rx="14" ry="13" fill="currentColor" fill-opacity="0.08"/>
                  <ellipse cx="24" cy="20" rx="5" ry="12" transform="rotate(-8 24 20)" fill="currentColor" fill-opacity="0.15"/>
                  <ellipse cx="40" cy="20" rx="5" ry="12" transform="rotate(8 40 20)" fill="currentColor" fill-opacity="0.15"/>
                  <ellipse cx="24" cy="20" rx="2.5" ry="8" transform="rotate(-8 24 20)" fill="currentColor" fill-opacity="0.06"/>
                  <ellipse cx="40" cy="20" rx="2.5" ry="8" transform="rotate(8 40 20)" fill="currentColor" fill-opacity="0.06"/>
                  <circle cx="27" cy="36" r="2" fill="currentColor"/>
                  <circle cx="37" cy="36" r="2" fill="currentColor"/>
                  <ellipse cx="32" cy="41" rx="2" ry="1.5" fill="currentColor"/>
                  <path d="M30,42 Q32,45 34,42"/>
                </svg>
                <span>Other</span>
              </div>
            </div>
            <input type="hidden" id="petType" name="petType" value="">
            
            <div class="form-navigation">
              <div></div>
              <button type="button" class="btn btn-primary" id="btnNext1">Next Step &rarr;</button>
            </div>
          </div>

          <!-- Step 2 -->
          <div class="form-step" id="step2">
            <h3 style="font-family: var(--font-ui);">Where are you located?</h3>
            <div class="form-group">
              <label for="zipCode">ZIP Code</label>
              <input type="text" id="zipCode" name="zipCode" class="form-control" placeholder="e.g. 90210" maxlength="5">
              <span style="font-size:12px; color:var(--danger); display:none;" id="zipError">Please enter a valid 5-digit ZIP code.</span>
            </div>

            <!-- Pet's Age Group -->
            <div class="form-group">
              <label for="petAge">Pet's Age Group</label>
              <select id="petAge" class="form-control" name="petAge">
                <option value="">Select Age Group</option>
                <option value="puppy">Puppy / Kitten (0 - 1 year)</option>
                <option value="adult">Adult (1 - 7 years)</option>
                <option value="senior">Senior (8+ years)</option>
              </select>
            </div>

            <div class="form-group">
              <label for="coverageNeed">Coverage Type</label>
              <select id="coverageNeed" class="form-control" name="coverageNeed">
                <option value="accident-illness">Accident & Illness (Recommended)</option>
                <option value="accident-only">Accident Only</option>
                <option value="wellness">Wellness / Preventative Add-on</option>
              </select>
            </div>

            <div class="form-navigation">
              <button type="button" class="btn btn-secondary" id="btnBack2">&larr; Back</button>
              <button type="button" class="btn btn-primary" id="btnNext2">Next Step &rarr;</button>
            </div>
          </div>

          <!-- Step 3 -->
          <div class="form-step" id="step3">
            <h3 style="font-family: var(--font-ui);">Almost Done! Get Your Quotes</h3>
            <div class="form-group">
              <label for="fullName">Your Full Name</label>
              <input type="text" id="fullName" name="fullName" class="form-control" placeholder="John Doe">
            </div>

            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" id="email" name="email" class="form-control" placeholder="john@example.com">
            </div>

            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone" class="form-control" placeholder="(555) 555-5555">
            </div>

            <label class="consent-checkbox">
              <input type="checkbox" id="consentCheck" name="consentCheck">
              <p>By clicking Calculate Quotes, I provide my express written consent to receive automated marketing calls/text messages from PetHomeScout and its service partners at the number provided. Consent is not required to purchase goods or services.</p>
            </label>
            <span style="font-size:12px; color:var(--danger); display:none; margin-bottom:12px;" id="consentError">You must agree to the terms to proceed.</span>

            <div class="form-navigation">
              <button type="button" class="btn btn-secondary" id="btnBack3">&larr; Back</button>
              <button type="submit" class="btn btn-accent" id="btnSubmit">Calculate Quotes &rarr;</button>
            </div>
          </div>
        </form>

        <!-- Success Modal/State -->
        <div id="formSuccess" style="display:none; text-align:center; padding: 20px 0;">
          <div style="width:64px; height:64px; border-radius:50%; background-color:var(--success-light); color:var(--success); display:flex; align-items:center; justify-content:center; margin: 0 auto 20px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
          </div>
          <h3 style="font-size:24px; margin-bottom:12px; font-family: var(--font-display);">Quotes Calculated!</h3>
          <p style="color:var(--text-muted); margin-bottom: 24px; font-size:15px; line-height: 1.6;">Based on your ZIP and pet profile, we matched you with the top 3 optimal policies. Rates have been dispatched to your email.</p>
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary" style="display:inline-block; padding: 12px 24px;">Return to Homepage</a>
        </div>

      </main>
    </div>
  </div>

  <script src="<?php echo esc_url( get_template_directory_uri() . '/js/lead-form.js' ); ?>"></script>

<?php
get_footer();
