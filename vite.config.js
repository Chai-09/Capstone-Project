import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
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

                // Partials
                'resources/js/partials/sidebar.js',
                'resources/js/partials/account-profile.js',
                'resources/css/partials/tables.css',
                'resources/css/partials/layout.css',
                'resources/css/partials/dashboard.css',
                'resources/css/partials/reports.css',

                // Accountant 
                'resources/js/accounting/payment.js',
                'resources/css/accounting/payment-modal.css',

                // Admission
                'resources/js/admission/applicant-list.js',
                'resources/css/admission/edit-applicant.css',
                'resources/js/admission/edit-applicant-info.js',
                'resources/css/admission/exam-schedule.css',
                'resources/js/admission/exam-schedule.js',

                // Administrator
                'resources/css/administrator/edit-account.css',
                'resources/js/administrator/edit-account.js',
                'resources/js/administrator/create-account.js',

                // Legal
                'resources/css/legal/terms.css',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],

     build: {
        outDir: 'public/build',    
        manifest: true,
        emptyOutDir: true,
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
});
