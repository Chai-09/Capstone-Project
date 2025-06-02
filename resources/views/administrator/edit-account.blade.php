@extends('administrator.index')

@section('content')
@vite('resources/js/administrator/edit-account.js')

{{-- Breadcrumbs --}}
<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admindashboard') }}" class="text-decoration-none">Dashboard</a>
        </li>
        <li class="breadcrumb-item active text-dark" aria-current="page">
            {{ $account->name }}
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

    <form action="{{ route('admin.updateAccount', $account->id) }}" method="POST" id="adminAccountEdit">
    @csrf
    @method('PUT')

    @php
        $nameParts = explode(' ', $account->name);
        $firstName = $nameParts[0] ?? '';
        $middleName = isset($nameParts[1]) ? rtrim($nameParts[1], '.') : '';
        $lastName = $nameParts[2] ?? '';
    @endphp

    <div class="card p-4 shadow-sm rounder-4 border-0">
        <h5 class="text-dark fw-bold mb-4"><i class="bi bi-person-lines-fill me-2"></i>Edit Account Information</h5>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label text-muted small">First Name</label><br>
                <input type="text" class="form-control" name="applicant_fname" placeholder="First Name" value="{{ old('applicant_fname', $first) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small">Middle Initial</label><br>
                <input type="text" class="form-control" name="applicant_mname" placeholder="Middle Initial" value="{{ old('applicant_mname', $middle) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small">Last Name</label><br>
                <input type="text" class="form-control" name="applicant_lname" placeholder="Last Name" value="{{ old('applicant_lname', $last) }}" required>
            </div>
        </div>

        <br>

        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label text-muted small">Email Address</label><br>
                <input type="email" class="form-control" name="applicant_email" id="email" placeholder="Enter email address" value="{{ old('applicant_email', $account->email) }}" required>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-12">
                <label class="form-label text-muted small">Role</label><br>
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
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-12">
                <label class="form-label text-muted small">Password</label><br>
                <input type="password" class="form-control" name="password" placeholder="Password (leave blank to keep current)">
            </div>
        </div>

        <div class="row g-3 mt-2 mb-4">
            <div class="col-md-12">
                <label class="form-label text-muted small">ConfirmPassword</label><br>
                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>

    </div>

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

<script>
   
</script>


@endif

@endsection
