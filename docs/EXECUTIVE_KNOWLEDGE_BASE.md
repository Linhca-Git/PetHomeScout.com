# PetHomeScout.com Executive Knowledge Base

Version: 2026.2

## Positioning

PetHomeScout is an independent pet-technology and pet-friendly-home decision engine for US households. It is not a generic pet blog, a coupon site, or a high-volume AI content farm. Its job is to reduce buyer anxiety and help people make a confident next decision.

Market: United States only · US English · USD · sq ft, inches, lbs · ZIP codes.

Supporting implementation contracts:

- `docs/PROJECT_BRIEF.md` — current MVP implementation direction.
- `docs/DATA_MODEL_AND_GO_SYSTEM_PLAN.md` — approval-required backend data and `/go/` system plan.
- `docs/TRACKING_EVENT_CONTRACT.md` — MVP analytics event contract and no-credential rule.
- `docs/FOUNDER_TEST_RUBRIC.md` — evidence rules for founder-tested claims.
- `docs/LAUNCH_READINESS_CHECKLIST.md` — local, staging, and production launch gates.

## Customer portrait

The primary decision-maker is a US woman aged roughly 35–65. She treats pets as family, spends carefully on higher-ticket home and pet technology, and searches for evidence before purchasing. Her trust signals are clarity, emotional warmth, transparent commercial relationships, practical tradeoffs, and a feeling that the recommendation understands her home.

Design implication: pair editorial warmth with fast data scanning. Every commercial page should answer “Is this right for my household?” before asking for a click.

## Four experience hubs

1. `/family-home/` — pet-safe interiors, scratch-resistant furniture, waterproof floors, gates, pet doors, and yard solutions.
2. `/smart-tech/` — robot vacuums, self-cleaning litter boxes, GPS collars, feeders, fountains, and home automation.
3. `/cleaning-odor/` — fur, stains, enzyme cleaning, carpet care, air quality, and local odor-cleaning services.
4. `/services-insurance/` — pet insurance, mobile grooming, sitting, walking, boarding, and local quote flows.

## Hybrid revenue model

### Affiliate revenue

- Use comparison, roundup, and decision-tool pages across the first three hubs.
- Never expose direct merchant URLs in article content. Route every commercial action through an internal `/go/{merchant}/` or `/go/{product}/` layer so tracking can be changed once in admin.
- Use multi-merchant buy boxes where helpful: “Check price on Chewy”, “Check price on Wayfair”, or a brand offer. Always disclose the relationship near the first commercial action.

### Lead-generation revenue

- Use service and insurance pages in the fourth hub.
- Use a low-friction three-step form: pet type → ZIP/breed → name, phone, email.
- The final action must show the TCPA consent language beside the submit control. Demo forms must not store or send personal data until a compliant backend and provider contract exist.
- Lead UX should promise a clear next step, not a guaranteed price, coverage, or provider quality.

## Frontend design system

- Display: `Fraunces` for warm editorial headings and memorable section titles.
- UI/data: `Nunito Sans` for rounded, accessible, friendly body copy, buttons, labels, specs, and navigation.
- Palette: deep navy for authority, cobalt blue for actions and tools, warm golden orange for household warmth and brand accents, amber for disclosures, and pale blue-gray surfaces. Reserve green for isolated success states only; it is not part of the primary brand lockup.
- Use recognizable line or duotone icons for pets, home, cleaning, safety, insurance, and tools. Avoid childish decoration and abstract icon glyphs.
- Desktop composition: utility bar → clean navigation → two-column hero → category rail → four-card picks → three editorial lists → trust section → newsletter CTA → legal footer.
- Keep CTAs visible, card density moderate, and long content easy to scan on mobile. Tables should scroll inside their own container instead of causing page-wide overflow.

## Copy system

Preferred hero direction: “Make smarter choices. Build a better pet home.”

SEO homepage introduction: “Practical product research, comparison tools, and service guides for U.S. households with dogs and cats—covering cleaning, smart pet tech, home safety, and pet insurance.”

Preferred service CTA: “Need local help? Preview the service checklist.”

Use language such as “best suited for”, “based on published specifications”, and “compare these factors”. Avoid fake testing, guaranteed outcomes, fake ratings, or claims that one product is best for everyone.

## SEO and trust strategy

- Build deep topic clusters around household problems and breed-specific purchase anxiety.
- Keep flat root-level URLs. Do not create country folders or mass city pages at launch.
- Do not copy Amazon/Chewy descriptions. Publish original decision frameworks, comparisons, FAQs, and ownership considerations.
- Maintain visible affiliate disclosures, editorial policy, methodology, privacy, CCPA/Do Not Sell or Share, and contact information.
- Operate transparently as a global digital business. Never invent US offices, addresses, testing locations, or legal entities.

## Five-year operating principle

The asset grows through trust and topical authority, not ad density. Each new page must strengthen a hub, answer a real US search intent, or improve a measured conversion path.

## Hyper-niche article and cross-monetization rules

Articles may be classified by primary hub, user intent, pet type, breed, hair length, shedding level, floor/carpet type, home size, children in the home, problem type, product category, evidence status, and last-reviewed date. These fields support narrow decisions such as a robot vacuum for a heavy-shedding breed on thick carpet or insurance factors for a breed/state context.

Cross-monetization is opt-in. A service fallback requires a selected related service page, a problem type, a written relevance reason, and an explicit enable flag. It renders after the article's primary content and affiliate action, never above a quick verdict or as an unrelated form. Automatic keyword linking and mass-generated breed/city pages are prohibited.
