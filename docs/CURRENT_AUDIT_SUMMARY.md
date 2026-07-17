# PetHomeScout Current Audit Summary

Status: working-tree audit snapshot for the current MVP hardening pass.

Canonical source: `docs/EXECUTIVE_KNOWLEDGE_BASE.md`.

## What has been hardened

- Unsupported trust claims were removed or replaced with research-led/evidence-labeled language.
- Local/tunnel previews are protected with `noindex,nofollow` meta and `X-Robots-Tag`.
- `/go/` routes render pending placeholders and do not redirect externally.
- Legacy routes redirect to current MVP routes.
- Sitemap excludes `/go/`, legacy routes, and backend-only surfaces.
- Lead forms remain demo-only and do not store, email, route, or expose submitted PII.
- Affiliate disclosure appears in commercial contexts before commercial pathways.
- Smart Tech and pet-odor hybrid hero templates now place disclosure before their first tracked CTA.
- Event names are documented in `docs/TRACKING_EVENT_CONTRACT.md`; analytics credentials remain intentionally absent.
- ChatGPT, Codex, and GSC/GA4/PageSpeed review roles are documented in `docs/REVIEW_OPERATING_MODEL.md`.
- Launch/staging gates are documented in `docs/LAUNCH_READINESS_CHECKLIST.md`.
- Backend-only CPT registration and ACF JSON groups for `product_test`, `merchant`, `offer`, `service`, and `insurance_provider` are present; real `/go/` resolution remains approval-required in `docs/DATA_MODEL_AND_GO_SYSTEM_PLAN.md`.
- The active stylesheet uses the approved `Fraunces` display and `Nunito Sans` UI/body/data typography.
- The unused legacy `wp-content/themes/pethomescout/css/mvp.css` stylesheet was removed; route layout CSS now lives in the main theme stylesheet.
- Google Fonts no longer load through a CSS `@import`; the theme enqueues the font stylesheet directly and adds preconnect hints for the font origins.
- Homepage and hub product grids now support editor-curated `pet_product` relationships through ACF, with shared evidence/offer rendering and explicitly labelled fixture fallbacks.
- Canonical ownership is now single-source: Rank Math owns persisted Page/Post routes while the theme fallback emits canonical only for synthetic preview routes; the nine-route smoke set reports exactly one canonical each.

## Verification evidence from current local runtime

Last local smoke set:

- `/` returned `200` with `X-Robots-Tag: noindex, nofollow`.
- `/services-insurance/` returned `200` with `X-Robots-Tag: noindex, nofollow`.
- `/pet-insurance/`, `/mobile-pet-grooming/`, `/pet-sitting/`, and `/pet-odor-carpet-cleaning/` returned `200` with `X-Robots-Tag: noindex, nofollow`.
- `/smart-tech/` returned `200` with `X-Robots-Tag: noindex, nofollow`.
- `/cleaning-odor/` returned `200` with `X-Robots-Tag: noindex, nofollow`.
- `/pet-tech-selector/` returned `200` with `X-Robots-Tag: noindex, nofollow`.
- `/go/roborock/test/` returned `200` with `X-Robots-Tag: noindex, nofollow`.
- `/sitemap.xml` returned `200` with `X-Robots-Tag: noindex, nofollow`.
- `/robots.txt` returned `200` with `X-Robots-Tag: noindex, nofollow`.

Previously completed checks during this hardening pass:

- PHP lint passed across theme PHP files.
- JS syntax checks passed across theme JS files.
- Lead demo interaction passed: step progression, consent requirement, success state, no submitted values shown, and console clean.
- Service lead demo pages passed: no `action`, no `method=post`, demo notice visible, and TCPA consent text visible.
- Legacy service URLs redirect to canonical service routes: `/pet-insurance/`, `/mobile-pet-grooming/`, and `/pet-odor-carpet-cleaning/`.
- Homepage commercial language now uses `Research Fixtures` and research-led fixture copy instead of unsupported editor-pick claims.
- Stylesheet verification passed for `Fraunces`, `Nunito Sans`, and absence of old `Inter`, `Playfair Display`, and `Poppins` font tokens.
- Browser QA passed on the local runtime: homepage loaded with no console errors, hero matchmaker navigated to `/services-insurance/`, non-native clickable cards had role/tabindex/aria labels, and desktop viewport had no horizontal overflow.
- Homepage card navigation was hardened from inline `onclick="location.href"` redirects to `data-href` plus shared JS handling. Rendered QA found 25 `data-href` cards, 0 missing role/tabindex/aria labels, 0 inline `location.href` handlers, 0 console errors, and no mobile-width horizontal overflow. A real card click navigated to `/smart-tech/`.
- Homepage dynamic post URLs in `href` and `data-href` attributes now use `esc_url( get_permalink() )` instead of raw `the_permalink()` output. PHP lint passed and the local homepage continued to return `200` with `X-Robots-Tag: noindex, nofollow`.
- Theme-wide scan for raw `the_permalink()` inside `href`/`data-href` attributes now passes after the remaining index template links were escaped with `esc_url( get_permalink() )`.
- ACF `evidence_status` machine values now use underscore keys (`research_led`, `specification_reviewed`, `not_yet_verified`, `founder_tested`) to match the tracking contract and canonical data model naming. JSON validation passed and the local homepage still returned `200` with `X-Robots-Tag: noindex, nofollow`.
- Single-post buy-box tracking attributes now include `data-product`, `data-cta-position`, and `data-evidence-status` alongside `data-merchant`, so future `buy_box_click` events align with the tracking contract. PHP lint passed, and `/go/roborock/test/` remained a noindex placeholder with no external redirect.
- Theme `data-track` usage now scans clean against the approved MVP event list; current rendered attributes use only `buy_box_click`, `decision_tool_start`, and `lead_form_view`.
- Shared lead-demo form now includes Dog/Cat/Other choices and browser autocomplete hints for ZIP, name, email, and phone. The rendered `/mobile-pet-grooming/` form still has no `action` or `method`, shows the demo no-storage notice, returns `200`, and keeps `X-Robots-Tag: noindex, nofollow`.
- Lead-demo tracking now emits `lead_form_start` only when the user advances beyond Step 1, matching the event contract. JS syntax passed, the Step 1 guard is present, and the lead demo still has no persistence/network patterns.
- Preview Open Graph type now uses `article` only for singular posts; hub, service, legal, homepage, and `/go/` placeholder routes render `og:type=website`. Endpoint smoke confirmed canonical URLs, meta robots, and `X-Robots-Tag: noindex, nofollow` on `/`, `/services-insurance/`, `/privacy-policy/`, and `/go/roborock/test/`; service-page JSON-LD is present without fake rating schema.
- Rendered MVP route scan found no `aggregateRating`, `reviewRating`, or `ratingValue` schema on the current homepage, hub, service, tool, methodology, and lead-demo routes.
- `<body>` now renders `data-content-type` for cleaner future analytics payloads. Smoke confirmed `home`, `services-insurance`, `pet-insurance`, and `affiliate_pathway` values on representative routes while preserving `X-Robots-Tag: noindex, nofollow`.
- Skip-link accessibility is now server-rendered on all MVP routes. A route smoke across homepage, hubs, services, tool, methodology, and legal pages confirmed exactly one H1, a `#main-content` skip target, and `X-Robots-Tag: noindex, nofollow` on each route.
- SEO endpoint audit passed: canonical, robots, schema presence, one H1, sitemap exclusions, and legacy redirects.
- Internal link crawl passed for current MVP hub anchors.
- A current sitemap crawl verified all 22 listed local URLs return `200`; no sitemap URL returned an error.
- A current full-theme lint pass verifies 30 PHP files and 4 JavaScript files; the rendered homepage contains no CSS `@import` and the direct font stylesheet/preconnect contract is present.
- Mobile navigation now exposes a labeled `nav`, `aria-controls`, and Escape-to-close focus restoration; the change passed PHP/JS checks and rendered label smoke.
- The decision-tool result now builds DOM nodes with `textContent` rather than interpolating form values into `innerHTML`.
- The cleaning hub no longer labels a research-only fixture as an “Editor's pick”; the rendered label is now “Research fixture.”
- Homepage, archive, and product comparison score badges now require a numeric score plus an allowed evidence status and `last_reviewed` metadata; otherwise they stay at “Pending score”/“Pending test record.”
- The theme now registers backend-only `product_test`, `merchant`, `offer`, `service`, and `insurance_provider` CPTs with no public archive, rewrite, navigation, or REST exposure; their public slugs return a noindex 404 template.
- `functions.php` now includes normalized product-evidence helpers, completed-rubric checks, merchant/offer record lookup, and approval gating. Missing records safely return `not_yet_verified`/pending and never activate an outbound redirect.
- Homepage, archive, and product-comparison templates now consume the shared evidence helper instead of duplicating score/status checks.
- An ephemeral local integration fixture verified merchant → product → completed product test → approved offer resolution; all temporary records were deleted and a follow-up query found zero `Codex Test` records.
- A feature-gated destination resolver now validates approved offer/merchant state and HTTP(S) URLs; the live flag is off by default and the preview `/go/` route remains placeholder-only. Resolver validation rejected `javascript:` and accepted a temporary HTTPS fixture, which was deleted.
- Runtime bootstrap confirms `show_in_rest=false` for all six backend CPTs, including the existing `pet_product`; public preview routes and `/go/` behavior remain unchanged.
- Release-hygiene scan found no direct affiliate/network URLs or live redirect calls in the theme; only intentional legacy redirects remain. A sitemap-wide internal-link crawl checked 22 same-origin page links with no error responses.
- ACF validation confirms all 6 JSON groups target registered CPTs and all 52 field keys are unique; repeated field names across provider/service groups are intentional and scoped by group.
- Runtime note: the legacy `pethomescout-preview.php` mu-plugin was moved to a `.disabled` backup so it no longer creates pages or rewrites templates. Old generated page records remain (`sample-page`, legacy service/tool aliases, and the original MVP page slugs) and should be removed only during an approved clean rebuild.
- `playground-blueprint.json` now installs and activates the official `advanced-custom-fields` WordPress.org plugin for future clean Playground rebuilds; the current temporary runtime remains unchanged until rebuilt.
- Added `README.md` and `CHANGELOG.md` so Codex/ChatGPT and future contributors have a reproducible setup, workflow, verification commands, and explicit pending gates.
- Preview HTML now emits one `robots` meta tag, with `wp_robots` as the single source and `X-Robots-Tag` retained as the HTTP-level guard.
- Local cold-request timing was sampled three times per route: homepage ~659 ms, Services & Insurance ~740 ms, Smart Tech comparison ~661 ms, and insurance demo ~598 ms. Modern browsers receive WebP hero sources; the PNG fallbacks remain larger (0.77–1.09 MB) and need PageSpeed validation on staging before production decisions.
- An isolated WordPress Playground CLI rebuild was attempted on separate ports with and without the ACF blueprint; both reached the server stage but returned the same SQLite/502 error before serving HTTP, so the failure is environmental rather than caused by the theme or ACF step. The existing local runtime was left unchanged.

## Current known untracked docs/assets

- `docs/DATA_MODEL_AND_GO_SYSTEM_PLAN.md`
- `docs/TRACKING_EVENT_CONTRACT.md`
- `docs/LAUNCH_READINESS_CHECKLIST.md`
- `docs/CURRENT_AUDIT_SUMMARY.md`
- `docs/COMMIT_READINESS_GROUPING.md`
- `docs/REVIEW_OPERATING_MODEL.md`
- `wp-content/themes/pethomescout/assets/hero-pet-home.webp`
- `wp-content/themes/pethomescout/assets/services-grooming-hero.webp`
- `wp-content/themes/pethomescout/assets/smart-tech-comparison.webp`
- `wp-content/themes/pethomescout/page-pet-sitting.php`
- `wp-content/themes/pethomescout/page-static-info.php`

`outputs/` appears to contain generated brand/logo artifacts and should be reviewed before deciding whether to commit it.

## Remaining approval-required work

Do not implement these without explicit approval:

- Real offer records, resolver wiring, and live backend integrations remain approval-required. ACF JSON groups, helper logic, and authenticated local Admin editing are verified.
- Real `/go/` offer resolver and outbound affiliate redirects.
- GA4/GTM/Clarity credentials.
- Lead storage, consent logging, CRM routing, email sending, or buyer delivery.
- US-hosted external staging setup.
- Production indexing and GSC/PageSpeed submission.

## Recommended next decision

Choose one path:

1. Commit the current MVP hardening work after reviewing the dirty worktree.
2. Select a password-protected US-hosted staging provider and repeat the documented Admin/SEO/Lighthouse QA.
3. Keep live redirects, lead storage, and analytics credentials disabled until their approvals are complete.

## 30-task WordPress brief audit — 2026-07-12

### Pass

- WordPress theme is the only runtime implementation; the rendered homepage, hubs, service pages, tools, legal pages, and `/go/` placeholder routes returned `200` locally.
- ACF is active in the isolated runtime with nine JSON groups, including homepage, article, hub, merchant, offer, product evidence, product test, service, and insurance-provider controls.
- Header/footer lifecycle hooks, title-tag support, theme.json, registered primary/footer menus, and the native Gutenberg PetHomeScout pattern catalog are present.
- Affiliate UI uses pending controls by default; no raw affiliate/network URLs are present in theme templates; `/go/` is noindex and does not redirect while live offers are disabled.
- Lead demos show the TCPA copy and no-storage notice; source scan found no persistence, email, CRM, REST, browser-storage, or external request path; browser interaction completed the three-step insurance demo without echoing submitted values.
- Local browser QA passed at desktop and mobile widths with no page-wide horizontal overflow, one H1 per representative route, canonical/meta/schema output, accessible labels, skip links, image alt text, and no console errors.

### Partial / needs follow-up

- The isolated runtime now uses `/%postname%/`; the production install checklist must still set this value and verify slug collision handling before indexing.
- Rank Math `1.0.274-beta` and ACF are active and visible in the authenticated local Admin. The Smart Tech Page edit screen exposes the ACF hub fields (`hub_title`, `featured_guides`) and the Rank Math admin integration; preview-route filters provide exactly one title, description, canonical, Open Graph description, and JSON-LD fallback on five representative routes.
- Re-ran internal-link crawling across nine representative routes: 10 unique root-relative links discovered, 0 broken responses.
- Local preview router now dispatches `/wp-admin/` to WordPress Admin's index file instead of treating the directory as the public homepage; authenticated HTTP QA reached Dashboard, Page editing, Services CPT listing, and Plugins screens successfully.
- Chrome fallback QA (Browser plugin unavailable) passed at 1440×1000 and 375×812: five representative routes had one H1, no horizontal overflow, no console errors, no failed requests, and all images had alt text. The insurance demo exposed the expected ZIP/breed/contact/consent fields; the selector changed state after interaction. Services hub load timing was 425 ms DOMContentLoaded / 425 ms load in local preview.
- Microsoft Edge smoke QA also passed at 1280×900 and 375×812 for Smart Tech and insurance: correct titles, one H1, no overflow, no console errors, and all expected form labels/inputs.
- `/go/roborock/qrevo/` remains internal, `200`, `noindex,nofollow`, and does not redirect; sitemap and robots endpoints return `200` with preview crawl blocking.
- Preview/production gate was verified by toggling the isolated runtime only: with `blog_public=0` and a local host it returns `noindex,nofollow`; with `blog_public=1` and a production-host header it returns `max-image-preview:large` without the theme's noindex rule. The runtime was restored to `blog_public=0`.
- Lighthouse desktop audit on Services & Insurance scored Performance 92, Accessibility 100, Best Practices 100, and SEO 69. The only SEO failure is the intentional preview `noindex`; FCP/LCP were ~1.3 s and CLS 0.002. The footer contrast finding was fixed from 95 to 100 accessibility.
- Synthetic preview routes now include a verified default `og:image` and `twitter:image` pointing to the optimized WebP hero asset; the asset returns `200` locally.
- Hyper-niche Article ACF controls now cover 27 fields, including household context, monetization toggles, related service, and relevance rationale. A temporary published QA article proved the contextual service CTA appears only when enabled with all required fields, disappears when disabled, and leaves no test record after cleanup.
- `single.php` reads WordPress post content and ACF relationships; homepage and hub templates now prefer editor-curated product records and retain fixture product/card copy only as an explicit empty-field fallback.
- The reusable block layer now contains native Gutenberg patterns for disclosure, quick verdict, comparison table, evidence badge, service CTA, FAQ, Buy Box, and ScoutScore. Offer resolution and evidence gating remain PHP/data-driven so editors cannot bypass approval rules.
- Homepage hero copy and primary/secondary CTA destinations now have an ACF field group with safe theme fallbacks; the local homepage still returns `200` and renders the fallback copy when fields are empty.
- Homepage featured guide selection now has an ACF `home_featured_guide` relationship field; the older `hero_featured_pick` meta query remains only as a compatibility fallback.
- Smart Tech hub now reads selected `featured_guides` relationship records from ACF and renders their evidence status, review date, and editable guide links; fixture cards remain only as the empty-field fallback.
- Family Home and Cleaning & Odor hubs now use the same ACF-curated guide path with evidence/review metadata and safe fixture fallbacks; both routes return `200` after the change.
- Services & Insurance now reads published Service CPT records for the service cards (with a safe four-card fallback), so approved service labels/routes can be managed from WordPress rather than hardcoded only in the template.
- A temporary local QA Post was linked through the Smart Tech Page's ACF `featured_guides` field; the hub rendered the QA title and suppressed fixtures, then the field and Post were deleted and the fixture fallback was verified again. This proves the relationship path without leaving test content.
- `functions.php` remains a large monolith (about 1,083 lines) and there is no `inc/` module split yet; behavior is functional but not at the target maintainability architecture.
- Supporting CPTs remain intentionally backend-only with `show_in_rest=false`; this is safe for the current admin model but differs from the brief's optional REST-enabled recommendation.
- Authenticated Admin screens are verified for Dashboard, Smart Tech Page editing, ACF relationship fields, Services CPT, and active plugins. Saving a real production content record and Rank Math field values remains a staging checkpoint.

### Blocked / intentionally deferred

- Real affiliate destinations, live `/go/` redirects, lead storage/routing, consent logging, CRM/email, GA4/Clarity credentials, and production indexing remain disabled by design.
- Clean WordPress Playground rebuild remains blocked by the previously observed SQLite/502 environment failure.
- External field data, staging-provider review, Firefox/Safari coverage, and production GSC validation remain unrun; local Lighthouse plus Chrome and Edge smoke QA are complete.
- `docs/STAGING_HANDOFF.md` now captures the exact US-hosted staging requirements, safety gates, QA routes, acceptance checks, and production cutover sequence without including credentials.
