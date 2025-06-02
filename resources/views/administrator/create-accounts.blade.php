@extends('administrator.index')

@section('content')
@vite('resources/js/administrator/create-account.js')

{{-- Breadcrumbs --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admindashboard') }}" class="text-decoration-none">Back</a>
        </li>   
    </ol>
</nav>

<hr>

<div class="container">
    {{-- Server Side Validation --}}
    @include('administrator.error.server-side-error')

    {{-- Front End Error --}}
    <div id="alert-wrap">
        <div id="alert-container"></div>
    </div>
    
    <form action="{{ route('admin.createAccount') }}" method="POST" id="adminAccountCreate">
    @csrf
        {{-- @if ($errors->any())
            <div style="background: #ffe0e0; padding: 10px; border: 1px solid red; margin-top: 10px;">
                <strong>Form submission failed:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color: red;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

    <div class="card p-4 shadow-sm rounder-4 border-0">
        <h5 class="text-dark fw-bold mb-4"><i class="bi bi-person-lines-fill me-2"></i>Create Account</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label text-muted small">First Name</label><br>
                <input type="text" class="form-control" name="applicant_fname" placeholder="First Name" required>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small">Middle Initial</label><br>
                <input type="text" class="form-control" name="applicant_mname" placeholder="Middle Initial">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small">Last Name</label><br>
                <input type="text" class="form-control" name="applicant_lname" placeholder="Last Name" required>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-12">
                <label class="form-label text-muted small">Email</label><br>
                <input type="email" class="form-control" name="applicant_email" id="email" placeholder="Enter email address" required>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-12">
                <label class="form-label text-muted small">Role</label><br>
                <select name="role" class="form-control" id="role" required>
                    <option value="">Select Role</option>
                        @foreach (['Administrator', 'Admission', 'Accounting'] as $role)
                    <option value="{{ $role }}">{{ $role }}</option>
                        @endforeach
                </select>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-12">
                <label class="form-label text-muted small">Password</label><br>
                <input type="text" class="form-control" name="password" placeholder="Password" required>
            </div>
        </div>

        <div class="row g-3 mt-2 mb-4">
            <div class="col-md-12">
                <label class="form-label text-muted small">Confirm Password</label><br>
                <input type="text" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <button type="submit" class="btn btn-success">Save</button>
    </div>
    </form>
</div>
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

@endsection