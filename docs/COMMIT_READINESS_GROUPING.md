# PetHomeScout Commit Readiness Grouping

Purpose: group the current audit-remediation work into reviewable commit scopes without staging or committing anything automatically.

Status: planning only. Do not stage, commit, push, or open a PR from this document unless the project owner explicitly requests it.

## Suggested commit groups

### 1. Project documentation and guardrails

Scope:

- `.gitignore`
- `README.md`
- `CHANGELOG.md`
- `docs/EXECUTIVE_KNOWLEDGE_BASE.md`
- `docs/PROJECT_BRIEF.md`
- `docs/US_AUDIENCE_AND_UI.md`
- `docs/DATA_MODEL_AND_GO_SYSTEM_PLAN.md`
- `docs/TRACKING_EVENT_CONTRACT.md`
- `docs/LAUNCH_READINESS_CHECKLIST.md`
- `docs/CURRENT_AUDIT_SUMMARY.md`
- `docs/REVIEW_OPERATING_MODEL.md`
- `docs/COMMIT_READINESS_GROUPING.md`

Intent:

- Preserve the current business, SEO, tracking, launch-readiness, and backend-approval decisions.
- Preserve the implemented backend-only CPT/ACF foundation while keeping live `/go/` routing and lead integrations approval-gated.

Review before commit:

- Confirm `docs/EXECUTIVE_KNOWLEDGE_BASE.md` remains the canonical strategy source.
- Confirm no obsolete Next.js/Vercel implementation wording was reintroduced.

### 2. Theme MVP trust, SEO, funnel, and accessibility hardening

Scope:

- `wp-content/themes/pethomescout/functions.php`
- `wp-content/themes/pethomescout/header.php`
- `wp-content/themes/pethomescout/footer.php`
- `wp-content/themes/pethomescout/front-page.php`
- `wp-content/themes/pethomescout/index.php`
- `wp-content/themes/pethomescout/single.php`
- `wp-content/themes/pethomescout/style.css`
- deleted `wp-content/themes/pethomescout/css/mvp.css`
- `wp-content/themes/pethomescout/acf-json/group_pethomescout_product_evidence.json`
- `wp-content/themes/pethomescout/partials/lead-form.php`
- updated page templates under `wp-content/themes/pethomescout/page-*.php`
- updated JavaScript under `wp-content/themes/pethomescout/js/*.js`

Intent:

- Remove unsupported trust, testing, rating, and real-time service claims.
- Keep commercial CTAs safe until merchant approval.
- Improve noindex handling, sitemap/robots behavior, internal links, demo lead forms, and accessibility states.
- Keep the active design system aligned to `Fraunces` display typography and `Nunito Sans` UI/body/data typography in the main theme stylesheet.

Review before commit:

- Verify no lead form persists PII, sends email, calls a CRM, or stores submitted values.
- Verify affiliate disclosure appears before the first commercial CTA.
- Verify `/go/` remains a placeholder/safe route until explicit backend approval.
- Verify Founder-tested labels only render with valid evidence records.
- Verify the deleted legacy `css/mvp.css` file is not enqueued or imported.

### 3. Image and performance assets

Scope:

- `wp-content/themes/pethomescout/assets/hero-pet-home.png`
- `wp-content/themes/pethomescout/assets/services-grooming-hero.png`
- `wp-content/themes/pethomescout/assets/smart-tech-comparison.png`
- `wp-content/themes/pethomescout/assets/hero-pet-home.webp`
- `wp-content/themes/pethomescout/assets/services-grooming-hero.webp`
- `wp-content/themes/pethomescout/assets/smart-tech-comparison.webp`

Intent:

- Keep optimized visual assets and WebP variants together so binary changes are easy to review.

Review before commit:

- Confirm the PNG changes are intentional.
- Confirm templates reference the WebP variants through safe fallbacks.

### 4. Legacy route and file cleanup

Scope:

- deleted `wp-content/themes/pethomescout/js/lead-form.js`
- deleted `wp-content/themes/pethomescout/js/tool.js`
- deleted `wp-content/themes/pethomescout/page-lead-form.php`
- deleted `wp-content/themes/pethomescout/page-services-reference.php`

Intent:

- Remove obsolete demo assets/templates after replacement routes and templates are in place.

Review before commit:

- Confirm no theme or documentation reference still depends on these deleted filenames.
- Confirm legacy public URLs are redirected or intentionally retired.

## Do not commit

- `outputs/`
- local logs, generated screenshots, browser dumps, or temporary QA artifacts
- any secret, affiliate credential, analytics credential, CRM token, or real lead data

## Required checks before any commit

- PHP lint all changed theme PHP files.
- JavaScript syntax check for changed JS files.
- Render smoke for homepage, Services & Insurance, Smart Tech, lead-demo pages, `/go/`, `robots.txt`, and `sitemap.xml`.
- Verify local/preview environments emit `noindex,nofollow`.
- Verify `/go/` routes do not redirect externally.
- Verify demo lead forms do not persist, email, CRM-route, cookie, localStorage, or sessionStorage PII.
- Verify footer/legal/internal links resolve.

## Current note

Targeted searches found no remaining direct references to the deleted legacy filenames or legacy routes in theme/docs at the time this grouping file was created.
