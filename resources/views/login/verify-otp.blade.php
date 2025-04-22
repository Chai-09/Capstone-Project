@extends('login.index')

@section('content')
<div class="otp-verification" style="padding: 2rem;">
    
    <img src="{{ asset('feudiliman_logo.png') }}" alt="FEU Diliman Logo">

    <h3 class="mb-3">Email Verification</h3>

    <p class="mb-4">We’ve sent a 6-digit OTP code to your email. Please enter it below to complete your sign up (Check Spam Folder).</p>

    @include('login.alert-errors')

    <form method="POST" action="{{ route('signup.verifyOtp') }}">
        @csrf
        <div class="form-group">
            <label for="otp">One-Time Password (OTP)</label>
            <input type="text" name="otp" id="otp" maxlength="6" class="form-control" placeholder="Enter 6-digit code" required>
        </div>

        <div class="form-group">
        <button type="submit" class="btn btn-success w-100">Verify & Create Account</button>
        </div>

    </form>

    
    <div class="form-group mt-3">
      <small>
        <span>Didn't receive it? </span>
        <form method="POST" action="{{ route('signup.resendOtp') }}" style="display:inline;" class="resend-otp-form">
          @csrf
          <button type="submit" class="resend-otp-fake-link">Resend OTP</button>
        </form>
      </small>
    </div>

    <div class="form-group">
      <a href="{{ route('login') }}">Go Back</a>
    </div>

</div>



@endsection
