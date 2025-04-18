<!DOCTYPE html>
<head>
    <script src="https://www.google.com/recaptcha/api.js?onload=initSignupRecaptcha&render=explicit" async defer></script>
    @vite('resources/js/login/login.js')
</head>
<body>
    <form id="login-form" action="{{ route('login.store') }}" method="POST">
        @csrf
        <img src="feudiliman_logo.png">

        @include('login.alert-errors')

        <div class="form-group">
            <label>Email address</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="remember-forgot">
            <label class="remember-me">
                <input type="checkbox" name="remember"> Keep me signed in
            </label>
            <a href="{{ route('password.request') }}" class="forgot">Forgot Password?</a>
        </div>

        <div class="form-group">
            <button type="button" id="login-btn">
                LOGIN
            </button>
        </div>

        <p class="signup-link">Not yet registered? <a href="#" id="openForms">Sign Up</a></p>
    </form> 
</body>
</html>
