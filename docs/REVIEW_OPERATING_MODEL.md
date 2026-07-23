# PetHomeScout Review Operating Model

Purpose: keep technical implementation review, SEO/content strategy review, and real-world performance measurement separated so PetHomeScout does not rely on guesswork.

## Roles

### ChatGPT: strategy, content, SEO, UX, and conversion review

Use ChatGPT for:

- Search intent and content quality.
- Meta title and meta description direction.
- Heading structure and page narrative.
- Landing-page structure and CTA hierarchy.
- Content gaps, topical map, and internal-link strategy.
- Affiliate and lead-generation funnel logic.
- Trust language, evidence positioning, and compliance-sensitive copy.
- UX review from the perspective of the target U.S. pet household.

ChatGPT should not be treated as the final source for runtime technical facts unless those facts are verified in code, browser output, Google Search Console, GA4, PageSpeed Insights, or another source of record.

### Codex: technical audit and implementation

Use Codex for:

- WordPress theme code review and focused patches.
- HTML, CSS, JavaScript, PHP, schema, sitemap, and robots checks.
- WordPress, theme, plugin, WooCommerce, console, and form errors.
- Core Web Vitals and frontend performance implementation work.
- Tracking hook verification for GA4/GTM readiness.
- Demo form behavior, no-PII persistence checks, and `/go/` redirect safety.
- Direct code/file/theme fixes after a scoped audit is approved.

Codex should keep patches small, verify locally, and avoid broad refactors unless explicitly approved.

### Google Search Console, GA4, and PageSpeed Insights: measurement sources

Use these tools to avoid guessing:

- Google Search Console: indexing, query data, impressions, CTR, sitemap status, coverage issues.
- GA4/GTM: event collection, conversion behavior, funnel drop-off, affiliate intent, lead demo interactions.
- PageSpeed Insights/Lighthouse: Core Web Vitals, lab performance, render-blocking resources, image/font issues.

Do not connect GA4, GTM, Clarity, CRM, real affiliate redirects, or lead routing until the tracking contract, consent model, and staging review are approved.

## Recommended review loop

1. ChatGPT audits content, SEO strategy, UX, trust, and conversion direction.
2. Codex converts approved findings into small technical patches.
3. Codex verifies the patch locally with targeted checks.
4. The site is reviewed in browser/staging.
5. GSC, GA4, and PageSpeed data are used once real measurement is approved and available.
6. New strategic findings return to ChatGPT before Codex makes broad implementation changes.

## Review boundaries

### ChatGPT findings become implementation tasks only when they are specific

Good:

- Add affiliate disclosure below H1 on commercial templates.
- Rename `/tool/` to `/pet-tech-selector/`.
- Remove unverified “Founder-tested” claims where no test record exists.

Too vague:

- Make SEO better.
- Improve trust.
- Add more content.

### Codex fixes only the approved scope

Codex should not:

- Add new content clusters without approval.
- Build real lead routing without approval.
- Add affiliate destinations without partner approval.
- Connect analytics credentials without approval.
- Commit, push, or deploy unless explicitly requested.

## Source-of-truth rule

When review feedback conflicts:

1. `docs/EXECUTIVE_KNOWLEDGE_BASE.md`
2. Approved MVP/audit remediation tasks
3. `docs/REVIEW_OPERATING_MODEL.md`
4. Code and rendered behavior
5. Tool measurements from GSC, GA4, PageSpeed, Lighthouse, and browser tests

If a conflict changes business direction, ask before implementing.
