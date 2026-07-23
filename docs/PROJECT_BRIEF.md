# PetHomeScout Project Brief

## Purpose and market

PetHomeScout.com is a US-English, USD-focused platform for product research, comparisons, recommendation tools, and pet-service lead generation. Its positioning is: **Practical product research and service guides for cleaner, safer, pet-friendly homes.**

It is not a general pet blog, a multi-country property-search product, or a coupon-style affiliate site. It is implemented as a custom WordPress theme.

## Source-of-truth map

- `docs/EXECUTIVE_KNOWLEDGE_BASE.md` is the canonical business, customer, revenue, UI, and SEO direction.
- `docs/PROJECT_BRIEF.md` summarizes the current MVP implementation direction.
- `docs/DATA_MODEL_AND_GO_SYSTEM_PLAN.md` defines the implemented backend-only CPT/ACF foundation and approval-gated live `/go/` architecture.
- `docs/TRACKING_EVENT_CONTRACT.md` defines stable MVP event names and analytics non-goals.
- `docs/FOUNDER_TEST_RUBRIC.md` defines the evidence threshold for any founder-tested claim.
- `docs/LAUNCH_READINESS_CHECKLIST.md` defines local, staging, and production launch gates.

## Initial product pillars

- Robot vacuums for pet hair
- Cleaning and pet odor
- Smart pet home
- Dog safety technology
- Pet insurance
- Pet services
- Decision tools

## Initial representative routes

- `/`
- `/robot-vacuums-for-pet-hair/`
- `/best-robot-vacuum-for-dog-hair/`
- `/mobile-pet-grooming/`
- `/pet-insurance/`
- `/pet-odor-carpet-cleaning/`
- `/pet-sitting/`
- `/pet-tech-selector/`
- Trust and legal routes named in the supplied brief

## Technical direction

- WordPress custom theme under `wp-content/themes/pethomescout/`, using semantic PHP templates, CSS variables, and vanilla JavaScript.
- Product, merchant, offer, evidence, and service metadata may provide the dynamic layer after the theme shell is reviewed. Do not create a `pet_lead` storage layer until compliant consent logging, buyer routing, and provider contracts are approved.
- Content and commercial data must be structured and reusable. Keep products, merchants, offers, redirects, keywords, and lead providers separate from page content.
- Build only representative pages in the first release. Do not mass-publish articles, city pages, real affiliate links, or live lead integrations.

## UX and brand

Use a warm, clean, premium editorial household aesthetic: deep navy for authority, cobalt blue for action, warm golden orange/terracotta for household warmth, amber for disclosures, and pale blue-gray/off-white surfaces. Reserve green for isolated success states. It should feel trustworthy and data-driven—not cartoonish, coupon-led, or like a low-quality affiliate blog.

The homepage should lead with buying guides and service discovery. Build accessible, mobile-first components for navigation, content cards, product/comparison displays, disclosures, lead-form demos, FAQs, trust content, and the selector tool.

## SEO, trust, and compliance

- US English only; US measurements, ZIP/city/state fields, and USD.
- Root-domain URLs only: no country selector, `/us/`, hreflang, or multi-country structure.
- Use metadata, canonical URLs, OG/Twitter cards, sitemap, robots, internal links, and only schema that is supported by visible page content.
- Do not claim physical testing, invent ratings or reviews, make medical/coverage guarantees, or use real-looking placeholder authors.
- Affiliate CTAs must disclose commercial relationships. Future outbound links use a replaceable `/go/{merchant}/{product}/` layer with sponsored/nofollow attributes.
- Lead forms are frontend demos only: validate accessibly, show a safe success state, and do not store or send PII until a compliant backend is approved.
- Preview and development deployments must be `noindex, nofollow`; production indexing requires review.

## Proposed delivery sequence

1. Establish the custom WordPress theme, design tokens, templates, backend-first product metadata, and core layout. Live offer routing and lead integrations remain separately approved steps.
2. Build the Services & Insurance hub and demo conversion flows without storing personal data.
3. Build the Smart Tech comparison/selector proof path and internal `/go/` placeholder architecture.
4. Add methodology, founder-test rubric, legal/trust pages, event hooks, and quality checks.
5. Review locally in WordPress Playground, then select a password-protected US-hosted WordPress staging environment with noindex enabled.
