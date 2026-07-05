# COMPONENT_LIBRARY.md — SPN Cabinets

The catalogue of every reusable component we will build. Each entry states the
component's **responsibility**, its **data contract** (args, later ACF), the
**template-part path**, accessibility notes and status. Build components to the
rules in [CLAUDE.md](CLAUDE.md) §14–15 and style them with tokens
([DESIGN_SYSTEM.md](DESIGN_SYSTEM.md)).

**Legend — Status:** ✅ built · 🟡 partial · ⬜ planned
**Type:** *Primitive* (atom), *Composite* (built from primitives), *Section*
(full-width page band), *Global* (site-wide chrome).

---

## Index

| # | Component | Type | Path | Status |
|---|---|---|---|---|
| 1 | Header | Global | `template-parts/header/site-header.php` | ✅ |
| 2 | Footer | Global | `template-parts/footer/site-footer.php` | ✅ |
| 3 | Primary Navigation | Global | (in header + nav walker) | ✅ |
| 4 | Button / CTA | Primitive | `template-parts/buttons/button.php` | ✅ |
| 5 | Card (base) | Primitive | `template-parts/cards/card.php` | ✅ |
| 6 | Hero | Section | `template-parts/hero/hero.php` | ✅ |
| 7 | CTA Band | Section | `template-parts/components/cta.php` | ✅ |
| 8 | Service Card | Composite | `template-parts/cards/service-card.php` | ✅ |
| 9 | Feature Card | Composite | `template-parts/cards/feature-card.php` | ⬜ |
| 10 | Gallery Grid | Section | `template-parts/components/gallery-grid.php` | ✅ |
| 11 | Project Card | Composite | `template-parts/cards/project-card.php` | ✅ |
| 12 | Testimonials | Section | `template-parts/sections/testimonials.php` | ⬜ |
| 13 | Statistics / Trust Bar | Section | `template-parts/sections/stats.php` | ⬜ |
| 14 | FAQ (Accordion) | Composite | `template-parts/faq/faq.php` | ⬜ |
| 15 | Quote Form | Composite | `template-parts/forms/quote-form.php` | ✅ |
| 16 | Contact Card | Composite | `template-parts/cards/contact-card.php` | ⬜ |
| 17 | Map | Composite | `template-parts/sections/map.php` | ⬜ |
| 18 | Breadcrumbs | Global | `template-parts/global/breadcrumbs.php` | ✅ |
| 19 | WhatsApp Button | Global | `template-parts/buttons/whatsapp.php` | 🟡 |
| 20 | Process / Steps | Section | `template-parts/sections/process.php` | ⬜ |
| 21 | Blog Card | Composite | `template-parts/cards/blog-card.php` | ⬜ |
| 22 | Pagination | Global | core `the_posts_pagination()` + `pagination.css` | ✅ |
| 23 | 404 Hero | Section | (in `404.php`) | ✅ |
| 24 | Cookie Banner | Global | `template-parts/global/cookie-banner.php` | ⬜ |
| 25 | Newsletter | Section | `template-parts/forms/newsletter.php` | ⬜ |
| 26 | Section Heading | Primitive | `template-parts/components/section-heading.php` | ✅ |
| 27 | Social Links | Primitive | `template-parts/global/social-links.php` | ⬜ |
| 28 | Logo Strip / Accreditations | Section | `template-parts/sections/logos.php` | ⬜ |
| 29 | Mobile Nav (off-canvas) | Global | `template-parts/header/mobile-nav.php` | ✅ |
| 30 | Announcement Bar | Global | `template-parts/header/announcement-bar.php` | ✅ |
| 31 | Testimonial Card | Composite | `template-parts/cards/testimonial-card.php` | ✅ |

---

## Global chrome

### 1. Header ✅
**Responsibility:** site branding + primary navigation + key contact CTAs at the
top of every page. Sticky-on-scroll (planned), fully keyboard-accessible.
**Contract:** uses `custom-logo` / site title; renders `primary` menu only if
assigned. **A11y:** `role="banner"`, skip-link target, accessible menu toggle.

### 2. Footer ✅
**Responsibility:** footer navigation, consistent **NAP** (name/address/phone),
WhatsApp, hours, legal links, copyright. **Contract:** `footer` menu + site info
helpers. **A11y:** `role="contentinfo"`, labelled nav.

### 3. Primary Navigation ✅
**Responsibility:** main site menu with accessible submenu toggles.
**Implementation:** `SPN_Cabinets_Walker_Nav_Menu` + `navigation.js`
(aria-expanded, Escape, outside-click). **A11y:** `aria-current`, real
`<button>` toggles, keyboard operable.

### 18. Breadcrumbs ⬜
**Responsibility:** show the user's location in the hierarchy on all non-home
pages; output `BreadcrumbList` schema. **Contract:** current queried object.
**A11y:** `nav[aria-label="Breadcrumb"]`, `aria-current="page"` on last crumb.

### 19. WhatsApp Button ⬜
**Responsibility:** persistent click-to-chat launcher (floating on mobile,
in-header on desktop). **Contract:** WhatsApp number + prefilled message (ACF/
theme option). **A11y:** real link with accessible name; not motion-dependent.
**Note:** needs client WhatsApp number (⛳).

### 22. Pagination 🟡
**Responsibility:** paginate archives/blog consistently. *Currently core
`the_posts_pagination()` in templates; extract to a styled part.* **A11y:**
`nav[aria-label]`, current page marked, prev/next labelled.

### 24. Cookie Banner ⬜
**Responsibility:** GDPR/UK-GDPR consent for non-essential cookies/analytics;
remember choice; gate analytics until consent. **Contract:** policy link, config.
**A11y:** focus-managed, keyboard-dismissible, not a focus trap. **Note:** only
needed if non-essential cookies are used.

### 27. Social Links ⬜
**Responsibility:** render provided social profiles as accessible icon links.
**Contract:** array of `{network, url}` (ACF/options). **A11y:** each link has a
text name; icons `aria-hidden`.

---

## Primitives

### 4. Button / CTA ✅
**Responsibility:** the single, consistent button/CTA primitive for the whole
site. **Contract (args):** `label`, `url`, `variant` (primary/secondary/ghost),
`size` (sm/md/lg), `new_tab`, `type`, `classes[]`, `attrs{}`. Renders `<a>` if
`url` else `<button>`. **A11y:** focus-visible, 44px target, escaped output.

### 5. Card (base) ✅
**Responsibility:** generic content card (title, media, excerpt, optional CTA)
reused by archives and composed by richer cards. **Contract (args):** `title`,
`url`, `image_id`, `image_size`, `excerpt`, `cta_label`, `classes[]`.
**A11y:** semantic `<article>`, `<h3>` title, lazy image.

### 26. Section Heading ✅
**Responsibility:** standardised kicker (eyebrow) + heading + description block
so every section header looks identical. Path:
`template-parts/components/section-heading.php`.
**Contract (args):** `kicker` (optional, uppercase accent eyebrow), `title`
(required — bails without it), `title_tag` (h1–h6, default `h2`), `description`
(optional, muted + constrained to 60ch), `alignment` (left|center, default
center). **A11y:** correct heading level per context (caller picks `title_tag`
to keep the page's heading hierarchy valid).

---

## Composites & sections (planned)

### 6. Hero (Section) ✅
**Responsibility:** above-the-fold headline, subcopy, primary + secondary CTA and
an optional background image; the page's LCP element. Dark surface (solid brand
primary or image + token scrim) with light text for a premium feel.
**Contract (args):** `title`, `title_tag` (h1|h2, default h1), `subtitle`,
`alignment` (left|center), `background_type` (image|solid),
`background_image_url`, `background_image_alt` (default ''=decorative),
`primary_cta_text`/`primary_cta_url`, `secondary_cta_text`/`secondary_cta_url`.
Bails without a `title`; falls back to solid if `image` has no URL; CTAs render
only when text **and** URL are present.
**Perf:** background renders as a real `<img>` with `fetchpriority="high"`,
`loading="eager"`, `decoding="async"`.
**A11y:** keep one `<h1>` per page — when the hero is the page heading, the
header branding must not also be `<h1>`; otherwise pass `title_tag => 'h2'`.
Decorative background image uses empty `alt`. CTAs reuse the button primitive
(primary→accent, secondary→outline re-themed light on the dark surface).

### 7. CTA Band (Section) ✅
**Responsibility:** full-width conversion band (title + optional description +
one button), repeated across pages. Path: `template-parts/components/cta.php`.
**Contract (args):** `title` (required), `description` (optional),
`button_text` + `button_url` (required — bails without them), `theme`
(primary|secondary|dark, default primary — sets the band background),
`alignment` (center|left, default center; left becomes a content|button row on
desktop). **Reuses the button primitive** (accent variant, chosen via a
theme→variant map so a future light theme maps differently). Text uses the
matching contrast token; `--section-space-y` vertical padding.

### 8. Service Card (Composite) ✅
**Responsibility:** summarise a service (Kitchens/Bedrooms) as a whole-card-
clickable tile for a grid. Built on the base card (`.card--service` modifier in
`cards.css`). **Contract (args):** `title` (required), `description` (optional),
`image_url` (optional — 4:3 `object-fit: cover` crop), `icon` (optional —
`spn_cabinets_icon()` slug; unknown slugs degrade to nothing), `url` (required).
**Interaction:** clickable-block pattern via the base `.card__link::after`
(single accessible link = the title); hover/focus-within lift + shadow +
arrow-nudge. **A11y:** decorative image (`alt=""`), decorative arrow
(`aria-hidden`), `<h3>` title link.

### 9. Feature Card (Composite) ⬜
**Responsibility:** highlight a benefit/USP (icon + short text) in feature grids.
**Contract:** `icon`, `title`, `text`.

### 10. Gallery Grid (Section) ✅
**Responsibility:** lay out Project Cards in a pure-CSS-grid "masonry-lite"
staggered grid (no JS masonry). Path: `template-parts/components/gallery-grid.php`.
**Contract (args):** `projects` (required — array of project-card arg arrays,
each passed straight to the project-card component; invalid entries are skipped),
`columns` (int 1–4, default 3). **Design:** single un-staggered column on mobile;
on desktop (≥768px) the requested columns with the offset column nudged down by
`--gallery-stagger` (`--space-xl` = 3rem). Filtering (Room-Type/Style) can be
layered on later. **A11y:** cards carry their own links/alt.

### 11. Project Card (Composite) ✅
**Responsibility:** luxury full-bleed portfolio tile — image fills a 4:5 card with
the category + title overlaid at the bottom over a gradient scrim. Built on the
base card (`.card--project` modifier in `cards.css`).
**Contract (args):** `title` (required), `image_url` (required), `category`
(optional accent eyebrow), `url` (optional — clickable-block when set, otherwise
a static gallery image), `image_alt` (optional — defaults to title).
**Interaction:** `overflow: hidden` + base `.card__image` `scale(1.05)`
zoom-on-hover (no card lift); `.card__link::after` clickable block when linked.
**A11y:** meaningful image `alt`; decorative overlay (`aria-hidden`); `<h3>` title.

### 12. Testimonials (Section) ⬜
**Responsibility:** display client reviews to build trust — composes the
**Testimonial Card (#31)** in a grid/slider. **Contract:** query of `testimonial`
CPT (name, quote, rating). **A11y:** if a slider, provide keyboard controls,
pause, and no motion for reduced-motion users. Consider `Review`/
`AggregateRating` schema (only for genuine, verifiable reviews).

### 31. Testimonial Card (Composite) ✅
**Responsibility:** a single customer review. Built on the base card
(`.card--testimonial` modifier in `cards.css`). Path:
`template-parts/cards/testimonial-card.php`.
**Contract (args):** `quote` (required), `author_name` (required), `service_name`
(optional muted), `rating` (int 1–5, default 5; out-of-range → 5), `avatar_url`
(optional — rounded, gracefully omitted). **Design:** gold `spn_cabinets_icon('star')`
rating (filled up to `rating`, faint beyond), italic `<blockquote>` over a faint
`::before` quotation mark, author row with `<cite>` + optional avatar.
**A11y:** rating exposed as one labelled image ("Rated N out of 5") with the
stars hidden; decorative avatar (`alt=""`); semantic blockquote/cite.

### 13. Statistics / Trust Bar (Section) ⬜
**Responsibility:** headline numbers (years experience, projects completed, etc.)
and trust badges. **Contract:** repeater of `{value, label}`. **A11y:** count-up
animation is enhancement-only and respects reduced-motion.

### 14. FAQ / Accordion (Composite) ⬜
**Responsibility:** expandable Q&A; feeds `FAQPage` schema. **Contract:** query
of `faq` CPT or ACF repeater `{question, answer}`. **A11y:** button-controlled
disclosure, `aria-expanded`/`aria-controls`, keyboard operable; content in DOM
(not display-none-only for SEO/schema).

### 15. Quote Form (Composite) ✅ — *conversion-critical*
**Responsibility:** the primary lead-capture form. **Native, no plugin.** Part:
`template-parts/forms/quote-form.php`; handler: `inc/form-handlers.php` (registered
in functions.php). **Fields:** Full Name, Email, Phone, Postcode (all required),
Service Required (`<select>`, whitelist-validated against
`spn_cabinets_quote_services()`), Project Details (optional). **Flow:** posts to
`admin-post.php` (`action=spn_cabinets_quote`) → nonce check → honeypot → aggressive
sanitise → server-side validate → on error, stash values+messages in a one-time
transient and redirect `?status=error&sqf=<token>`; on success, `wp_mail()` the
lead to `spn_cabinets_contact()['email']` (fallback `admin_email`, Reply-To =
enquirer) and redirect `?status=success`. **Args:** `submit_label` (optional).
**Security:** nonce, honeypot, sanitise-on-input, validate (required + email +
service whitelist), same-site redirect via `wp_validate_redirect`. **Design:**
reuses forms.css hooks; submit is the **button primitive** (`type=submit`,
block). **A11y:** labelled fields, `aria-invalid`/`aria-describedby`, non-colour
errors, `role="status"`/`role="alert"` banners. **Future:** hook
`spn_cabinets_quote_submitted` to also store leads in a CPT.

### 16. Contact Card (Composite) ⬜
**Responsibility:** compact contact details block (phone, WhatsApp, email, hours,
address). **Contract:** NAP fields (ACF/options). Consistent with footer NAP.

### 17. Map (Composite) ⬜
**Responsibility:** show service area/location. **Contract:** address/coords.
**Perf/Privacy:** lazy-load (facade/click-to-load) to avoid third-party cost and
consent issues. **A11y:** provide a text address alongside the map.

### 20. Process / Steps (Section) ⬜
**Responsibility:** "How it works" numbered steps (consultation → design → fit).
**Contract:** repeater `{step, title, text, icon}`. **A11y:** ordered list.

### 21. Blog Card (Composite) ⬜
**Responsibility:** post preview for the blog/archive (thumb, title, date,
excerpt, read-more). **Contract:** post object. Built on Card.

### 23. 404 Hero (Section) ✅
**Responsibility:** friendly not-found state with search + home link. Currently
in `404.php`; may be extracted to a part if reused.

### 25. Newsletter (Section) ⬜
**Responsibility:** email-capture signup (phase 2). **Contract:** provider/list
config. **Security/A11y:** nonce, labelled input, consent, clear success/error.
**Note:** only if the client wants email marketing.

### 28. Logo Strip / Accreditations (Section) ⬜
**Responsibility:** display trade accreditations / brand logos for credibility.
**Contract:** array of `{image, name, url?}`. **A11y:** each logo has alt text.

---

## Build order (recommended)

1. **Section Heading, Hero, CTA Band** (page scaffolding + conversion).
2. **Service Card, Feature Card, Process** (services + home).
3. **Project Card, Gallery Grid** (portfolio + CPT).
4. **Quote Form, Contact Card, WhatsApp, Map** (contact + conversion).
5. **Testimonials, Statistics, FAQ, Logo Strip** (trust).
6. **Breadcrumbs, Pagination** (navigation polish).
7. **Blog Card, Newsletter, Cookie Banner** (phase 2 / as required).

> Every new component: add its row above, document the contract, build the
> args-driven part, style with tokens, verify a11y + responsive, then tick it in
> [TODO.md](TODO.md) and note it in [CHANGELOG.md](CHANGELOG.md).
