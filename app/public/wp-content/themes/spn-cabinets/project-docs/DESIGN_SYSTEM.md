# DESIGN_SYSTEM.md — SPN Cabinets

The single source of truth for design decisions. Every value here maps to a
**CSS custom property (design token)** defined in
`assets/css/src/01-settings/tokens.css` and compiled into `assets/css/main.css`.
Components consume tokens — **never hard-coded values**.

> **Brand palette finalised (Phase 5):** deep slate **`--color-primary: #2c3e50`**
> (+ `--color-heading`, `--color-secondary: #34495e`) and brushed gold
> **`--color-accent: #c8a24b`**. Text-on-primary is `#ffffff` (≈10.9:1),
> text-on-accent is `#1a1a1a` (≈7.3:1). Only the `--color-*` values changed —
> nothing else in the system moved. Neutrals/state stay as documented below.

> **Status:** the design system described here is **implemented** (v0.1). Files
> and build are documented in §0. UI components (Hero, forms markup, etc.) are
> built in the components phase; this file defines the visual foundation they
> inherit.

---

## 0. CSS architecture & build

The CSS is authored as **modular ITCSS partials** and compiled into a **single
render-blocking stylesheet** — modular for developers, one request for browsers.

### Source layout (`assets/css/src/`)

```
src/
├── 01-settings/tokens.css        # all design tokens (:root custom properties)
├── 02-generic/reset.css          # modern reset + global reduced-motion
├── 03-base/typography.css        # headings, prose, lists, links, tables, quotes
├── 03-base/elements.css          # focus, media, form baseline, WP alignments
├── 04-layout/layout.css          # container, section, stack, cluster, auto-grid
├── 05-components/buttons.css     # button system (variants/sizes/states)
├── 05-components/forms.css       # inputs, textarea, select, checkbox/radio, validation
├── 05-components/cards.css       # base card + service/gallery/blog/testimonial/cta
├── 06-utilities/accessibility.css# sr-only, skip link, focus helpers
├── 06-utilities/utilities.css    # spacing/flex/grid/text/visibility helpers
└── 07-animations/animations.css  # keyframes, micro-interactions, reveal, reduced-motion
```

### Build

- **`assets/css/main.css` is a GENERATED file — never edit it directly.**
  Edit the partials, then rebuild.
- Build tool: `tools/build-css.mjs` (zero-dependency Node, concatenates
  `src/**` in path order → `main.css`).
- Commands (`package.json`): `npm run build:css` (once) · `npm run watch:css`
  (rebuild on change).
- The compiled `main.css` is committed, so the theme works **without** running a
  build. `main.css` is the file enqueued (with `filemtime()` cache-busting).
- **Ordering:** the numeric folder prefixes guarantee the ITCSS cascade
  (settings → generic → base → layout → components → utilities → animations).
- **Editor styles:** `assets/css/editor.css` mirrors the key tokens/typography
  for the block editor (expanded during the components phase).

### Rules
- New token → add to `01-settings/tokens.css` **and** document it here.
- New component styles → new/existing partial in `05-components/`, BEM, tokens
  only. Then rebuild.
- Never add a second render-blocking stylesheet; keep the single-file output.

---

## 1. Design principles

- **Token-driven & consistent** — one scale for type, space, radius, shadow.
- **Mobile-first & fluid** — `clamp()`, `rem`, `min()/max()`; avoid fixed px.
- **Accessible by construction** — contrast, focus, target sizes, motion-safe.
- **Restrained & premium** — generous whitespace, clear hierarchy, calm motion.
- **Reusable** — styles attach to components (BEM), not to pages.

## 2. Colour (⛳ placeholders — do not finalise yet)

Token names are stable; **values are placeholders** to be replaced with the
brand palette. All text/background pairings must meet **WCAG AA (≥ 4.5:1)**.

| Token | Placeholder | Role |
|---|---|---|
| `--color-text` | `#1a1a1a` | Body text |
| `--color-text-muted` | `#555555` | Secondary text |
| `--color-background` | `#ffffff` | Page background |
| `--color-surface` | `#f5f5f5` | Cards / raised surfaces |
| `--color-primary` | ⛳ | Primary brand / CTAs |
| `--color-primary-contrast` | ⛳ | Text on primary |
| `--color-accent` | ⛳ | Highlights / secondary CTA |
| `--color-border` | `#e2e2e2` | Dividers / outlines |
| `--color-focus` | `#1a73e8` | Focus ring (must be highly visible) |

> When branding arrives: define a full palette (primary/accent + 50–900 shades,
> success/warning/error, and dark-on-light + light-on-dark pairs), verify
> contrast, then swap the placeholder values only. No component CSS should change.

## 3. Typography

- **Font stack (until brand fonts supplied):**
  `--font-body: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;`
  `--font-heading: var(--font-body);`
- Self-host brand fonts later (`woff2`, `font-display: swap`, preload critical).
- **Base:** `--font-size-base: 1rem` (16px), `--line-height-base: 1.6`,
  headings `--line-height-heading: 1.2`.

### Type scale (fluid, `clamp()`)

| Element | Token | Value |
|---|---|---|
| H1 | `--font-size-h1` | `clamp(2rem, 1.4rem + 3vw, 3.25rem)` |
| H2 | `--font-size-h2` | `clamp(1.6rem, 1.2rem + 2vw, 2.5rem)` |
| H3 | `--font-size-h3` | `clamp(1.3rem, 1.1rem + 1vw, 1.75rem)` |
| H4–H6 | (define as needed) | step down from H3 |
| Body | `--font-size-base` | `1rem` |
| Small / caption | `--font-size-sm` | `0.875rem` (add token) |

**Rules**
- One `<h1>` per page; never skip heading levels (order ≠ styling — restyle, don't
  mis-level).
- Measure (line length) ~**60–75ch** for body copy (`--container-narrow`).
- Use `text-wrap: balance` on headings, `pretty` on paragraphs (already in base).

## 4. Spacing scale (8px baseline, rem-based)

| Token | Value | Typical use |
|---|---|---|
| `--space-3xs` | `0.25rem` | Hairline gaps |
| `--space-2xs` | `0.5rem` | Icon/text gaps |
| `--space-xs` | `0.75rem` | Tight padding |
| `--space-sm` | `1rem` | Default gap |
| `--space-md` | `1.5rem` | Component padding / container gutter |
| `--space-lg` | `2rem` | Between components |
| `--space-xl` | `3rem` | Small section padding |
| `--space-2xl` | `4rem` | Section padding |
| `--space-3xl` | `6rem` | Large section padding (desktop) |

**Rule:** all margins/paddings/gaps use these tokens — no arbitrary values.

## 5. Border radius

| Token | Value | Use |
|---|---|---|
| `--radius-sm` | `4px` | Buttons, inputs, small chips |
| `--radius-md` | `8px` | Cards, media |
| `--radius-lg` | `16px` | Large panels / feature blocks |
| (full) | `9999px` | Pills / avatars (add `--radius-pill` if needed) |

## 6. Container widths

| Token | Value | Use |
|---|---|---|
| `--container-max` | `1200px` | Main content max width |
| `--container-narrow` | `768px` | Readable prose / forms |
| `--container-gutter` | `var(--space-md)` | Left/right page padding |

- `.container` centres content and applies gutters. Full-bleed sections use a
  full-width wrapper with an inner `.container`.

## 7. Grid & layout

- **CSS Grid** for two-dimensional layouts (galleries, card grids), **Flexbox**
  for one-dimensional (nav, button rows).
- Card grids: `repeat(auto-fill, minmax(min(100%, 280px), 1fr))` for fluid,
  responsive columns without media queries.
- Standard grid gap: `--space-md` (mobile) → `--space-lg` (desktop).
- Never rely on floats or a grid framework. No Bootstrap.

## 8. Breakpoints (mobile-first, `min-width`)

| Token / name | Value | Notes |
|---|---|---|
| `sm` | `480px` | Large phones |
| `md` | `768px` | Tablets / small laptops |
| `lg` | `1024px` | Laptops |
| `xl` | `1280px` | Desktops |
| `2xl` | `1440px` | Large desktops |

- Breakpoints are **content-driven** — add one only when the layout breaks, not
  by device. Base styles target mobile; enhance upward.

## 9. Buttons

Built from `template-parts/buttons/button.php` (args-driven). Variants/sizes map
to modifier classes; all consume tokens.

- **Variants:** `--primary` (solid brand), `--secondary` (alt/accent),
  `--ghost` (outline/text). More only if justified.
- **Sizes:** `--sm`, `--md` (default), `--lg`.
- **States:** default / `:hover` / `:focus-visible` (visible ring) / `:active` /
  `[disabled]` / `[aria-disabled]`. Never remove focus outlines.
- Min touch target **44×44px**; readable label; `<a>` when it navigates,
  `<button>` when it acts.
- Radius `--radius-sm`; transition `--transition-base`.

## 10. Cards

Built from `template-parts/cards/card.php`. Structure: `.card > .card__media`
(image, lazy) `+ .card__body` (`__title`, `__excerpt`, optional `__cta`).

- Surface `--color-surface`, radius `--radius-md`, optional `--shadow-sm`
  (→ `--shadow-md` on hover).
- Consistent internal padding (`--space-md`), equal-height in grids (flex column).
- Entire card optionally clickable, but keep an explicit, focusable link for a11y.

## 11. Forms

- Every field has a visible, associated `<label>`; placeholders are **not**
  labels.
- Inputs: full-width, radius `--radius-sm`, `--color-border`, clear
  `:focus-visible` ring, comfortable padding (`--space-xs`/`--space-sm`).
- **Errors:** text + `aria-describedby` + `aria-invalid`; never colour-only.
- Required fields marked in text (not just `*`). Adequate spacing between fields
  (`--space-md`).
- Buttons use the button component. Success/thank-you state is explicit.
- Full pattern in [COMPONENT_LIBRARY.md](COMPONENT_LIBRARY.md) (Quote Form).

## 12. Icons

- **Inline SVG** (or an SVG sprite) from `assets/icons/` — no icon-font, no
  external icon library CSS.
- Decorative icons: `aria-hidden="true"`. Meaningful icons: `role="img"` +
  `<title>`/accessible name.
- Size via `em`/tokens so icons scale with text; `currentColor` for theming.

## 13. Shadows (elevation)

| Token | Value | Use |
|---|---|---|
| `--shadow-sm` | `0 1px 2px rgba(0,0,0,.06)` | Subtle raise (cards) |
| `--shadow-md` | `0 4px 12px rgba(0,0,0,.1)` | Hover / overlays / sticky header |

- Keep elevation subtle and consistent; two levels are usually enough. Add
  `--shadow-lg` only for modals/menus if needed.

## 14. Transitions & motion

- **Standard transition:** `--transition-base: 200ms ease` for hover/focus.
- Animate **`transform`/`opacity`** only (GPU-friendly); avoid animating layout
  properties (width/height/top).
- Durations: micro-interactions 150–250ms; larger reveals ≤ 400ms.

## 15. Animation philosophy

- **Purposeful, subtle, fast.** Motion guides attention and confirms actions —
  it is never decorative filler.
- **Respect `prefers-reduced-motion`** (global handling already in `main.css`):
  reduce or remove non-essential motion.
- Prefer CSS transitions/animations; use JS (IntersectionObserver) only for
  scroll-triggered reveals, and keep them optional/enhancement-only.
- No autoplay carousels that move without user control; no parallax that harms
  performance or accessibility.

## 16. Component spacing

- **Vertical rhythm:** sections use `--space-2xl`/`--space-3xl` top+bottom
  padding (scale down on mobile). Content blocks within a section use
  `--space-lg`.
- Use a consistent **stack** pattern (owl selector or `gap`) so vertical spacing
  is systematic, not per-element guesswork.
- Container gutters via `--container-gutter`; never add ad-hoc side padding.

## 17. Design consistency rules

1. **Tokens only** — no magic numbers, no one-off hex/px in component CSS.
2. **BEM naming**, flat specificity, no IDs for styling, no `!important`
   (except documented a11y utilities).
3. **One way to do a thing** — reuse the button/card/form patterns; don't fork.
4. **Accessible states are mandatory** — focus, hover, error, disabled.
5. **Mobile-first**; every component verified from 320px → 1440px+.
6. Any new token or scale value is **added here first**, then to `main.css`.
7. When branding lands: change **only** the placeholder colour tokens — nothing
   else in the system should need to move.

## 18. Additional token scales (implemented)

Beyond colour/type/space/radius/shadow above, the system defines:

### Font weights
`--font-weight-light: 300` · `-regular: 400` · `-medium: 500` · `-semibold: 600`
· `-bold: 700`. Body = regular; headings = bold; UI labels = semibold.

### Motion — durations & easings
- Durations: `--duration-fast: 120ms` · `--duration-base: 200ms` ·
  `--duration-slow: 350ms`.
- Easings: `--ease-standard` (default) · `--ease-in` · `--ease-out` ·
  `--ease-in-out`.
- Composites: `--transition-base`, `--transition-colors`,
  `--transition-transform` (use these in components).

### Focus state tokens
`--focus-ring-width: 3px` · `--focus-ring-offset: 2px` ·
`--focus-ring-color: var(--color-focus)` · `--focus-ring` (shorthand). Applied
globally via `:focus-visible`; form controls use a border + `box-shadow` ring.

### Z-index scale (named layers — never use arbitrary values)
`--z-below: -1` · `--z-base: 0` · `--z-raised: 10` · `--z-dropdown: 1000` ·
`--z-sticky: 1020` · `--z-header: 1030` · `--z-overlay: 1040` ·
`--z-modal: 1050` · `--z-popover: 1060` · `--z-toast: 1070` · `--z-max`.

### Opacity scale
`--opacity-0/25/50/75/100`, plus `--opacity-disabled: 0.55` and
`--opacity-muted: 0.7`.

### Section spacing (fluid)
`--section-space-y` (default band), `--section-space-y-sm`,
`--section-space-y-lg` — consumed by `.section` layout classes.

### Breakpoints (reference tokens)
`--breakpoint-sm/md/lg/xl/2xl` exist for JS to read. **Media queries must use
the literal px values** (custom properties can't be used in `@media`).

## 19. Layout, utility & animation classes (implemented)

These ship in the design system so components/pages inherit them.

- **Layout:** `.container` (+ `--narrow`/`--wide`/`--fluid`), `.section`
  (+ `--sm`/`--lg`/`--surface`), `.stack`, `.cluster`, `.auto-grid`
  (set `--grid-min`), `.center`.
- **Utilities:** token-based spacing (`.mt-*`, `.mb-*`, `.p-*`), flex
  (`.flex`, `.items-*`, `.justify-*`, `.gap-*`), grid (`.grid`, `.grid-2/3/4`,
  responsive `.grid-md-*`/`.grid-lg-*`), text (`.text-*`, `.font-*`, `.truncate`,
  `.line-clamp`), visibility (`.hidden`, `.hidden-mobile`, `.hidden-desktop`),
  and surface helpers.
- **Accessibility:** `.screen-reader-text` / `.visually-hidden`, `.skip-link`
  (visible on focus), `.focus-ring`, `.tap-target`.
- **Animation:** `.hover-lift`, `.hover-nudge`, `.img-zoom`, `.transition-*`,
  reveal-on-scroll via `[data-animate]` + `.is-visible` (JS-driven,
  enhancement-only), and named `.animate-*` one-shots. All respect
  `prefers-reduced-motion`.

## 20. Animation guidelines

- **Purposeful, subtle, fast** — motion confirms actions and guides attention;
  never decorative filler. Micro-interactions 120–200ms; reveals ≤ 350ms.
- **Animate `transform`/`opacity` only** (GPU-friendly); never animate layout
  properties (width/height/top/left).
- **Hover:** buttons shift background + tiny `translateY` on active; cards lift
  (`--shadow-lg` + `translateY(-4px)`) and gently zoom their image
  (`scale(1.05)`); links use colour + underline thickness or a small nudge.
- **Navigation:** submenu carets rotate; mobile menu transitions opacity/
  transform. Managed by `navigation.js` state classes.
- **Reveal on scroll:** opt-in via `[data-animate]`; content is fully visible
  without JS and for reduced-motion users (enhancement-only).
- **Reduced motion:** honoured globally (reset) and reinforced in the animation
  layer — reveals resolve to their final state, hovers stop transforming.
- **No** autoplay carousels without controls, no performance-harming parallax.
