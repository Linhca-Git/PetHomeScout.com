# PetHomeScout Launch Readiness Checklist

Status: checklist for staging and production review. Do not treat local preview as launch-ready.

Canonical source: `docs/EXECUTIVE_KNOWLEDGE_BASE.md`.

## Purpose

This checklist separates local preview, password-protected staging, and production launch so PetHomeScout does not accidentally index unfinished pages, expose unapproved affiliate paths, or collect personal data before compliance work is complete.

## Local preview requirements

- Localhost and tunnel URLs must stay `noindex,nofollow`.
- Set WordPress Settings → Permalinks to `Post name` (`/%postname%/`) and flush rewrite rules; verify flat routes and legacy redirects before review.
- Activate exactly one approved SEO plugin (Rank Math or Yoast) and confirm title, description, canonical, robots, Open Graph, and schema fields on real Page and Post records; do not rely only on theme fallback output.
- Rebuild or inspect the local WordPress runtime before staging; the legacy `pethomescout-preview.php` mu-plugin is retained as a `.disabled` backup and old generated page records may still exist outside tracked source.
- Local preview may use demo forms only.
- `/go/` routes must show pending placeholders and must not redirect externally.
- Sitemap must exclude `/go/`, backend-only CPT archives, and legacy routes.
- Robots.txt may disallow all local preview crawling.
- Console errors and PHP lint failures must be fixed before external staging review.
- If using the local PHP router, verify `/wp-admin/` is dispatched to the Admin index rather than the public preview route before attempting authenticated QA.

## Staging requirements

Before sharing staging externally:

- Use US-hosted WordPress staging.
- If backend records are part of the staging scope, activate the approved ACF edition and complete the field-group verification checklist in `docs/DATA_MODEL_AND_GO_SYSTEM_PLAN.md`.
- Enable password protection.
- Keep `noindex,nofollow` in meta and `X-Robots-Tag`.
- Confirm canonical URLs do not point to production unless production content is approved.
- Confirm forms are still demo-only unless compliant consent logging is implemented.
- Confirm no real affiliate destination is active unless merchant approval and redirect ownership are documented.
- Confirm no GA4, GTM, Clarity, CRM, email, or lead-buyer integration is active without approval.

## Production indexing requirements

Before production can be indexed:

- Remove password protection only after review.
- Switch robots/meta/header behavior intentionally from noindex to index for approved public pages.
- Set Settings → Reading to allow search engines (`blog_public=1`) only at the approved production cutover; verify the production host returns `index,follow` while local/staging remains blocked.
- Keep `/go/` and backend-only surfaces noindex and out of sitemap.
- Submit sitemap only after canonical, title, meta, schema, and internal links pass audit.
- Verify visible affiliate disclosure before the first commercial CTA.
- Verify demo language is removed only when the real backend is compliant and approved.
- Verify all “Founder-tested” labels have complete rubric records.
- Verify no fake prices, fake ratings, fake reviews, fake providers, or fake testing claims exist.

## External tools to run after production approval

- Google Search Console: property verification, sitemap submission, index coverage, query monitoring.
- GA4/GTM: only after the tracking contract and consent decisions are approved.
- Microsoft Clarity: only after consent/privacy review.
- PageSpeed Insights or Lighthouse: collect real field/lab data for Core Web Vitals.
- Broken-link checker: verify public internal links and approved outbound paths.

## Hard stop conditions

Do not launch production indexing if any of these are true:

- Lead forms store, email, or route PII without approved compliance work.
- `/go/` redirects externally without approved merchant/offer records.
- Staging or tunnel URLs are indexed.
- Product/Review schema is emitted without visible supporting evidence.
- Public pages contain unsupported testing, rating, user count, state coverage, real-time quote, or background-check claims.
