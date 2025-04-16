<form action="{{ route('login.store') }}" method="POST">
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

    <div class="form-group">
        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
    </div>

    <button type="submit">LOGIN</button>

    <p class="signup-link">Not yet registered? <a href="#" id="openForms">Sign Up</a></p>
</form>
