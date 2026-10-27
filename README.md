# Clarke's Court – Grenada Distillers

Website and back office for Grenada Distillers Ltd, makers of Clarke's Court rum at Woodlands, St George, Grenada (distilling on the site since 1937). The company's own site, clarkescourtrum.com, has served a "Temporarily Disabled" host page since about 2024, so the national rum has nowhere for tour bookings, export enquiries or job applications to land. This is the proposed replacement.

## What it does

- **Public site.** An age check first (18+, the legal drinking age in Grenada; a server-side redirect, so it works without JavaScript), then home, the rum range with a page per rum, heritage with a sourced timeline, distillery tours, trade and export, careers with a page per vacancy, contact and directions, privacy notice, photo credits and a site map. Mobile-first, light and dark themes, 17px body text, 48px buttons, and every page and form works without JavaScript. Addresses from the old site (`/products/aged/clarke-s-court-grog-rum`, `/about-us`, `/factorytour.aspx` and the rest) redirect with a 301.
- **Rum pages show only sourced facts.** Every name, strength and tasting note comes from the distillery's own archived product pages, and each page links its sources. Where the old site gave no ABV or notes, the page says so instead of guessing. No awards, prices or sizes are shown on product pages (a test checks).
- **Four request flows, each with a reference number and an email confirmation.**
  - Tour booking (`TB-26-00042`): pick a day and time from a week-by-week grid that shows the places left on every tour. Capacity is counted in guests per tour (Settings), claimed under a lock so two parties can't take the last places, and cancelled bookings free their places. Public holidays are closed. Under-18s can come but don't taste.
  - Trade and export enquiry (`TE-…`): company, country, type of business, markets, rums of interest, first-order size and licence status.
  - Job application (`JA-…`): a vacancy or a general application, parish, experience, qualification and a CV upload (PDF or Word, 5 MB) to the private disk, kept for the next try if something else on the form needs fixing, with an explicit 12-month consent.
  - Contact message (`EN-…`) with a topic.
- **Back office** at `/admin`, with four roles:
  - **Admin**: everything, including staff and settings.
  - **Tours**: tour bookings and general enquiries, plus the tour calendar.
  - **Trade**: trade enquiries and general enquiries.
  - **HR**: job applications and vacancies only. Only HR and admins can open CVs, and every opening is logged on the application's timeline.

  The dashboard leads with one number: requests nobody has answered for more than a working day. Below it are tiles (new requests vs the week before, median time to first reply, guests booked in the next 7 days, guests on today's tours against places, open trade enquiries and countries, applications to review), requests per day, a breakdown by type, a "reply next" queue and the next three days of tours. The inbox has filters (type, status, assignee, overdue), search (press `/`) and CSV export. Each request has statuses for its type (a tour goes new → confirmed → attended / no-show / cancelled; trade goes new → contacted → qualified → samples → signed / declined; an application goes new → reviewing → interview → offered → hired / declined), an assignee, a notes timeline and one-tap email, call or WhatsApp. There is a month tour calendar with a printable day sheet, vacancy management (a vacancy with applicants is closed, never deleted), staff management and settings.

## Requirements

PHP 8.3 or 8.4, Composer 2, Node 20+ for building assets, and SQLite locally or MySQL in production.

## Local setup

```sh
composer install
cp .env.example .env && php artisan key:generate
php artisan migrate --seeder=DemoSeeder   # demo staff, 3 sample vacancies, ~200 requests over six weeks
npm install && npm run build
php artisan serve --port=8106
```

Demo logins all use the password `password`: `admin@clarkescourt.test`, `tours@clarkescourt.test`, `trade@clarkescourt.test` and `hr@clarkescourt.test`. Every demo vacancy is marked "Sample" and every demo request carries `details.demo`. The vacancy titles and duties follow vacancies Grenada Distillers advertised on NOW Grenada; the people, companies and numbers are made up. `DatabaseSeeder` only creates the first administrator from `ADMIN_*` in `.env`.

## Checks

```sh
php artisan test                 # feature tests for every flow, role, policy and tour capacity under the lock
vendor/bin/phpstan analyse       # Larastan level 6, analysed as PHP 8.3
vendor/bin/pint --test
node scripts/qa/crawl.mjs http://127.0.0.1:8106   # every page as every role, plus one of each form
node scripts/qa/shots.mjs                          # phone and desktop screenshots, light and dark, overflow check
```

## Deploying

See [INSTALL-HOSTINGER.md](INSTALL-HOSTINGER.md). `scripts/package-hostinger.sh` builds `dist/grenada-distillers-hostinger.zip`, which extracts straight into `public_html/`, with the app in `gdl-app/`. `npm run proposal` (dev server on 8106 with demo data) builds the client proposal PDF in `dist/proposal/`.

## Before launch: confirm with the client

Everything below came from public sources and has not been confirmed by Grenada Distillers.

- **Contact details.** The phone, (473) 444-5363, is the tours and office number on the archived site (2006–2014). The email shown, `assistsect@clarkescourtrum.com`, is the address on every GDL vacancy notice on NOW Grenada (2024–25); a general `info@` mailbox is better for the public site (`GDL_EMAIL`). `gm@clarkescourtrum.com` appears in a 2021 press release. No WhatsApp number is published (`GDL_WHATSAPP`). The Facebook (`clarkes.court`) and Instagram (`clarkescourtrum`) links are from the 2014–15 site; the 2016 and 2019 pages link `facebook.com/grenadadistillers` and `instagram.com/grenadadistillers` instead. Ask which accounts are live.
- **New-request emails.** Each type goes to its team inbox when set (`GDL_NOTIFY_TOURS`, `GDL_NOTIFY_TRADE`, `GDL_NOTIFY_HR`), otherwise to `GDL_NOTIFY_EMAIL`. Set `GDL_NOTIFY_HR`, or job applications go to the general list.
- **Hours and tours.** Office and factory hours (8am to 4pm, Monday to Friday) and the tour description (about fifteen minutes in the factory, steam engines from as early as 1886, then a tasting at the Hospitality Centre) come from the archived site. The four daily start times, 20 guests per tour and the online party limit of 12 are proposals. Tours were also offered to groups at weekends; that goes through the contact form for now.
- **Public holidays** in `gdl.closed_dates`, for the tour calendar.
- **Legal age.** The age check uses 18, the age most sources give for Grenada. A 2018 NOW Grenada article says the 1911 Liquor Act sets 16, and the company's own 2023 site asked visitors to confirm 21+. Confirm which age the company wants (`gdl.legal_age`).
- **Service promises** are proposals: trade replies "usually within two working days" and "a named person who follows it up", and keeping applications for 12 months (also in the privacy notice).
- **The range.** The thirteen rums in `config/gdl.php` are the ones on the archived product pages (2014–2019). Ask which are still made, and for ABV and notes for Old Grog Extra Old, #37, Passion Fruit, Rhythm Coconut, Mojito and Camerhogne. The 2021 press release mentions 21 spirits and three new cream and coffee liqueurs that are not listed. Bottle sizes are shown only where the source gave one (Black Gold, 750 ml). Serving suggestions appear only where the product page gave one (Black Gold, Pure White, Rum Lemon, Camerhogne).
- **Awards.** The old product pages list medals (Old Grog: World Spirits Awards gold 2006, San Francisco World Spirits Competition bronze 2005, Beverage Testing Institute gold 2003) and company news reports "Distillery of the Year (Gold)" in the rum category at the World Spirits Award in 2020 and 2021 (2021 from Wee FM); NOW Grenada also reports Distillery of the Year Bronze in 2017 and the title again in 2018. Only the 2020/2021 line appears, on the heritage timeline, with its sources. Confirm before adding any medal to a product page.
- **Heritage.** The 1670s, 1763, 1824 and 1937 entries come from the company's own "Our story" page; the 1771 inventory and the 1795 uprising from research by Dr S. D. Smith (University of York) published on the 2003 site; 1877 from the sale particulars in the Library of Congress. The two sources disagree on dates ("Our story" has Gedney Clarke buying land from 1763 to about 1801 and 780 acres; Dr Smith has the estate surrendered to the Lascelles in 1773, sold in 1791, and 800 acres), so the site says only "from 1763". Ask the company to review the wording on enslaved labour and the 1795 uprising.
- **People.** No staff are named on the site. The 2016 product page credits the Black Gold concept to the chairman (Leroy Neckles in the sources, chairman and CEO in 2010); the site says "the chairman of the board". Fred Antoine was General Manager in 2010; a later GM (Lester Andall, about 2017) could not be confirmed. The September 2026 Sales and Marketing Manager vacancy was handled by J's HR Consultancy.
- **ISO 22000** certification in 2017 (re-certified to ISO 22000:2005 in July 2020) is from company news. The 2005 edition was withdrawn in 2021, so the site does not say it is current; confirm.
- **UK launch.** clarkescourt.com is a UK holding page ("Grenada's Clarke's Court is coming to the UK trade. We're building this brochure with Webwight."). Agree how this site and the UK trade site link to each other.
- **Photos.** The hero, range, bottle, heritage and launch photos are the company's own, recovered from the archived site at low resolution; ask for originals and a Black Gold bottle shot (the nutmeg photo stands in). The barrel warehouse (Foursquare, Barbados), column still and steam engine are generic Wikimedia Commons stand-ins, credited and flagged on `/photo-credits`. The home page pairs the stand-in engine with "steam engines from as early as 1886", so replace that one first. Replace them with photography of Woodlands.
- **Logo.** The wordmark is typographic. Ask for the Clarke's Court logo artwork as a vector.
- **Privacy notice** is a draft for the company's legal adviser, including the retention periods.
