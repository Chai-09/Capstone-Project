import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 
                'resources/css/login/login.css',
                'resources/css/fillupforms/fillupforms.css',
                'resources/css/applicants/navbar.css',
                'resources/css/applicants/sidebar.css',

                'resources/js/app.js',
                'resources/js/fillupforms/fillupforms.js',
                'resources/js/address/address.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
