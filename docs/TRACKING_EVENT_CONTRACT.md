# PetHomeScout Tracking Event Contract

Status: MVP event contract. Do not add analytics credentials yet.

Canonical source: `docs/EXECUTIVE_KNOWLEDGE_BASE.md`.

## Purpose

PetHomeScout needs stable event names before GA4, GTM, Microsoft Clarity, affiliate reporting, or lead routing are connected.

The MVP only emits local JavaScript events into `window.dataLayer` and dispatches a `pethomescout:event` browser event. It must not load third-party analytics credentials until consent, staging, and production measurement rules are approved.

## Approved MVP events

| Event | Trigger | Required parameters |
|---|---|---|
| `affiliate_intent` | A user clicks an internal `/go/` commercial pathway. | `page_path`, `page_type`, `content_type`, `merchant_id`, `product_id`, `cta_position` |
| `buy_box_click` | A user interacts with a buy-box control or approved commercial CTA. | `page_path`, `page_type`, `content_type`, `merchant_id`, `product_id`, `cta_position`, `evidence_status` |
| `comparison_interaction` | A user filters, scrolls, or interacts with comparison/filter UI. | `page_path`, `page_type`, `content_type`, `interaction_type`, `filter` |
| `decision_tool_start` | A user opens or starts a decision tool flow. | `page_path`, `page_type`, `content_type` |
| `decision_tool_complete` | A user completes the local fixture selector. | `page_path`, `page_type`, `content_type`, `floor`, `hair`, `dock` |
| `lead_form_view` | A user views, focuses, or enters a lead-demo flow. | `page_path`, `page_type`, `content_type`, `service_type` |
| `lead_form_start` | A user advances beyond the first lead-demo step. | `page_path`, `page_type`, `content_type`, `service_type`, `step` |
| `lead_form_demo_submit` | A user completes the demo-only lead form. | `page_path`, `page_type`, `content_type`, `service_type` |
| `newsletter_demo_submit` | Reserved for a future demo newsletter interaction. | `page_path`, `page_type`, `content_type` |

## Non-goals for MVP

- No GA4 Measurement ID.
- No GTM container ID.
- No Microsoft Clarity ID.
- No server-side event forwarding.
- No affiliate-network postback.
- No lead buyer ping/post.
- No PII in event payloads.
- No email, phone, name, ZIP code, breed, or free-text form data in analytics events.

## Parameter rules

- `page_path`: current URL path only.
- `page_type`: home or first path segment.
- `content_type`: body `data-content-type` when available, otherwise `page_type`.
- `merchant_id`: merchant slug only, never a destination URL.
- `product_id`: product slug/id only, never a destination URL.
- `service_type`: internal service slug such as `insurance`, `mobile_grooming`, `pet_odor_cleaning`, or `sitting_walking`.
- `cta_position`: stable placement label such as `hero`, `comparison_table`, `buy_box`, or empty string.
- `evidence_status`: internal label such as `research_led`, `founder_tested`, or empty string.

## Acceptance criteria

- Code emits only approved MVP event names unless this document is updated first.
- Events do not contain PII.
- Demo lead form submit events do not imply a real quote request.
- Disabled merchant buttons may emit `buy_box_click` only as UI intent, not as an outbound affiliate click.
- `/go/` links emit `affiliate_intent` before routing, while the route itself remains noindex and placeholder-only until approved offers exist.
- JS syntax checks pass after any tracking edit.

