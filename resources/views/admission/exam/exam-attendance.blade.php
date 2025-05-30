<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admissions | Dashboard</title>
</head>
<body>
<div class="container mt-5">

    {{-- Header with optional time frame --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admission.exam.schedule') }}" class="btn btn-secondary">Back to Schedule</a>
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
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Admission ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Grade Level</th>
                        <th>Educational Level</th>
                        <th>Exam Time</th>
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
                            <td>{{ $app->applicant_id }}</td>
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
</body>
</html>
