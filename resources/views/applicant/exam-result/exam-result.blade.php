<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Exam Result</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<nav class="navbar bg-dark p-3">
    <p style="color: white" class="m-0">{{ auth()->user()->name }}</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
    </form>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Your Exam Result</h2>

    @if($examResult)
        {{-- Explanation --}}
        <div class="alert alert-info text-center">
            @if($examResult->exam_result === 'pending')
                Your result is currently under review. Please check back later.
            @elseif($examResult->exam_result === 'passed')
                🎉 Congratulations! You passed the exam.
            @elseif($examResult->exam_result === 'failed')
                Thank you for your effort. Unfortunately, you did not pass.
            @elseif($examResult->exam_result === 'scholarship')
                You qualified for a scholarship! Our team will contact you soon.
            @elseif($examResult->exam_result === 'interview')
                You have been selected for an interview. Details will be sent to your email.
            @elseif($examResult->exam_status === 'no_show')
                You were marked as a no-show for the exam. Please contact Admissions for rescheduling.
            @endif
        </div>

        {{-- Result Table --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong>Exam Summary</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered text-center mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Applicant Name</th>
                            <th>Exam Date</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $examResult->applicant_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($examResult->exam_date)->format('F d, Y') }}</td>
                            <td class="text-capitalize">{{ $examResult->exam_result }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center">
            No exam result found for your account.
        </div>
    @endif
</div>

</body>
</html>
