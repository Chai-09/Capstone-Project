@extends('admission.admission-home')

@section('content')


<div class="dashboard">
  <div class="content">
    <h2 class="text-white mb-4 fw-semibold">Exam Results</h2>
  </div>
</div>


<div class="table-design">

    <form method="GET">
        <div class="filter-bar" style="gap: 10px;">
            <div class="dropdown">
                <button class="btn btn-filter dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Add filter
                </button>
                <div class="dropdown-menu p-3" style="min-width: 300px;">

                    {{-- Results --}}
                    <div class="mb-3">
                        <label for="result" class="form-label">Results</label>
                        <select name="result" id="result" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All Result</option>
                                <option value="pending" {{ request('result') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="passed" {{ request('result') == 'passed' ? 'selected' : '' }}>Passed</option>
                                <option value="no show" {{ request('result') == 'no_show' ? 'selected' : '' }}>No Show</option>
                                <option value="failed" {{ request('result') == 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="scholarship" {{ request('result') == 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                                <option value="interview" {{ request('result') == 'interview' ? 'selected' : '' }}>Interview</option>
                        </select>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All Statuses</option>
                            <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                            <option value="no show" {{ request('status') == 'no show' ? 'selected' : '' }}>No Show</option>
                        </select>
                    </div>
                </div>
            </div>


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
                        <th>Applicant Name</th>
                        <th>Grade Level</th>
                        <th>Exam Date</th>
                        <th>Exam Status</th>
                        <th>Exam Result</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $result)

                        @php 
                        $isReadOnly = $result->exam_result !== 'pending' || $result->exam_status === 'no show';
                        @endphp 
                    <tr>
                        <td>{{ $result->applicant_name }}</td>
                        <td>{{ $result->incoming_grade_level }}</td>
                        <td>{{ \Carbon\Carbon::parse($result->exam_date)->format('F d, Y') }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', strtolower($result->exam_status))) }}</td>
                    
                        <td>
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="exam_result" class="form-select" {{ $isReadOnly ? 'disabled' : '' }}>
                                        <option value="pending" {{ $result->exam_result === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="passed" {{ $result->exam_result === 'passed' ? 'selected' : '' }}>Passed</option>
                                        <option value="failed" {{ $result->exam_result === 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="scholarship" {{ $result->exam_result === 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                                        <option value="interview" {{ $result->exam_result === 'interview' ? 'selected' : '' }}>Interview</option>
                                        <option value="no show"
                                            {{ $result->exam_result === 'no show' ? 'selected' : '' }}
                                            style="{{ $result->exam_status !== 'no show' ? 'display: none;' : '' }}">
                                            No Show
                                        </option>
                                    </select>                      
                                </div>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('exam.results.update') }}">
                                @csrf
                                <input type="hidden" name="applicant_id" value="{{ $result->applicant_id }}">
                                <input type="hidden" name="exam_result" class="hidden-result-value">
                                
                            <div class="text-center mt-2">
                                @if ($isReadOnly)
                                    <button type="button" class="btn btn-success edit-btn me-2" data-editing="false"><i class="bi bi-pencil-square"></i></button>
                                @endif
                                <button type="button" class="btn btn-success submit-btn" {{ $isReadOnly ? 'disabled' : '' }}>&#10003;</button>
                            </div>
                        </form>
                    </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-muted">No applicants marked as done yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
 document.querySelectorAll('.submit-btn').forEach(button => {
    button.addEventListener('click', function () {
        const form = this.closest('form');
        const row = this.closest('tr'); 
        const select = row.querySelector('select[name="exam_result"]');
        const hiddenInput = form.querySelector('.hidden-result-value');

      if (!form || !select || !hiddenInput) return;

        const selectedResult = select.value;
        hiddenInput.value = selectedResult; 

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to set this result to "${selectedResult}".`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, confirm it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});


    @if (session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif
</script>

<script>
    //edit button script block and sweetalerts
    document.querySelectorAll('.submit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            const selectedResult = form.querySelector('select[name="exam_result"]').value;

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to set this result to "${selectedResult}".`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, confirm it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    //sweetalert for sucess
    @if (session('success'))
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    @endif

     // Edit button logic
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const select = row.querySelector('select[name="exam_result"]');
            const confirmBtn = row.querySelector('.submit-btn');

            const isEditing = button.dataset.editing === 'true';

            if (isEditing) {
                // para sa Cancel edit
                if (select) select.setAttribute('disabled', 'disabled');
                if (confirmBtn) confirmBtn.setAttribute('disabled', 'disabled');

                button.innerHTML = '<i class="bi bi-pencil-square"></i>';
                button.classList.remove('btn-danger');
                button.classList.add('btn-success');
                button.dataset.editing = 'false';
            } else {
                // para sa Enable edit
                if (select) select.removeAttribute('disabled');
                if (confirmBtn) confirmBtn.removeAttribute('disabled');

                button.innerHTML = '<i class="bi bi-x-lg"></i>';
                button.classList.remove('btn-success');
                button.classList.add('btn-danger');
                button.dataset.editing = 'true';
            }
        });
    });
</script>

@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>