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
