import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        
    ],
    server: {
        host: 'antrian.test',   // ganti sesuai domain Valet kamu
        port: 5173,
        hmr: {
            host: 'antrian.test',
        },
    },
});
