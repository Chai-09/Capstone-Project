@extends('login.index')

@section('content')
<div class="otp-verification">
    
    <img src="{{ asset('feudiliman_logo.png') }}" alt="FEU Diliman Logo">

    <div class="form-group">
      <h3 class="mb-3">Email Verification</h3>
      <div class="note">
        <p>We’ve sent a 6-digit OTP code to your email. Please enter it below to complete your sign up <strong>(Check Spam Folder)</strong>.</p>
      </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    

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
