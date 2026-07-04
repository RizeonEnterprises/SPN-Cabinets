# SPN Cabinets — Custom WordPress Theme

A bespoke, production-grade WordPress theme for **SPN Cabinets** (bedroom &
kitchen fitters). Built for lead generation and portfolio presentation using
**native WordPress** only — no page builder, no jQuery, no framework bloat.

> **Status:** Foundation / architecture phase. Templates are structural shells.
> Design, homepage sections and content are added in the build phase.

---

## Tech & principles

- **CMS:** WordPress (tested up to 7.0) · **PHP:** 7.4+
- Custom PHP templates + reusable template parts (no Elementor / Divi / WPBakery)
- **Vanilla JavaScript** (deferred, no jQuery)
- **Modern CSS** — design tokens (CSS custom properties) + ITCSS layering
- Accessibility-first (skip link, focus styles, ARIA nav, reduced-motion)
- SEO-friendly (semantic landmarks, `title-tag`, clean `<head>`)
- Performance-minded (single stylesheet, deferred JS, file-time cache-busting)
- Follows the **WordPress Coding Standards (WPCS)**

---

## Folder structure

```
spn-cabinets/
├── assets/
│   ├── css/
│   │   ├── main.css          # Single front-end stylesheet (ITCSS layers + tokens)
│   │   └── editor.css        # Block-editor styles (add_editor_style)
│   ├── js/
│   │   ├── main.js           # Site entry point (feature wiring)
│   │   └── navigation.js     # Accessible mobile nav + submenu toggles
│   ├── images/               # Theme graphics (not Media Library uploads)
│   ├── fonts/                # Self-hosted web fonts (woff2)
│   └── icons/                # SVG icons / sprite
│
├── inc/                      # All functionality (loaded by functions.php)
│   ├── classes/
│   │   └── class-spn-cabinets-walker-nav-menu.php   # Accessible nav walker
│   ├── helpers/
│   │   └── template-helpers.php                     # Shared template functions
│   ├── theme-support.php     # add_theme_support(), i18n, content width
│   ├── menus.php             # register_nav_menus()
│   ├── enqueue-assets.php    # CSS/JS enqueue + defer + cache-busting
│   ├── cleanup.php           # <head> tidy, emoji removal, resource hints
│   └── security.php          # Version hiding, XML-RPC off, headers, REST guard
│
├── template-parts/          # Reusable, composable markup
│   ├── header/
│   │   └── site-header.php   # Branding + primary nav
│   ├── footer/
│   │   └── site-footer.php   # Footer nav + copyright
│   ├── hero/                 # (reserved) homepage hero section
│   ├── buttons/
│   │   └── button.php        # Args-driven button / CTA primitive
│   ├── cards/
│   │   └── card.php          # Args-driven content card primitive
│   └── forms/                # (reserved) quote / contact form parts
│
├── languages/               # Translation files (.pot/.po/.mo)
│
├── style.css                # Theme header ONLY (no visual CSS)
├── functions.php            # Bootstrap: constants + module loader only
├── index.php                # Universal fallback template
├── front-page.php           # Homepage shell (no placeholder sections)
├── page.php                 # Single page
├── single.php               # Single post / future CPT
├── archive.php              # Archives (uses the card component)
├── 404.php                  # Not-found template
├── header.php               # Document head + header part + content open
├── footer.php               # Footer part + wp_footer + document close
└── README.md                # This file
```

---

## Architecture notes

### `functions.php` = loader only
`functions.php` defines three constants (`SPN_CABINETS_VERSION`, `_DIR`, `_URI`)
and requires the modules in `/inc` via a guarded `spn_cabinets_require()` helper.
**No business logic lives in `functions.php`** — add new behaviour as a new file
in `/inc` and register it in the `$spn_cabinets_modules` array.

### Theme supports (`inc/theme-support.php`)
`title-tag`, `post-thumbnails`, `custom-logo`, `html5`, `align-wide`,
`responsive-embeds`, `editor-styles` (+ `editor.css`), `wp-block-styles`,
`automatic-feed-links`, selective-refresh widgets, and i18n via
`load_theme_textdomain()`.

### Menus (`inc/menus.php`)
Two locations are registered: **Primary Menu** (`primary`) and
**Footer Menu** (`footer`). Navigation only renders when a menu is assigned
(`spn_cabinets_has_menu()`), so empty locations output nothing.

### Assets (`inc/enqueue-assets.php`)
- One front-end stylesheet: `assets/css/main.css`.
- Two footer scripts: `navigation.js`, `main.js` — both `defer`-ed via the
  `script_loader_tag` filter (never hand-written `<script>` tags).
- **Cache-busting:** each asset is versioned with its `filemtime()`
  (`spn_cabinets_asset_version()`), so browsers refetch only on real changes.
- `wp_localize_script()` exposes a safe `spnCabinets` JS object
  (`ajaxUrl`, `restUrl`, `nonce`).

### CSS architecture (`assets/css/main.css`)
A single render-blocking stylesheet organised into ITCSS layers:
`1. Settings (tokens) → 2. Generic (reset) → 3. Elements → 4. Layout →
5. Components → 6. Utilities`. **All colours, type and spacing are CSS custom
properties** — components must consume tokens, never hard-coded values. The
current token values are neutral placeholders pending the final brand design.

> When the CSS grows, introduce a build step (Sass/PostCSS) to split these
> layers into partials that compile back to a single `main.css`. The enqueue
> logic will not need to change.

### Reusable components (`template-parts/`)
Rendered via the `spn_cabinets_component( $slug, $args )` helper (WP 5.5+
`$args`). `buttons/button.php` and `cards/card.php` are args-driven primitives
so every CTA/card shares consistent, escaped, accessible markup.

### Accessibility
Skip link, `:focus-visible` outlines, `.screen-reader-text`, ARIA-labelled nav
landmarks, a keyboard/AT-friendly nav walker with `aria-current` and real
`<button>` submenu toggles, and `prefers-reduced-motion` handling.

### Security & cleanup
`inc/security.php` hides the WP version, disables XML-RPC, blocks anonymous
REST user enumeration, and sends `X-Content-Type-Options`, `X-Frame-Options`
and `Referrer-Policy` headers. `inc/cleanup.php` removes RSD/WLW/shortlink/
oEmbed head links and the emoji script.

---

## Local development

This theme lives inside a **Local (by Flywheel)** site at
`app/public/wp-content/themes/spn-cabinets`.

1. Start the site in Local.
2. **Appearance → Themes → activate “SPN Cabinets”.**
3. **Settings → Reading:** set a static front page to use `front-page.php`.
4. **Appearance → Menus:** create menus and assign them to *Primary* / *Footer*.
5. Enable `WP_DEBUG` in `wp-config.php` while developing.

### Coding standards
- Follow **WordPress Coding Standards** (tabs for indentation, Yoda conditions,
  escape on output, i18n on all strings with the `spn-cabinets` text domain).
- Recommended tooling: `composer require --dev wp-coding-standards/wpcs` +
  PHP_CodeSniffer; `wp i18n make-pot . languages/spn-cabinets.pot` for strings.

---

## Roadmap (next phases)

1. Finalise brand tokens in `main.css` (colours, type scale, spacing).
2. Build homepage sections as parts in `template-parts/hero` & `sections/`.
3. Register a `project` (portfolio) custom post type + taxonomies in `/inc`.
4. Build the **Free Quote** form part in `template-parts/forms` with a secure
   handler in `/inc` (nonce + sanitisation + server-side validation).
5. Add schema.org / Open Graph output for SEO.
6. Wire up analytics/consent as required.
