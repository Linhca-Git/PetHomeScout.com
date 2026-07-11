# PetHomeScout.com Workflow

1. Define the current MVP slice, audience, conversion goal, and acceptance criteria.
2. Inspect the smallest relevant project area and existing worktree state.
3. For the current WordPress handover, design the responsive UI before wiring ACF/CPT data.
4. Make the smallest implementation patch inside `wp-content/themes/pethomescout/` using semantic PHP templates, CSS variables, and vanilla JS.
5. Run targeted checks: build, type check, lint, keyboard/mobile/SEO review where relevant.
6. Use GitHub CLI only for intentional Git/PR actions.
7. Use Vercel only for requested preview/staging; confirm preview is noindex before sharing.

## Product Guardrails

- Market: United States.
- Core value: practical product research, comparison tools, and service resources for US households with dogs and cats.
- SEO: prioritize original, decision-useful content; no thin programmatic pages, fake review schema, or broad city-page generation.
- Monetization: use placeholder data and redirect architecture only until real affiliate/service partnerships are approved.
- Privacy: frontend demo lead forms must not store or submit personal data until a compliant backend and consent flow are approved.
- Do not use the prior WordPress/Linhca publishing automations for this project.
- Do not add real affiliate destinations, lead storage, or personal-data processing until the corresponding security and consent review is complete.
