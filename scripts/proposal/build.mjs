// Builds the client proposal (letter-size PDF) from the captured screenshots, in the site's own
// molasses-and-amber palette and fonts. Usage: npm run proposal  (capture first; this step only needs Chrome)
import puppeteer from 'puppeteer-core';
import fs from 'node:fs';
import path from 'node:path';

const CHROME = process.env.CHROME_PATH ?? '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
const SHOTS = path.resolve('dist/proposal/shots');
const chunks = JSON.parse(fs.readFileSync(path.join(SHOTS, 'chunks.json'), 'utf8'));
const OUT_HTML = path.resolve('dist/proposal/proposal.html');
const OUT_PDF = path.resolve('dist/proposal/Grenada-Distillers-Website-Proposal.pdf');
const DATE = new Date().toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
const TITLE = "Clarke's Court – Website Proposal for Grenada Distillers";
const img = (f) => 'file://' + f;
const esc = (s) => String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');

// Self-hosted site fonts (built by Vite into public/build/assets).
const ASSETS = path.resolve('public/build/assets');
const font = (prefix) => {
  const f = fs.readdirSync(ASSETS).find((n) => n.startsWith(prefix) && n.endsWith('.woff2'));
  if (!f) throw new Error(`Font ${prefix} not found: run npm run build first`);
  return 'file://' + path.join(ASSETS, f);
};
const FONTS = [
  ['DM Serif Display', 400, 'normal', 'dm-serif-display-400-normal'], ['DM Serif Display', 400, 'italic', 'dm-serif-display-400-italic'],
  ['Source Sans 3', 400, 'normal', 'source-sans-3-400-normal'], ['Source Sans 3', 600, 'normal', 'source-sans-3-600-normal'],
  ['Source Sans 3', 700, 'normal', 'source-sans-3-700-normal'], ['Source Sans 3', 400, 'italic', 'source-sans-3-400-italic'],
].map(([fam, w, st, p]) => `@font-face { font-family: '${fam}'; font-weight: ${w}; font-style: ${st}; src: url('${font(p)}') format('woff2'); }`).join('\n');

// The site's typographic wordmark (resources/views/components/logo.blade.php).
const WORDMARK = (light) => `<div class="brand"><span class="bn" style="color:${light ? '#fff' : 'var(--ink)'}">Clarke's Court</span><span class="bs" style="color:${light ? 'rgba(255,255,255,.75)' : 'var(--ink-3)'};border-color:${light ? 'rgba(217,154,61,.7)' : 'var(--cask)'}">Grenada Distillers · 1937</span></div>`;
// The barrel-hoop band that runs along the foot of every page header on the site.
const HOOPS = 'linear-gradient(180deg, #2a1d13 0 4px, #8d6a45 4px 5px, transparent 5px calc(100% - 5px), #8d6a45 calc(100% - 5px) calc(100% - 4px), #2a1d13 calc(100% - 4px)), repeating-linear-gradient(90deg, #7a4a22 0 46px, #5d3818 46px 48px, #8a5a2e 48px 92px, #5d3818 92px 94px)';
const RIBBON = 'linear-gradient(90deg, #ce1126 0 33.3%, #fcd116 33.3% 66.6%, #007a5e 66.6%)';

/** Hand-written captions per slice (key = screen name, index = slice number). */
const CAPTIONS = {
  age: ['The age check every first-time visitor sees (18+, Grenada’s legal drinking age). It is a server-side check, so it works without JavaScript; “Remember me” keeps the answer for 30 days, and the visitor lands on the page they asked for.'],
  home: [
    'Hero on the distillery’s own photograph of the range, then three doors for the three things the old site had nowhere to send: book a tour (with the next date that has places), trade and export, and careers (with the live vacancy count).',
    'The shelf: four of the thirteen rums with their strength on a proof seal, then the heritage band on Clarke’s Court Bay, the bay the rum is named after.',
    'Tours teaser with the next tour day and its places, and the export band for importers, distributors and duty-free buyers.',
    'The footer: office hours, address and directions, the main links, and the responsible-drinking line.',
  ],
  rums: [
    'The range header, on the distillery’s own photograph of the bottles, with jump links to the three families.',
    'Aged and dark rums. Every name and strength comes from the archived clarkescourtrum.com product pages; the bottle shots are the company’s own.',
    'White and overproof rums, including Pure White at 69% ABV.',
    'Flavoured rums and liqueurs.',
    'A prompt for buyers that leads to the trade enquiry.',
  ],
  rum: [
    'A rum page: the story and tasting notes in the distillery’s own words, a spec sheet, a serving suggestion where the distillery gave one, and the archived source it came from. No awards, prices or sizes are shown unless the distillery confirms them.',
    'More from the same family, to keep visitors browsing.',
  ],
  heritage: [
    'The story of the name, from Court Bay to the distillery of 1937, written from the company’s own history pages, beside the 1877 sale particulars for the estate.',
    'A dated timeline from the 1670s to 2020, written plainly about the enslaved people who worked the estate. Every entry links its source.',
    'The last entries, the company’s archive photographs of the mill, and an invitation to visit.',
  ],
  tours: [
    'What the tour covers, in the order a visitor sees it, taken from the distillery’s own tour description, with the practical facts beside it.',
    'Booking starts here, on the same page.',
    'A week-by-week grid with the places left on every tour, beside the party, access needs and contact details. Places are counted in guests and claimed under a lock, so two parties can never take the last places. The visitor gets a reference number on screen and by email.',
  ],
  trade: [
    'Trade and export: what buyers need to know, including ISO 22000 certification and the UK launch.',
    'The enquiry: what happens next, then the company, country, type of business and markets.',
    'The rums of interest, first-order size, licence status and who to reply to. The export team gets it with a reference number.',
  ],
  careers: [
    'Open vacancies, closing soonest first. The three postings are samples based on vacancies Grenada Distillers advertised on NOW Grenada.',
    'How applying works, on the company’s own photograph of its team.',
  ],
  job: ['A vacancy page with duties and requirements, an Apply button, and Google for Jobs structured data. Sample posting.'],
  apply: [
    'The application header, with the chosen vacancy named.',
    'The form: vacancy, contact details, parish, experience, qualification, a CV upload (PDF or Word, up to 5 MB) and consent to keep it for 12 months. CVs are stored outside the public website.',
  ],
  contact: [
    'Contact header on Clarke’s Court Bay.',
    'The fastest route to the right team, the email and telephone, office hours, directions to Woodlands and a message form.',
  ],
  'admin-login': ['Staff sign-in. Each person has their own account and role; switched-off accounts are refused and signed out.'],
  'admin-dashboard': [
    'The administrator’s overview leads with the one number to act on: requests that have waited more than a working day for a reply. Then the week’s requests, the median time to first reply, tour guests, trade enquiries and applications. Demo data.',
    'Requests per day and by type, the “reply next” queue and the next three days of tours.',
  ],
  'admin-inbox': ['One inbox for every request, filtered by type, status, assignee or overdue, with search by name, company, country, phone or reference, and CSV export. Demo requests.', 'The rest of the page, with paging.'],
  'tours-dashboard': ['The tours team’s overview: the same headline, scoped to tour bookings and general enquiries only. Demo data.'],
  'tour-request': ['A tour booking: the slot, the party, access needs, one-tap email, call or WhatsApp, the status (confirmed, attended, no-show, cancelled), the assignee and a notes timeline. Cancelling frees the places. Demo booking.'],
  'tour-calendar': ['The month calendar: guests booked against places each day, and a printable day sheet per tour for the guides. Demo bookings.'],
  'trade-request': ['A trade enquiry as the export team sees it: company, country, markets, rums of interest, order size and licence, with a pipeline from contacted to samples to signed. Demo enquiry.'],
  'hr-application': ['A job application as HR sees it. Only HR and administrators can open the CV, and every opening is recorded on the timeline. The tours and trade teams cannot see applications at all. Demo applicant and sample CV.'],
  'hr-vacancies': ['HR publishes, edits and closes vacancies. A vacancy with applicants is closed, never deleted. Sample postings.'],
  'admin-users': ['Staff accounts with four roles: administrator, tours, trade and HR.'],
  'admin-settings': ['Guests per tour and the largest party that can book online, changed without a developer.'],
};

const SECTIONS = [
  { id: 'public', eyebrow: 'Part 1', title: 'The public website', intro: 'A modern, phone-first home for Clarke’s Court on clarkescourtrum.com. Every fact on it comes from the distillery’s own archived pages, its published vacancies or a cited source, and each rum page links where its facts came from.', screens: [
    ['age', 'Age check', ['Shown once, before anything else; legal pages and the sitemap stay reachable for search engines.']],
    ['home', 'Home page', ['Tours, trade and careers are the first three things a visitor sees.', 'The distillery’s own photographs where they exist; credited Wikimedia Commons images elsewhere, to be replaced.']],
    ['rums', 'The rum range', ['Thirteen rums from the archived product pages, in the distillery’s own families.']],
    ['rum', 'A rum page', ['Sourced facts only, with the source linked on the page.']],
    ['heritage', 'Heritage', ['The estate’s history and the distillery since 1937, each milestone with its source.']],
    ['tours', 'Distillery tours', ['Online booking with live places per tour, a reference number and an email confirmation.']],
    ['trade', 'Trade & export', ['A proper landing place for importers, distributors and duty-free buyers.']],
    ['careers', 'Careers', ['Vacancies published by HR from the back office.']],
    ['job', 'Vacancy page', ['Search-engine ready job pages.']],
    ['apply', 'Job application', ['CV upload to private storage, seen only by HR.']],
    ['contact', 'Contact & directions', ['Each kind of request routed to the team that handles it.']],
  ]},
  { id: 'admin', eyebrow: 'Part 2', title: 'The staff back office', intro: 'One private back office with four roles. The tours team works bookings and the calendar; the trade team works export enquiries; HR works applications and vacancies; administrators see everything and manage staff and settings. Each person sees only the requests that are theirs to answer.', screens: [
    ['admin-login', 'Staff sign-in', ['Individual accounts, rate-limited sign-in.']],
    ['admin-dashboard', 'Administrator: overview', ['Leads with requests waiting more than a working day.']],
    ['admin-inbox', 'Administrator: requests inbox', ['Every request in one place, filtered and searchable.']],
    ['tours-dashboard', 'Tours: overview', ['Scoped to the tours team’s own requests.']],
    ['tour-request', 'Tours: a booking', ['Confirm, record attendance or cancel, and email the guest in one tap.']],
    ['tour-calendar', 'Tours: calendar and day sheet', ['Guests against places, per day and per tour.']],
    ['trade-request', 'Trade: an export enquiry', ['A simple pipeline for every buyer.']],
    ['hr-application', 'HR: an application', ['CVs open only for HR and administrators, and every opening is logged.']],
    ['hr-vacancies', 'HR: vacancies', ['Publish, edit or close.']],
    ['admin-users', 'Administrator: staff', ['Add staff and assign roles.']],
    ['admin-settings', 'Administrator: settings', ['Tour capacity and party size.']],
  ]},
];

const FEATURES = [
  ['Public website', ['Phone-first, light and dark themes', 'Age check that works without JavaScript', 'A page per rum, sourced facts only', 'Heritage timeline with sources', 'Tour booking with live places', 'Trade & export enquiries', 'Careers with CV upload', 'Redirects from the old site’s addresses', 'Sitemap and structured data for search']],
  ['Back office', ['Four roles: admin, tours, trade, HR', 'Headline: requests waiting over a day', 'One inbox with filters, search and CSV', 'Per-type statuses and notes', 'Tour calendar and printable day sheet', 'Vacancy publishing', 'CVs for HR only, every opening logged', 'Editable tour capacity']],
  ['Platform', ['Laravel 13 on PHP 8.3', 'Runs on standard shared hosting', 'Private file storage outside the web root', 'HTTPS, security headers, spam protection', '70 automated tests', 'Packaged installer and written guide']],
];

const PHONES = [
  [['m-home', 'Home'], ['m-rum', 'A rum page'], ['m-tours', 'Booking a tour']],
  [['m-apply', 'Applying for a job'], ['m-tours-dashboard', 'Overview (tours team)'], ['m-tour-request', 'A booking (tours team)']],
];

function caption(key, i, c) {
  const text = CAPTIONS[key]?.[i];
  if (!text) return '';
  const n = c.chunks.length > 1 ? `Part ${i + 1} of ${c.chunks.length} · ` : '';
  return `<figcaption class="cap">${esc(n)}${esc(text)}</figcaption>`;
}

// Screen pages are packed by measured height. Each section's slices are split into pages, in order, so
// that a page can hold slices from more than one screen (a slice that starts a new screen mid-page gets a
// small screen heading). A page may shrink its screenshots a little (to no less than 85% width) to take
// one more slice, such as a short tail. The split is chosen to avoid half-empty pages first, then to use
// as few pages as possible, then to shrink as little as possible.
const CONTENT_W = 7.4 * 96; // letter width minus the 0.55in side margins, in CSS px
const PAGE_H = 10 * 96; // .page height
const ITEM_GAP = 16; // .item + .item
const SAFETY = 6;
const MIN_SCALE = 0.85;
const HALF_EMPTY = 0.55; // a page whose content ends above 55% of its height reads as half empty

const headHtml = (sec, title, url, cont) => `<header class="shot-head"><div><p class="eyebrow">${esc(sec.title)}${cont ? ' · continued' : ''}</p><h2>${esc(title)}</h2></div><p class="url">${esc(url)}</p></header>`;
const subHtml = (title, url) => `<header class="sub-head"><h3>${esc(title)}</h3><p class="url">${esc(url)}</p></header>`;
const bulletsHtml = (bullets) => `<ul class="bullets">${bullets.map((b) => `<li>${esc(b)}</li>`).join('')}</ul>`;

function sectionSlices(sec) {
  return sec.screens.flatMap(([key, title, bullets]) => {
    const c = chunks[key];
    if (!c) throw new Error(`Screenshot missing: ${key}`);
    return c.chunks.map((file, i) => ({ key, title, bullets, url: c.url, i, file, cap: caption(key, i, c), report: false }));
  });
}

/** Renders every piece once in Chrome at the page's content width and returns their outer heights. */
async function measure(browser, sections) {
  const pieces = {};
  const add = (id, h) => { pieces[id] = h; };
  for (const sec of sections) {
    add(`foot`, foot());
    for (const sl of sectionSlices(sec)) {
      if (sl.i === 0) {
        add(`head:${sl.key}:0`, headHtml(sec, sl.title, sl.url, false));
        add(`sub:${sl.key}`, subHtml(sl.title, sl.url));
        add(`bul:${sl.key}`, bulletsHtml(sl.bullets));
      } else add(`head:${sl.key}:1`, headHtml(sec, sl.title, sl.url, true));
      add(`cap:${sl.key}:${sl.i}`, sl.cap);
    }
  }
  const files = [...new Set(sections.flatMap((sec) => sectionSlices(sec).map((sl) => sl.file)))];
  const file = path.resolve('dist/proposal/measure.html');
  fs.writeFileSync(file, `<!doctype html><html><head><meta charset="utf-8"><style>${STYLE}</style></head><body>${Object.entries(pieces).map(([id, h]) => `<div data-id="${esc(id)}" style="width:${CONTENT_W}px;display:flex;flex-direction:column">${h}</div>`).join('')}</body></html>`);
  const page = await browser.newPage();
  await page.goto('file://' + file, { waitUntil: 'networkidle0' });
  await page.evaluate(() => document.fonts.ready);
  const out = await page.evaluate(async (files) => {
    const h = {};
    for (const el of document.querySelectorAll('[data-id]')) h[el.dataset.id] = el.getBoundingClientRect().height;
    const dims = {};
    for (const f of files) { const im = new Image(); im.src = f; await im.decode(); dims[f] = [im.naturalWidth, im.naturalHeight]; }
    return { h, dims };
  }, files.map(img));
  await page.close();
  fs.rmSync(file);
  return { h: out.h, dims: Object.fromEntries(files.map((f) => [f, out.dims[img(f)]])) };
}

function packSection(sec, { h, dims }) {
  const budget = PAGE_H - h.foot - SAFETY;
  const slices = sectionSlices(sec);
  const imgBox = (sl) => {
    const [nw, nh] = dims[sl.file];
    const w = sl.report ? Math.min(CONTENT_W, 6.9 * 96 * nw / nh) : CONTENT_W;
    return { w, h: w * nh / nw };
  };
  // A page holding slices a..b-1: its items, the scale that fits them, the height used.
  const layout = (a, b) => {
    const first = slices[a];
    const headH = h[`head:${first.key}:${first.i > 0 ? 1 : 0}`];
    const items = slices.slice(a, b).map((sl, k) => {
      const sub = k > 0 && sl.i === 0;
      const fixed = (k ? ITEM_GAP : 0) + (sub ? h[`sub:${sl.key}`] : 0) + (sl.i === 0 ? h[`bul:${sl.key}`] : 0) + h[`cap:${sl.key}:${sl.i}`];
      return { sl, sub, fixed, img: imgBox(sl) };
    });
    const fixed = headH + items.reduce((t, it) => t + it.fixed, 0);
    const imgs = items.reduce((t, it) => t + it.img.h, 0);
    const scale = Math.min(1, (budget - fixed) / imgs);
    return { first, items, scale, used: fixed + imgs * scale };
  };
  // best[a] = cheapest packing of slices a..end; a lone slice always fits (shrunk if it must be).
  const best = Array(slices.length + 1).fill(null);
  best[slices.length] = { cost: 0, pages: [] };
  for (let a = slices.length - 1; a >= 0; a--) {
    for (let b = a + 1; b <= slices.length; b++) {
      const pg = layout(a, b);
      if (b - a > 1 && pg.scale < MIN_SCALE) break;
      const cost = (pg.used < HALF_EMPTY * PAGE_H ? 1000 : 0) + 100 + 200 * (1 - pg.scale) + best[b].cost;
      if (!best[a] || cost < best[a].cost) best[a] = { cost, pages: [pg, ...best[b].pages] };
    }
  }
  const pages = best[0].pages;
  return pages.map((pg) => `
    <section class="page shot">
      ${headHtml(sec, pg.first.title, pg.first.url, pg.first.i > 0)}
      ${pg.items.map(({ sl, sub, img: box }) => `<div class="item">${sub ? subHtml(sl.title, sl.url) : ''}${sl.i === 0 ? bulletsHtml(sl.bullets) : ''}<figure class="${sl.report ? 'report' : ''}"><img src="${img(sl.file)}" alt="${esc(sl.title)}" style="width:${(box.w * pg.scale).toFixed(1)}px;height:${(box.h * pg.scale).toFixed(1)}px">${sl.cap}</figure></div>`).join('')}
      ${foot()}
    </section>`).join('');
}

const foot = () => `<footer class="foot"><span>${esc(TITLE)}</span><span>${esc(DATE)}</span></footer>`;

const STYLE = `
  ${FONTS}
  :root { --m950: #120c07; --m900: #1f150d; --oak: #6e4320; --cask: #a8662c; --amber: #d99a3d; --amber-text: #8a4a12; --amber-soft: #f6e6c9; --paper: #f7f1e6; --ink: #1f150d; --ink-2: #4a3a2c; --ink-3: #6b5847; --line: #e2d6c3; }
  @page { size: Letter; margin: 0.5in 0.55in 0.5in; }
  * { box-sizing: border-box; }
  html, body { margin: 0; padding: 0; font-family: 'Source Sans 3', 'Helvetica Neue', Arial, sans-serif; color: var(--ink); font-size: 10.6pt; line-height: 1.45; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  h1, h2, h3 { font-family: 'DM Serif Display', Georgia, serif; font-weight: 400; color: var(--m900); margin: 0; line-height: 1.05; }
  b, strong { font-weight: 700; }
  .page { page-break-after: always; break-after: page; height: 10in; display: flex; flex-direction: column; overflow: hidden; }
  .page:last-child { page-break-after: auto; break-after: auto; }
  .eyebrow { font-size: 8pt; font-weight: 700; letter-spacing: .18em; text-transform: uppercase; color: var(--amber-text); margin: 0 0 4px; }
  .muted { color: var(--ink-3); }
  /* molasses bands: cover and part dividers, with the barrel hoops and the Grenada ribbon */
  .band { background: var(--m900); color: #fff; border-radius: 10px; padding: 0.65in 0.6in 0.85in; position: relative; overflow: hidden; }
  .band::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 5px; background: ${RIBBON}; }
  .band::after { content: ''; position: absolute; left: 0; right: 0; bottom: 0; height: 22px; background: ${HOOPS}; }
  .band h1 { color: #fff; } .band .eyebrow { color: var(--amber); }
  .cover { justify-content: space-between; }
  .brand { display: inline-flex; flex-direction: column; } .bn { font-family: 'DM Serif Display', Georgia, serif; font-size: 26pt; line-height: 1; } .bs { margin-top: 5px; padding-top: 4px; border-top: 1px solid; font-size: 7.5pt; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; }
  .stamp { display: inline-flex; align-items: center; gap: 8px; padding: 3px 11px 3px 3px; border: 1.5px solid var(--amber); border-radius: 999px; color: var(--amber); font-size: 7.5pt; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; } .stamp i { font-style: normal; display: inline-grid; place-items: center; min-width: 22px; height: 22px; border-radius: 999px; background: var(--amber); color: var(--m900); font-family: 'DM Serif Display', Georgia, serif; font-size: 9pt; letter-spacing: 0; padding: 0 4px; }
  .cover h1 { font-size: 40pt; line-height: 1.02; margin: 16px 0 14px; } .cover h1 em { color: var(--amber); font-style: italic; }
  .cover p.lead { color: rgba(255,255,255,.86); font-size: 12.5pt; max-width: 5.8in; margin: 0; }
  .cover .meta { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; border-top: 1px solid rgba(255,255,255,.18); padding-top: 16px; font-size: 9.3pt; color: rgba(255,255,255,.82); margin-bottom: 16px; }
  .cover .meta b { display: block; font-size: 8pt; letter-spacing: .14em; text-transform: uppercase; margin-bottom: 4px; color: var(--amber); }
  .cover .meta .n { color: #fff; font-weight: 700; font-size: 10.5pt; }
  .divider { justify-content: center; }
  .divider h1 { font-size: 40pt; margin: 8px 0 16px; } .divider p { color: rgba(255,255,255,.86); font-size: 12pt; max-width: 5.9in; margin: 0; }
  .divider ol { color: rgba(255,255,255,.86); columns: 2; font-size: 10pt; margin: 22px 0 0; padding-left: 18px; } .divider li { break-inside: avoid; margin: 3px 0; }
  /* text pages */
  .prose h1 { font-size: 28pt; margin-bottom: 10px; }
  .prose h2 { font-size: 16pt; margin: 14px 0 6px; }
  .prose p { margin: 0 0 8px; }
  .prose ul.list { margin: 0 0 8px; padding-left: 17px; } .prose ul.list li { margin: 2px 0; }
  .cols { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .card { border: 1px solid var(--line); border-radius: 6px; padding: 11px 13px; background: #fffbf4; break-inside: avoid; position: relative; }
  .card::before { content: ''; position: absolute; inset: 3px; border: 1px solid rgba(226,214,195,.7); border-radius: 4px; pointer-events: none; }
  .card h3 { font-size: 13pt; margin-bottom: 5px; }
  .card ul { margin: 0; padding-left: 15px; } .card li { margin: 2px 0; }
  .evidence { border-left: 3px solid var(--cask); background: var(--amber-soft); border-radius: 0 6px 6px 0; padding: 9px 12px 9px 28px; margin: 8px 0 10px; }
  .prose ul.evidence { padding-left: 30px; } .evidence li { margin: 3px 0; }
  .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 9px; margin: 12px 0; } .stat { background: var(--m900); color: #fff; border-radius: 6px; padding: 11px 12px; border-bottom: 4px solid var(--oak); } .stat b { display: block; font-family: 'DM Serif Display', Georgia, serif; font-weight: 400; font-size: 26pt; line-height: 1; color: var(--amber); } .stat span { display: block; margin-top: 4px; font-size: 8.6pt; color: rgba(255,255,255,.85); line-height: 1.3; }
  table.feat { width: 100%; border-collapse: collapse; font-size: 9.4pt; } table.feat td { border-bottom: 1px solid var(--line); padding: 9px 6px; vertical-align: top; } table.feat td:first-child { width: 20%; font-family: 'DM Serif Display', Georgia, serif; font-size: 13.5pt; color: var(--m900); }
  .pill-row { display: flex; flex-wrap: wrap; gap: 5px; } .pill { border: 1px solid #e3cfa6; background: var(--amber-soft); color: var(--m900); border-radius: 999px; padding: 2px 9px; font-size: 8.6pt; font-weight: 600; }
  table.sla { width: 100%; border-collapse: collapse; font-size: 9.4pt; margin: 4px 0 8px; } table.sla th, table.sla td { text-align: left; vertical-align: top; padding: 6px 8px; border-bottom: 1px solid var(--line); } table.sla th { color: var(--ink-3); font-size: 8pt; letter-spacing: .1em; text-transform: uppercase; }
  .price { display: grid; grid-template-columns: 1.35fr 1fr; gap: 12px; align-items: stretch; margin: 6px 0 4px; }
  .price .big { background: var(--m900); color: #fff; border-radius: 8px; padding: 14px 16px; border-bottom: 5px solid var(--oak); } .price .big .amt { font-family: 'DM Serif Display', Georgia, serif; font-size: 30pt; line-height: 1; color: var(--amber); } .price .big .amt small { font-size: 13pt; color: #fff; } .price .big p { color: rgba(255,255,255,.86); font-size: 9.6pt; margin: 8px 0 0; } .price .big p b { color: #fff; }
  .price .year { border: 2px solid var(--cask); border-radius: 8px; padding: 10px 14px; background: #fffbf4; display: grid; gap: 4px; } .price .year span { display: block; font-size: 8pt; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: var(--amber-text); } .price .year b { font-family: 'DM Serif Display', Georgia, serif; font-weight: 400; font-size: 16pt; color: var(--m900); }
  ul.terms li { margin: 3px 0; }
  .weeks { margin: 6px 0 10px; } .week { display: grid; grid-template-columns: 0.9in 1fr; gap: 10px; padding: 8px 0; border-bottom: 1px solid var(--line); } .week b { font-family: 'DM Serif Display', Georgia, serif; font-weight: 400; font-size: 14pt; color: var(--amber-text); } .week p { margin: 0; }
  ul.plain { padding-left: 17px; margin: 0 0 8px; } ul.plain li { margin: 3px 0; }
  .contact { margin-top: 18px; max-width: 4.8in; }
  a { color: var(--amber-text); }
  /* screenshot pages */
  .shot-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 12px; border-bottom: 2px solid var(--m900); padding-bottom: 6px; margin-bottom: 7px; }
  .shot-head h2 { font-size: 20pt; } .url { font-family: Menlo, Consolas, monospace; font-size: 8pt; color: var(--ink-3); margin: 0; white-space: nowrap; }
  .bullets { margin: 0 0 7px; padding-left: 16px; font-size: 9.4pt; } .bullets li { margin: 1px 0; }
  figure { margin: 0; display: flex; flex-direction: column; min-height: 0; flex: 1 1 auto; }
  figure img { display: block; max-width: 100%; min-height: 0; flex: 0 1 auto; object-fit: contain; object-position: left top; border: 1px solid var(--line); border-radius: 4px; align-self: flex-start; }
  .item { display: flex; flex-direction: column; flex: none; } .item + .item { margin-top: 16px; } .item figure { flex: none; } .item figure img { max-width: none; max-height: none; flex: none; }
  .sub-head { display: flex; justify-content: space-between; align-items: baseline; gap: 12px; border-bottom: 1px solid var(--line); padding-bottom: 4px; margin-bottom: 6px; } .sub-head h3 { font-size: 14.5pt; }
  .cap { margin: 6px 0 0; font-size: 9pt; line-height: 1.38; color: var(--ink-2); border-left: 3px solid var(--cask); padding-left: 8px; flex: none; }
  .phones { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; margin: 14px 0.15in 0; } .phones figure { display: block; } .phones img { display: block; width: 100%; height: auto; border-radius: 18px; border: 6px solid var(--m950); } .phones figcaption { text-align: center; font-size: 9pt; color: var(--ink-3); margin-top: 6px; }
  footer.foot { margin-top: auto; padding-top: 8px; font-size: 7.8pt; color: #8f7d6b; display: flex; justify-content: space-between; flex: none; }
`;

const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--no-sandbox', '--allow-file-access-from-files'] });
const measured = await measure(browser, SECTIONS);
const packed = Object.fromEntries(SECTIONS.map((sec) => [sec.id, packSection(sec, measured)]));

const html = `<!doctype html><html lang="en"><head><meta charset="utf-8"><title>${esc(TITLE)}</title>
<style>${STYLE}</style></head><body>

<section class="page band cover">
  ${WORDMARK(true)}
  <div>
    <p class="stamp"><i>37</i>Website proposal · ${esc(DATE)}</p>
    <h1>A website worthy of <em>Grenada’s national rum</em></h1>
    <p class="lead">A complete Clarke’s Court website on clarkescourtrum.com with an age check, a page for every rum, the distillery’s heritage, online tour booking, trade and export enquiries, careers with CV upload, and a staff back office – for US$1,000 a month, with no charge for design and development.</p>
  </div>
  <div class="meta">
    <div><b>Prepared for</b><span class="n">Grenada Distillers Ltd</span><br>Woodlands Valley, St George<br>Grenada</div>
    <div><b>Prepared by</b><span class="n">Keron Lewis, Code Canvas Consultants Ltd</span><br>Port of Spain · codecanvastt.com<br>+1 868 466-CODE · info@codecanvastt.com</div>
  </div>
</section>

<section class="page prose">
  <p class="eyebrow">Executive summary</p>
  <h1>Why rebuild now</h1>
  <p>Clarke’s Court has been distilled at Woodlands since 1937, at what the company describes as the largest distillery in Grenada. Its range runs from Pure White to Old Grog and #37, it is preparing a UK trade launch, and it recruits regularly. Its website has not kept pace. As of October 2026:</p>
  <ul class="list evidence">
    <li><b>clarkescourtrum.com</b> shows a hosting company’s “Temporarily Disabled” page, over plain HTTP without an encrypted connection. The last working version of the site in the Internet Archive dates from mid-2023.</li>
    <li><b>clarkescourt.com</b> is a holding page for the UK trade launch, with no product information and no enquiry form, only a UK telephone number.</li>
    <li>Visitors who want a <b>distillery tour</b> have no way to see times or book; the old site only gave a phone number.</li>
    <li>Importers and distributors have <b>no trade or export enquiry</b> route at all, at the moment the brand is looking for new markets.</li>
    <li>Vacancies (sales and marketing manager, blending technician, warehouse assistant) are advertised on news sites, with CVs sent by email or through a recruiter, so there is no one place where applications are kept and tracked.</li>
  </ul>
  <p>This proposal replaces all of that with one system on clarkescourtrum.com: a public website for drinkers, visitors, buyers and job seekers, and a back office where each team answers its own requests. A complete working demo has been built from the distillery’s own published information, and it can be shown live.</p>
  <div class="stat-grid">
    <div class="stat"><b>40+</b><span>pages and screens in the working demo</span></div>
    <div class="stat"><b>13</b><span>rums, each with its sourced facts</span></div>
    <div class="stat"><b>4</b><span>staff roles: admin, tours, trade, HR</span></div>
    <div class="stat"><b>70</b><span>automated tests, run on every change</span></div>
  </div>
  <h2>What the distillery gains</h2>
  <div class="cols">
    <div class="card"><h3>Visitors and buyers</h3><ul><li>Tour places booked online, with a reference number</li><li>A real landing place for importers and duty-free buyers</li><li>The range and its story, told in the distillery’s own words</li></ul></div>
    <div class="card"><h3>The teams at Woodlands</h3><ul><li>Each request goes to the team that handles it</li><li>One number to act on: requests waiting over a day</li><li>Applications and CVs kept private to HR</li></ul></div>
  </div>
  ${foot()}
</section>

<section class="page prose">
  <p class="eyebrow">At a glance</p>
  <h1>What is included</h1>
  <table class="feat"><tbody>
    ${FEATURES.map(([a, f]) => `<tr><td>${esc(a)}</td><td><div class="pill-row">${f.map((x) => `<span class="pill">${esc(x)}</span>`).join('')}</div></td></tr>`).join('')}
  </tbody></table>
  <h2>How a tour booking works</h2>
  <p>A visitor picks a day and a time from a week-by-week grid that shows the places left on every tour, says how many adults and under-18s are coming, and sends the form. Their places are held at once: the system counts guests against the tour’s capacity under a lock, so two parties booking the last places at the same moment can never both get them. The visitor gets a reference number on screen and by email, the tours team is alerted, and the booking appears on the tour calendar and the printable day sheet. A cancellation frees the places straight away.</p>
  <h2>Content and data in the demo</h2>
  <p>Facts come from the archived clarkescourtrum.com (product pages, “Our story”, the factory-tour page and company news, 2003–2020, plus 2021 press coverage), vacancy notices on NOW Grenada (2024–2026), the Library of Congress sale particulars for the estate (1877) and the UK holding page at clarkescourt.com. Each rum page and timeline entry links its source. The bottle, range, heritage and launch photographs are the company’s own, recovered from the archived site; the rest are credited Wikimedia Commons images to be replaced. <b>Nothing is invented</b>: no prices, awards on product pages, statistics, testimonials or staff names. The vacancies are samples, and every booking, enquiry, applicant and CV in the screenshots is demo data.</p>
  ${foot()}
</section>

${SECTIONS.map((sec) => `
<section class="page band divider">
  <p class="eyebrow">${esc(sec.eyebrow)}</p>
  <h1>${esc(sec.title)}</h1>
  <p>${esc(sec.intro)}</p>
  <ol>${sec.screens.map((s) => `<li>${esc(s[1])}</li>`).join('')}</ol>
</section>
${packed[sec.id]}
`).join('')}

${PHONES.map((row, i) => `
<section class="page">
  <header class="shot-head"><div><p class="eyebrow">Responsive design${i ? ' · continued' : ''}</p><h2>${i ? 'Applications and the back office on a phone' : 'Built for phones first'}</h2></div></header>
  <p style="margin:0 0 4px">${i ? 'Job seekers apply and upload a CV from a phone, and the tours team can confirm a booking from the factory floor.' : 'Most visitors arrive on a phone, many of them on a cruise or a hotel’s Wi-Fi. On small screens a bar with Call, Contact and Book a tour stays at the bottom of every public page.'}</p>
  <div class="phones">${row.map(([k, c]) => `<figure><img src="${img(chunks[k].chunks[0])}" alt="${esc(c)}"><figcaption>${esc(c)}</figcaption></figure>`).join('')}</div>
  ${foot()}
</section>`).join('')}

<section class="page prose">
  <p class="eyebrow">Technology, hosting &amp; security</p>
  <h1>Built on a standard, open platform</h1>
  <div class="cols">
    <div class="card"><h3>Platform</h3><ul><li>Laravel 13 on PHP 8.3 with a MySQL database: free, open-source and widely supported</li><li>No proprietary site builder or licence; any Laravel developer can maintain it</li><li>No background workers or extra servers required</li><li>70 automated tests cover every form, every staff role and tour capacity under the lock</li></ul></div>
    <div class="card"><h3>Privacy</h3><ul><li>CVs are stored outside the public web folder and open only for HR and administrators</li><li>Every opening of a CV is recorded on the application</li><li>The tours and trade teams never see job applications</li><li>A privacy notice drafted for the company’s legal adviser</li></ul></div>
    <div class="card"><h3>Security</h3><ul><li>HTTPS throughout, with security headers</li><li>Hashed passwords and individual staff accounts with roles; switched-off accounts are signed out</li><li>Spam protection and rate limits on every public form</li><li>Monthly patching and daily backups under the plan</li></ul></div>
    <div class="card"><h3>Accessibility &amp; reach</h3><ul><li>17-pixel body text and 48-pixel buttons</li><li>Colour contrast checked to WCAG AA in light and dark themes</li><li>Every page and form works without JavaScript</li><li>Sitemap, structured data for rums and vacancies, and redirects from the old site’s addresses</li></ul></div>
  </div>
  <h2>Emails the system sends</h2>
  <p>Tour booking received, with the slot, party and directions (visitor) and a new-booking alert (tours team); trade enquiry received (buyer) and alert (export team); application received (applicant) and alert to HR, without the CV attached; message received and alert. All are sent from the distillery’s own mailbox.</p>
  ${foot()}
</section>

<section class="page prose">
  <p class="eyebrow">Investment</p>
  <h1>The US$1,000 a month plan</h1>
  <div class="price">
    <div class="big"><div class="amt">US$1,000 <small>per month</small></div><p><b>US$0 for design and development.</b> No setup fee and no deposit. Invoiced in US dollars. Billing starts at the end of the month in which the site launches, prorated for the days it was live; monthly invoices are due within 14 days.</p></div>
    <div class="year"><div><span>Year one</span><b>US$12,000</b></div><div><span>Or prepaid annually (10% off)</span><b>US$10,800</b></div><div><span>Build cost</span><b>US$0</b></div></div>
  </div>
  <div class="cols" style="margin-top:8px">
    <div class="card"><h3>Included every month</h3><ul>
      <li>The complete design and build shown in this proposal</li>
      <li>Managed hosting with CDN and SSL</li>
      <li>Daily backups plus a weekly off-site copy</li>
      <li>Security patches and software updates</li>
      <li>24/7 uptime monitoring</li>
      <li><b>Up to 10 hours a month</b> of content changes and small improvements</li>
      <li>Staff training</li>
      <li>Google Analytics, Search Console and a monthly summary</li>
      <li>Support by email, WhatsApp and phone, plus a quarterly review call</li>
      <li>A 30-day post-launch warranty</li>
    </ul></div>
    <div class="card"><h3>Terms</h3><ul class="terms">
      <li>No minimum term. 30 days' notice by email from either side.</li>
      <li>Price fixed for the first 24 months.</li>
      <li>Optional annual prepayment at 10% off: US$10,800 a year.</li>
      <li><b>Handover fee US$7,000, only if you leave.</b> It buys the website outright and moves it to hosting in Grenada Distillers' name. It is waived if Code Canvas stops trading.</li>
      <li>Your content, domain and data are always yours.</li>
    </ul>
    <h3 style="margin-top:8px">Quoted separately, only with your approval</h3><ul>
      <li>Work beyond 10 hours in a month: US$50 an hour, or a fixed quote</li>
      <li>Online shop and card payments, such as paid tours or gift orders</li>
      <li>SMS reminders for tour bookings</li>
      <li>Integrations with a stock, accounting or HR system</li>
      <li>A distributor portal; paid advertising and SEO campaigns; professional photography</li>
    </ul></div>
  </div>
  <h2>Service levels</h2>
  <table class="sla"><thead><tr><th>Issue</th><th>Response</th><th>Fix target</th></tr></thead><tbody>
    <tr><td>Site down or forms not sending</td><td>1 hour, any day</td><td>4 hours</td></tr>
    <tr><td>Something on a page is broken</td><td>4 business hours</td><td>1 business day</td></tr>
    <tr><td>Content changes (text, photos, vacancies, tour times, holidays)</td><td>Acknowledged in 1 business day</td><td>Done in 2 business days</td></tr>
  </tbody></table>
  ${foot()}
</section>

<section class="page prose">
  <p class="eyebrow">Timeline</p>
  <h1>Six weeks to launch</h1>
  <div class="weeks">
    <div class="week"><b>Week 1</b><p>Kick-off, brand assets and content: your logo files, photos and confirmation of the facts on the site.</p></div>
    <div class="week"><b>Week 2</b><p>Revision round 1. Forms, emails and staff roles configured with your real addresses.</p></div>
    <div class="week"><b>Week 3</b><p>Data and content load: the current range with strengths and notes, tour times and capacity, public holidays and open vacancies.</p></div>
    <div class="week"><b>Week 4</b><p>Revision round 2.</p></div>
    <div class="week"><b>Week 5</b><p>Formal testing with your tours, export and HR staff on every form and screen.</p></div>
    <div class="week"><b>Week 6</b><p>Launch on HTTPS, redirects from the old addresses, Search Console, and staff training.</p></div>
  </div>
  <h2>What we need from Grenada Distillers</h2>
  <ul class="plain">
    <li>Your Clarke’s Court logo as a vector file and any brand guidelines (the demo uses a typographic stand-in).</li>
    <li>Bottle shots and photos of the distillery, the steam engines, the cask room and the team, or time for a short photo session.</li>
    <li>Confirmation of the range, strengths and tasting notes, the tour times and how many guests a tour takes, and your public holidays.</li>
    <li>Which awards, if any, you want shown, and how the site should link to the UK trade site.</li>
    <li>The staff who need accounts and their roles, and the inboxes that should receive tour, trade and HR alerts.</li>
    <li>Access to the clarkescourtrum.com domain settings, and to your Google Business Profile and social accounts if they exist.</li>
  </ul>
  <h2>When billing starts</h2>
  <p>Not on signing. The build, both revision rounds, testing and the preview site cost nothing. Billing starts at the end of the month in which the site launches, prorated for the days it was live. Nothing goes live until you approve it in writing.</p>
  ${foot()}
</section>

<section class="page prose">
  <p class="eyebrow">Next steps</p>
  <h1>From proposal to launch</h1>
  <ol class="plain" style="padding-left:18px">
    <li style="margin:5px 0"><b>See the demo live.</b> We walk through the website and the back office together, on a laptop and a phone.</li>
    <li style="margin:5px 0"><b>Tell us what to change.</b> Pages, wording, roles or the request flows; revision round 1 opens straight away.</li>
    <li style="margin:5px 0"><b>Sign a one-page agreement</b> with the terms in this proposal: US$1,000 a month, month to month on 30 days' notice, US$0 build cost, and a US$7,000 handover fee only if you leave.</li>
    <li style="margin:5px 0"><b>Kick-off the same week</b>, with launch six weeks later.</li>
  </ol>
  <div class="card contact">
    <h3>Contact</h3>
    <p style="margin:0">Keron Lewis, Director<br>Code Canvas Consultants Ltd, Port of Spain<br>codecanvastt.com · +1 868 466-CODE<br><a href="mailto:info@codecanvastt.com">info@codecanvastt.com</a><br>Book a call: <a href="https://calendly.com/keronlewis/30min">calendly.com/keronlewis/30min</a></p>
  </div>
  <div style="margin-top:auto; margin-bottom:12px">${WORDMARK(false)}</div>
  ${foot()}
</section>
</body></html>`;

fs.writeFileSync(OUT_HTML, html);
const page = await browser.newPage();
await page.goto('file://' + OUT_HTML, { waitUntil: 'networkidle0' });
await page.evaluate(() => document.fonts.ready);
await page.pdf({ path: OUT_PDF, format: 'Letter', printBackground: true, preferCSSPageSize: true, displayHeaderFooter: false });
await browser.close();
console.log('PDF written:', OUT_PDF, Math.round(fs.statSync(OUT_PDF).size / 1024 / 1024 * 10) / 10 + ' MB');
