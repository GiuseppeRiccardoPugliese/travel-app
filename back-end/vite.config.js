import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import dotenv from 'dotenv';

// Carica variabili di ambiente dal file .env
dotenv.config();

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss', 
                'resources/js/app.js',
                'resources/js/search_city_image.js',
                'resources/js/maps_scripts.js',
                'resources/js/stars.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~icons': path.resolve(__dirname, 'node_modules/bootstrap-icons/font'),
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~resources': path.resolve(__dirname, 'resources')
        }
    },
    build: {
        outDir: 'public/build',
        manifest: true,
        rollupOptions: {
            output: {
                assetFileNames: '[name].[hash].[ext]',
                chunkFileNames: 'js/[name].[hash].js',
                entryFileNames: 'js/[name].[hash].js',
            }
        }
    },
    base: process.env.VITE_APP_BASE_URL || '/', // Usa la variabile di ambiente per la base URL
});
