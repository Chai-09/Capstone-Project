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
                            <div class="table-responsive">
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
                                            <td data-label="Admission No.">{{ $examResult->admission_number }}</td>
                                            <td data-label="Applicant Name">{{ $examResult->applicant_name }}</td>
                                            <td data-label="Exam Date">{{ \Carbon\Carbon::parse($examResult->exam_date)->format('F d, Y') }}</td>
                                            <td data-label="Result">{{ ucwords(str_replace('_', ' ', $examResult->exam_result)) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($hasScheduled && !$hasReschedPayment && $examResult->exam_result === 'no_show')
                    <form method="POST" action="{{ route('payment.resched.trigger') }}">
                        @csrf
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-submit w-auto">
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

@if($examResult && $examResult->exam_result === 'failed')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Important Notice',
            html: `Due to the failed status and no refund policy, your account will be archived in 3 days after giving your exam result.<br><br>
                   Please note that you will be unable to log back in after logging out.<br><br>
                   For more information, contact the Admissions Office (<strong>admissions@feudiliman.edu.ph</strong>).`,
            confirmButtonText: 'OK'
        });
    </script>
@endif


@endsection
