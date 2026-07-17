# Accessibility checklist

- [x] Semantic heading hierarchy and one H1 per representative route
- [x] Visible keyboard focus styles
- [x] Form labels and accessible error regions
- [x] Decorative icons hidden from assistive technology
- [x] Comparison tables use independent horizontal scroll regions
- [x] Mobile CTA targets are touch-sized
- [x] Footer contrast corrected for readable muted text
- [x] No page-wide horizontal overflow in local desktop/mobile QA

Responsive smoke test (local noindex runtime, representative insurance page):

| Viewport | H1 count | Unlabelled inputs | Body overflow |
|---|---:|---:|---|
| 375x812 | 1 | 0 | none |
| 768x900 | 1 | 0 | none |
| 1440x1000 | 1 | 0 | none |

Final production audit remains required after real content and hosting are added.
