# PetHomeScout Staging Handoff

Status: ready for a password-protected US-hosted WordPress staging environment.

This handoff does not authorize deployment, indexing, live affiliate redirects, lead routing, or analytics credentials.

## Required environment

- US-hosted WordPress staging.
- PHP version compatible with the selected WordPress release.
- HTTPS enabled.
- Password protection enabled before sharing the URL.
- WordPress Settings → Permalinks: **Post name** (`/%postname%/`).
- WordPress Settings → Reading: discourage search engines (`blog_public=0`).
- One SEO plugin only: Rank Math or Yoast.
- Official Advanced Custom Fields plugin activated and JSON groups synced.

## Theme and content setup

1. Install `wp-content/themes/pethomescout/` and activate the theme.
2. Sync the nine ACF JSON groups under `acf-json/`.
3. Assign the primary and footer menus.
4. Create the approved hub Pages and representative Posts.
5. Verify ACF relationships for `featured_guides`, `home_featured_guide`, evidence, services, merchants, and offers.
6. Keep all Merchant and Offer records pending until partner approval.

## Required safety checks

- Preview/staging responses include `noindex,nofollow` and `X-Robots-Tag: noindex, nofollow`.
- `/go/{merchant}/{product}/` never redirects externally while live offers are disabled.
- Demo forms show the approved consent language but do not write, email, route, or persist PII.
- No GA4, GTM, Clarity, CRM, email, lead buyer, or affiliate credentials are present.
- No fake prices, ratings, testing claims, providers, or quote estimates are visible.

## QA routes

```text
/
/services-insurance/
/smart-tech/
/cleaning-odor/
/family-home/
/pet-insurance/
/mobile-pet-grooming/
/pet-tech-selector/
/go/roborock/qrevo/
/sitemap.xml
/robots.txt
```

## Acceptance checks

- Desktop: 1440px and 1280px.
- Mobile: 375px and 390px.
- One H1 per page.
- No page-wide horizontal overflow.
- Keyboard focus and form labels are visible.
- No console errors or failed asset requests.
- Lighthouse performance/accessibility/best-practices review completed.
- Internal links return successful responses.
- Rank Math/Yoast title, description, canonical, robots, social metadata, and schema are verified on real Posts/Pages.

## Production cutover

Only after owner approval:

1. Remove staging password protection.
2. Set `blog_public=1` on the production site.
3. Verify production host returns `index,follow`.
4. Submit the sitemap in Google Search Console.
5. Enable approved affiliate destinations and compliant lead routing separately.
6. Connect analytics only after consent and privacy review.
