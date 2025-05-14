@extends('login.index')

@section('content')
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <img src="{{ asset('feudiliman_logo.png') }}" alt="FEU Diliman Logo">
    <input type="hidden" name="token" value="{{ $token }}">

    <h3>Reset Password</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @include('login.alert-errors')
    <div id="alert-container"></div>

    <div class="form-group">
        <label>Email address</label>
        <input type="email" name="email" value="{{ $email }}" readonly placeholder="Password Reset Has Expired">
    </div>

    <div class="form-group">
        <label>New Password</label>
        <input type="password" name="password"  id="reset-password"required>
    </div>

    <div class="form-group">
        <label>Confirm New Password</label>
        <input type="password" name="password_confirmation" id="reset-password-confirmation"required>
    </div>

    <div class="form-group">
        <button type="button" id="reset-btn">Reset Password</button>
    </div>

    <div class="form-group">
        <a href="{{ route('login') }}">Go Back</a>
    </div>
</form>
 <script>
    function showSignupError(message) {
        const alertContainer = document.getElementById('alert-container');

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

    function isValidPassword(passwordInput) {
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        return passwordPattern.test(passwordInput.trim());
    }

    document.getElementById('reset-btn').addEventListener('click', function (e) {
        e.preventDefault(); 

        const form = this.closest('form');
        const password = document.getElementById('reset-password').value.trim();
        const confirmPassword = document.getElementById('reset-password-confirmation').value.trim();

        // Reset borders
        document.getElementById('reset-password').classList.remove('border-danger');
        document.getElementById('reset-password-confirmation').classList.remove('border-danger');

        if (password === "" || confirmPassword === "") {
            showSignupError('Please fill in both password fields.');
            document.getElementById('reset-password').classList.add('border-danger');
            document.getElementById('reset-password-confirmation').classList.add('border-danger');
            return;
        } else {
            document.getElementById('reset-password').classList.remove('border-danger');
            document.getElementById('reset-password-confirmation').classList.remove('border-danger');
        }

        // Validate password format
        if (!isValidPassword(password)) {
            showSignupError('Password must be at least 8 characters and include uppercase, lowercase, number, and special character.');
            document.getElementById('reset-password').classList.add('border-danger');
            return;
        } else {
            document.getElementById('reset-password').classList.remove('border-danger');
        }

        // Check password match
        if (password !== confirmPassword) {
            showSignupError('Passwords do not match.');
            document.getElementById('reset-password-confirmation').classList.add('border-danger');
            return;
        } else {
            document.getElementById('reset-password-confirmation').classList.remove('border-danger');
        }

        form.submit();
    });
</script>

@endsection
