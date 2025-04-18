<form id="login-form" action="{{ route('login.store') }}" method="POST">
    @csrf
    <img src="feudiliman_logo.png">

    @include('login.alert-errors')

    <div class="form-group">
        <label>Email address</label>
        <input type="email" name="email" required>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>

    <div class="remember-forgot">
        <label class="remember-me">
            <input type="checkbox" name="remember"> Keep me signed in</label>
            <a href="{{ route('password.request') }}" class="forgot">Forgot Password?</a>
    </div>

    {{-- Button para ma trigger recaptcha check check js sa index--}}
    <button
            class="g-recaptcha"
            data-sitekey="{{ config('services.recaptcha.site_key') }}"
            data-callback="onLoginSubmit"
            data-badge="bottomright"
            data-action="login"
         >LOGIN</button>

    <p class="signup-link">Not yet registered? <a href="#" id="openForms">Sign Up</a></p>
</form>
 