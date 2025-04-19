<!DOCTYPE html>
<head>
    <script src="https://www.google.com/recaptcha/api.js?onload=initRecaptcha&render=explicit" async defer></script> 
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


<script>
    let widgetId;

function initRecaptcha() {
    const container = document.createElement('div');
    container.style.display = 'none';
    document.body.appendChild(container);

    widgetId = grecaptcha.render(container, {
        sitekey: "{{ config('services.recaptcha.site_key') }}",
        size: "invisible",
        callback: onSubmitRecaptcha
    });
}

document.getElementById('login-btn').addEventListener('click', function () {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    // Trigger blade-based error if fields are empty
    if (!email || !password) {
        const errorBox = document.createElement('div');
        errorBox.classList.add('alert-box');
        errorBox.innerHTML = `<p><i class="fa-solid fa-circle-exclamation"></i> Please fill in all required fields.</p>`;

        // Remove existing errors before appending new
        const existing = document.querySelector('.alert-box');
        if (existing) existing.remove();

        const form = document.getElementById('login-form');
        form.insertBefore(errorBox, form.children[2]); // insert after img + csrf + errors
        return;
    }

    grecaptcha.execute(widgetId);
});

function onSubmitRecaptcha(token) {
    const form = document.getElementById('login-form');

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'g-recaptcha-response';
    input.value = token;
    form.appendChild(input);

    form.submit();
}
</script>
</html>
