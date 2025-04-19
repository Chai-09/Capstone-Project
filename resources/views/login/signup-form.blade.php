<!DOCTYPE html>
<head>
    <meta name="recaptcha-site-key" content="{{ config('services.recaptcha.site_key') }}">
    <script src="https://www.google.com/recaptcha/api.js?onload=initSignupRecaptcha&render=explicit" async defer></script>
</head>

<body>
    <span id="close">&times;</span>
    <h3>Create your account</h3>

    <form id="signup-form" action="{{ route('loginForms.store') }}" method="POST">
        @csrf

        <!-- Guardian Section -->
        <fieldset>
            <div class="form-group">
                <label>Guardian's Full Name <span class="required">*</span></label>
                <p>Example: Jeremy E. Joseph</p>
                <div class="name-fields">
                    <div class="name-field">
                        <input type="text" name="guardian_fname" placeholder="First Name" required>
                    </div>
                    <div class="name-field">
                        <input type="text" name="guardian_mname" placeholder="Middle Name" value="{{ old('guardian_mname') }}">
                    </div>
                    <div class="name-field">
                        <input type="text" name="guardian_lname" placeholder="Last Name" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="guardian_email">Email Address <span class="required">*</span></label>
                <input type="email" name="guardian_email" id="guardian_email" required>
            </div>

            <div class="form-group">
                <label for="password">Password <span class="required">*</span></label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="repassword">Confirm Password <span class="required">*</span></label>
                <input type="password" name="repassword" id="repassword" required>
            </div>
        </fieldset>

        <!-- Applicant Section -->
        <fieldset>
            <div class="form-group">
                <label>Applicant's Full Name <span class="required">*</span></label>
                <p>Example: Jeremy E. Joseph</p>
                <div class="name-fields">
                    <div class="name-field">
                        <input type="text" name="applicant_fname" placeholder="First Name" required>
                    </div>
                    <div class="name-field">
                        <input type="text" name="applicant_mname" placeholder="Middle Name">
                    </div>
                    <div class="name-field">
                        <input type="text" name="applicant_lname" placeholder="Last Name" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="current_school">Current School <span class="required">*</span></label>
                <input type="text" name="current_school" id="current_school" required>
            </div>

            <div class="form-group">
                <label for="incoming_grlvl">Incoming Grade Level <span class="required">*</span></label>
                <select name="incoming_grlvl" id="incoming_grlvl" required>
                    <option value="">Select Grade Level</option>
                    @foreach (['Kinder','Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6','Grade 7','Grade 8','Grade 9','Grade 10','Grade 11','Grade 12'] as $grade)
                        <option value="{{ $grade }}">{{ $grade }}</option>
                    @endforeach
                </select>
            </div>
        </fieldset>

        <div class="terms">
            <p>By signing up, you agree to the <a href="#">Terms of Service</a>, <a href="#">Privacy Policy</a>, including <a href="#">Cookie Use</a></p>
        </div>

        <div class="form-group">
            <button type="button" id="signup-btn" class="submit-btn">Sign Up</button>
        </div>
    </form>
</body>

<script>
    let signupWidgetId;

function initSignupRecaptcha() {
    const container = document.createElement('div');
    container.style.display = 'none';
    document.body.appendChild(container);

    signupWidgetId = grecaptcha.render(container, {
        sitekey: document.querySelector('meta[name="recaptcha-site-key"]').content,
        size: 'invisible',
        callback: onSignupCaptchaSuccess
    });
}

document.getElementById('signup-btn').addEventListener('click', function () {
    const form = document.getElementById('signup-form');
    const requiredFields = form.querySelectorAll('[required]');
    let allValid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            allValid = false;
            field.classList.add('border-danger');
        } else {
            field.classList.remove('border-danger');
        }
    });

    // Password match check
    const password = document.getElementById('password').value.trim();
    const repassword = document.getElementById('repassword').value.trim();
    if (password && repassword && password !== repassword) {
        allValid = false;
        alert('Passwords do not match.');
    }

    if (allValid) {
        grecaptcha.execute(signupWidgetId);
    }
});

function onSignupCaptchaSuccess(token) {
    const form = document.getElementById('signup-form');

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'g-recaptcha-response';
    input.value = token;
    form.appendChild(input);

    form.submit();
}
</script>
</html>
