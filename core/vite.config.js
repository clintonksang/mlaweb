import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                '../assets/admin/css/app.css',
                '../assets/admin/js/app.js'
            ],
            refresh: true,
        })

    ],
    build: {
        // Ensure compatibility with different platforms
        target: 'es2015',
        outDir: 'public/build',
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
    optimizeDeps: {
        include: ['@rollup/rollup-linux-x64-gnu'],
    },
}); 