# CLIENT_REQUIREMENTS.md — SPN Cabinets

Everything we currently know about the client's requirements. Where information
is not yet supplied, a **`⛳ PLACEHOLDER`** marks what we need to collect. Update
this file as the client provides detail.

---

## 1. Business details

| Field | Value |
|---|---|
| Business name | **SPN Cabinets** |
| Business type | **Bedroom & Kitchen Fitter** (fitted furniture / joinery) |
| Website type | **Lead Generation + Portfolio** |
| Legal/trading name | ⛳ PLACEHOLDER |
| Address / service area | ⛳ PLACEHOLDER (needed for local SEO + schema) |
| Phone number | ⛳ PLACEHOLDER |
| WhatsApp number | ⛳ PLACEHOLDER (for WhatsApp button) |
| Email address | ⛳ PLACEHOLDER (quote form recipient) |
| Opening hours | ⛳ PLACEHOLDER |
| Social profiles | ⛳ PLACEHOLDER (FB / Instagram / Houzz etc.) |
| Google Business Profile | ⛳ PLACEHOLDER |
| Company reg / VAT (if shown) | ⛳ PLACEHOLDER |

## 2. Website purpose

The website exists to:

1. **Generate leads** — quote requests, calls, WhatsApp messages.
2. **Portfolio** — showcase completed kitchens & bedrooms.
3. **Information** — explain services, process and coverage.
4. **Sales** — persuade and convert visitors into enquiries.

## 3. Required pages (confirmed)

| Page | Purpose | Primary CTA |
|---|---|---|
| **Home** | Overview, trust, showcase highlights, funnel to quote | Free Quote |
| **About** | Story, experience, credibility, team | Free Quote |
| **Services** | Bedrooms, kitchens (+ any sub-services) | Free Quote |
| **Gallery** | Portfolio of completed projects | Free Quote |
| **Contact** | Quote form, phone, WhatsApp, location | Submit / WhatsApp |

**Likely additional (recommended):** Privacy Policy, Cookie Policy, Terms,
Thank-You (post-submission), 404 (built). Blog/News optional for SEO later.
See [SITE_ARCHITECTURE.md](SITE_ARCHITECTURE.md).

## 4. Required features

| Feature | Requirement | Status / notes |
|---|---|---|
| **WhatsApp button** | Persistent click-to-chat (mobile priority) | Needs WhatsApp number ⛳ |
| **Free Quote form** | Accessible, spam-protected, emails + stores lead | Fields TBD (see §5) |
| **Admin panel** | Client-manageable content, gallery, enquiries | ACF-driven |
| **SEO friendly** | Titles, meta, schema, sitemap, local SEO | See [SEO_STRATEGY.md](SEO_STRATEGY.md) |
| **Responsive** | Mobile-first, all breakpoints | Core requirement |

## 5. Free Quote form — fields (proposed)

> Confirm with client. Keep it short to maximise conversions.

- Name *(required)*
- Phone *(required)*
- Email *(required)*
- Service interested in *(Kitchen / Bedroom / Both)*
- Postcode / location *(for service-area qualification)*
- Message / project details *(optional)*
- Consent checkbox *(GDPR — required)*
- Hidden: honeypot + nonce (anti-spam), source page.

⛳ PLACEHOLDER: confirm required fields, recipient email(s), and whether file/
photo upload is wanted.

## 6. Reference website

- **Primary reference:** <https://www.dianeberrykitchens.co.uk/>
  - Use for **inspiration on structure, tone and portfolio presentation** — not
    for copying design or content. Note: our build must be faster, more
    accessible and fully bespoke.
- ⛳ PLACEHOLDER: any additional references / "likes & dislikes" from the client.

## 7. Content & assets (supplied by client)

**All content and images will be supplied by the client.** Until then, use clear
placeholders and never invent business facts (services, guarantees, reviews).

| Asset | Needed for | Status |
|---|---|---|
| Logo (SVG + PNG) | Header, favicon, schema | ⛳ PLACEHOLDER |
| Brand colours | Design tokens | ⛳ PLACEHOLDER (do **not** choose yet) |
| Fonts / brand type | Typography | ⛳ PLACEHOLDER (system fonts until then) |
| Project photos | Gallery, hero, cards | ⛳ PLACEHOLDER (high-res, optimised) |
| Services copy | Services page | ⛳ PLACEHOLDER |
| About/story copy | About page | ⛳ PLACEHOLDER |
| Testimonials/reviews | Trust sections | ⛳ PLACEHOLDER |
| Certifications/guarantees | Trust badges | ⛳ PLACEHOLDER |
| Legal policies | Privacy/Cookie/Terms | ⛳ PLACEHOLDER |

## 8. Brand & tone

- ⛳ PLACEHOLDER: brand personality (e.g. premium / approachable / traditional /
  modern), tone of voice, tagline, and any existing brand guidelines.

## 9. Technical / hosting

| Item | Value |
|---|---|
| Environment (dev) | Local by Flywheel |
| Production host | ⛳ PLACEHOLDER |
| Domain | ⛳ PLACEHOLDER |
| Email/SMTP for form delivery | ⛳ PLACEHOLDER (recommend transactional SMTP) |
| Analytics | ⛳ PLACEHOLDER (GA4? consent required) |
| Existing site to migrate/redirect | ⛳ PLACEHOLDER |

## 10. Compliance

- **GDPR/UK-GDPR:** consent on the form, privacy policy, cookie consent banner
  if non-essential cookies are used, secure handling of enquiry data.
- ⛳ PLACEHOLDER: data-retention preferences, cookie/analytics scope.

## 11. Open questions for the client

1. Confirm phone, WhatsApp number and enquiry email.
2. Full service list and any sub-services / brands fitted.
3. Service area / towns covered (drives local SEO pages).
4. Do you want a blog now or later?
5. Quote-form fields + whether photo uploads are wanted.
6. Do you have brand colours/fonts/logo, or do we propose them?
7. Testimonials/reviews source (Google, Checkatrade, etc.).
8. Any accreditations, guarantees or finance options to feature?
