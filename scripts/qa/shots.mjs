// Phone and desktop screenshots in light and dark themes, plus an overflow check.
// node scripts/qa/shots.mjs [baseUrl] [outDir] [pages...]
import puppeteer from 'puppeteer-core';
import fs from 'node:fs';
const BASE = process.argv[2] || 'http://127.0.0.1:8106';
const OUT = process.argv[3] || 'dist/shots';
const PAGES = process.argv.slice(4).length ? process.argv.slice(4) : ['/', '/rums', '/rums/old-grog', '/rums/black-gold', '/heritage', '/tours', '/trade', '/careers', '/careers/sales-and-marketing-manager', '/careers/apply', '/contact', '/photo-credits', '/age', 'ADMIN/admin', 'ADMIN/admin/requests', 'ADMIN/admin/tours', 'ADMIN/admin/vacancies'];
const CHROME = '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome';
fs.mkdirSync(OUT, { recursive: true });
const browser = await puppeteer.launch({ executablePath: CHROME, headless: 'new', args: ['--hide-scrollbars', '--no-sandbox'] });
const host = new URL(BASE).hostname;
async function session(theme) {
    const ctx = await browser.createBrowserContext();
    const page = await ctx.newPage();
    await page.setCookie({ name: 'gdl_age_ok', value: '1', domain: host, path: '/' });
    await page.evaluateOnNewDocument((t) => { try { localStorage.setItem('theme', t); } catch (e) {} }, theme);
    await page.emulateMediaFeatures([{ name: 'prefers-color-scheme', value: theme }]);
    await page.goto(BASE + '/login');
    await page.type('#email', 'admin@clarkescourt.test'); await page.type('#password', 'password');
    await Promise.all([page.waitForNavigation(), page.click('button[type=submit], button.a-btn-primary')]);
    return page;
}
const problems = [];
for (const theme of ['light', 'dark']) {
    const page = await session(theme);
    for (const [vw, vh, tag] of [[390, 844, 'phone'], [1440, 900, 'desktop']]) {
        await page.setViewport({ width: vw, height: vh, deviceScaleFactor: 1 });
        for (const p of PAGES) {
            const path = p.replace('ADMIN', '');
            await page.goto(BASE + path, { waitUntil: 'networkidle0' });
            await page.evaluate(async () => {
                document.querySelectorAll('[data-reveal]').forEach((e) => e.classList.add('is-visible'));
                document.querySelectorAll('img[loading=lazy]').forEach((i) => { i.loading = 'eager'; });
                for (let y = 0; y < document.body.scrollHeight; y += 600) { window.scrollTo(0, y); await new Promise((r) => setTimeout(r, 40)); }
                window.scrollTo(0, 0);
                await Promise.all([...document.images].map((i) => i.complete ? null : new Promise((r) => { i.onload = i.onerror = r; })));
            });
            await new Promise((r) => setTimeout(r, 900));
            const over = await page.evaluate(() => {
                const W = document.documentElement.clientWidth; const bad = [];
                document.querySelectorAll('body *').forEach((el) => { const r = el.getBoundingClientRect(); if (r.width && r.right > W + 1 && !el.closest('.table-box, .hero-photo, [aria-hidden=true]')) bad.push(el.tagName + '.' + String(el.className).slice(0, 50)); });
                return { scroll: document.documentElement.scrollWidth > W, bad: bad.slice(0, 5) };
            });
            if (over.scroll || over.bad.length) problems.push(`${tag} ${theme} ${path}: ${JSON.stringify(over)}`);
            const name = `${OUT}/${tag}-${theme}-${(path.replace(/\//g, '_') || '_home')}.png`;
            await page.screenshot({ path: name, fullPage: true });
        }
    }
}
await browser.close();
console.log(problems.length ? problems.join('\n') : 'no horizontal overflow');
