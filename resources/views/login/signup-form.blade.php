<span id="close">&times;</span>
<h3>Create your account</h3>

<form action="{{ route('loginForms.store') }}" method="POST">
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
        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
    </div>

    <button type="submit" class="submit-btn">Sign Up</button>
</form>
