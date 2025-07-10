@extends('admission.admission-home')

@section('content')

<div class="dashboard">
  <div class="content">
    <h2 class="text-white mb-4 fw-semibold">Applicant List</h2>
  </div>
</div>


<div class="table-design">
    @if (session('success'))
        <script>window.flashSuccess = @json(session('success'));</script>
    @endif
    @vite('resources/js/admission/applicant-list.js')

    <form method="GET" id="filterForm">
        <div class="filter-bar" style="gap: 10px;">
            <div class="dropdown">
                <button class="btn btn-filter dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Add filter
                </button>
                <div class="dropdown-menu p-3" style="min-width: 300px;">
                    <div class="mb-3">
                        <label for="grade_level" class="form-label">Grade Level</label>
                        <select name="grade_level" id="grade_level" class="form-select form-select-sm">
                            <option value="">All Grade Levels</option>
                            <option value="Kinder" {{ request('grade_level') == 'Kinder' ? 'selected' : '' }}>Kinder</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="Grade {{ $i }}" {{ request('grade_level') == "Grade $i" ? 'selected' : '' }}>Grade {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stage" class="form-label">Current Stage</label>
                        <select name="stage" id="stage" class="form-select form-select-sm">
                            <option value="">All Stages</option>
                            @for ($s = 1; $s <= 7; $s++)
                                <option value="{{ $s }}" {{ request('stage') == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endfor
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
            @if ($applicants->count() > 0)
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 18%; position: relative;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Name</span>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm p-1 px-2 border rounded"
                                            type="button"
                                            id="sortNameDropdown"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            style="line-height: 1;">
                                    <i class="bi bi-funnel"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="dropdown-header fw-semibold">Sort by Name</li>
                                        <li><a class="dropdown-item {{ request('sort_name') === 'asc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort_name' => 'asc', 'sort_id' => null]) }}">A to Z</a></li>
                                        <li><a class="dropdown-item {{ request('sort_name') === 'desc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort_name' => 'desc', 'sort_id' => null]) }}">Z to A</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item {{ !request('sort_name') && !request('sort_id') ? 'active' : '' }}" href="{{ request()->url() }}">Default</a></li>
                                    </ul>
                                </div>
                            </div>
                        </th>
                        <th style="width: 20%;">Email Address</th>
                        <th style="width: 12%;">Contact Number</th>
                        <th style="width: 17%;">Current School</th>
                        <th style="width: 10%; position: relative;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Grade Level</span>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm p-1 px-2 border rounded"
                                            type="button"
                                            id="sortNameDropdown"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            style="line-height: 1;">
                                    <i class="bi bi-funnel"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="dropdown-header fw-semibold">Sort by Grade</li>
                                        <li><a class="dropdown-item {{ request('sort_grade') === 'asc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort_grade' => 'asc', 'sort_name' => null]) }}">Kinder to Grade 12</a></li>
                                        <li><a class="dropdown-item {{ request('sort_grade') === 'desc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort_grade' => 'desc', 'sort_name' => null]) }}">Grade 12 to Kinder</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item {{ !request('sort_grade') ? 'active' : '' }}" href="{{ request()->url() }}">Default</a></li>
                                    </ul>
                                </div>
                            </div>
                        </th>
                        <th style="width: 10%; position: relative;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Stage</span>
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm p-1 px-2 border rounded"
                                            type="button"
                                            id="sortNameDropdown"
                                            data-bs-toggle="dropdown"
                                            aria-expanded="false"
                                            style="line-height: 1;">
                                    <i class="bi bi-funnel"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="dropdown-header fw-semibold">Sort by Stage</li>
                                        <li><a class="dropdown-item {{ request('sort_step') === 'asc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort_step' => 'asc']) }}">Ascending</a></li>
                                        <li><a class="dropdown-item {{ request('sort_step') === 'desc' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['sort_step' => 'desc']) }}">Descending</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item {{ !request('sort_step') ? 'active' : '' }}" href="{{ request()->url() }}">Default</a></li>
                                    </ul>
                                </div>
                            </div>
                        </th>
                        <th style="width: 8%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applicants as $applicant)
                        <tr>
                            <td>{{ ($applicants->currentPage() - 1) * $applicants->perPage() + $loop->iteration }}</td>
                            <td>{{ $applicant->applicant_fname }} {{ $applicant->applicant_mname ?? '' }} {{ $applicant->applicant_lname }}</td>
                            <td>{{ $applicant->formSubmission->applicant_email ?? 'N/A' }}</td>
                            <td>{{ $applicant->formSubmission->applicant_contact_number ?? 'N/A' }}</td>
                            <td>{{ $applicant->current_school ?? 'N/A' }}</td>
                            <td>{{ $applicant->incoming_grlvl ?? 'N/A' }}</td>
                            <td>{{ $applicant->current_step }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @if ($applicant->current_step == 1)
                                        <button type="button"
                                                onclick="showIncompleteAlert('{{ $applicant->applicant_fname }} {{ $applicant->applicant_lname }}')" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    @else
                                        <a href="{{ route('admission.editApplicant', $applicant->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endif

                                    <form action="{{ route('admission.applicants.destroy', $applicant->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this applicant?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
                {{ $applicants->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @else
            <p class="text-center">No applicants found.</p>
        @endif
    </div>
</div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('filterForm');
        const selects = form.querySelectorAll('select');

        selects.forEach(select => {
            select.addEventListener('change', () => {
                form.submit();
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showIncompleteAlert(applicantName) {
        Swal.fire({
            icon: 'info',
            title: 'Form Incomplete',
            text: applicantName + ' has not submitted their application form yet. Editing is not available at this stage.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

