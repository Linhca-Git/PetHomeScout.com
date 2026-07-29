# PetHomeScout.com

PetHomeScout is a US-focused WordPress decision engine for pet-friendly family homes. It combines research-led product guidance, comparison tools, and privacy-first service/insurance demo flows.

## Current scope

- US English, USD, US household context.
- Custom WordPress theme under `wp-content/themes/pethomescout/`.
- Core hubs: Family Home, Smart Tech, Cleaning & Odor, Services & Insurance.
- Backend-only CPTs: `pet_product`, `product_test`, `merchant`, `offer`, `service`, and `insurance_provider`.
- ACF JSON groups are stored under `wp-content/themes/pethomescout/acf-json/`.
- Affiliate `/go/` routes remain pending placeholders. Live offers are feature-gated and disabled.
- Lead forms are demo-only and do not store, email, or route personal information.

## Local preview

The tracked setup file is `playground-blueprint.json`. A clean WordPress Playground rebuild installs and activates the official Advanced Custom Fields plugin, then activates the theme. The current temporary runtime may contain legacy generated pages or mu-plugins; rebuild it before staging review.

The current local preview has the legacy generated mu-plugin retained as `pethomescout-preview.php.disabled`; it is not loaded. Old generated page records may still exist and should be removed only during an approved clean rebuild.

The local preview must remain:

- `noindex,nofollow`
- password-protected when shared externally
- free of real affiliate credentials, analytics credentials, provider contracts, and lead data

## WordPress editor setup

Before authoring content in a staging or production-like install:

1. Activate the theme and the official Advanced Custom Fields plugin; sync the JSON groups under `acf-json/`.
2. Activate exactly one SEO plugin: Rank Math or Yoast. Do not run both.
3. Set Settings → Permalinks to **Post name** (`/%postname%/`) and flush rewrite rules.
4. Confirm the primary and footer menus are assigned, then create the approved hub Pages before publishing Posts.
5. Use ACF relationships for hub curation, evidence status, review dates, offers, and services. Keep `/go/` offers pending until partner approval.
6. Keep staging password-protected and `noindex,nofollow`; never enter real lead data in demo forms.
7. Before production indexing, enable Settings → Reading → “Allow search engines to index this site” (`blog_public=1`) and verify the production host returns `index,follow`; the local runtime intentionally keeps `blog_public=0`.

Rank Math/Yoast owns SEO title, description, canonical, robots, social metadata, and standard schema for real Posts and Pages. The theme fallback only supports synthetic local preview routes.

## Verification commands

From the repository root:

```powershell
$theme = "wp-content/themes/pethomescout"
Get-ChildItem $theme -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
Get-ChildItem "$theme/js" -Filter *.js | ForEach-Object { node --check $_.FullName }
Get-ChildItem "$theme/acf-json" -Filter *.json | ForEach-Object { Get-Content -Raw $_.FullName | ConvertFrom-Json | Out-Null }
```

The project audit also checks route status, canonical/noindex headers, sitemap exclusions, backend 404 behavior, internal links, and demo-form non-persistence.

## Operating model

- ChatGPT: content, SEO strategy, UX, conversion, and topical authority review.
- Codex: PHP/JS/theme/schema/sitemap/robots/tracking implementation and technical verification.
- Search Console, GA4/GTM, Clarity, and PageSpeed: connect only after staging, consent, and production approval.

Canonical project guidance lives in `docs/EXECUTIVE_KNOWLEDGE_BASE.md`. Backend and `/go/` rules live in `docs/DATA_MODEL_AND_GO_SYSTEM_PLAN.md`.

The external staging handoff is documented in `docs/STAGING_HANDOFF.md`.
The hyper-niche content and contextual monetization rules are documented in `docs/CONTENT_STRATEGY.md`, `docs/ACF_SCHEMA.md`, and `docs/INTERNAL_LINKING.md`.

Do not stage, commit, push, deploy, enable live redirects, or connect lead buyers without explicit project-owner approval.
