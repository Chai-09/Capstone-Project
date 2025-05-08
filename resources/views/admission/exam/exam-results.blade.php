<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admissions | Dashboard</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<nav class="navbar bg-dark p-3">
    <p style="color: white" class="m-0"> {{ auth()->user()->name }}</p>
    <a href="{{ route('admissionhome') }}" class="btn btn-primary">Back</a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
    </form>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Exam Results - Applicants Marked as Done</h2>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
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
                <tr>
                    <td>{{ $result->applicant_name }}</td>
                    <td>{{ $result->incoming_grade_level }}</td>
                    <td>{{ \Carbon\Carbon::parse($result->exam_date)->format('F d, Y') }}</td>
                    <td>{{ ucfirst($result->exam_status) }}</td>
                    <td>{{ ucfirst($result->exam_result) }}</td>
                    <td>
                    <form method="POST" action="{{ route('exam.results.update') }}" class="result-form">
    <input type="hidden" name="applicant_id" value="{{ $result->applicant_id }}">

                            @csrf
                            <div class="input-group input-group-sm">
                                <select name="exam_result" class="form-select">
                                    <option value="pending" {{ $result->exam_result === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="passed" {{ $result->exam_result === 'passed' ? 'selected' : '' }}>Passed</option>
                                    <option value="failed" {{ $result->exam_result === 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="scholarship" {{ $result->exam_result === 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                                    <option value="interview" {{ $result->exam_result === 'interview' ? 'selected' : '' }}>Interview</option>
                                </select>
                                <button type="button" class="btn btn-success confirm-btn">Confirm</button>
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

<script>
    document.querySelectorAll('.confirm-btn').forEach(button => {
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

</body>
</html>
