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

<form action="{{ route('admin.updateAccount', $account->id) }}" method="POST">
@csrf
@method('PUT')

    <p>First Name</p>
    <input type="text" name="applicant_fname" placeholder="First Name" required>

    <p>Middle Initial</p>
    <input type="text" name="applicant_mname" placeholder="Middle Initial">

    <p>Last Name</p>
    <input type="text" name="applicant_lname" placeholder="Last Name" required>

    <p>Email Address</p>
    <input type="email" name="applicant_email" id="email" placeholder="Enter email address">

    <p>Role</p>
    <select name="role" id="role" required>
        <option value="">Select Role</option>
        @foreach (['Administrator', 'Admission', 'Accounting'] as $role)
        <option value="{{ $role }}">{{ $role }}</option>
        @endforeach
    </select>

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

