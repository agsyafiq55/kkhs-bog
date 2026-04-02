import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

const vitePort = Number(process.env.VITE_PORT || 5173);
const viteHmrHost = process.env.VITE_HMR_HOST || 'localhost';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0',
        port: vitePort,
        strictPort: true,
        cors: true,
        hmr: {
            host: viteHmrHost,
            port: vitePort,
        },
    },
});