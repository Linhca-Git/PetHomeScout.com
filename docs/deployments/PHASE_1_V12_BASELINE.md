# PetHomeScout Phase 1 v12 Deployment Baseline

## Release identity

- Deployment date: 2026-07-19
- Production domain: https://pethomescout.com/
- Theme package: `pethomescout-theme-phase1-v12.zip`
- Theme SHA-256: `08800B9214C485F492F65BC131042114B555115DC2F1E522CD6DB43EB22242F1`
- Theme comparison: 55 of 55 files matched the working theme byte-for-byte; no missing, extra, or mismatched theme files.
- WordPress: 7.0.2
- Web PHP: 8.3.31
- Active SEO plugin: Rank Math SEO
- Active field plugin: Advanced Custom Fields (ACF)

## Active public routes

- `/`
- `/cleaning-odor/`
- `/pet-hair-cleaning/`
- `/pet-odor-stain-removal/`
- `/pet-home-cleaning-selector/`
- `/how-we-test/`
- `/methodology/`
- `/best-robot-vacuum-for-dog-hair/`
- `/about/`
- `/contact/`
- `/affiliate-disclosure/`
- `/advertising-disclosure/`
- `/privacy-policy/`
- `/terms/`
- `/do-not-sell-or-share/`

All public routes intentionally remain `noindex, nofollow` at this release.

## Redirect ownership

- `/robot-vacuums-for-pet-hair/` returns 301 to `/pet-hair-cleaning/`.
- `/evidence-standards/` returns 301 to `/how-we-test/`.

## Intentional future-route 404s

- `/family-home/`
- `/smart-tech/`
- `/services-insurance/`
- `/pet-insurance-for-french-bulldogs/`
- `/mobile-pet-grooming/`

These routes are not active Phase 1 business lines and are excluded from the public sitemap and navigation.

## WordPress database state from Task 1

- Page ID 34 (`robot-vacuums-for-pet-hair`) is draft.
- Page ID 26 (`evidence-standards`) is draft.
- Primary menu name: `Phase 1 Primary`.
- Primary menu ID: `2`.
- Menu location: `primary`.
- Approved menu destinations:
  - Home: `/`
  - Pet Hair: `/pet-hair-cleaning/`
  - Odor & Stains: `/pet-odor-stain-removal/`
  - Cleaning Selector: `/pet-home-cleaning-selector/`
  - How We Test: `/how-we-test/`
- WordPress `blog_public`: `0`.

The database state above is documented for reproducibility but is not contained in Git or in the theme ZIP.

## Monetization and data safety

- No live merchant or external affiliate destinations are configured.
- `/go/` commercial destinations remain inactive placeholders.
- No production lead routing is active.
- No production lead form stores, emails, routes, or transmits PII.
- No production analytics credentials are part of this baseline.

## Source-control and artifact boundaries

- The committed theme tree is the exact content of the verified v12 deployable ZIP.
- The deployable ZIP is a generated artifact under ignored `outputs/` and is not committed; its package name and SHA-256 are recorded here.
- Logs, local preview output, tunnels, caches, databases, credentials, and environment-specific files are excluded.
- `docs/PHASE_1_SCOPE_LOCK.md` was local-only and not present in v12; it was preserved outside the baseline commit in a named Git stash.

## Known limitations

- This Git baseline does not reproduce WordPress database records automatically.
- Editorial product research and first-hand testing remain incomplete.
- Merchant approval, affiliate destinations, buyers, consent logging, and lead routing remain inactive.
- Search indexing remains intentionally disabled pending a separate launch review.
- Plugin versions beyond the verified WordPress and PHP runtime were not captured in the deploy artifact.
