@extends('admission.admission-home')

@section('content')

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
                    <td>{{ ucwords(str_replace('_', ' ', strtolower($result->exam_status))) }}
</td>
                    <td>{{ ucwords(str_replace('_', ' ', strtolower($result->exam_result))) }}
</td>
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
                                    <option value="no_show" {{ $result->exam_result === 'no show' ? 'selected' : '' }}>No Show</option>
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

@endsection