# Architecture Decisions

## 2026-07-12 — Sprint 1 theme foundation and ACF verification

- Kept the existing custom WordPress theme as the implementation path; the current interface already owns the approved Fraunces/Nunito Sans typography, color tokens, header/footer, editable primary/footer menu locations, and `title-tag`/WordPress lifecycle hooks.
- Added `wp-content/themes/pethomescout/theme.json` as the editor-facing design-token contract without replacing the existing CSS design system.
- Installed and activated the official Advanced Custom Fields plugin in the isolated local WordPress runtime only. The theme's initial six JSON field groups loaded successfully; the current theme now ships nine groups including homepage and provider/service controls. No plugin files are added to the repository.
- Added a Rank Math/Yoast compatibility guard so the theme's plugin-free preview metadata fallback stops emitting canonical, social, and standard schema output when either SEO plugin is active. This prevents duplicate SEO markup in production.

## 2026-07-12 — Sprint 2 content system

- Kept editorial content in native WordPress Posts and permanent hubs in Pages; supporting product, merchant, offer, service, insurance, and test entities remain backend CPTs.
- Added ACF JSON groups for article editorial controls and hub curation. These fields provide evidence status, review date, parent hub, related guides/comparisons/tools/services, and hub hero/featured-content controls without hardcoding article relationships.
- Added safe ACF fallbacks so the theme still renders when ACF is unavailable.
- Added native Gutenberg patterns for the recurring Affiliate Disclosure and Quick Verdict blocks. ACF Pro-only blocks remain deferred; the free ACF runtime is not forced into a paid dependency.
- Added an article related-links renderer to turn selected relationships into a visible decision path instead of automatic keyword injection.

## 2026-07-12 — Sprint 3 monetization system

- Standardized commercial URLs as `/go/{merchant}/{product}/`; raw affiliate destinations remain stored only on Offer records and are never rendered into article content.
- Added normalized Merchant/Offer resolution, approval checks, display-price metadata, and a feature flag for live redirects. Pending or unapproved offers render disabled controls and the `/go/` placeholder.
- Added reusable disclosure, multi-merchant buy-box, comparison-table, and ScoutScore template parts. ScoutScore remains hidden as a numeric result until evidence status and review-date requirements are met.
- Live redirect behavior remains disabled by default; enabling it requires an explicit `PETHOMESCOUT_ENABLE_LIVE_OFFERS` configuration change and approved Merchant + Offer records.

## 2026-07-12 — Sprint 4 lead demo and QA

- Kept all lead forms frontend-only demos: no database writes, email, CRM, REST request, browser storage, or external endpoint.
- Corrected Hub title fallback so stale WordPress page titles such as “Hello world!” cannot replace the approved UI heading; editors may override through the new `hub_title` ACF field.
- Added the missing shared `.button` aliases and responsive Services hub card grid; this preserves the existing `.btn` system while making MVP templates render as designed.
- Local QA passed at 1440px and 375px with no horizontal overflow. The insurance demo advanced through all three steps, displayed the approved TCPA language, and reached a success state without echoing submitted values.

## 2026-07-12 — Sprint 5 editor patterns and permalink audit

- Added native Gutenberg patterns for comparison tables, evidence badges, service CTAs, and FAQs so editors can assemble common decision-page sections without editing PHP.
- Kept Buy Box, ScoutScore, and offer resolution as template/data-driven components because they require controlled product and evidence fields rather than free-form editor content.
- Verified the isolated runtime uses `/%postname%/`; production setup must apply the same permalink setting and flush rewrite rules before indexing.
- Added an ACF homepage editorial group for hero copy and two CTA destinations, while retaining safe defaults so a fresh install does not render empty content.
- Added an optional homepage `home_featured_guide` relationship field; legacy `hero_featured_pick` metadata remains supported only for existing fixtures.
- Added native Gutenberg Buy Box and ScoutScore patterns for editor discovery; live merchant links and numeric scores remain controlled by Offer/Product Evidence data and cannot be enabled by pattern text alone.
- Connected the Smart Tech hub's featured guide cards to the existing ACF relationship field, retaining fixture cards only when editors have not selected records.
- Reused the same ACF relationship pattern for Family Home and Cleaning & Odor so hub curation remains consistent across the three product-led hubs.
- Services & Insurance now consumes published Service CPT records for dynamic entry cards; when no records exist, the approved demo cards remain the fallback and no live routing is implied.
- Verified the ACF curation path with a temporary local Post: selecting it on the Smart Tech Page replaced fixture cards, and cleanup restored the fallback state with no test content retained.
- Added Rank Math filters for synthetic preview routes so description, Open Graph description, canonical, and JSON-LD are present without overriding saved Rank Math metadata on real content.
- Added a narrow canonical/schema fallback for synthetic routes that have no persisted query object; representative routes now emit one of each SEO element instead of relying on empty plugin defaults.
- Authenticated local Admin QA is now possible through the corrected router; Dashboard, Smart Tech Page editing (including ACF relationships), Services CPT listing, and Plugins (ACF + Rank Math) were reached without changing production credentials.
- Lighthouse identified low-contrast footer copy; moved the disclaimer to a class and raised muted footer text to an accessible contrast color, producing an Accessibility score of 100 in the follow-up audit.
- Added a preview-only default social image using the optimized WebP hero asset; saved Rank Math/Yoast social image fields still take precedence on real content.
- Integrated the hyper-niche Article ACF model and opt-in contextual service fallback. The rule requires a selected related service, problem type, rationale, and explicit enable flag; unrelated affiliate articles remain service-CTA free.
