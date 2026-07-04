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
| 6 | Hero | Section | `template-parts/hero/hero.php` | ⬜ |
| 7 | CTA Band | Section | `template-parts/sections/cta-band.php` | ⬜ |
| 8 | Service Card | Composite | `template-parts/cards/service-card.php` | ⬜ |
| 9 | Feature Card | Composite | `template-parts/cards/feature-card.php` | ⬜ |
| 10 | Gallery Grid | Section | `template-parts/gallery/gallery-grid.php` | ⬜ |
| 11 | Project Card | Composite | `template-parts/cards/project-card.php` | ⬜ |
| 12 | Testimonials | Section | `template-parts/sections/testimonials.php` | ⬜ |
| 13 | Statistics / Trust Bar | Section | `template-parts/sections/stats.php` | ⬜ |
| 14 | FAQ (Accordion) | Composite | `template-parts/faq/faq.php` | ⬜ |
| 15 | Quote Form | Composite | `template-parts/forms/quote-form.php` | ⬜ |
| 16 | Contact Card | Composite | `template-parts/cards/contact-card.php` | ⬜ |
| 17 | Map | Composite | `template-parts/sections/map.php` | ⬜ |
| 18 | Breadcrumbs | Global | `template-parts/global/breadcrumbs.php` | ✅ |
| 19 | WhatsApp Button | Global | `template-parts/buttons/whatsapp.php` | 🟡 |
| 20 | Process / Steps | Section | `template-parts/sections/process.php` | ⬜ |
| 21 | Blog Card | Composite | `template-parts/cards/blog-card.php` | ⬜ |
| 22 | Pagination | Global | `template-parts/navigation/pagination.php` | 🟡 |
| 23 | 404 Hero | Section | (in `404.php`) | ✅ |
| 24 | Cookie Banner | Global | `template-parts/global/cookie-banner.php` | ⬜ |
| 25 | Newsletter | Section | `template-parts/forms/newsletter.php` | ⬜ |
| 26 | Section Heading | Primitive | `template-parts/sections/section-heading.php` | ⬜ |
| 27 | Social Links | Primitive | `template-parts/global/social-links.php` | ⬜ |
| 28 | Logo Strip / Accreditations | Section | `template-parts/sections/logos.php` | ⬜ |
| 29 | Mobile Nav (off-canvas) | Global | `template-parts/header/mobile-nav.php` | ✅ |
| 30 | Announcement Bar | Global | `template-parts/header/announcement-bar.php` | ✅ |

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

### 26. Section Heading ⬜
**Responsibility:** standardised eyebrow + heading + intro for sections, so every
section header looks identical. **Contract:** `eyebrow`, `title`, `level`
(h2/h3), `intro`, `align`. **A11y:** correct heading level per context.

---

## Composites & sections (planned)

### 6. Hero (Section) ⬜
**Responsibility:** above-the-fold headline, subcopy, primary + secondary CTA,
hero image/media; the page's LCP element. **Contract:** `heading`, `subheading`,
`cta_primary`, `cta_secondary`, `image_id`, `variant`. **Perf:** LCP image gets
`fetchpriority="high"`, explicit dimensions. **A11y:** single `<h1>` on home.

### 7. CTA Band (Section) ⬜
**Responsibility:** full-width "Get your free quote" conversion band, repeated
across pages. **Contract:** `heading`, `text`, `cta`, `background`. Uses Button.

### 8. Service Card (Composite) ⬜
**Responsibility:** summarise a service (Kitchens/Bedrooms) with icon, title,
blurb, link. **Contract:** `icon`, `title`, `excerpt`, `url`. Built on Card.

### 9. Feature Card (Composite) ⬜
**Responsibility:** highlight a benefit/USP (icon + short text) in feature grids.
**Contract:** `icon`, `title`, `text`.

### 10. Gallery Grid (Section) ⬜
**Responsibility:** responsive portfolio grid of Project Cards, with optional
Room-Type/Style filtering. **Contract:** query args (taxonomy, count, paged).
**Perf:** lazy images, `srcset`. **A11y:** filters as accessible controls;
grid is a list of links.

### 11. Project Card (Composite) ⬜
**Responsibility:** single portfolio item preview (image, title, room type).
**Contract:** `project` (post) → title, thumb, terms, permalink. Built on Card.

### 12. Testimonials (Section) ⬜
**Responsibility:** display client reviews to build trust. **Contract:** query of
`testimonial` CPT (name, quote, rating). **A11y:** if a slider, provide
keyboard controls, pause, and no motion for reduced-motion users. Consider
`Review`/`AggregateRating` schema (only for genuine, verifiable reviews).

### 13. Statistics / Trust Bar (Section) ⬜
**Responsibility:** headline numbers (years experience, projects completed, etc.)
and trust badges. **Contract:** repeater of `{value, label}`. **A11y:** count-up
animation is enhancement-only and respects reduced-motion.

### 14. FAQ / Accordion (Composite) ⬜
**Responsibility:** expandable Q&A; feeds `FAQPage` schema. **Contract:** query
of `faq` CPT or ACF repeater `{question, answer}`. **A11y:** button-controlled
disclosure, `aria-expanded`/`aria-controls`, keyboard operable; content in DOM
(not display-none-only for SEO/schema).

### 15. Quote Form (Composite) ⬜ — *conversion-critical*
**Responsibility:** the primary lead-capture form (see fields in
[CLIENT_REQUIREMENTS.md](CLIENT_REQUIREMENTS.md) §5). **Contract:** recipient,
success URL, source page. **Security:** nonce, honeypot, server-side sanitise +
validate, spam protection; store lead in DB **and** email. **A11y:** labelled
fields, `aria-invalid`/`aria-describedby` errors, no colour-only errors, clear
success state. **Perf:** no heavy third-party JS.

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
