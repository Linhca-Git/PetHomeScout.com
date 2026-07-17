# PetHomeScout Data Model & `/go/` System Plan

Status: Phase 1 CPT registration, ACF JSON field groups, evidence helpers, and approval checks implemented; real offer records and any live resolver remain approval-required.

Canonical source: `docs/EXECUTIVE_KNOWLEDGE_BASE.md`.

## Purpose

This plan defines the next large implementation step for PetHomeScout after the MVP theme, demo forms, trust pages, and placeholder commercial paths are stable.

The goal is to make commercial, evidence, product, and service data reusable without exposing thin public archives, direct affiliate URLs, or unapproved lead routing.

## Non-negotiable guardrails

- WordPress custom theme only.
- No page builder.
- No direct affiliate URLs in article content.
- No live outbound merchant redirects until partner credentials and approval status exist.
- No lead storage, CRM routing, email sending, or buyer delivery until compliant consent logging and provider agreements are approved.
- No fake ratings, fake test records, fake providers, fake prices, or real-looking placeholder offers.
- Public SEO pages must remain editorial/decision pages, not thin database archives.

## CPTs to add after approval

All CPTs should be backend-first unless a public template is explicitly approved.

| CPT | Public? | Purpose |
|---|---:|---|
| `pet_product` | No | Product records and evidence metadata. Backend-first with public query and REST exposure disabled. |
| `product_test` | No | Founder-led test records and rubric evidence. Registered backend-only; ACF JSON group present. |
| `merchant` | No | Affiliate merchant/network/account metadata. Registered backend-only; ACF JSON group present. |
| `offer` | No | Product-to-merchant commercial offer records and approval status. Registered backend-only; ACF JSON group present. |
| `service` | No | Local/service vertical records such as grooming, sitting, odor cleaning. Registered backend-only; ACF JSON group present. |
| `insurance_provider` | No | Pet insurance partner metadata and approval status. Registered backend-only; ACF JSON group present. |

## Minimum field groups

### Product

- Evidence status
- Last reviewed date
- ScoutScore components
- Product category
- Pet type suitability
- Breed/hair/floor suitability
- Limitations

### Product test

- Related product
- Test date
- Tester
- Household context
- Pet breed/type
- Floor type
- Setup notes
- Observed outcomes
- Ownership friction
- Limitations
- Evidence assets/notes
- Completed rubric flag

### Merchant

- Merchant slug
- Network
- Program status
- Contact/manager notes
- Default `/go/` path
- Last checked date

### Offer

- Related product
- Related merchant
- Destination URL
- Backup destination
- Offer status: pending, approved, paused, rejected
- Commission notes
- Cookie window
- Last checked date

### Service / insurance provider

- Provider/service type
- Approval status
- Covered states or scope
- Consent requirements
- Routing status
- Partner notes

## `/go/` system design

Phase 1 should keep `/go/` as a safe placeholder:

- `/go/{merchant}/`
- `/go/{merchant}/{product}/`
- `noindex,nofollow`
- not in sitemap
- no external redirect unless the matched offer is approved

Phase 2, only after approval:

1. Resolve `/go/` path to an approved `offer` record.
2. Confirm merchant and offer status are both approved.
3. Log non-PII click intent event.
4. Redirect with `rel="sponsored nofollow"` used on the originating link.
5. Fall back to the pending placeholder if no approved offer exists.

## Acceptance criteria

- New CPTs are admin-visible but not publicly queryable.
- No new public archive is created.
- No direct merchant URLs appear in rendered article content.
- `/go/` remains excluded from sitemap.
- Pending offers render disabled controls, not “Check price” buttons.
- “Founder-tested” appears only when a complete `product_test` rubric exists.
- Product/Review schema is not emitted unless visible evidence supports it.
- PHP lint and route smoke checks pass.

## Approval packet for the remaining live-integration step

The safe backend foundation is implemented. The remaining live-integration step needs explicit approval because it can expose commercial destinations, involve partner credentials, and change privacy/measurement behavior.

### Proposed scope

Complete only the approved runtime/integration work:

1. Verify ACF Admin rendering in an approved WordPress runtime.
2. Add real offer records only after merchant credentials and destination ownership are documented.
3. Wire `/go/` routing only after explicit approval and keep a rollback switch.
4. Keep public templates using disabled commercial controls unless an offer is explicitly approved.
5. Keep lead storage, CRM routing, analytics credentials, and buyer delivery out of scope until separately approved.

### Files likely to change

Expected files:

- `wp-content/themes/pethomescout/functions.php`
- `wp-content/themes/pethomescout/acf-json/*.json`
- `docs/DATA_MODEL_AND_GO_SYSTEM_PLAN.md`

Possible files only if needed:

- `wp-content/themes/pethomescout/page-go-placeholder.php`
- `wp-content/themes/pethomescout/single.php`
- `wp-content/themes/pethomescout/page-smart-tech.php`

### Explicit non-goals for the remaining approval step

Do not implement these in the next step:

- No real outbound affiliate redirect.
- No GA4/GTM/Clarity credentials.
- No lead storage or CRM routing.
- No provider/buyer delivery.
- No public product archive.
- No fake offer prices.
- No Product/Review schema from incomplete evidence.
- No WooCommerce dependency.
- No page builder dependency.

### Test plan

Before handoff, verify:

- PHP lint passes for all theme PHP files.
- JS syntax check passes for all theme JS files.
- Admin-only CPT registration is visible in code and not publicly queryable.
- `/products/` still redirects to `/smart-tech/`.
- `/go/roborock/test/` still renders the pending placeholder.
- `/go/` remains noindex via meta and `X-Robots-Tag`.
- `sitemap.xml` does not contain `/go/`, product archives, legacy routes, or backend-only CPT archives.
- Commercial templates still render disabled merchant controls when offers are pending.
- Founder-tested labels require a completed `product_test` record.

### Rollback plan

If the implementation causes template or routing regressions:

1. Revert the CPT registration block and helper functions.
2. Leave existing MVP templates and `/go/` placeholder behavior intact.
3. Keep ACF JSON groups and the live-offer feature flag in their safe disabled state.
4. Re-run endpoint, sitemap, `/go/`, and lead-form smoke tests.

## Implementation note

The theme now contains the safe, backend-only CPT registration, ACF JSON, evidence helpers, offer approval checks, and feature-gated destination validator. Remaining work is Admin/plugin verification, real approved offer records, resolver wiring, and migration/rollback review before any live routing.

## Hyper-niche article controls

The Article ACF group now also stores household context and contextual monetization controls: user intent, pet/breed context, hair/shedding, floor/carpet, home size, children, problem type, product category, primary monetization, affiliate enablement, service fallback enablement, related service type/page, CTA copy, and relevance rationale. Service fallback rendering is opt-in and requires all required relationship/relevance fields.

## ACF runtime verification checklist

The isolated local runtime now includes the official ACF plugin and has been verified through authenticated Admin screens. A clean rebuild or staging install still needs the same verification before using the backend:

1. Install and activate the approved ACF edition in the WordPress Admin.
2. Confirm the nine JSON groups appear under the ACF field-group screen and sync without conflicts.
3. Open one record of each backend CPT and verify the expected fields are visible.
4. Save a non-production draft for each CPT and confirm the values are stored as the documented meta keys.
5. Confirm the public site still returns 404 for backend slugs and no CPT appears in REST, navigation, search, or sitemap output.
6. Delete the draft fixtures and record the verification date before staging review.

Do not enter live affiliate credentials, real provider contracts, or personal lead data during this verification.
