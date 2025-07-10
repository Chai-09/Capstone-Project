@extends('admission.admission-home')

@section('content')

{{-- Breadcrumbs --}}

<div>
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admission.exam.schedule') }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Back to Schedule
                </a>
            </li>   
        </ol>
    </nav>

    <hr>
    {{-- Header with optional time frame --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="text-center flex-grow-1">
        <h2 class="m-0">Applicants Scheduled for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h2>

        @if (!empty($timeFrame))
            <div class="fs-5 text-muted">{{ $timeFrame }}</div>
        @endif

        @if (!empty($educationalLevel))
            <div class="fs-5 text-muted">{{ $educationalLevel }}</div>
        @endif
        </div>

        <div style="width: 135px;"></div>
    </div>

    @if($applicants->isEmpty())
        <div class="alert alert-info text-center">No applicants scheduled for this {{ !empty($timeFrame) ? 'time slot' : 'date' }}.</div>
    @else
        <div class="table-design">
        @if (session('success'))
            <script>
                window.flashSuccess = @json(session('success'));
            </script>
        @endif
            <div class="table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Admission ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Grade Level</th>
                            <th>Educational Level</th>
                            <th>Exam Time</th>
                            <th>Venue</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applicants as $index => $app)
                            @php
                                $educLevel = optional(optional($app->applicant)->formSubmission)->educational_level ?? 'Unknown';
                                $examStatus = optional($app->examResult)->exam_status;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $app->admission_number }}</td>
                                <td>{{ $app->applicant_name }}</td>
                                <td>{{ $app->applicant_contact_number }}</td>
                                <td>{{ $app->incoming_grade_level }}</td>
                                <td>{{ $educLevel }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($app->start_time)->format('g:i A') }}
                                    –
                                    {{ \Carbon\Carbon::parse($app->end_time)->format('g:i A') }}
                                </td>
                                <td>
                                    {{ $app->venue ?? 'N/A' }}
                                </td>
                                <td>
                                    @if (!$examStatus)
                                        <form method="POST" action="{{ route('exam.markAttendance') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="schedule_id" value="{{ $app->id }}">
                                            <input type="hidden" name="status" value="done">
                                            <button type="submit" class="btn btn-success btn-sm">Done</button>
                                        </form>

                                        <form method="POST" action="{{ route('exam.markAttendance') }}" class="d-inline ms-1">
                                            @csrf
                                            <input type="hidden" name="schedule_id" value="{{ $app->id }}">
                                            <input type="hidden" name="status" value="no show">
                                            <button type="submit" class="btn btn-danger btn-sm">No Show</button>
                                        </form>
                                    @elseif ($examStatus === 'done')
                                        <button class="btn btn-success btn-sm" disabled>Done</button>
                                    @elseif ($examStatus === 'no show')
                                        <button class="btn btn-danger btn-sm" disabled>No Show</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<script>
    @if(session('alert_message'))
        Swal.fire({
            icon: '{{ session('alert_type') }}',
            title: '{{ session('alert_message') }}',
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('form[action="{{ route('exam.markAttendance') }}"]').forEach(form => {
            form.addEventListener('submit', function (e) {
                Swal.fire({
                    title: 'Submitting...',
                    text: 'Please wait while the attendance is being marked.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            });
        });
    });
</script>


@endsection