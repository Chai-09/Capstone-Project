<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admissions | Dashboard</title>
</head>
<body>
<!-- this new file shows yung list ng applicants -->
<nav class="navbar bg-dark p-3">
    <p style="color: white" class="m-0"> {{ auth()->user()->name }}</p>
    <a href="{{ route('admissionhome') }}" class="btn btn-primary">
    Back
</a>
    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
</nav>
<div class="container mt-5">
<form method="GET" class="row mb-4">
    <div class="col-md-3 mb-2">
        <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
    </div>
    <div class="col-md-3 mb-2">
        <select name="grade_level" class="form-control">
            <option value="">All Grade Levels</option>
            <option value="Kinder" {{ request('grade_level') == 'Kinder' ? 'selected' : '' }}>Kinder</option>
            @for ($i = 1; $i <= 12; $i++)
                <option value="Grade {{ $i }}" {{ request('grade_level') == "Grade $i" ? 'selected' : '' }}>Grade {{ $i }}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-3 mb-2">
        <select name="stage" class="form-control">
            <option value="">All Stages</option>
            @for ($s = 1; $s <= 6; $s++)
                <option value="{{ $s }}" {{ request('stage') == $s ? 'selected' : '' }}>{{ $s }}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-3 mb-2">
        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
    </div>
</form>


    <h3 class="mb-4">List of Applicants</h3>

    @if(count($applicants) > 0)
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>Contact Number</th>
                    <th>Current School</th>
                    <th>Grade Level</th>
                    <th>Current Stage</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applicants as $applicant): ?>
                    <tr>
                        <td>
                            {{ $applicant->applicant_fname }}
                            {{ $applicant->applicant_mname ? $applicant->applicant_mname . '.' : '' }}
                            {{ $applicant->applicant_lname }}
                        </td>
                        <td>{{ $applicant->formSubmission->applicant_email ?? 'N/A' }}</td>
                        <td>{{ $applicant->formSubmission->applicant_contact_number ?? 'N/A' }}</td>
                        <td>{{ $applicant->current_school ?? 'N/A' }}</td>
                        <td>{{ $applicant->incoming_grlvl ?? 'N/A' }}</td>
                        <td>{{ $applicant->current_step }}</td>
                        <td>
                            <!-- Edit button -->
                            <a href="{{ route('admission.editApplicant', ['id' => $applicant->id]) }}" class="btn btn-sm btn-primary me-2" title="Edit">
    <i class="bi bi-pencil-square"></i>
</a>


                            <!-- Delete button -->
                            <form action="{{ route('admission.applicants.destroy', $applicant->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" title="Delete"
        onclick="return confirm('Are you sure you want to delete this applicant?');">
        <i class="bi bi-trash"></i>
    </button>
</form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {!! $applicants->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    @else
        <p class="text-center">No applicants found.</p>
    @endif
</div>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ session('success') }}',
        confirmButtonText: 'OK',
        customClass: {
            popup: 'swal2-border-radius'
        }
    });
</script>
@endif


</body>
</html>
