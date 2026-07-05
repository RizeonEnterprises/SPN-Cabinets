# TODO.md — SPN Cabinets

Project task tracker, organised by milestone. Mirrors the phases in
[DEVELOPMENT_WORKFLOW.md](DEVELOPMENT_WORKFLOW.md).

**Legend:** `[x]` done · `[~]` in progress · `[ ]` not started · `⛳` blocked on
client input.

_Last updated: 2026-07-03_

---

## Milestone 1 — Foundation (Architecture) — 🟢 ~80%

**Theme scaffold**
- [x] Create custom theme `spn-cabinets` + folder architecture
- [x] `functions.php` loader pattern (loads `/inc` only)
- [x] `inc/theme-support.php` (title-tag, thumbnails, custom-logo, html5,
      align-wide, responsive-embeds, editor-styles, i18n, content width)
- [x] `inc/menus.php` (Primary + Footer)
- [x] `inc/enqueue-assets.php` (CSS/JS, defer, filemtime cache-busting, localize)
- [x] `inc/cleanup.php` (head tidy, emoji removal, resource hints)
- [x] `inc/security.php` (version hidden, XML-RPC off, REST guard, headers)
- [x] `inc/helpers/template-helpers.php`
- [x] `inc/classes/class-spn-cabinets-walker-nav-menu.php` (accessible walker)
- [x] Base templates: index, front-page, page, single, archive, 404, header, footer
- [x] Structural parts: site-header, site-footer
- [x] Primitives: `buttons/button.php`, `cards/card.php`
- [x] Base `assets/css/main.css` (ITCSS + tokens) + `editor.css`
- [x] `assets/js/navigation.js`, `assets/js/main.js`
- [x] PHP lint pass (all files) 

**Project setup**
- [x] Documentation suite (`project-docs/`)
- [ ] `git init` (scoped to theme) + `.gitignore` + first commit
- [x] Activate theme + QA smoke test in Local (browser QA passed 2026-07-04)
- [x] Set permalinks to Post name
- [ ] Tooling: Composer + PHPCS + `wp-coding-standards/wpcs`; `.editorconfig`

**Information architecture**
- [x] Register **Project** CPT `spn_project` (`inc/post-types.php`) + flush rewrites
- [x] Register hierarchical taxonomy `spn_project_category`
- [ ] (Optional/future) Style + Location taxonomies; Testimonial + FAQ CPTs
- [~] ACF field group defined in PHP (`inc/acf-fields.php`, guarded) — **install
      ACF PRO** (gallery field) to activate; consider Local JSON later
- [ ] Create page tree (Home, About, Services + children, Gallery, Contact, legal)
- [ ] Build + assign Primary and Footer menus
- ⛳ Confirm service-area/towns (affects local pages) — see CLIENT_REQUIREMENTS

## Milestone 2 — Design system — 🟡 in progress (~70%)

- [x] Build full design-token set in `assets/css/src/01-settings/tokens.css`
      (colour, type, spacing, section spacing, containers, radius, shadow,
      motion, z-index, opacity, focus, breakpoint refs)
- [x] Global typography (headings, prose, lists, links, captions, quotes, tables)
- [x] Buttons (primary/secondary/outline/ghost/text + sizes + disabled/loading)
- [x] Forms (inputs/textarea/select/checkbox/radio + focus/validation states)
- [x] Cards (base + service/gallery/blog/testimonial/cta variants)
- [x] Utilities (spacing/flex/grid/text/visibility) + accessibility helpers
- [x] Animation system + reduced-motion support
- [x] Modular CSS partials + build (`tools/build-css.mjs`, `npm run build:css`)
- [x] Expand [DESIGN_SYSTEM.md](DESIGN_SYSTEM.md) to match implementation
- ⛳ Receive brand colours → replace placeholder colour tokens (values only)
- ⛳ Confirm brand fonts vs. system; self-host if provided
- [ ] Verify colour contrast (WCAG AA) once palette is set
- [ ] Mirror finalised tokens into `assets/css/editor.css` (block-editor parity)
- [ ] Sign off [DESIGN_SYSTEM.md](DESIGN_SYSTEM.md) as final (post-branding)

## Milestone 3 — Components — 🟡 in progress (global shell done)

_Global shell (header / navigation / footer)_
- [x] Site wrapper (`#page`) + main content wrapper + breadcrumb slot
- [x] Premium sticky header (branding, primary nav, actions, mobile toggle)
- [x] Desktop primary navigation with dropdowns (hover + focus + toggle)
- [x] Off-canvas mobile nav (focus trap, Escape, outside-click, scroll-lock, inert)
- [x] 4-column footer + bottom bar (Quick Links / Services / Contact / legal)
- [x] Announcement bar support (disabled by default)
- [x] Global CTA + contact config (`inc/helpers/site-options.php`)
- [x] Inline SVG icon system (`inc/helpers/icons.php`)
- [x] Breadcrumbs baseline (inner pages, filter-overridable)
- [x] WhatsApp button (placeholder-aware) ⛳ needs number
_Scaffolding_
- [ ] Section Heading
- [ ] Hero
- [ ] CTA Band
_Services / home_
- [ ] Service Card
- [ ] Feature Card
- [ ] Process / Steps
_Portfolio_
- [ ] Project Card
- [ ] Gallery Grid (+ optional filtering)
_Conversion_
- [x] Quote Form — native: nonce, honeypot, sanitise/validate, email lead
      (store-in-CPT deferred to the `spn_cabinets_quote_submitted` hook)
- [ ] Contact Card
- [ ] WhatsApp Button ⛳ (needs number)
- [ ] Map (lazy/facade)
_Trust_
- [ ] Testimonials
- [ ] Statistics / Trust Bar
- [ ] FAQ (accordion + schema)
- [ ] Logo Strip / Accreditations
_Navigation polish_
- [ ] Breadcrumbs (+ schema)
- [ ] Pagination (extract from core to styled part)
_Phase 2 / optional_
- [ ] Blog Card
- [ ] Newsletter
- [ ] Cookie Banner (if non-essential cookies used)
- [ ] Social Links

_For each component:_ args contract → build part → token styles → a11y +
responsive check → ACF fields → document + tick in
[COMPONENT_LIBRARY.md](COMPONENT_LIBRARY.md).

## Milestone 4 — Pages — 🔴 not started

- [ ] Homepage (`front-page.php`) via ACF flexible content
- [ ] About
- [ ] Services (hub) + Fitted Kitchens + Fitted Bedrooms
- [x] Single Project (`single-spn_project.php`) — assembled from components
- [x] Gallery / project archive (`archive-spn_project.php` → `/portfolio/`)
- [ ] Contact (+ Thank-You)
- [ ] Legal pages (Privacy, Cookies, Terms)
- [ ] 404 polish
- [ ] Per-page SEO (titles, meta, schema, internal links)
- ⛳ Populate real content + images (client-supplied)

## Milestone 5 — Testing & optimisation — 🔴 not started

- [ ] Image pipeline (WebP/AVIF, srcset, lazy, LCP priority)
- [ ] Font strategy (preload, swap)
- [ ] Lighthouse ≥ 90 mobile; CWV in "good" band
- [ ] Accessibility audit (keyboard + screen reader + axe) → WCAG 2.2 AA
- [ ] Forms end-to-end (email delivery + storage + spam protection)
- [ ] Cross-browser + real-device QA
- [ ] SEO: sitemap, robots, canonicals, schema validation
- [ ] PHPCS (WPCS) clean; no console errors; debug off

## Milestone 6 — Deployment — 🔴 not started

- ⛳ Provision host, domain, SSL, transactional SMTP
- [ ] Staging deploy + client review
- [ ] Backups + security + analytics/consent configured
- [ ] Pre-launch checklist ([PROJECT_GUIDE.md](PROJECT_GUIDE.md) §10)
- [ ] Go-live: DNS, redirects, smoke test
- [ ] Submit sitemap to Search Console; align GBP
- [ ] Tag release in [CHANGELOG.md](CHANGELOG.md); set up maintenance

---

## Blocked on client (⛳ summary)

- Brand colours, fonts, logo
- Phone, WhatsApp number, enquiry email, opening hours, address
- Service list + service-area towns
- Content + images for all pages
- Testimonials/accreditations source; blog yes/no
- Hosting, domain, analytics/consent preferences

_See [CLIENT_REQUIREMENTS.md](CLIENT_REQUIREMENTS.md) for the full open-questions
list._
