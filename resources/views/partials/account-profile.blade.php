<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <title> ApplySmart | Administrator </title>

    {{-- CSS --}}
    @vite('resources/css/partials/sidebar.css')
    @vite('resources/css/partials/layout.css')
    @vite('resources/css/partials/dashboard.css')
    @vite('resources/css/administrator/edit-account.css')
    @vite('resources/css/partials/tables.css')


    {{-- JS --}}
    @vite('resources/js/partials/sidebar.js')
    @vite('resources/js/partials/account-profile.js')


</head>
<body>

<div class="d-flex">
    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    {{-- Main Content --}}
    <div class="container table-design" id="content" class="flex-grow-1 p-2">

        <div class="dashboard">
            <div class="content">
                <h2 class="text-white mb-4 fw-semibold">Profile</h2>
            </div>
        </div>  

        <div class="container">
            {{-- Front End Validation --}}
            <div id="alert-wrap">
                <div id="alert-container"></div>
            </div>

            {{-- Server Side Validation --}}
            @include('administrator.error.server-side-error')

            <form method="POST" action="{{ route('account.profile.update') }}" id="accountProfile">
                @csrf
                @method('PUT')
                <div class="card p-4 shadow-sm rounder-4 border-0">
                    <h5 class="text-dark fw-bold mb-4"><i class="bi bi-person-lines-fill me-2"></i>Edit Account Information</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted small">First Name</label><br>
                            <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ old('first_name', $first) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Middle Initial</label><br>
                            <input type="text" class="form-control" name="middle_name" placeholder="Middle Initial" value="{{ old('middle_name', $middle) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Last Name</label><br>
                            <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{ old('last_name', $last) }}" required>
                        </div>
                    </div>

                    <br>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted small">Email</label><br>
                            <input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>

                    <br>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted small">Password</label><br>
                            <input type="password" name="password" class="form-control" placeholder="Password (leave blank to keep current)">
                        </div>
                    </div>

                    <br>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted small">Confirm Password</label><br>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

</body>

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

</html>

