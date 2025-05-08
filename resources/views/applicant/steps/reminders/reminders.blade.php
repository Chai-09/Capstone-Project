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
    <title>Reminders</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Reminders</h2>
    <p class="text-center">Your exam schedule has been successfully selected! Please be reminded of your upcoming examination.</p>

    @if ($schedule)
        <p><strong>Applicant's Name:</strong> {{ $schedule->applicant_name }}</p>
        <p><strong>Date of Exam:</strong> {{ \Carbon\Carbon::parse($schedule->exam_date)->format('F d, Y') }}</p>
        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</p>
    @else
        <p class="text-danger">Please wait for further announcements.</p>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: 'Schedule Confirmed!',
            text: 'You have successfully selected a schedule. Please wait for further instructions.',
            confirmButtonColor: '#007f3e'
        });
    });
</script>
</body>
</html>
