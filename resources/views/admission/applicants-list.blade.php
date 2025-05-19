@extends('admission.admission-home')

@section('content')
<div class="table-design">

    {{-- SweetAlert Flash --}}
    @if (session('success'))
        <script>window.flashSuccess = @json(session('success'));</script>
    @endif
    @vite('resources/js/admission/applicant-list.js')

    {{-- Filter Bar --}}
    <form method="GET">
        <div class="filter-bar" style="gap: 10px;">

            {{-- Filter Button --}}
            <div class="dropdown">
                <button class="btn btn-filter dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Add filter
                </button>
                <div class="dropdown-menu p-3" style="min-width: 300px;">
                    {{-- Grade Level Filter --}}
                    <div class="mb-3">
                        <label for="grade_level" class="form-label">Grade Level</label>
                        <select name="grade_level" id="grade_level" class="form-select form-select-sm">
                            <option value="">All Grade Levels</option>
                            <option value="Kinder" {{ request('grade_level') == 'Kinder' ? 'selected' : '' }}>Kinder</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="Grade {{ $i }}" {{ request('grade_level') == "Grade $i" ? 'selected' : '' }}>
                                    Grade {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    {{-- Stage Filter --}}
                    <div class="mb-3">
                        <label for="stage" class="form-label">Current Stage</label>
                        <select name="stage" id="stage" class="form-select form-select-sm">
                            <option value="">All Stages</option>
                            @for ($s = 1; $s <= 6; $s++)
                                <option value="{{ $s }}" {{ request('stage') == $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            {{-- Search Box --}}
            <div class="search-wrapper">
                <input type="text" name="search" class="search-input"
                       placeholder="Search for an applicant by name or email"
                       value="{{ request('search') }}">
                <i class="bi bi-search position-absolute"
                   style="left: 12px; top: 50%; transform: translateY(-50%); color: #888;"></i>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-search">Search</button>
        </div>
    </form>


    <div class="table-wrapper">
        <table class="custom-table">
        @if ($applicants->count() > 0)
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 18%;">Name</th>
                    <th style="width: 20%;">Email Address</th>
                    <th style="width: 12%;">Contact Number</th>
                    <th style="width: 17%;">Current School</th>
                    <th style="width: 10%;">Grade Level</th>
                    <th style="width: 10%;">Current Stage</th>
                    <th style="width: 8%;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applicants as $applicant)
                    <tr>
                        <td>
                            {{ ($applicants->currentPage() - 1) * $applicants->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            {{ $applicant->applicant_fname }}
                            {{ $applicant->applicant_mname ? $applicant->applicant_mname : '' }}
                            {{ $applicant->applicant_lname }}
                        </td>
                        <td>{{ $applicant->formSubmission->applicant_email ?? 'N/A' }}</td>
                        <td>{{ $applicant->formSubmission->applicant_contact_number ?? 'N/A' }}</td>
                        <td>{{ $applicant->current_school ?? 'N/A' }}</td>
                        <td>{{ $applicant->incoming_grlvl ?? 'N/A' }}</td>
                        <td>{{ $applicant->current_step }}</td>
                        <td class="d-flex gap-1">
                            {{-- Edit --}}
                            <a href="{{ route('admission.editApplicant', $applicant->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            {{-- Delete --}}
                            <form action="{{ route('admission.applicants.destroy', $applicant->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this applicant?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $applicants->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @else
        <p class="text-center">No applicants found.</p>
    @endif
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>