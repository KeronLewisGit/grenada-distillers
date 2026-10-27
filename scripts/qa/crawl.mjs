// Crawl every public and back-office page reachable by links, as each demo role, and submit
// one of each form. Fails on any 4xx/5xx. node scripts/qa/crawl.mjs [baseUrl]
const BASE = process.argv[2] || 'http://127.0.0.1:8106';
const jar = new Map();
const cookieHeader = () => [...jar].map(([k, v]) => `${k}=${v}`).join('; ');
async function req(path, opts = {}) {
    const res = await fetch(BASE + path, { redirect: 'manual', ...opts, headers: { cookie: cookieHeader(), ...(opts.headers || {}) } });
    for (const c of res.headers.getSetCookie()) { const [kv] = c.split(';'); const i = kv.indexOf('='); jar.set(kv.slice(0, i), kv.slice(i + 1)); }
    return res;
}
const token = (html) => (html.match(/name="_token" value="([^"]+)"/) || [])[1];
async function post(path, fields, from) {
    const html = await (await req(from)).text();
    const body = new URLSearchParams({ _token: token(html), ...fields });
    return req(path, { method: 'POST', body, headers: { 'content-type': 'application/x-www-form-urlencoded' } });
}
const bad = []; let count = 0;
async function crawl(start, prefix) {
    const seen = new Set(); const queue = [...start];
    while (queue.length) {
        const p = queue.shift(); if (seen.has(p)) continue; seen.add(p);
        const res = await req(p); count++;
        if (res.status >= 400) bad.push(`${res.status} ${p}`);
        if (res.status >= 300 && res.status < 400) { const loc = res.headers.get('location') || ''; const u = new URL(loc, BASE); if (u.origin === new URL(BASE).origin && !seen.has(u.pathname + u.search)) queue.push(u.pathname + u.search); continue; }
        const html = await res.text();
        for (const m of html.matchAll(/href="([^"#]+)/g)) {
            let u; try { u = new URL(m[1].replace(/&amp;/g, '&'), BASE); } catch { continue; }
            if (u.origin !== new URL(BASE).origin) continue;
            const path = u.pathname + u.search;
            if (/\/(logout|build|img)\b|\.(webp|css|js|svg|png)$|\/files\/|export/.test(path)) continue;
            if (prefix && !path.startsWith(prefix)) continue;
            if (/[?&]page=\d{2,}/.test(path)) continue;
            if (!seen.has(path) && seen.size < 900) queue.push(path);
        }
    }
    return seen.size;
}
jar.set('gdl_age_ok', '1');
const pub = await crawl(['/', '/sitemap', '/sitemap.xml', '/robots.txt', '/age', '/products/aged/clarke-s-court-grog-rum'], null);
// Forms
const tours = await (await req('/tours')).text();
const slot = (tours.match(/name="slot" value="([^"]+)"/) || [])[1];
const contact = { name: 'Crawl Test', email: 'crawl@example.com', phone: '+1 473 440 0000', contact_pref: 'email' };
const forms = [
    ['/tours', { ...contact, slot, adults: '2', children: '0', group_type: 'family' }, '/tours'],
    ['/trade', { ...contact, organisation: 'Crawl Imports', country: 'Canada', business_type: 'importer', volume: 'cases', licensed: 'yes', message: 'Test' }, '/trade'],
    ['/contact', { ...contact, topic: 'general', message: 'Test' }, '/contact'],
];
for (const [path, fields, from] of forms) {
    const r = await post(path, fields, from);
    const loc = r.headers.get('location') || '';
    if (!loc.endsWith('/thanks')) bad.push(`form ${path} -> ${r.status} ${loc}`);
    const t = await req('/thanks'); if (t.status !== 200) bad.push(`thanks after ${path}: ${t.status}`);
}
let admin = 0;
for (const role of ['admin', 'tours', 'trade', 'hr']) {
    jar.clear(); jar.set('gdl_age_ok', '1');
    const r = await post('/login', { email: `${role}@clarkescourt.test`, password: 'password' }, '/login');
    if (!(r.headers.get('location') || '').endsWith('/admin')) { bad.push(`login ${role} failed`); continue; }
    admin += await crawl(['/admin', '/admin/requests/export'], '/admin');
}
console.log(`pages fetched ${count}; public ${pub}; admin (all roles) ${admin}`);
console.log(bad.length ? 'PROBLEMS:\n' + bad.join('\n') : 'all OK');
