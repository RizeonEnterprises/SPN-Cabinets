# SITE_ARCHITECTURE.md — SPN Cabinets

The complete information architecture (IA) for the site, designed around SEO
best practice, clear user journeys and the primary goal: **enquiries**.

---

## 1. Guiding principles

- **Shallow, logical hierarchy** — every key page reachable in ≤ 2 clicks.
- **Conversion on every page** — Free Quote + WhatsApp always accessible.
- **Topical clustering for SEO** — service pages link to relevant portfolio and
  supporting content (see [SEO_STRATEGY.md](SEO_STRATEGY.md)).
- **Clean, descriptive URLs** — human-readable, keyword-relevant, stable.
- **Content managed, not hard-coded** — CPTs + ACF power dynamic sections.

## 2. Page hierarchy (sitemap)

```
Home (/)
├── About (/about/)
├── Services (/services/)
│   ├── Fitted Kitchens (/services/fitted-kitchens/)
│   └── Fitted Bedrooms (/services/fitted-bedrooms/)
│       └── (future sub-services: home offices, media walls, etc.)
├── Gallery (/gallery/)
│   └── Project single (/project/{project-slug}/)
├── Contact (/contact/)
│   └── Thank You (/contact/thank-you/)   ← post-submission
├── Blog (/blog/)                          ← optional, phase 2 (SEO)
│   └── Post single (/blog/{post-slug}/)
└── Legal
    ├── Privacy Policy (/privacy-policy/)
    ├── Cookie Policy (/cookie-policy/)
    └── Terms (/terms/)
```

> **Service-area pages** (e.g. `/fitted-kitchens-{town}/`) may be added later for
> local SEO once coverage is confirmed — see [SEO_STRATEGY.md](SEO_STRATEGY.md).

## 3. Custom post types (CPTs)

Registered in code (`inc/post-types.php`), not a plugin, following prefix rules.

| CPT | Key | Purpose | Public archive? | Status |
|---|---|---|---|---|
| **Project** | `spn_project` | Portfolio items (completed kitchens/bedrooms) | Yes → `/portfolio/` | ✅ **Registered (Phase 2)** |
| **Service** | `spn_service` | Structured service entries (optional; pages may suffice) | Optional | ⬜ future |
| **Testimonial** | `spn_testimonial` | Client reviews for trust sections | No (used via query) | ⬜ future |
| **FAQ** | `spn_faq` | Reusable Q&A for FAQ component + schema | No (used via query) | ⬜ future |

**`spn_project` (registered)** — `public: true`, `show_in_rest: true`,
`has_archive: 'portfolio'`, `rewrite: {slug: 'project'}` → **archive `/portfolio/`,
singles `/project/{slug}/`**. Supports: `title`, `editor`, `thumbnail`, `excerpt`,
`revisions`. Menu icon `dashicons-portfolio`. Rewrite rules flushed on
`after_switch_theme` (no per-request flush). Gallery/spec fields come later via ACF.

**Notes**
- Future utility CPTs (`spn_testimonial`, `spn_faq`) are surfaced through
  components, not individually indexed — consider `exclude_from_search` +
  `noindex` on singles when added.

## 4. Taxonomies

| Taxonomy | Key | Attached to | Terms (examples) | Status |
|---|---|---|---|---|
| **Project Category** | `spn_project_category` | `spn_project` | Kitchens, Bedrooms, Home Offices, Media Walls | ✅ **Registered (Phase 2)** |
| **Style** | `spn_project_style` | `spn_project` | Modern, Traditional, Shaker, Handleless, Gloss | ⬜ future / optional |
| **Location** | `spn_project_location` | `spn_project` | \[towns covered] | ⬜ future / optional |

**`spn_project_category` (registered)** — `hierarchical: true` (category-like),
`public: true`, `show_in_rest: true`, `show_admin_column: true`,
`rewrite: {slug: 'project-category'}` → term pages at
**`/project-category/{term}/`**.

- Archive templates for `project-category` become natural landing pages — decide
  indexation per [SEO_STRATEGY.md](SEO_STRATEGY.md) to avoid thin/duplicate pages.
- Add the optional taxonomies later only if faceted filtering / local pages need
  them.

## 5. Navigation

### Primary menu (`primary` — already registered)
```
Home · About · Services (▾ Fitted Kitchens, Fitted Bedrooms) · Gallery · Contact
[ Free Quote — button-styled CTA, right-aligned ]
```
- Keep to **5–6 top items** + a visually distinct **Free Quote** CTA.
- Sticky header on scroll (accessible, respects reduced-motion) — phase: header.
- Mobile: accessible toggle + submenu buttons (already built into the nav walker).

### Utility / secondary
- Phone number + WhatsApp visible in the header (click-to-call on mobile).

### Footer menu (`footer` — already registered)
See §6.

### Breadcrumbs
- Enable on all non-home pages (`BreadcrumbList` schema) for orientation + SEO.

## 6. Footer layout (recommended)

A structured, multi-column footer (stacks on mobile):

```
┌──────────────────────────────────────────────────────────────┐
│ Col 1: Brand      │ Col 2: Quick   │ Col 3: Services │ Col 4: │
│  logo + short     │  links (About, │  (Kitchens,     │ Contact│
│  trust statement  │  Gallery,      │  Bedrooms)      │  NAP + │
│                   │  Contact)      │                 │  hours │
│                   │  = Footer menu │                 │  + WA  │
├──────────────────────────────────────────────────────────────┤
│  © {year} SPN Cabinets · Privacy · Cookies · Terms   (legal)  │
└──────────────────────────────────────────────────────────────┘
```

- **Col 4 (Contact)** carries consistent **NAP** (Name/Address/Phone) for local
  SEO, plus WhatsApp and opening hours.
- Legal links in a slim sub-bar. Social icons if provided.
- Optional newsletter signup (phase 2).

## 7. URL structure

**Principles:** lowercase, hyphenated, keyword-relevant, no dates on evergreen
pages, no stop-words bloat, stable (set up redirects if anything changes).

| Content | Pattern | Example |
|---|---|---|
| Pages | `/{page-slug}/` | `/about/`, `/services/` |
| Service children | `/services/{service}/` | `/services/fitted-kitchens/` |
| Project archive (`spn_project`) | `/portfolio/` | `/portfolio/` |
| Project single | `/project/{project-slug}/` | `/project/oakwood-shaker-kitchen/` |
| Project category | `/project-category/{term}/` | `/project-category/kitchens/` |
| Blog (optional) | `/blog/`, `/blog/{post}/` | `/blog/planning-your-kitchen/` |

- **Permalinks:** set to *Post name* (`/%postname%/`).
- Avoid deep nesting beyond 2 levels. Keep project slugs descriptive (place +
  style) for SEO, e.g. `oakwood-handleless-kitchen`.

## 8. Reusable sections (page composition)

Pages are assembled from **reusable, ACF-driven sections** (no page builder).
The homepage and service pages share a common section vocabulary:

| Section | Used on | Sourced from |
|---|---|---|
| Hero (headline + CTA + image) | Home, Services, About | ACF fields |
| Intro / value proposition | Home, Services | ACF |
| Services overview (cards) | Home | `service` CPT / ACF |
| Portfolio highlights (grid) | Home, Services | `project` CPT query |
| Process / "How it works" (steps) | Home, Services, About | ACF repeater |
| Trust bar (stats / badges) | Home, About | ACF |
| Testimonials | Home, About, Services | `testimonial` CPT |
| FAQ | Services, Contact | `faq` CPT (+ FAQ schema) |
| CTA band (Free Quote) | All | ACF / global |
| Contact / map | Contact | ACF + `LocalBusiness` schema |

- Homepage sections should be **reorderable** via ACF **flexible content** so the
  client controls order without code.
- Every section is a **template part** built to the component contract in
  [COMPONENT_LIBRARY.md](COMPONENT_LIBRARY.md).

## 9. Content model summary

```
Page (WP core)
  └─ ACF flexible-content sections (compose the page)

Project (CPT)
  ├─ ACF: gallery images, location, summary, spec
  └─ Taxonomies: Room Type, Style, Location

Testimonial (CPT) → name, quote, rating, project link
FAQ (CPT)         → question, answer  (feeds FAQPage schema)
Service (CPT/opt) → title, summary, icon, linked projects
```

## 10. Open architecture decisions

- **Gallery = `project` archive vs. a static Gallery page** that queries
  projects. *Recommendation:* map **Gallery page → project archive** so the URL
  is `/gallery/` and it paginates naturally.
- **Services as pages vs. CPT.** *Recommendation:* **pages** (few, content-rich,
  SEO landing pages) unless the client needs many structured services → then CPT.
- **Room-type archive indexation** — index only if pages carry unique content;
  otherwise `noindex` to avoid thin pages.
- ⛳ Confirm town/service-area list before building local pages.
