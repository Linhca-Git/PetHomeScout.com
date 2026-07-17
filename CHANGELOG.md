# Changelog

## Unreleased — MVP hardening

- Added WordPress-only theme routing, trust/legal pages, and US-only flat URL handling.
- Added backend-only CPT registration for products, tests, merchants, offers, services, and insurance providers.
- Added ACF JSON field groups for evidence, test, merchant, offer, service, and insurance records.
- Added normalized evidence and offer-approval helpers with safe defaults.
- Added a feature-gated offer destination validator; live redirects remain disabled.
- Added noindex/robots/sitemap guards for local previews and `/go/` placeholders.
- Hardened demo lead forms so they do not persist or transmit PII.
- Added accessibility, tracking-event, internal-link, and score-display hardening.
- Moved commercial disclosures ahead of the first CTA on Smart Tech and pet-odor hybrid templates.
- Added a visible Privacy Policy link beside the demo lead-form consent text.
- Added postal-code autocomplete to the canonical insurance demo form.
- Added compact styling for the consent-adjacent privacy link on demo forms.
- Removed duplicate preview robots meta output; `wp_robots` is now the single HTML source while the HTTP header guard remains.
- Recorded local request-timing and asset-size baselines; real Core Web Vitals remain a staging/PageSpeed gate.
- Added a Playground blueprint step to install and activate Advanced Custom Fields for clean rebuilds.

## Pending before staging

- Rebuild a clean WordPress runtime and verify ACF fields in Admin.
- Review real merchant/offer records and redirect ownership.
- Approve staging host, consent logging, analytics, lead routing, and production indexing separately.
