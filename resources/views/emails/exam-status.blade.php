<!DOCTYPE html>
<html>
<head>
    <title>Exam Status Update</title>
</head>
<body>
    <p>Hi {{ $applicant->applicant_fname }},</p>

    <p>Your exam status has been updated to: <strong>{{ $status }}</strong>.</p>

    @if ($status === 'Done')
        <p>You have completed the exam. Please wait for your exam result — we will notify you soon.</p>
    @elseif ($status === 'No Show')
        <p>It looks like you missed your exam schedule. Please contact Admissions to reschedule.</p>
    @endif

    <p>Thank you,<br>ApplySmart Admissions</p>
</body>
</html>
