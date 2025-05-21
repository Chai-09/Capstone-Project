@extends('applicant.index')

@section('content')

@php
    $applicantId = \App\Models\Applicant::where('account_id', Auth::id())->value('id');
    $hasScheduled = \App\Models\ApplicantSchedule::where('applicant_id', $applicantId)->exists();

    $hasReschedPayment = \App\Models\Payment::where('applicant_id', $applicantId)
        ->where('payment_for', 'resched')
        ->exists();
@endphp

<div class="container exam-result"> 
    <div class="step-form">
        <div class="form-section">
            @if($examResult)
                <div class="form-row">
                    {{-- Alert --}}
                    <div class="alert alert-info">
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
                </div>

                <div class="form-row">
                    <div class="card shadow-sm">
                        <div class="card-header">
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
                </div>

                @if ($hasScheduled && !$hasReschedPayment)
                <form method="POST" action="{{ route('payment.resched.trigger') }}">
                    @csrf
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-submit w-25">
                            Reschedule (Submit New Payment)
                        </button>
                    </div>
                </form>
                @endif
                
            @else
                <div class="alert alert-warning text-center mt-3">
                    Please wait for announcements.
                </div>
            @endif

        </div>
    </div>
</div>

@endsection
