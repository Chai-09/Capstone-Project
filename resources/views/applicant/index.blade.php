<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <title>ApplySmart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2c99ab7d67.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- CSS --}}
    @vite('resources/css/fillupforms/fillupforms.css')
    @vite('resources/css/applicants/layout.css')
    @vite('resources/css/applicants/navbar.css')
    @vite('resources/css/applicants/sidebar.css')
    @vite('resources/css/applicants/step-1.css')
    @vite('resources/css/applicants/step-2.css')
    @vite('resources/css/applicants/step-3.css')
    @vite('resources/css/applicants/step-4.css')
    @vite('resources/css/applicants/step-5.css')
    @vite('resources/css/applicants/step-6.css')
</head>
<body>
    {{-- Navbar always visible --}}
    @include('applicant.navbar.navbar')

    <div class="container-fluid">
        <div class="row">

            {{-- Sidebar visible only on desktop --}}
            <div class="col-lg-3 d-none d-lg-block p-0">
                @include('applicant.sidebar.sidebar', ['currentStep' => $currentStep ?? 1])
            </div>

            {{-- Main content --}}
            <div class="forms col-lg-9">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/fillupforms/fillupforms.js')
    @vite('resources/js/address/address.js')
    @vite('resources/js/applicant/payment-verification.js')
    @vite('resources/js/applicant/exam-schedule.js')
</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const navbarCollapse = document.getElementById('navbarCollapse');
    const sidebarWrapper = document.getElementById('sidebarWrapper');

    if (navbarCollapse && sidebarWrapper) {
        navbarCollapse.addEventListener('show.bs.collapse', function () {
            sidebarWrapper.classList.add('navbar-open');
        }); 

        navbarCollapse.addEventListener('hide.bs.collapse', function () {
            setTimeout(() => {
                sidebarWrapper.classList.remove('navbar-open');
            }, 450);
        });
    }
});
</script>
