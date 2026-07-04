# DEVELOPMENT_WORKFLOW.md — SPN Cabinets

How this project is built, in order. The sequence is deliberate: each phase
depends on the one before it. **Do not jump ahead** — building pages before the
design system exists, or components before the architecture is set, creates
rework. Follow the phases; tick progress in [TODO.md](TODO.md).

---

## Guiding rule

> **Architecture → Design System → Components → Pages → Optimisation → Deployment.**
> Foundations before features. Reusable before bespoke. Content-managed, not
> hard-coded.

---

## Phase 1 — Architecture (foundations) — ✅ largely complete

**Goal:** a standards-compliant theme skeleton and documented decisions.

- ✅ Custom theme scaffold, folder structure, `functions.php` loader pattern.
- ✅ `/inc` modules: theme-support, menus, enqueue (filemtime cache-bust),
  cleanup, security; helpers; accessible nav walker.
- ✅ Base templates + structural template parts; button/card primitives.
- ✅ Project documentation (`project-docs/`).
- ⬜ **Next in this phase:** register CPTs/taxonomies
  ([SITE_ARCHITECTURE.md](SITE_ARCHITECTURE.md)), install/configure **ACF** with
  Local JSON, set permalinks, create the page tree + menus.

**Exit criteria:** theme activates cleanly; IA/CPTs/ACF in place; standards +
docs agreed. No design or page content yet.

## Phase 2 — Design system

**Goal:** lock the visual language as tokens before building UI.

- Finalise brand colours (⛳ awaiting client) → replace placeholder colour tokens
  only.
- Confirm typography (brand fonts vs. system), type scale, spacing, radius,
  shadows, breakpoints, motion — per [DESIGN_SYSTEM.md](DESIGN_SYSTEM.md).
- Ensure every token exists in `main.css` `:root`; verify contrast (AA).

**Exit criteria:** design tokens final; no component uses hard-coded values.

## Phase 3 — Components

**Goal:** build the reusable component library, in isolation, to contract.

- Build each component from [COMPONENT_LIBRARY.md](COMPONENT_LIBRARY.md) as an
  **args-driven template part**, styled with tokens, accessible + responsive.
- Suggested order: Section Heading → Hero → CTA Band → Service/Feature Cards →
  Project Card/Gallery Grid → Quote Form/Contact/WhatsApp/Map → Testimonials/
  Stats/FAQ → Breadcrumbs/Pagination.
- Wire ACF field groups per component/section (PHP + Local JSON).
- Each component: escape output, verify keyboard + screen-reader, test 320px→1440px.

**Exit criteria:** components pass a11y + responsive checks and render from
sample data; documented and ticked in COMPONENT_LIBRARY.

## Phase 4 — Pages

**Goal:** assemble pages by composing existing components — mostly content, not
new code.

- Build page templates (`front-page.php`, service pages, `page.php`, gallery/
  archive, single project, contact, 404 polish) by composing components.
- Use ACF **flexible content** so the homepage/section order is client-editable.
- Populate with **client-supplied content** (⛳); use clear placeholders until
  provided. Never invent business facts.
- Apply per-page SEO (titles, meta, schema, internal links) per
  [SEO_STRATEGY.md](SEO_STRATEGY.md).

**Exit criteria:** all required pages ([CLIENT_REQUIREMENTS.md](CLIENT_REQUIREMENTS.md)
§3) built from components, content in place or clearly stubbed.

## Phase 5 — Optimisation

**Goal:** hit performance, accessibility, SEO and QA targets.

- **Performance:** image pipeline (WebP/AVIF, srcset, lazy, LCP priority),
  font strategy, CSS/JS audit, caching; Lighthouse ≥ 90 + CWV "good".
- **Accessibility:** full keyboard + screen-reader pass, axe/Lighthouse, contrast,
  focus order, form errors → WCAG 2.2 AA.
- **SEO:** titles/meta/schema/sitemap/robots/canonicals; validate rich results.
- **QA:** cross-browser (Chrome/Firefox/Safari/Edge) + real devices; forms
  end-to-end (email + storage + spam); 404 + redirects.
- **Standards:** PHPCS (WPCS) clean; no console errors; debug off.

**Exit criteria:** all targets met; QA checklist passed on staging.

## Phase 6 — Deployment

**Goal:** launch safely and support post-launch.

- Provision production host, domain, SSL, transactional SMTP (⛳).
- Deploy theme (git-based/SFTP); ACF/CPT config ships in code.
- Pre-launch: backups, security headers, analytics + consent, sitemap →
  Search Console, GBP aligned, final content sign-off.
- Go-live: DNS cutover, redirects live, smoke-test forms/CTAs/tracking.
- Post-launch: monitor CWV, Search Console, enquiries; tag the release; schedule
  maintenance (updates/backups). Full checklist in
  [PROJECT_GUIDE.md](PROJECT_GUIDE.md) §10.

**Exit criteria:** live, verified, monitored, documented; release tagged in
[CHANGELOG.md](CHANGELOG.md).

---

## Cross-cutting practices (every phase)

- **Branch → PR → review** against [CLAUDE.md](CLAUDE.md); Conventional Commits.
- **Docs updated in the same PR** as the change (component library, TODO,
  changelog).
- **Accessibility, security (escape/sanitise/nonce), and performance are
  acceptance criteria — not afterthoughts.**
- **Reuse before building**; no page builders, no Bootstrap, no jQuery.
- Test locally (Local by Flywheel) → staging → production; never edit prod code.

## Definition of Done (any task)

- [ ] Meets its acceptance criteria / component contract
- [ ] WPCS-clean (PHPCS), no console errors
- [ ] Escaped/sanitised; nonce + capability checks where relevant
- [ ] Accessible (keyboard + SR) and responsive (320→1440px+)
- [ ] Performant (no CLS/blocking regressions)
- [ ] SEO essentials in place (if user-facing)
- [ ] Docs + TODO + CHANGELOG updated
- [ ] Reviewed and merged
