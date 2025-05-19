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
                'resources/css/applicants/step-2.css',
                'resources/css/applicants/step-3.css',
                'resources/css/applicants/step-4.css',
                'resources/css/applicants/step-5.css',
                'resources/css/applicants/step-6.css',

                // 3 Sidebar
                'resources/css/partials/sidebar.css',

                'resources/js/app.js',
                'resources/js/fillupforms/fillupforms.js',
                'resources/js/address/address.js',
                'resources/js/applicant/payment-verification.js',
                'resources/js/applicant/exam-schedule.js',

                //3 Sidebar
                'resources/js/partials/sidebar.js',
                'resources/css/partials/tables.css',
                'resources/css/partials/layout.css',

                // Accountant 
                'resources/js/accounting/payment.js',

                // Admission
                'resources/js/admission/applicant-list.js',
                'resources/css/admission/edit-applicant.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
