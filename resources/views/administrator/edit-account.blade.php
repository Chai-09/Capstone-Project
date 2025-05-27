<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Edit Account</title>
</head>
<body>

<nav class="navbar bg-dark">
<p style="color: white"> {{ auth()->user()->name }}</p>
</nav>
<a href="{{ route('admindashboard') }}" class="btn btn-secondary">Back</a>
<form action="{{ route('admin.updateAccount', $account->id) }}" method="POST">
@csrf
@method('PUT')

@php
    // Split name into parts (assuming "FIRST M. LAST" format)
    $nameParts = explode(' ', $account->name);
    $firstName = $nameParts[0] ?? '';
    $middleName = isset($nameParts[1]) ? rtrim($nameParts[1], '.') : '';
    $lastName = $nameParts[2] ?? '';
@endphp

<p>First Name</p>
<input type="text" name="applicant_fname" placeholder="First Name" value="{{ old('applicant_fname', $first) }}" required>

<p>Middle Initial</p>
<input type="text" name="applicant_mname" placeholder="Middle Initial" maxlength="1" value="{{ old('applicant_mname', $middle) }}">

<p>Last Name</p>
<input type="text" name="applicant_lname" placeholder="Last Name" value="{{ old('applicant_lname', $last) }}" required>

<p>Email Address</p>
<input type="email" name="applicant_email" id="email" placeholder="Enter email address" value="{{ old('applicant_email', $account->email) }}" required>

<p>Role</p>

@if (strtolower($account->role) === 'applicant')
    <input type="text" class="form-control" value="Applicant" readonly>
    <input type="hidden" name="role" value="applicant">
@else
    <select name="role" id="role" required class="form-select">
        <option value="">Select Role</option>
        @foreach (['Administrator', 'Admission', 'Accounting'] as $role)
            <option value="{{ $role }}" {{ old('role', ucfirst($account->role)) === $role ? 'selected' : '' }}>{{ $role }}</option>
        @endforeach
    </select>
@endif


<p>Password</p>
<input type="password" name="password" placeholder="Password (leave blank to keep current)">

<p>Confirm Password</p>
<input type="password" name="password_confirmation" placeholder="Confirm Password">

<button type="submit" class="btn btn-success">Update</button>
</form>

@if (session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: '{{ session('success') }}',
        icon: 'success',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    });
</script>
@endif
</body>
</html>

