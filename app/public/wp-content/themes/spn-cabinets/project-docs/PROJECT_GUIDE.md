# PROJECT_GUIDE.md — SPN Cabinets

A high-level guide to *what* we are building and *why*. Read this after
[CLAUDE.md](CLAUDE.md) to understand the project's intent, shape and direction.

---

## 1. Executive summary

SPN Cabinets is a bedroom & kitchen fitting business. We are building a custom
WordPress website whose single most important job is to **turn local visitors
into enquiries** ("Free Quote" requests), backed by a credible portfolio of
completed work. The site is a hand-built, no-page-builder theme optimised for
speed, accessibility, SEO and long-term maintainability.

## 2. Project goals (our build goals)

- Ship a **fast, accessible, SEO-strong** custom theme with **zero page-builder
  dependency**.
- Establish a **scalable component architecture** so future pages/sections are
  assembled from reusable parts, not rebuilt from scratch.
- Give the client a **simple, safe admin experience** to manage content, gallery
  and enquiries without touching code.
- Keep the codebase **documented, standards-compliant and reviewable**.

## 3. Client goals

- Look **professional and trustworthy** to homeowners comparing fitters.
- **Showcase completed kitchens & bedrooms** attractively (portfolio/gallery).
- Make it **effortless to request a quote** (form + WhatsApp + clear phone/CTA).
- Be **found locally** on Google for relevant searches.
- Be **easy to update** as new projects are completed.

## 4. Business goals

- **Increase qualified enquiries** month over month (primary KPI).
- **Lower cost per lead** vs. paid directories by ranking organically.
- **Build brand credibility** in the service area.
- Create a foundation that can later support **blogging/content marketing** and
  additional service pages.

## 5. Website objectives (measurable)

| Objective | Target / KPI |
|---|---|
| Lead generation | ↑ quote-form submissions & WhatsApp click-throughs |
| Performance | Lighthouse ≥ 90 mobile; CWV in "good" band |
| Accessibility | WCAG 2.2 AA |
| SEO | Rank for local "fitted kitchens / bedrooms + \[area]" terms |
| Engagement | Healthy gallery views, low bounce on service pages |
| Maintainability | New section shipped from existing components in < 1 day |

> **Placeholder:** exact numeric targets (lead volume, keyword list, conversion
> rate) to be agreed with the client. See [CLIENT_REQUIREMENTS.md](CLIENT_REQUIREMENTS.md).

## 6. Future scalability

The architecture is deliberately built to grow:

- **Custom post types** for portfolio *Projects* (and later *Testimonials*,
  *Services*, *FAQs*) — see [SITE_ARCHITECTURE.md](SITE_ARCHITECTURE.md).
- **ACF flexible content** so the client can compose pages from sections without
  a page builder.
- **Component library** that new pages consume — adding a page is mostly
  content, not code.
- Room for a **blog / resource centre** for content-marketing SEO.
- Clean separation (`/inc` modules) makes adding features (search, filtering,
  multi-location service-area pages) low-risk.

## 7. Theme architecture

- **Classic custom theme**, PHP templates + `template-parts/` rendered via
  `spn_cabinets_component()`.
- **`functions.php` = loader only**; all behaviour in `/inc` modules
  (theme-support, menus, enqueue, cleanup, security, + future: cpt, acf, forms).
- **Design tokens** in CSS custom properties; **ITCSS** single stylesheet.
- **Vanilla JS**, deferred, progressive-enhancement.
- Content authored in the **native block editor**; structured content via **ACF**.
- Full standards in [CLAUDE.md](CLAUDE.md); IA in
  [SITE_ARCHITECTURE.md](SITE_ARCHITECTURE.md).

## 8. Plugin philosophy

**Minimal, justified, reputable.** A plugin is added only when it provides
security, reliability or capability we should not hand-roll. Each plugin must be
actively maintained, well-reviewed, performant, and documented in this guide.

**Anticipated / recommended:**

| Need | Likely choice | Notes |
|---|---|---|
| Custom fields | **ACF (Advanced Custom Fields)** | Field groups in PHP + Local JSON, committed to repo |
| SEO | **Yoast SEO** or **Rank Math** | Titles, meta, sitemaps, schema baseline |
| Forms | **Native custom handler** or a lightweight plugin (WPForms Lite / CF7 / Fluent Forms) | Decision pending; must be spam-protected & accessible |
| Spam | Honeypot + (optional) hCaptcha/Turnstile | Avoid reCAPTCHA perf/privacy cost if possible |
| Caching | Host-level or a page cache (e.g. WP Super Cache / server cache in Local→prod host) | Prefer host caching |
| Backups | Host-level or UpdraftPlus | Environment-dependent |
| Security | Host WAF + theme hardening; optionally Wordfence-lite | Don't duplicate host protections |

**Avoid:** page builders, "do-everything" bloat plugins, anything that injects
its own render-blocking CSS/JS sitewide, and duplicate-purpose plugins.

> Every plugin decision is logged here and in [CHANGELOG.md](CHANGELOG.md).

## 9. Admin experience

The client should manage the site confidently without developer help:

- **Content** via the block editor on standard pages.
- **Portfolio** via a *Projects* CPT with ACF (title, gallery, room type,
  location, summary) — no layout decisions required of them.
- **Homepage sections** via ACF flexible content (reorder/toggle sections).
- **Menus** via Appearance → Menus (Primary/Footer already registered).
- **Enquiries** captured and (recommended) stored in the DB + emailed, so leads
  are never lost.
- Sensible admin polish later: hide irrelevant menus for the editor role,
  helpful field instructions, and a short client guide.

## 10. Deployment strategy

**Environments:** Local (dev) → Staging (client review) → Production (live).

- **Version control:** git, scoped to the theme; feature branches → reviewed PRs
  → `main`. Conventional Commits (see [CLAUDE.md](CLAUDE.md) §17).
- **Deploy method:** to be confirmed with host — preferably git-based deploy or
  SFTP of the theme folder; never edit code directly on production.
- **Config parity:** ACF field definitions and CPT registration live in code, so
  they deploy with the theme (no manual DB re-entry).
- **Pre-launch checklist:** standards lint, Lighthouse/axe pass, cross-browser +
  device QA, forms tested end-to-end, SEO (titles/meta/schema/sitemap/robots),
  404 + redirects, analytics + consent, backups configured. See
  [DEVELOPMENT_WORKFLOW.md](DEVELOPMENT_WORKFLOW.md).
- **Rollback:** tag releases; keep the previous release deployable.

> **Placeholder:** production host, domain, DNS, SSL, staging URL and deploy
> pipeline to be confirmed with the client.
