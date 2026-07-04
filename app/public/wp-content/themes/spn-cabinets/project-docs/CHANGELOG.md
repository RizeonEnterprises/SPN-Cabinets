# Changelog — SPN Cabinets

All notable changes to the SPN Cabinets theme are documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

> **Versioning policy**
> - **MAJOR** — breaking changes to templates, component contracts or data model.
> - **MINOR** — new features/components/pages, backward-compatible.
> - **PATCH** — fixes, tweaks, docs, non-breaking refinements.
>
> Keep the theme `Version:` header in `style.css` (and `SPN_CABINETS_VERSION` in
> `functions.php`) in sync with the latest released version below. Move items
> from **[Unreleased]** into a dated version block on each release.

---

## [Unreleased]

### Added
- **Portfolio backend (Phase 2)** — `inc/post-types.php` (registered in
  functions.php). Registers the **`spn_project`** CPT (`public`, `show_in_rest`,
  `has_archive: 'portfolio'`, `rewrite slug 'project'`; supports title/editor/
  thumbnail/excerpt/revisions; `dashicons-portfolio`) and the hierarchical
  **`spn_project_category`** taxonomy (`rewrite slug 'project-category'`,
  `show_in_rest`, admin column). URLs: archive `/portfolio/`, singles
  `/project/{slug}/`, terms `/project-category/{term}/`. Rewrite rules flush on
  `after_switch_theme`; flushed now via WP-CLI.
- **Free Quote form (native, no plugin)** — conversion-critical.
  `template-parts/forms/quote-form.php` + secure handler `inc/form-handlers.php`
  (registered in `functions.php`) + shared `spn_cabinets_quote_services()` in
  site-options. Fields: Full Name, Email, Phone, Postcode (required), Service
  (whitelisted `<select>`), Project Details (optional). Posts to `admin-post.php`;
  nonce + honeypot + aggressive sanitisation + server-side validation; on error
  redirects `?status=error` (one-time transient repopulates values + per-field
  messages), on success `wp_mail()`s the lead (Reply-To enquirer) and redirects
  `?status=success`. Submit reuses the button primitive; uses existing forms.css
  hooks (+ 3 small `.quote-form*` spacing rules); no inline styles.
- **Testimonial Card component** (`template-parts/cards/testimonial-card.php`;
  styles via the `.card--testimonial` modifier in `cards.css` — no new CSS file).
  Customer review card: `quote` (required), `author_name` (required),
  `service_name` (optional), `rating` (1–5, default 5), `avatar_url` (optional,
  gracefully omitted). Gold SVG star rating, italic `<blockquote>` over a faint
  decorative `::before` quotation mark, and a `<cite>` author row with optional
  rounded avatar. Added a reusable `star` icon to `spn_cabinets_icon()`.
- **Gallery Grid component** (`template-parts/components/gallery-grid.php` +
  `assets/css/src/05-components/gallery-grid.css`). Pure-CSS-grid "masonry-lite"
  layout for project cards: `projects` (required — array of project-card arg
  arrays), `columns` (1–4, default 3). Single column on mobile; on desktop the
  requested columns with the offset column nudged down by `--gallery-stagger`
  (3rem). No JavaScript. Invalid project entries are skipped.
- **Project Card component** (`template-parts/cards/project-card.php`; styles via
  the `.card--project` modifier in `assets/css/src/05-components/cards.css` — no
  new CSS file). Luxury full-bleed gallery tile: `title` (required), `image_url`
  (required), `category` (optional), `url` (optional — clickable-block when set,
  else a static gallery image), `image_alt` (optional). 4:5 image with
  `object-fit: cover`, a token-derived gradient scrim, an overlaid bottom
  caption, and the base card's contained zoom-on-hover.
- **Service Card component** (`template-parts/cards/service-card.php`; styles via
  the `.card--service` modifier in `assets/css/src/05-components/cards.css` — no
  new CSS file). Whole-card-clickable service tile for grids: `title` (required),
  `description`, `image_url` (optional, uniform 4:3 `object-fit: cover`), `icon`
  (optional `spn_cabinets_icon()` slug), `url` (required). Reuses the base card's
  clickable-block (`.card__link::after`) + hover-lift; adds accent icon and a
  hover-nudged arrow affordance.

- **CTA Band component** (`template-parts/components/cta.php` +
  `assets/css/src/05-components/cta.css`). Full-width conversion band: `title`
  (required), `description`, `button_text`+`button_url` (required), `theme`
  (primary|secondary|dark — sets the background + contrast text), `alignment`
  (center|left — left is a content|button row on desktop). **Reuses the button
  primitive** (accent variant via a theme→variant map); `--section-space-y`
  padding; token-only.

- **Section Heading component** (`template-parts/components/section-heading.php`
  + `assets/css/src/05-components/section-heading.css`). Args-driven kicker +
  title + description block for use above grids/galleries/testimonials/sections:
  `kicker` (uppercase accent eyebrow), `title` (required), `title_tag` (h1–h6,
  default h2), `description` (muted, constrained to 60ch), `alignment`
  (left|center, default center). Token-only styling; new `template-parts/components/`
  directory.

- **Hero component** (`template-parts/hero/hero.php` + `assets/css/src/05-components/hero.css`).
  Args-driven, reusable across homepage/service pages: `title` (+`title_tag`),
  `subtitle`, `alignment` (left|center), `background_type` (image|solid),
  `background_image_url`(+alt), and primary/secondary CTA text+URL. Dark surface
  with responsive `min-height` (60vh mobile / 70vh desktop), a token-derived
  `color-mix` overlay for image backgrounds, flex-centred content, and CTAs
  reusing the button primitive (accent + light outline on the dark surface).
  Background renders as a real `<img>` (LCP-friendly: fetchpriority/eager/async).

- Documentation suite in `project-docs/`: `CLAUDE.md`, `PROJECT_GUIDE.md`,
  `CLIENT_REQUIREMENTS.md`, `SITE_ARCHITECTURE.md`, `DESIGN_SYSTEM.md`,
  `COMPONENT_LIBRARY.md`, `SEO_STRATEGY.md`, `DEVELOPMENT_WORKFLOW.md`,
  `TODO.md`, `CHANGELOG.md`.
- **Global design system (visual foundation).** Modular ITCSS CSS partials under
  `assets/css/src/` compiled to the single enqueued `assets/css/main.css`:
  - `01-settings/tokens.css` — full design-token set: colour (⛳ placeholder
    brand + neutrals + state), typography (families/weights/sizes/fluid heading
    scale/line-heights/letter-spacing), spacing, section spacing, containers,
    radius, borders, shadow/elevation, motion (durations + easings + composite
    transitions), z-index scale, opacity scale, focus tokens, breakpoint refs.
  - `02-generic/reset.css` — modern reset + global reduced-motion.
  - `03-base/typography.css` + `elements.css` — headings, prose rhythm, lists,
    links, captions/small text, blockquotes, tables, focus, media, WP alignments.
  - `04-layout/layout.css` — `.container`, `.section`, `.stack`, `.cluster`,
    `.auto-grid`, `.center`.
  - `05-components/buttons.css` — button system (primary/secondary/outline/ghost/
    text, sizes sm/md/lg, disabled + loading states).
  - `05-components/forms.css` — inputs/textarea/select/checkbox/radio, focus and
    validation (success/error) states, form messages, honeypot helper.
  - `05-components/cards.css` — base card + service/gallery/blog/testimonial/cta
    variants.
  - `06-utilities/accessibility.css` — sr-only, skip link, focus/tap helpers.
  - `06-utilities/utilities.css` — spacing/flex/grid/text/visibility helpers.
  - `07-animations/animations.css` — keyframes, micro-interactions, reveal-on-
    scroll utilities, navigation hooks, reduced-motion reinforcement.
- **CSS build tooling:** `tools/build-css.mjs` (zero-dependency Node) + npm
  scripts (`build:css`, `watch:css`) in a new `package.json`.
- **Global website shell.** The full layout every page inherits:
  - Site wrapper (`#page`), main content wrapper, and a breadcrumb slot.
  - Premium **sticky header** (`template-parts/header/site-header.php`) with
    branding, desktop primary navigation (hover + focus + toggle dropdowns),
    header actions (phone / WhatsApp / CTA) and an accessible mobile toggle.
  - **Off-canvas mobile navigation** (`template-parts/header/mobile-nav.php`):
    slide-in panel with focus trap, Escape/outside-click close, body scroll-lock
    and background `inert`. No-JS fallback keeps the inline nav usable.
  - **4-column footer + bottom bar** (`template-parts/footer/site-footer.php`):
    Brand/description, Quick Links, Services, Contact, plus copyright + legal.
  - **Announcement bar** (`template-parts/header/announcement-bar.php`) — support
    only, disabled by default.
  - **Breadcrumbs** baseline (`template-parts/global/breadcrumbs.php`) on inner
    pages, filter-overridable for an SEO plugin.
  - Reusable **WhatsApp button** (`template-parts/buttons/whatsapp.php`),
    placeholder-aware.
  - **Inline SVG icon system** (`inc/helpers/icons.php`) and a central,
    filterable **site-options/contact config** (`inc/helpers/site-options.php`)
    so contact details / CTA / announcement are defined once and reused.
  - New footer menu locations: `footer_services`, `footer_legal`.
  - New CSS component partials: `announcement`, `breadcrumbs`, `contact`,
    `footer`, `header`, `mobile-nav`, `navigation`.
  - Reworked `assets/js/navigation.js` for the off-canvas menu, sticky header
    and submenu toggles.

### Changed
- Registered `inc/form-handlers.php` in the functions.php module loader; added
  `spn_cabinets_quote_services()` to site-options and small `.quote-form*`
  spacing rules to `forms.css`.
- Reworked the `.card--testimonial` variant in `cards.css` (decorative `::before`
  quote mark, SVG star rating, italic quote, avatar/author row) and added a
  `star` icon to the icon set.
- Added the `.card--project` variant to `cards.css` (full-bleed 4:5 image tile
  with gradient scrim + overlaid caption; reuses the base card zoom/clickable).
- `.card--service` in `cards.css` reworked from icon-only/centred to support an
  optional top image (4:3) and/or accent icon, left-aligned, with an arrow.
- `assets/css/main.css` is now a **generated** file (compiled from
  `assets/css/src/**`); replaced the initial hand-written base stylesheet.
- Moved the authoritative `CLAUDE.md` to the **theme root** so Claude Code
  auto-loads it; `project-docs/CLAUDE.md` is now a pointer stub.
- Expanded `DESIGN_SYSTEM.md` with the CSS architecture/build (§0) and the
  implemented token scales, utilities and animation guidelines (§18–20).
- Reworked `header.php`/`footer.php` to render the global shell (site wrapper,
  announcement bar, off-canvas nav, breadcrumb slot).
- Rebuilt `template-parts/header/site-header.php` and
  `template-parts/footer/site-footer.php` (4-column) for the shell.
- Nav walker now emits a chevron icon for submenu toggles (cleaner rotation).

### Deprecated
- _n/a_

### Removed
- _n/a_

### Fixed
- QA pass (theme activated + browser-tested in Local): the mobile `.menu-toggle`
  no longer renders when no primary menu is assigned (it previously pointed at a
  non-existent `#mobile-nav`). Now guarded like the nav parts.

### Security
- _n/a_

### QA notes (2026-07-04)
- Activated the theme in Local and reviewed the shell in a real browser.
  Verified: sticky header, desktop dropdowns (hover/focus/toggle), off-canvas
  focus trap (Tab/Shift+Tab wrap, Escape + backdrop close, focus restore,
  background `inert`, body scroll-lock), breadcrumbs on inner pages, one `<h1>`
  per view, no horizontal scroll, assets 200 + deferred + `filemtime` versions,
  and localize object present.
- Zero PHP notices/warnings (WP_DEBUG log empty), zero console errors from the
  theme, no jQuery/emoji/generator, a single external stylesheet (`main.css`).
- No duplicate element IDs (WordPress de-duplicates `menu-item-*` across the
  desktop + off-canvas renders of the same menu).

---

## [0.1.0] — 2026-07-03

Initial theme foundation (architecture phase). Not a public release.

### Added
- Custom theme scaffold `spn-cabinets` with scalable folder architecture
  (`assets/`, `inc/`, `template-parts/`, `languages/`).
- `functions.php` bootstrap: theme constants + guarded `/inc` module loader
  (`spn_cabinets_require()`); no business logic in `functions.php`.
- Feature modules in `/inc`:
  - `theme-support.php` — title-tag, post-thumbnails, custom-logo, html5,
    align-wide, responsive-embeds, editor-styles (+ `editor.css`),
    wp-block-styles, automatic-feed-links, selective-refresh, i18n, content width.
  - `menus.php` — Primary + Footer nav locations.
  - `enqueue-assets.php` — token-based enqueue with `filemtime()` cache-busting,
    deferred footer scripts (via `script_loader_tag`), `wp_localize_script`
    (`spnCabinets`).
  - `cleanup.php` — `<head>` tidy (RSD/WLW/shortlink/oEmbed), emoji removal,
    resource-hint cleanup.
  - `security.php` — hide WP version, disable XML-RPC, block anonymous REST user
    enumeration, security headers (X-Content-Type-Options, X-Frame-Options,
    Referrer-Policy).
  - `helpers/template-helpers.php` — `spn_cabinets_component()`,
    `spn_cabinets_has_menu()`, `spn_cabinets_site_branding()`,
    `spn_cabinets_get_excerpt()`, `spn_cabinets_copyright_year()`.
  - `classes/class-spn-cabinets-walker-nav-menu.php` — accessible nav walker
    (`aria-current`, real `<button>` submenu toggles).
- Base templates: `index`, `front-page` (empty shell — no placeholder sections),
  `page`, `single`, `archive`, `404`, `header`, `footer`.
- Structural template parts: `header/site-header.php`, `footer/site-footer.php`.
- Reusable primitives: `buttons/button.php`, `cards/card.php` (args-driven).
- CSS: `assets/css/main.css` (ITCSS layers + design tokens; brand colours are
  placeholders) and `assets/css/editor.css`.
- JS: `assets/js/navigation.js` (accessible menu), `assets/js/main.js` (entry).
- `README.md` (theme) and `style.css` theme header.

### Security
- Baseline theme hardening (see `inc/security.php`).

### Notes
- No design, page sections or client content produced in this phase, by design.

---

<!--
Release template (copy for each new version):

## [X.Y.Z] — YYYY-MM-DD
### Added
### Changed
### Deprecated
### Removed
### Fixed
### Security
-->
