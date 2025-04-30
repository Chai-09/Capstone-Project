import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 
                'resources/css/login/login.css',
                'resources/css/fillupforms/fillupforms.css',

                // Applicant
                'resources/css/applicants/layout.css',
                'resources/css/applicants/navbar.css',
                'resources/css/applicants/sidebar.css',
                'resources/css/applicants/step-1.css',
                'resources/css/applicants/step-1.css',

                // 3 Sidebar
                'resources/css/partials/sidebar.css',

                'resources/js/app.js',
                'resources/js/fillupforms/fillupforms.js',
                'resources/js/address/address.js',
                'resources/js/partials/sidebar.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
