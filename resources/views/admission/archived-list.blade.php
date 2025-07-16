@extends('admission.admission-home')

@section('content')

<div class="dashboard">
  <div class="content">
    <h2 class="text-white mb-4 fw-semibold">Archived Applicants</h2>
  </div>
</div>

<div class="table-design">
    @if (session('success'))
        <script>window.flashSuccess = @json(session('success'));</script>
    @endif

    <form method="GET" id="filterForm">
        <div class="filter-bar" style="gap: 10px;">
            <select name="grade_level" class="form-select" style="width: 200px;">
                <option value="">All Grade Levels</option>
                <option value="Kinder" {{ request('grade_level') == 'Kinder' ? 'selected' : '' }}>Kinder</option>
                <option value="Grade 1" {{ request('grade_level') == 'Grade 1' ? 'selected' : '' }}>Grade 1</option>
                <option value="Grade 2" {{ request('grade_level') == 'Grade 2' ? 'selected' : '' }}>Grade 2</option>
                <option value="Grade 3" {{ request('grade_level') == 'Grade 3' ? 'selected' : '' }}>Grade 3</option>
                <option value="Grade 4" {{ request('grade_level') == 'Grade 4' ? 'selected' : '' }}>Grade 4</option>
                <option value="Grade 5" {{ request('grade_level') == 'Grade 5' ? 'selected' : '' }}>Grade 5</option>
                <option value="Grade 6" {{ request('grade_level') == 'Grade 6' ? 'selected' : '' }}>Grade 6</option>
                <option value="Grade 7" {{ request('grade_level') == 'Grade 7' ? 'selected' : '' }}>Grade 7</option>
                <option value="Grade 8" {{ request('grade_level') == 'Grade 8' ? 'selected' : '' }}>Grade 8</option>
                <option value="Grade 9" {{ request('grade_level') == 'Grade 9' ? 'selected' : '' }}>Grade 9</option>
                <option value="Grade 10" {{ request('grade_level') == 'Grade 10' ? 'selected' : '' }}>Grade 10</option>
                <option value="Grade 11" {{ request('grade_level') == 'Grade 11' ? 'selected' : '' }}>Grade 11</option>
                <option value="Grade 12" {{ request('grade_level') == 'Grade 12' ? 'selected' : '' }}>Grade 12</option>
            </select>
            <div class="search-wrapper">
                <input type="text" name="search" class="search-input" placeholder="Search for an applicant by name or email" value="{{ request('search') }}">
                <i class="bi bi-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #888;"></i>
            </div>
            <button type="submit" class="btn btn-search">Search</button>
        </div>
    </form>



    <div class="table-wrapper">
    <table class="custom-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Grade Level</th>
            <th>Action</th>
        </tr>
    </thead>

    @if ($applicants->count() > 0)
        <tbody>
            @foreach ($applicants as $applicant)
                <tr>
                    <td>{{ ($applicants->currentPage() - 1) * $applicants->perPage() + $loop->iteration }}</td>
                    <td>{{ $applicant->applicant_fname }} {{ $applicant->applicant_lname }}</td>
                    <td>{{ $applicant->formSubmission->applicant_email ?? 'N/A' }}</td>
                    <td>{{ $applicant->incoming_grlvl ?? 'N/A' }}</td>
                    <td>
                        <button type="button" class="btn btn-success btn-sm restore-btn" data-id="{{ $applicant->id }}" data-name="{{ $applicant->applicant_fname }} {{ $applicant->applicant_lname }}">
                            <i class="bi bi-arrow-counterclockwise"></i> Restore
                        </button>

                        <form id="restore-form-{{ $applicant->id }}" action="{{ route('admission.applicants.restore', $applicant->id) }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    @else
        <tbody>
            <tr>
                <td colspan="5" class="text-center">No archived applicants found.</td>
            </tr>
        </tbody>
    @endif
</table>

<div class="d-flex justify-content-center mt-4">
    {{ $applicants->withQueryString()->links('pagination::bootstrap-5') }}
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('filterForm');
        const selects = form.querySelectorAll('select');

        selects.forEach(select => {
            select.addEventListener('change', () => {
                form.submit();
            });
        });

        document.querySelectorAll('.restore-btn').forEach(button => {
            button.addEventListener('click', function() {
                const applicantName = this.dataset.name;
                const applicantId = this.dataset.id;

                Swal.fire({
                    title: 'Restore Applicant?',
                    text: `Are you sure you want to restore ${applicantName}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, restore',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`restore-form-${applicantId}`).submit();
                    }
                });
            });
        });
    });
</script>

@endsection
