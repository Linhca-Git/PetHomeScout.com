# PetHomeScout ACF Schema

## Article controls

The Article group supports hub, intent, household/breed context, evidence, review date, related guides/tools/services, monetization type, affiliate enablement, service fallback enablement, CTA copy, and cross-monetization rationale.

## Rendering rule

`service_fallback_enabled` is false by default. The service fallback renders only when all of these exist:

```text
service_fallback_enabled = true
related_service_page
related_service_type
problem_type
cross_monetization_reason
```

## Backend entities

`pet_product`, `product_test`, `merchant`, `offer`, `service`, and `insurance_provider` remain backend-first CPTs. ACF JSON is the portable source of field definitions; live offer/provider data remains approval-gated.

## Editor-first hub curation

The Homepage and Hub groups expose relationship fields for `home_featured_products` and `featured_products`. Editors can select backend `pet_product` records for the Research Fixtures and hub grids without editing PHP. Each product record may point to a `primary_guide`; evidence status, review date, limitations, and merchant approval are read from the shared product/evidence and offer helpers.

If no product records are selected, the approved research-fixture fallback remains visible and is explicitly labelled as a fixture.
