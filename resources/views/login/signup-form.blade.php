<!DOCTYPE html>
<head>
    <meta name="recaptcha-site-key" content="{{ config('services.recaptcha.site_key') }}">
    <script src="https://www.google.com/recaptcha/api.js?onload=initSignupRecaptcha&render=explicit" async defer></script>
</head>

<body>
    <span id="close">&times;</span>
    <h3>Create your account</h3>
    <div id="alert-container"></div>


    <form id="signup-form" action="{{ route('signup.requestOtp') }}" method="POST">
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
                        <input type="text" name="guardian_mname" placeholder="Middle Initial" value="{{ old('guardian_mname') }}">
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
                <p>Password must be at least 8 characters long and include at least one uppercase letter and one number.</p>
                <input type="password" name="password" id="signup-password" required>
            </div>

            <div class="form-group">
                <label for="repassword">Confirm Password <span class="required">*</span></label>
                <input type="password" name="repassword" id="signup-repassword" required>
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
                        <input type="text" name="applicant_mname" placeholder="Middle Initial">
                    </div>
                    <div class="name-field">
                        <input type="text" name="applicant_lname" placeholder="Last Name" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="current_school">Current School <span class="required">*</span></label>
                <p>If incoming Grade is Kinder, type N/A</p>
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
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="agreeTerms" name="agreeTerms">
                <p for="agreeTerms">I agree to the <a href="{{ route('terms-and-condition') }}" target="_blank" rel="noopener noreferrer">Terms of Service</a>, <a href="{{ route('privacy-policy') }}" target="_blank" rel="noopener noreferrer">Privacy Policy</a>, including <a href="{{ route('cookies-use') }}" target="_blank" rel="noopener noreferrer">Cookie Use</a></p>
            </div>
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

    function showSignupError(message) {
        const alertContainer = document.getElementById('alert-container');

        // Clear existing alerts
        const existing = document.querySelector('.alert-box');
        if (existing) existing.remove();

        const errorBox = document.createElement('div');
        errorBox.classList.add('alert-box');
        errorBox.innerHTML = `
            <div class="alert-content">
                <div class="alert-message">
                    <span class="alert-message"><i class="fa-solid fa-circle-exclamation"></i> ${message}</span>
                </div>
                <span class="alert-close" onclick="this.parentElement.parentElement.remove()">&times;</span>
            </div>
        `;

        alertContainer.appendChild(errorBox);
    }

    document.getElementById('signup-btn').addEventListener('click', function () {
        const form = document.getElementById('signup-form');
        const requiredFields = form.querySelectorAll('[required]');
        const checkbox = document.getElementById('agreeTerms')
        let allValid = true;
        let invalidEmail = false;
        const password = document.getElementById('signup-password').value.trim();
        const repassword = document.getElementById('signup-repassword').value.trim();
        const guardianMi = form.querySelector('[name="guardian_mname"]').value.trim();
        const applicantMi = form.querySelector('[name="applicant_mname"]').value.trim();


        requiredFields.forEach(field => {
            const value = field.value.trim();
            
            // Required fields with no input
            if (!value) {
                allValid = false;
                field.classList.add('border-danger');
            } else {
                field.classList.remove('border-danger');
            }
            
            // Email Validation
            if (field.name === 'guardian_email' && value) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(value)) {
                    invalidEmail = true;
                    field.classList.add('border-danger');
                } else {
                    field.classList.remove('border-danger');
                }
            }   
            
        });

        // Shows error for required fields with no input
        if (!allValid) {
            showSignupError('Please fill in all required fields.');
            return;
        }

        // Shows error for invalid email input
        if (invalidEmail) {
            showSignupError('Invalid email address.');
            return;
        }

        //  Password Validation (Paki comment-out to try)
        function isValidPassword(passwordInput) {
            const passwordPattern = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
            return passwordInput === "" || passwordPattern.test(passwordInput.trim());
        }

        if (!isValidPassword(password)) {
            showSignupError('Password must be at least 8 characters long and include at least 1 uppercase letter and 1 number.');
            document.getElementById('signup-password').classList.add('border-danger');
            return;
        } else {
            document.getElementById('signup-password').classList.remove('border-danger');
        }


        if (password.length < 6) {
            showSignupError('Password must be at least 6 characters.');
            document.getElementById('signup-password').classList.add('border-danger');
            document.getElementById('signup-repassword').classList.add('border-danger'); 
            return;
        }

        if (password !== repassword) {
            showSignupError('Passwords do not match.');
            document.getElementById('signup-repassword').classList.add('border-danger');
            return;
        }

        // Middle Initial Validation (In case nag input si applicant)
        function isValidMiddleInitial(input) {
            const miPattern = /^[A-Z]{1,2}\.?$/i;
            return input === "" || miPattern.test(input.trim());
        }
    
        if(!isValidMiddleInitial(guardianMi) && !isValidMiddleInitial(applicantMi)) {
            showSignupError("Middle name must be initials only (e.g., A. or AL.)");
            form.querySelector('[name="guardian_mname"]').classList.add('border-danger');
            form.querySelector('[name="applicant_mname"]').classList.add('border-danger');
            return;
        } else {
            form.querySelector('[name="guardian_mname"]').classList.remove('border-danger');
        }

        if (!isValidMiddleInitial(guardianMi)) {
            showSignupError("Middle name must be initials only (e.g., A. or AL.)");
            form.querySelector('[name="guardian_mname"]').classList.add('border-danger');
            return;
        } else {
            form.querySelector('[name="guardian_mname"]').classList.remove('border-danger');
        }

        if (!isValidMiddleInitial(applicantMi)) {
            showSignupError("Middle name must be initials only (e.g., A. or AL.)");
            form.querySelector('[name="applicant_mname"]').classList.add('border-danger');
            return;
        } else {
            form.querySelector('[name="applicant_mname"]').classList.remove('border-danger');
        }

        // ✅ Checkbox Validation
        if (!checkbox.checked) {
            showSignupError('You must agree to the Terms, Privacy Policy, and Cookie Use before signing up.');
            return;
        }

        grecaptcha.execute(signupWidgetId); 
    });

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof initSignupRecaptcha === 'function') {
            initSignupRecaptcha(); 
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
