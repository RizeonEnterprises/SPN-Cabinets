# CLAUDE.md — SPN Cabinets Project Instructions

> **This is the permanent, authoritative instruction file for the SPN Cabinets
> theme.** Every contributor — human or AI — must read and follow it before
> writing a single line of code. When any other document conflicts with this
> one, **this file wins**. Keep it up to date; it is the project's constitution.

---

## 1. Project overview

We are building a **bespoke, production-grade custom WordPress theme** named
`spn-cabinets` for a real client. It is a **lead-generation + portfolio**
website — not eCommerce. The site must be fast, accessible, SEO-strong,
maintainable and built entirely with native WordPress and hand-written code.

- **Theme slug / text domain:** `spn-cabinets`
- **Function/handle prefix:** `spn_cabinets_` (functions), `SPN_CABINETS_`
  (constants), `SPN_Cabinets_` (classes), `spn-cabinets-` (asset handles).
- **Location:** `app/public/wp-content/themes/spn-cabinets` (Local by Flywheel).

## 2. Business overview

- **Client:** SPN Cabinets
- **Trade:** Bedroom & Kitchen Fitter (fitted furniture / joinery).
- **Primary objective:** generate qualified enquiries ("Free Quote" requests).
- **Secondary objectives:** showcase completed work (portfolio), communicate
  services, and build trust with prospective local customers.
- **Audience:** homeowners in the client's service area researching a fitted
  kitchen or bedroom — typically mobile-first, comparison-shopping, trust-driven.

See [CLIENT_REQUIREMENTS.md](project-docs/CLIENT_REQUIREMENTS.md) and
[PROJECT_GUIDE.md](project-docs/PROJECT_GUIDE.md) for full detail.

## 3. Technology stack

| Layer | Choice |
|---|---|
| CMS | WordPress (latest; tested to 7.0) |
| Language | PHP 7.4+ (runtime is PHP 8.2) |
| Theme | Custom classic theme (PHP templates + template parts) |
| Editor | Native block editor (Gutenberg) for content |
| Custom fields | **ACF (Advanced Custom Fields)** — added in the fields phase |
| JS | Vanilla ES5-safe / ES2015 (no framework, no jQuery) |
| CSS | Hand-authored, ITCSS layering + CSS custom-property design tokens |
| Build | None initially; optional PostCSS/Sass later (must still output one CSS file) |

### Hard "never" rules
- ❌ **Never use Elementor, Divi, WPBakery or any page builder.**
- ❌ **Never use Bootstrap** (or Tailwind, Foundation, etc.).
- ❌ **Never use jQuery** unless a third-party dependency makes it *absolutely*
  unavoidable — and then document why in the PR.
- ❌ Never add a plugin where a few lines of theme code will do. Justify every
  plugin (see [PROJECT_GUIDE.md](project-docs/PROJECT_GUIDE.md) → Plugin philosophy).

## 4. Folder structure

```
spn-cabinets/
├── assets/         css/ js/ images/ fonts/ icons/
├── inc/            classes/ helpers/ + feature modules
├── template-parts/ header/ footer/ hero/ buttons/ cards/ forms/
├── languages/
├── project-docs/   (this documentation)
└── [templates]     style.css functions.php header/footer/index/front-page/…
```

- **`functions.php` only loads files.** All behaviour lives in `/inc` modules,
  registered in the `$spn_cabinets_modules` array and pulled in through the
  `spn_cabinets_require()` guard.
- New functionality = **new file in `/inc`**, not more code in `functions.php`.

## 5. WordPress coding standards

Follow the **WordPress Coding Standards (WPCS)** without exception:

- Indent with **tabs**, not spaces.
- **Yoda conditions** (`if ( 'x' === $var )`).
- Spaces inside parentheses: `foo( $bar )`.
- One space after control-structure keywords: `if (`, `foreach (`.
- Use `snake_case` for functions/variables, `Capitalized_Snake_Case` for classes.
- All user-facing strings are **internationalised** with the `spn-cabinets`
  text domain: `__()`, `_e()`, `esc_html__()`, `esc_attr_e()`, `_n()`, etc.
- Prefer WordPress core APIs over raw PHP (`wp_remote_get` over cURL, `WP_Query`
  over raw SQL, `wp_date()` over `date()`).
- Every file starts with `defined( 'ABSPATH' ) || exit;`.
- Run **PHP_CodeSniffer with `wp-coding-standards/wpcs`** before every commit.

## 6. PHP standards

- Every function, class and method has a **PHPDoc block** (`@since`, `@param`,
  `@return`). File-level docblocks include `@package SPN_Cabinets`.
- **Prefix everything** with `spn_cabinets_` / `SPN_Cabinets_` — no global
  namespace pollution.
- Hook into WordPress; never edit core, and never call template tags before
  `after_setup_theme` where init order matters.
- Escape **on output**, sanitise **on input**, validate **always** (see §11).
- Fail safely: guard optional includes, check `function_exists`/`class_exists`
  for anything that may be pluggable.
- Keep functions small and single-purpose; extract helpers into
  `inc/helpers/`.

## 7. JavaScript standards

- **Vanilla JS only.** No jQuery, no framework, no build-time transpilation
  assumed (write ES2015 that runs in evergreen browsers).
- Wrap modules in an IIFE with `'use strict';` — no globals leak.
- Enqueue via `wp_enqueue_script()`, load in the **footer**, and **`defer`** it
  (handled by the `script_loader_tag` filter). Never hand-write `<script>` tags.
- Pass server data via `wp_localize_script()` (the `spnCabinets` object). Never
  echo PHP into inline JS.
- **Progressive enhancement:** the site must work without JS; JS only enhances.
- Keep DOM queries scoped, listeners cleaned up, and respect
  `prefers-reduced-motion`.
- Accessibility in JS: manage `aria-expanded`, focus and `Escape` handling for
  any interactive widget (see the nav walker + `navigation.js` as the pattern).

## 8. CSS architecture

- **One render-blocking stylesheet:** `assets/css/main.css`, organised in ITCSS
  layers, broad → specific:
  `1. Settings (tokens) → 2. Generic (reset) → 3. Elements → 4. Layout →
  5. Components → 6. Utilities`.
- **Design tokens are CSS custom properties** in `:root`. Components must
  consume tokens (`var(--space-md)`), **never hard-coded values**.
- Naming: **BEM** — `.block`, `.block__element`, `.block--modifier`.
- **Mobile-first**: base styles are mobile; enhance upward with `min-width`
  media queries. No `max-width`-first cascades.
- No `!important` except documented utilities (e.g. `.screen-reader-text`).
- No inline styles. No ID selectors for styling. Keep specificity flat.
- If a build step is added later, it must still compile to a **single**
  `main.css`; the enqueue logic does not change.
- See [DESIGN_SYSTEM.md](project-docs/DESIGN_SYSTEM.md) for the token values and scales.

## 9. Accessibility requirements (WCAG 2.2 AA target)

- **Semantic HTML first** — correct landmarks (`header`, `nav`, `main`,
  `footer`), one `<h1>` per page, logical heading order (no skipped levels).
- Provide a **skip link**, visible **`:focus-visible`** styles, and full
  **keyboard operability** for every interactive element.
- Images have meaningful `alt` (empty `alt=""` for decorative). Icons that
  convey meaning have accessible names.
- Colour contrast ≥ **4.5:1** for text (verify once brand colours land).
- Respect **`prefers-reduced-motion`**; never trap focus unexpectedly.
- Forms have associated `<label>`s, clear error messaging, and `aria-*` state.
- Test with keyboard only, a screen reader, and automated tools (axe/Lighthouse).

## 10. Performance requirements

- **Targets:** Lighthouse ≥ 90 (mobile) across Performance/SEO/Best-Practices/
  A11y; Core Web Vitals in the "good" band (LCP < 2.5s, INP < 200ms, CLS < 0.1).
- One CSS request; JS deferred; **no jQuery**; minimal plugins.
- **Images:** always `width`/`height` (prevent CLS), `loading="lazy"` below the
  fold, `fetchpriority="high"` for the LCP image, responsive `srcset`, modern
  formats (WebP/AVIF). Never ship unoptimised uploads.
- Self-host fonts (`woff2`, `font-display: swap`, preload critical); avoid
  render-blocking third parties.
- **Cache-bust with `filemtime()`** (already implemented in enqueue-assets).
- Query responsibly: cache expensive queries (transients), avoid N+1 in loops,
  never query in a template where a `WP_Query` arg would do.

## 11. Security rules

- **Escape on output, sanitise on input, validate everything.**
  - Output: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`.
  - Input: `sanitize_text_field()`, `sanitize_email()`, `absint()`, etc.
- **Nonces** on every form and state-changing request; verify with
  `check_admin_referer()` / `wp_verify_nonce()`.
- **Capability checks** (`current_user_can()`) before privileged actions.
- Use `$wpdb->prepare()` for any raw SQL (prefer the query APIs instead).
- Never trust `$_GET`/`$_POST`/`$_REQUEST`/`$_SERVER` unsanitised.
- Keep the hardening in `inc/security.php` (version hidden, XML-RPC off, REST
  user-enumeration blocked, security headers). Don't undo it without reason.
- No secrets in the repo. No debug output in production.

## 12. SEO rules

- Let core manage `<title>` (`title-tag` support). One `<h1>` per page.
- **Semantic, crawlable markup**; clean, keyword-relevant URL slugs.
- Every page needs a unique title + meta description (managed via the SEO
  plugin — see [SEO_STRATEGY.md](project-docs/SEO_STRATEGY.md)).
- **Structured data (schema.org):** `LocalBusiness`, `Service`, `BreadcrumbList`,
  `ImageObject`/portfolio, `FAQPage` where relevant.
- Descriptive `alt` text; sensible internal linking; XML sitemap; canonical URLs.
- Local SEO first (NAP consistency, service-area pages, Google Business Profile).
- Full plan in [SEO_STRATEGY.md](project-docs/SEO_STRATEGY.md).

## 13. Naming conventions

| Thing | Convention | Example |
|---|---|---|
| Functions | `spn_cabinets_{verb}_{noun}` | `spn_cabinets_enqueue_assets()` |
| Constants | `SPN_CABINETS_*` | `SPN_CABINETS_VERSION` |
| Classes | `SPN_Cabinets_*` (file `class-…php`) | `SPN_Cabinets_Walker_Nav_Menu` |
| Hooks/filters | `spn_cabinets_*` | `spn_cabinets_script_data` |
| Asset handles | `spn-cabinets-*` | `spn-cabinets-navigation` |
| CSS classes | BEM, kebab-case | `.card__title`, `.button--primary` |
| Template parts | `template-parts/{group}/{name}.php` | `cards/card.php` |
| ACF field keys | `field_spn_{group}_{name}` | `field_spn_hero_heading` |
| ACF field names | `spn_{group}_{name}` | `spn_hero_heading` |

## 14. Template part rules

- Reusable markup lives in `template-parts/{group}/{name}.php` and is rendered
  through the helper **`spn_cabinets_component( 'group/name', $args )`**.
- Parts receive data via **`$args`** (WP 5.5+). A part must:
  1. `defined( 'ABSPATH' ) || exit;`
  2. Declare defaults with `wp_parse_args()`.
  3. **Escape every output** and bail early if required data is missing.
  4. Contain **no business/query logic** — the caller prepares data; the part
     only renders markup. (Header/footer parts may call display helpers.)
- Parts are **presentation-only, self-contained, and reusable** — no page-
  specific assumptions baked in.

## 15. How components should be built

1. Define the component + its data contract in
   [COMPONENT_LIBRARY.md](project-docs/COMPONENT_LIBRARY.md).
2. Build an **args-driven template part** (see `buttons/button.php`,
   `cards/card.php` as the reference pattern).
3. Add BEM styles in the **Components** layer of `main.css` using tokens only.
4. Add progressive-enhancement JS only if interaction requires it.
5. **Accessible + responsive + escaped by default.** No hard-coded copy —
   content comes from `$args` (later, from ACF/fields).
6. Reuse before you create — check the library before building anything new.

## 16. How ACF should be used later

- Register **all field groups in PHP** (`inc/acf/` module) via
  `acf_add_local_field_group()`, and **commit the field definitions to the repo**
  (local JSON / PHP export) — never rely on database-only fields.
- Enable **ACF Local JSON** (`acf-json/` sync folder) so field changes are
  version-controlled and portable across environments.
- Naming: field group per component/section; keys `field_spn_*`, names
  `spn_*` (see §13).
- **Always escape ACF output** in templates (`esc_html( get_field(...) )`,
  `wp_kses_post()` for rich text, `esc_url()` for links). ACF returns raw data.
- Prefer **flexible content / repeaters** for page-section composition so the
  client can reorder homepage sections without a page builder.
- Provide sensible defaults and helper wrappers so templates stay clean.

## 17. Git commit standards

- **Conventional Commits:** `type(scope): subject`
  - Types: `feat`, `fix`, `docs`, `style`, `refactor`, `perf`, `test`, `build`,
    `chore`, `a11y`, `seo`.
  - Example: `feat(hero): add args-driven homepage hero template part`.
- Imperative mood, ≤ 72-char subject, body explains **why** not just what.
- **Small, atomic commits**; one logical change each. Never commit commented-out
  code, secrets, or `node_modules`/build artefacts.
- Branch naming: `feat/…`, `fix/…`, `docs/…`. PRs reviewed against this file.
- Co-author trailer for AI-assisted commits where applicable.

## 18. Responsive philosophy

- **Mobile-first, content-first.** Design and code for the smallest viewport,
  then enhance upward with `min-width` breakpoints (see
  [DESIGN_SYSTEM.md](project-docs/DESIGN_SYSTEM.md)).
- **Fluid by default** — use `clamp()`, relative units (`rem`, `%`, `vw`),
  `min()/max()`, container gutters and CSS grid/flex. Avoid fixed pixel layouts.
- Touch targets ≥ 44×44px; readable line lengths (~60–75ch); no horizontal
  scroll at any width.
- Breakpoints are **content-driven**, not device-driven.

## 19. Documentation standards

- Docs live in `project-docs/` and are **kept current** — update the relevant
  doc in the same PR as the code change.
- **CHANGELOG.md** follows *Keep a Changelog* + **Semantic Versioning**.
- **TODO.md** tracks milestones and task status.
- Every new component is documented in COMPONENT_LIBRARY.md; every architectural
  decision is reflected in the relevant doc. Stale docs are treated as bugs.
- Write for "the senior dev joining tomorrow": explain the *why*, not just the *what*.

## 20. Golden rules (always)

1. **Always build reusable components** — reuse before you create.
2. **Always sanitise input and escape output.**
3. **Always follow the WordPress Coding Standards.**
4. **Always use semantic, accessible HTML.**
5. **Never** use Elementor, Bootstrap, or (barring true necessity) jQuery.
6. **Never** put logic in `functions.php` or markup in `/inc`.
7. When in doubt, prefer the **native WordPress** and **most-accessible** option.
