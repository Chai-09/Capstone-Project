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


    <div class="form-group">
        <label>Email address</label>
        <input type="email" name="email" value="{{ $email }}" readonly placeholder="Password Reset Has Expired">
    </div>

    <div class="form-group">
        <label>New Password</label>
        <input type="password" name="password" required>
    </div>

    <div class="form-group">
        <label>Confirm New Password</label>
        <input type="password" name="password_confirmation" required>
    </div>

    <div class="form-group">
        <button type="submit">Reset Password</button>
    </div>

    <div class="form-group">
        <a href="{{ route('login') }}">Go Back</a>
    </div>
</form>
@endsection
