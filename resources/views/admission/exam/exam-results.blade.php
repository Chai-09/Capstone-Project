@extends('admission.admission-home')

@section('content')


<style>
.custom-exam-result {
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
    font-size: 0.9rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.custom-exam-result:focus {
    border-color: #198754;
    box-shadow: 0 0 0 0.15rem rgba(25, 135, 84, 0.25);
}

.btn-action {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    font-size: 1rem;
    border-radius: 6px;
}
</style>


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
                            <th style="width: 10%;">#</th>
                            <th style="width: 25%; position: relative;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Applicant Name</span>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm p-1 px-2 border rounded"
                                        type="button"
                                        id="sortNameDropdown"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        style="line-height: 1;">
                                        <i class="bi bi-funnel"></i>
                                    </button>
                                     <ul class="dropdown-menu dropdown-menu-end" >
                                        <li class="dropdown-header fw-semibold">Sort by Name</li>
                                        <li><a class="dropdown-item {{ request('sort_name') == 'asc' ? 'active' : '' }}"
                                            href="{{ request()->fullUrlWithQuery(['sort_name' => 'asc', 'sort_date' => null, 'sort_grade' => null]) }}">A-Z</a></li>
                                        <li><a class="dropdown-item {{ request('sort_name') == 'desc' ? 'active' : '' }}"
                                            href="{{ request()->fullUrlWithQuery(['sort_name' => 'desc', 'sort_date' => null, 'sort_grade' => null]) }}">Z-A</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item {{ !request('sort_name') ? 'active' : '' }}"
                                            href="{{ request()->url() }}">Default</a></li>
                                    </ul>
                                    </div>
                                </div>
                            </th>
                        
                             <th style="width: 10%;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Grade Level</span>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm p-1 px-2 border rounded"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <i class="bi bi-funnel"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li class="dropdown-header fw-semibold">Sort by Grade</li>
                                            <li><a class="dropdown-item {{ request('sort_grade') == 'asc' ? 'active' : '' }}"
                                                href="{{ request()->fullUrlWithQuery(['sort_grade' => 'asc', 'sort_name' => null, 'sort_date' => null]) }}">Kinder to Grade 12</a></li>
                                            <li><a class="dropdown-item {{ request('sort_grade') == 'desc' ? 'active' : '' }}"
                                                href="{{ request()->fullUrlWithQuery(['sort_grade' => 'desc', 'sort_name' => null, 'sort_date' => null]) }}">Grade 12 to Kinder</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item {{ !request('sort_grade') ? 'active' : '' }}"
                                                href="{{ request()->url() }}">Default</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </th>

                             <th style="width: 15%;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Exam Date</span>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm p-1 px-2 border rounded"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <i class="bi bi-funnel"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li class="dropdown-header fw-semibold">Sort by Date</li>
                                            <li><a class="dropdown-item {{ request('sort_date') == 'asc' ? 'active' : '' }}"
                                                href="{{ request()->fullUrlWithQuery(['sort_date' => 'asc', 'sort_name' => null, 'sort_grade' => null]) }}">Oldest First</a></li>
                                            <li><a class="dropdown-item {{ request('sort_date') == 'desc' ? 'active' : '' }}"
                                                href="{{ request()->fullUrlWithQuery(['sort_date' => 'desc', 'sort_name' => null, 'sort_grade' => null]) }}">Newest First</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item {{ !request('sort_date') ? 'active' : '' }}"
                                                href="{{ request()->url() }}">Default</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </th>

                            <th style="width: 15%;">Exam Status</th>
                            <th>Exam Result</th>
                            <th style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)

                            @php 
                            $isReadOnly = $result->exam_result !== 'pending' || $result->exam_status === 'no show';
                            @endphp 
                        <tr>
                            <td>{{ ($results->currentPage() - 1) * $results->perPage() + $loop->iteration }}</td>
                            <td>{{ $result->applicant_name }}</td>
                            <td>{{ $result->incoming_grade_level }}</td>
                            <td>{{ \Carbon\Carbon::parse($result->exam_date)->format('F d, Y') }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', strtolower($result->exam_status))) }}</td>
          
                            <td>
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="exam_result"
                                            class="form-select rounded-pill px-3 shadow-sm custom-exam-result"
                                            {{ $isReadOnly ? 'disabled' : '' }}>
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
                                    
                               <div class="d-flex justify-content-center gap-2 mt-2">
                                    <button type="button" class="btn btn-success btn-sm btn-action edit-btn" data-editing="false">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <button type="button" class="btn btn-success btn-sm btn-action submit-btn d-none">
                                        <i class="bi bi-check-lg"></i>
                                    </button>
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
            <div class="d-flex justify-content-center mt-4">
                {{ $results->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
</div>
<script>
    // Submit button with SweetAlert confirmation
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

    // Edit button toggle logic
    // Edit button toggle logic
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const select = row.querySelector('select[name="exam_result"]');
            const confirmBtn = row.querySelector('.submit-btn');

            const isEditing = this.dataset.editing === 'true';

            if (isEditing) {
                // Cancel edit
                select.setAttribute('disabled', 'disabled');
                confirmBtn.classList.add('d-none');

                this.innerHTML = '<i class="bi bi-pencil-square"></i>';
                this.classList.remove('btn-danger');
                this.classList.add('btn-success');
                this.dataset.editing = 'false';
            } else {
                // Start edit
                select.removeAttribute('disabled');
                confirmBtn.classList.remove('d-none');

                this.innerHTML = '<i class="bi bi-x-lg"></i>';
                this.classList.remove('btn-success');
                this.classList.add('btn-danger');
                this.dataset.editing = 'true';
            }
        });
    });


    window.addEventListener('DOMContentLoaded', () => {
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            confirmButtonColor: '#198754'
        });
    @endif
    
    // Auto-enable editing for pending results
    document.querySelectorAll('tr').forEach(row => {
        const select = row.querySelector('select[name="exam_result"]');
        const editBtn = row.querySelector('.edit-btn');
        const confirmBtn = row.querySelector('.submit-btn');

        if (select && editBtn && confirmBtn) {
            const result = select.value;

            // If result is 'pending' and editable, auto-enable edit mode
            if (result === 'pending' && !select.disabled) {
                // Simulate Edit button click
                editBtn.click();
            }
        }
    });
});

</script>


@endsection

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>