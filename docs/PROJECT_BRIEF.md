# PetHomeScout Project Brief

## Purpose and market

PetHomeScout.com is a US-English, USD-focused platform for product research, comparisons, recommendation tools, and pet-service lead generation. Its positioning is: **Practical product research and service guides for cleaner, safer, pet-friendly homes.**

It is not a general pet blog, a WordPress site, or a multi-country property-search product.

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
- `/best-robot-vacuum-for-dog-hair-on-carpet/`
- `/roborock-vs-narwal-for-pet-hair/`
- `/how-to-remove-dog-urine-smell-from-carpet/`
- `/pet-insurance-for-french-bulldogs/`
- `/mobile-dog-grooming/`
- `/robot-vacuum-selector/`
- Trust and legal routes named in the supplied brief

## Technical direction

- WordPress custom theme under `wp-content/themes/pethomescout/`, using semantic PHP templates, CSS variables, and vanilla JavaScript.
- CPTs `pet_product` and `pet_lead` plus ACF metadata will provide the dynamic layer after the theme shell is reviewed.
- Content and commercial data must be structured and reusable. Keep products, merchants, offers, redirects, keywords, and lead providers separate from page content.
- Build only representative pages in the first release. Do not mass-publish articles, city pages, real affiliate links, or live lead integrations.

## UX and brand

Use a warm, clean, premium editorial household aesthetic: deep navy/charcoal, muted green or teal, warm amber/terracotta, and off-white surfaces. It should feel trustworthy and data-driven—not cartoonish, coupon-led, or like a low-quality affiliate blog.

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

1. Approve MVP scope, design direction, and first conversion paths.
2. Scaffold the Next.js foundation, design tokens, data types, SEO/indexing utilities, and core layout.
3. Build the homepage, core reusable components, and the robot-vacuum hub.
4. Build the three commercial/editorial page templates plus demo lead forms and redirects.
5. Build the selector tool, trust/legal pages, content data, docs, and quality checks.
6. Deploy a noindex Vercel preview for visual/SEO QA; production only after review.
