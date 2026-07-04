# SEO_STRATEGY.md — SPN Cabinets

A professional SEO strategy for a **local, service-based, lead-generation**
business. The overriding aim: rank for local "fitted kitchens / fitted bedrooms
+ \[area]" intent and convert that traffic into enquiries. Technical foundations
are built into the theme; content and local signals are ongoing.

> ⛳ Depends on client input: exact **service area/towns**, **NAP**, **keywords**,
> and **content**. Placeholders flagged throughout.

---

## 1. SEO principles

- **Local intent first** — most value is in "\[service] near me / in \[town]".
- **Topical authority** — cluster services + supporting content + portfolio.
- **Fast, accessible, crawlable** — good technical SEO is a ranking multiplier
  and directly aids conversion.
- **Genuine E-E-A-T** — real projects, real reviews, real credentials. Never
  fabricate testimonials, ratings or claims.

## 2. Technical SEO (built into the theme)

- **Performance/CWV** — Lighthouse ≥ 90 mobile; LCP < 2.5s, INP < 200ms,
  CLS < 0.1 (see [CLAUDE.md](CLAUDE.md) §10). Fast sites crawl and convert better.
- **Crawlability & indexation**
  - Clean, keyword-relevant URLs; permalinks = `/%postname%/`
    (see [SITE_ARCHITECTURE.md](SITE_ARCHITECTURE.md) §7).
  - **XML sitemap** (SEO plugin or core) submitted to Search Console.
  - **`robots.txt`** allows crawling of public content; blocks admin/utility.
  - Thin/utility archives (`testimonial`, `faq`, low-value tax terms) set to
    **`noindex`** to avoid index bloat.
  - Canonical URLs on every page; avoid duplicate content (params, pagination).
- **Mobile-first & responsive** — mandatory (Google is mobile-first indexing).
- **HTTPS** everywhere; HTTP→HTTPS and non-www/www redirects consolidated.
- **Structured semantic HTML** — landmarks, one `<h1>`, logical headings.
- **404 + redirects** — custom 404 (built); 301-map any legacy URLs on migration.
- **Core `title-tag`** support; no render-blocking bloat; deferred JS.
- **Search Console + analytics** connected at launch (consent-aware).

## 3. On-page SEO

For **every** indexable page:

- **Unique `<title>`** (~50–60 chars): primary keyword + brand, e.g.
  *"Fitted Kitchens in \[Town] | SPN Cabinets"*.
- **Unique meta description** (~150–160 chars) with a benefit + CTA.
- **One `<h1>`** containing the primary keyword; **H2/H3** for subtopics
  (natural, not stuffed).
- **Intent-matched content** — answer what the searcher wants (service, area,
  proof, price guidance, next step).
- **Internal links** to related services, relevant projects, and the quote page.
- **Descriptive URL slug**; **image alt text**; a clear **primary CTA**.
- **Open Graph / Twitter cards** for good social/link previews.

### Page-level keyword mapping (⛳ refine with client + research)

| Page | Primary intent (example) |
|---|---|
| Home | brand + "fitted kitchens & bedrooms \[area]" |
| Services | "kitchen & bedroom fitters \[area]" |
| Fitted Kitchens | "fitted kitchens \[area]" |
| Fitted Bedrooms | "fitted / built-in wardrobes \[area]" |
| Gallery | "kitchen & bedroom \[area] portfolio/examples" |
| Contact | brand + "free kitchen/bedroom quote \[area]" |

## 4. Local SEO (highest priority)

- **Google Business Profile** — claim, complete, categorise, add photos, collect
  reviews; keep NAP identical to the site. ⛳ needs client access.
- **Consistent NAP** in header/footer + `LocalBusiness` schema + contact page.
- **Service-area strategy** — if multiple towns are served, create **unique,
  genuinely differentiated** landing pages per key town (not doorway/thin
  duplicates). ⛳ confirm town list first.
- **Local citations** — consistent listings on relevant UK directories
  (Checkatrade, Houzz, Yell, etc.). ⛳ client to provide existing listings.
- **Reviews** — encourage Google reviews; surface genuine ones on-site.
- **Embed map / directions** on Contact (lazy-loaded for performance).

## 5. Structured data (schema.org)

Output valid JSON-LD (via SEO plugin where possible, custom where needed):

| Schema | Where | Notes |
|---|---|---|
| `LocalBusiness` (+ `HomeAndConstructionBusiness`) | Site-wide/Contact | NAP, hours, geo, areaServed, sameAs |
| `WebSite` + `Organization` | Site-wide | Brand, logo, social profiles |
| `BreadcrumbList` | All non-home | Matches breadcrumbs component |
| `Service` | Service pages | Service type + provider |
| `ImageObject` / `CreativeWork` | Projects/gallery | Portfolio items |
| `FAQPage` | FAQ sections | Only for genuinely on-page Q&A |
| `Review` / `AggregateRating` | Testimonials | **Only** real, verifiable reviews |

- Validate with the Rich Results Test; never mark up content not visible on the
  page; never fake ratings.

## 6. Internal linking

- **Hub-and-spoke:** Services (hub) ↔ individual service pages ↔ related projects
  ↔ quote CTA.
- Every project links back to its **service** and to the **gallery**.
- Contextual links in body copy with **descriptive anchor text** (not "click
  here").
- Sitewide CTA band + nav ensure the **quote page** is always ≤ 1 click away.
- Keep important pages **shallow** (≤ 2 clicks from home).

## 7. Image optimisation

- **Modern formats** (WebP/AVIF), correctly sized, compressed; never ship raw
  camera uploads.
- Always set `width`/`height` (prevent CLS); `loading="lazy"` below the fold;
  `fetchpriority="high"` on the LCP image; responsive `srcset`/`sizes`.
- **Descriptive, keyworded (naturally) alt text** and sensible file names
  (`shaker-kitchen-oakwood.webp`, not `IMG_1234.jpg`).
- Serve appropriately scaled thumbnails via registered image sizes.

## 8. Heading hierarchy

- Exactly **one `<h1>`** per page (the page's main topic).
- Logical, sequential H2 → H3 (don't skip levels; restyle instead of mis-leveling).
- Section headings via the **Section Heading** component for consistency.
- Headings describe content and include relevant terms naturally.

## 9. Meta strategy

- Managed centrally via the SEO plugin (Yoast/Rank Math) with **per-page
  overrides**; sensible **templated defaults** (e.g. `%title% | SPN Cabinets`).
- CPT/taxonomy title & description templates configured.
- OG/Twitter defaults set; per-page featured image used as social image.
- Avoid duplicate titles/descriptions across pages.

## 10. Blog / content strategy (phase 2)

Optional but recommended to build topical authority and capture research-stage
traffic:

- Target **informational** queries that precede a purchase, e.g. *"how much does
  a fitted kitchen cost in \[area]"*, *"fitted wardrobe ideas"*, *"kitchen design
  process"*.
- Each post: single intent, helpful, internally links to the relevant service +
  quote CTA, includes real project imagery.
- Cadence over volume — a few strong pieces beat many thin ones.
- Use posts to support service clusters (topical relevance), not as isolated SEO
  bait.

## 11. Keyword clustering

Organise keywords into **clusters** mapped to pages (avoids cannibalisation):

```
Cluster: Fitted Kitchens
  head:      fitted kitchens [area]
  variants:  bespoke/handmade kitchens, kitchen fitters [area]
  long-tail: shaker/handleless kitchen [area], small kitchen ideas
  → maps to: /services/fitted-kitchens/ (+ supporting blog posts)

Cluster: Fitted Bedrooms
  head:      fitted bedrooms / built-in wardrobes [area]
  variants:  sliding wardrobes, bedroom furniture fitters
  long-tail: fitted wardrobe ideas, loft/alcove wardrobes
  → maps to: /services/fitted-bedrooms/

Cluster: Local / brand
  → home, contact, GBP, citations

Cluster: Portfolio / inspiration
  → gallery, projects, "ideas" content
```

- **One primary keyword per page**; supporting terms as H2/H3 and in copy.
- ⛳ Populate real clusters after keyword research (volumes, difficulty, intent).

## 12. Measurement & iteration

- **Tools:** Google Search Console + GA4 (consent-aware) + Business Profile
  insights; optional rank tracking.
- **KPIs:** local pack visibility, organic impressions/clicks for target
  clusters, CWV pass rate, and — most importantly — **enquiries** (form + calls +
  WhatsApp).
- Review quarterly: refine titles/meta, add content for gaps, prune/merge thin
  pages, expand winning clusters.

## 13. SEO definition-of-done (per page)

- [ ] Unique title + meta description
- [ ] One H1, logical heading order
- [ ] Intent-matched content + clear CTA
- [ ] Internal links in + out (incl. quote CTA)
- [ ] Optimised images with alt text
- [ ] Schema present + validated
- [ ] Canonical correct; indexation intended
- [ ] Passes Lighthouse/CWV + accessibility checks
