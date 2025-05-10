@extends('applicant.index')

@section('content')


<div class="container mt-5">
    <h2 class="text-center mb-4">Your Exam Result</h2>

    @if($examResult)
        {{-- Explanation --}}
        <div class="alert alert-info text-center">
            @if($examResult->exam_result === 'pending')
                Your result is currently under review. Please check back later.
            @elseif($examResult->exam_result === 'passed')
                Congratulations! You passed the exam.
            @elseif($examResult->exam_result === 'failed')
                Thank you for your effort. Unfortunately, you did not pass.
            @elseif($examResult->exam_result === 'scholarship')
                You qualified for a scholarship! Our team will contact you soon.
            @elseif($examResult->exam_result === 'interview')
                You have been selected for an interview. Details will be sent to your email.
            @elseif($examResult->exam_result === 'no_show')
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
        <th>Admission No.</th>
        <th>Applicant Name</th>
        <th>Exam Date</th>
        <th>Result</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td>{{ $examResult->admission_number }}</td>
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
            Please wait for announcements.
        </div>
    @endif
</div>

@endsection
