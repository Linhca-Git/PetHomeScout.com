# PetHomeScout.com Project Rules

## Product Direction

- Build PetHomeScout.com as a US-focused WordPress custom theme and product-research, affiliate, and lead-generation platform for cleaner, safer pet-friendly homes.
- Core pillars: robot vacuums, pet cleaning and odor, smart pet home, dog safety technology, pet insurance, pet services, and decision tools.
- Treat SEO as a product capability: original, decision-useful hubs, buying guides, comparisons, problem pages, and later location pages backed by authorized data.
- Start with a small, testable MVP. Confirm monetization partners, service-provider/data permissions, legal wording, and analytics before broad implementation.

## Working Workflow

- Antigravity: main IDE for manual navigation and editing.
- Codex: inspect the local project, make focused theme patches, and run relevant checks.
- GitHub CLI: repository, branch, commit, push/pull, and pull-request work.
- Vercel: preview/staging deployments only; do not deploy production without approval.
- ChatGPT: product, code, UX, and US SEO review.

## Delivery Rules

- Keep changes small and scoped; ask before a change spanning more than three files, 150 lines, dependencies, or a major rebuild.
- Before implementation, identify the current milestone and acceptance criteria.
- For SEO work, preserve canonical URLs, use accurate US-facing language, and avoid unverified market claims or scraped listing data without clear authorization.
- Do not present placeholder products, ratings, authors, tests, reviews, affiliate offers, or lead providers as real.
- Keep preview/development deployments noindex, nofollow; production indexing requires an explicit review.
- WordPress theme work lives under `wp-content/themes/pethomescout/`; do not introduce a page builder.
- Treat the supplied WordPress handover plan as the implementation source of truth. The earlier Next.js brief is superseded for this project.
- Treat `docs/EXECUTIVE_KNOWLEDGE_BASE.md` as the canonical source for customer strategy, revenue flows, UI direction, copy tone, and SEO guardrails.
- Verify relevant behavior locally before handoff. Record remaining assumptions or blockers plainly.
