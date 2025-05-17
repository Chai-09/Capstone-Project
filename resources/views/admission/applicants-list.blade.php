@extends('admission.admission-home')

@section('content')
<!-- this new file shows yung list ng applicants -->

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

@endsection

</body>
</html>
