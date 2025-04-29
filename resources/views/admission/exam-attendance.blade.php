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
    <h2 class="text-center mb-4">Applicants Scheduled for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Applicant Name</th>
                    <th>Contact Number</th>
                    <th>Grade Level</th>
                    <th>Exam Time</th>
                    
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
@forelse($applicants as $applicant)
<tr>
    <td>{{ $applicant->applicant_name }}</td>
    <td>{{ $applicant->applicant_contact_number }}</td>
    <td>{{ $applicant->incoming_grade_level }}</td>
    <td>{{ \Carbon\Carbon::parse($applicant->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($applicant->end_time)->format('h:i A') }}</td>
    <td class="text-center">
        <form method="POST" action="{{ route('exam.attendance.mark') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $applicant->id }}">
            <button type="submit" name="status" value="done" class="btn btn-success btn-sm">Done</button>
            <button type="submit" name="status" value="no_show" class="btn btn-danger btn-sm">No Show</button>
        </form>
    </td>
</tr>

@empty
<tr>
    <td colspan="6" class="text-center text-muted">No applicants scheduled for this day.</td>
</tr>
@endforelse
</tbody>


        </table>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('examschedule') }}" class="btn btn-secondary">Back to Calendar</a>
    </div>
</div>

</body>
</html>
