@extends('login.index')

@section('content')
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <img src="feudiliman_logo.png">

    <h3>Forgot Password</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @include('login.alert-errors')

    <div class="form-group">
        <label>Email address</label>
        <input type="email" name="email" required>
    </div>

    <div class="form-group">
        <button type="submit">Send Reset Link</button>
    </div>
    {{-- Back Button baka gusto niyo ibahin --}}
    <div class="form-group">
        <a href="{{ route('login') }}" >Go Back</a>
    </div>
</form>


@endsection
