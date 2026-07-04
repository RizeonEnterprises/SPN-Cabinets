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

## 3. Recommended custom post types (CPTs)

Registered in code (`inc/cpt/` module), not a plugin, following prefix rules.

| CPT | Slug | Purpose | Public archive? |
|---|---|---|---|
| **Project** | `project` | Portfolio items (completed kitchens/bedrooms) | Yes → `/gallery/` |
| **Service** | `service` | Structured service entries (optional; pages may suffice) | Optional |
| **Testimonial** | `testimonial` | Client reviews for trust sections | No (used via query) |
| **FAQ** | `faq` | Reusable Q&A for FAQ component + schema | No (used via query) |

**Notes**
- Start with **`project`** (essential for the gallery). Add others as needed.
- `project` supports: title, editor, excerpt, featured image, **gallery (ACF)**,
  and taxonomy terms below.
- Set the `project` archive slug to **`gallery`** (or map the Gallery page to the
  archive) so URLs read `/gallery/` and `/project/{slug}/`.
- `testimonial` and `faq` are "utility" CPTs — not individually indexed; surfaced
  through components. Consider `exclude_from_search` + `noindex` on singles.

## 4. Recommended taxonomies

| Taxonomy | Attached to | Terms (examples) | Purpose |
|---|---|---|---|
| **Room Type** (`room-type`) | `project` | Kitchen, Bedroom, Home Office, Media Wall | Filter/segment the gallery; SEO clusters |
| **Style** (`project-style`) | `project` | Modern, Traditional, Shaker, Handleless, Gloss | Faceted browsing (phase 2) |
| **Location** (`project-location`) | `project` | \[towns covered] | Local SEO signals (optional) |
| **Service Category** (`service-cat`) | `service` | Kitchens, Bedrooms | Group services if CPT used |

- Keep taxonomies **hierarchical where it aids IA** (Room Type), flat where
  tag-like (Style).
- Archive templates for `room-type` become natural landing pages (e.g.
  `/room-type/kitchen/`) — decide indexation per [SEO_STRATEGY.md](SEO_STRATEGY.md)
  to avoid thin/duplicate pages.

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
| Gallery archive | `/gallery/` | `/gallery/` |
| Project single | `/project/{project-slug}/` | `/project/oakwood-shaker-kitchen/` |
| Room-type archive | `/room-type/{term}/` | `/room-type/kitchen/` |
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
