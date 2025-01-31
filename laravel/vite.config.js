import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.jsx',  // Entrada para o React
                'resources/css/app.css'  // Entrada para o Tailwind CSS
            ],
            refresh: true,
        }),
        react(),
    ],
});
