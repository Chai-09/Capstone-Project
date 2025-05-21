<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <title>ApplySmart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/2c99ab7d67.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite('resources/css/login/login.css')
    @vite('resources/js/app.js')


</head>
<body>
<!-- Modal: College Notice -->
<div class="modal fade" id="collegeNoticeModal" tabindex="-1" aria-labelledby="collegeNoticeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow rounded-3">
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-dark" id="collegeNoticeModalLabel">
                    <i class="fas fa-triangle-exclamation text-warning me-2"></i> Important Notice
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="/images/login/college-warning.png" alt="Not for college" class="img-fluid mb-2" style="max-height: 300px;">
                <br>
                This admission form is for students applying in the K-12 Program (Kinder to Grade 12). If you
                are applying for the Tertiary Level, please refer to the Tertiary Level’s Admission Form. You may
                contact The School’s Admissions Office for the Admission Form for the Tertiary Level.
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" data-bs-dismiss="modal">Got it</button>
            </div>
        </div>
    </div>
</div>


<div class="main">
    <div class="wrapper1">
        <img src="/images/login/logo_name.png">

        <div class="container">
            <div class="contents">
                <h2>FEU Diliman</h2>
                <h1>BE A <span>TAMARAW</span> NOW!</h1>
                <p><i class="fa-solid fa-check"></i> Kinder to Grade 6</p>
                <p><i class="fa-solid fa-check"></i> Junior High School</p>
                <p><i class="fa-solid fa-check"></i> Senior High School</p>
            </div>
        </div>
    </div>
    
    <div class="wrapper2">
        <div id="loginforms">
            @hasSection('content')
                @yield('content')
            @else
                @include('login.login-form')
            @endif
        </div>

        <div id="formsModal">
            @include('login.signup-form')
        </div>
    </div>
</div>

</body>
</html>

@if (session('just_logged_out'))
<script>
    // Clear the flag on logout so it can show again next time
    localStorage.removeItem('collegeNoticeSeen');
</script>
@endif

@if (session('show_college_modal') && request()->is('login'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        // Show modal only if not previously seen in this browser
        if (!localStorage.getItem('collegeNoticeSeen')) {
            const modal = new bootstrap.Modal(document.getElementById('collegeNoticeModal'));
            modal.show();
            localStorage.setItem('collegeNoticeSeen', 'true');
        }
    });
</script>
@endif

{{-- Validation when account is created successfully. --}}
@if (session()->has('success'))
<script>
Swal.fire({
    title: "Success!",
    text: "{{ session('success') }}",
    icon: "success",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    background: '#f0fff4',
    iconColor: '#16a34a', 
    customClass: {
        popup: 'rounded-xl shadow-lg',
        title: 'text-lg font-semibold text-green-800',
        htmlContainer: 'text-sm text-green-700'
    }
});
</script>
@endif

<script>
    function onLoginSubmit(token) {
        document.getElementById("login-form").submit();
    }

    function onSignupSubmit(token) {
        document.getElementById("signup-form").submit();
    }
</script>

</body>
</html>
