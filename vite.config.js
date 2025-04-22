import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 
                'resources/css/login/login.css',
                'resources/css/fillupforms/fillupforms.css',
                'resources/css/applicant/navbar.css',

                'resources/js/app.js',
                'resources/js/fillupforms/fillupforms.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
