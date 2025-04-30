import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';


export default defineConfig({
    server: {
        host: 'knowledge.local',
        hmr: {
            host: 'knowledge.local',
        },
        watch: {},
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '$': 'jquery',
            'jquery': 'jquery'
        }
    }

});
