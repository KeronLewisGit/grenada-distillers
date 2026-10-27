import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

// Fonts are downloaded at build time and served from /build, so visitors never hit a font CDN.
// Two families: DM Serif Display, a high-contrast serif with the look of a printed rum label,
// for display type only (h1/h2, the wordmark, the proof seal); Source Sans 3 for everything people read.
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('DM Serif Display', {
                    alias: 'display',
                    variable: '--ff-display',
                    weights: [400],
                    styles: ['normal', 'italic'],
                    subsets: ['latin'],
                    preload: [{ weight: 400, style: 'normal' }],
                    fallbacks: ['Georgia', 'ui-serif', 'serif'],
                }),
                bunny('Source Sans 3', {
                    alias: 'sans',
                    variable: '--ff-sans',
                    weights: [400, 600, 700],
                    styles: ['normal', 'italic'],
                    subsets: ['latin'],
                    preload: [{ weight: 400, style: 'normal' }, { weight: 600, style: 'normal' }],
                    fallbacks: ['ui-sans-serif', 'system-ui', 'sans-serif'],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: { watch: { ignored: ['**/storage/framework/views/**'] } },
});
