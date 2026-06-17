import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/script.js',
                'resources/js/map.js',
            ],
            refresh: true,
        }),
    ],

    server: {
        host: '0.0.0.0',
        port: 5175,
        strictPort: true,

        origin: 'https://pilsetasbite.ddev.site:5176',

        cors: {
            origin: [
                'https://pilsetasbite.ddev.site',
                'https://pilsetasbite.ddev.site:5176',
            ],
            credentials: true,
        },

        hmr: {
            protocol: 'wss',
            host: 'pilsetasbite.ddev.site',
            clientPort: 5176,
        },
    },
});