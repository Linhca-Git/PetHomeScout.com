# PetHomeScout Review Build

## Package

- `pethomescout-review-build.zip` — WordPress Playground blueprint, theme ZIP, and review documentation.
- `pethomescout-theme.zip` — installable theme archive.
- `playground-blueprint.json` — imports WordPress, activates ACF, and activates the PetHomeScout theme.
- The review bundle contains the complete `docs/` directory and `review-reports/` directory.
- `docs/CHANGE_SUMMARY.md` — files changed since the previous package, blocker fixes, and limitations.

The final bundle contains 22 documentation files and 10 review-report files.

The preview metadata layer guarantees canonical and JSON-LD output for the homepage and French Bulldog fixture route when Rank Math has no persisted schema configuration.

## Changed implementation areas

- `wp-content/themes/pethomescout/functions.php` — ACF registration, article context normalization, service-fallback eligibility, redirect placeholders, metadata/schema helpers, and admin integrations.
- `wp-content/themes/pethomescout/single.php` — renders contextual service fallback after the primary article decision path.
- `wp-content/themes/pethomescout/template-parts/commercial/service-fallback-cta.php` — secondary service CTA component.
- `wp-content/themes/pethomescout/style.css` — service fallback and current theme presentation styles.
- `wp-content/themes/pethomescout/acf-json/group_pethomescout_article.json` — 27 article fields for hyper-niche context, evidence, internal links, monetization, and fallback controls.
- `wp-content/themes/pethomescout/acf-json/` — homepage, hub, merchant, offer, product evidence/test, service, and insurance-provider field groups.
- `wp-content/themes/pethomescout/template-parts/cards/hub-product.php` — editor-curated product/evidence/offer card renderer used by hub templates.
- `wp-content/themes/pethomescout/front-page.php` and hub templates — prefer ACF-selected product records with explicitly labelled fixture fallbacks.
- `docs/` — business, SEO, internal-linking, affiliate, lead-generation, page-template, ACF schema, decision, audit, and staging documentation.

## ACF/database changes

The theme adds or syncs ACF field groups from `acf-json/`. It does not perform a production database migration and does not store lead PII. The article group contains 27 fields, including:

- hyper-niche household context: pet type, breed, hair length, shedding level, floor/carpet type, home size, children in home, problem type, product category;
- editorial relationships: parent hub, problem guide, product guide, comparison, tool, service, methodology;
- monetization controls: commercial intent, primary monetization type, affiliate CTA, service fallback, service type, CTA copy, cross-monetization reason;
- evidence controls: evidence status and last reviewed date.

## Review routes

- `/`
- `/services-insurance/`
- `/smart-tech/`
- `/cleaning-odor/`
- `/family-home/`
- `/pet-tech-selector/`
- `/mobile-pet-grooming/`
- `/pet-insurance-for-french-bulldogs/`
- `/pet-odor-cleaning/`

## Known limitations

- No external staging provider or public tunnel is included.
- Affiliate destinations remain placeholders; no merchant credentials are bundled.
- Lead forms are demo-only and intentionally do not persist, email, or route PII.
- ACF is installed by the Playground blueprint from WordPress.org; no custom plugin ZIP is required for this build.
- Real production SEO indexing, analytics credentials, consent logging, and provider routing require a reviewed hosting environment.
- The Windows Playground CLI snapshot command reached WordPress boot but could not release the SQLite `.htaccess` lock, so the package includes the validated blueprint and a rebuild report rather than claiming a generated snapshot.

## Credentials

No credentials are included. The package contains no sensitive demo credentials and no real user data.
