<!DOCTYPE html>
<head>
    <meta name="recaptcha-site-key" content="{{ config('services.recaptcha.site_key') }}">
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
                {{-- <input type="checkbox" name="remember"> Keep me signed in --}}
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

    function isValidEmail(input) {
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return pattern.test(input.trim());
    }


    document.getElementById('login-btn').addEventListener('click', function () {
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const alertContainer = document.getElementById('alert-container') || document.createElement('div');

        // Remove previous errors
        const existing = document.querySelector('.alert-box');
        if (existing) existing.remove();

        let message = '';

        // Email Validation
        if (!email && !password) {
            message = 'Please fill in all required fields.';
        } else if (!isValidEmail(email)) {
            message = 'Invalid email address.';
        } else if (isValidEmail(email) && !password) {
            message = 'Invalid password.';
        }

        // Error display
        if (message !== '') {
            const errorBox = document.createElement('div');
            errorBox.classList.add('alert-box');
            errorBox.innerHTML = `
                <div class="alert-content">
                    <span class="alert-message"><i class="fa-solid fa-circle-exclamation"></i> ${message}</span>
                    <span class="alert-close" onclick="this.parentElement.parentElement.remove()">&times;</span>
                </div>
            `;

            const form = document.getElementById('login-form');
            form.insertBefore(errorBox, form.children[2]);
            return;
        }

        // reCAPTCHA
        grecaptcha.execute(widgetId); //comment out after
        // document.getElementById('login-form').submit(); //remove after
    });

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof initRecaptcha === 'function') {
            initRecaptcha();
        }
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

    // pag pinindot nila back button mag force reload page, para matanggal yung cached swal (di na siya magpapakita)
    if (performance.navigation.type === 2) {
        location.reload(); 
    }
</script>
</html>
