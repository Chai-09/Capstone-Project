@extends('applicant.index')

@section('content')

<div class="container exam-reminders">

    <div class="step-form">
        <div class="form-section">
            <h2>ON-CAMPUS Admission Test (O-CAT) Schedule and Admission Number</h2>
            @if ($schedule)
                <div class="form-row admission-number">
                    <p>Admission Number:<br>
                    <span class="tamaraw-text">{{ $schedule->admission_number }}</span></p>
                </div>
                <div class="form-row">
                    <p><strong>Applicant's Name:</strong> {{ $schedule->applicant_name }}</p>
                </div>

                <div class="form-row">
                    <p><strong>Date of Exam:</strong> {{ \Carbon\Carbon::parse($schedule->exam_date)->format('F d, Y') }}</p>
                </div>

                <div class="form-row">
                     <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</p>
                </div>
                <div class="form-row">
                     <p><strong>Campus: </strong> FEU Diliman </p>
                </div>
                <div class="form-row">
                     <p><strong>Venue: </strong> {{ $schedule->venue ?? '—' }}</p>
                </div>
            @else
                <div class="form-row">
                     <p class="text-danger">Please wait for further announcements.</p>
                </div>
            @endif
        </div>
        <hr>
        <div class="form-section reminder">
            <p>All Examinees are reminded of the following:</p>
            <div class="form-row">
                <ol>
                    <li>Please arrive 10 minutes before your scheduled time of examination</li>
                    <li>Bring your school or any valid ID</li>
                    <li>Bring your own No. 2 pencil</li>
                    <li>Bring 2 pieces 2x2 ID picture with white background</li>
                    <li>The examination last for a maximum of 60 minutes</li>
                    <li>Eat a full meal before taking the exam because food and drinks are not permitted inside the exam room</li>
                    <li>In the event of failure to take the scheduled examination, examinees are allowed to reschedule with an additional payment of ₱150.</li>
                </ol>
            </div>
        </div>
        <hr>
        <div class="form-section question">
            <div class="form-row question-header">
                <p>For questions, please call us at the following:</p>
            </div>
            <div class="form-row">
                <p>Mobile: <span>(0906) 407 6850 & (0917) 112 2694</span></p>
            </div>
            <div class="form-row">
                <p>Email address: <span>admissions@feudiliman.edu.ph</span></p>
            </div>
            <div class="form-row">
                <p>See you there, <span class="tamaraw-text">FEU</span>ture Tamaraw!</p>
            </div>
            <div class="form-row d-flex justify-content-center">

                {{-- Proceed button magpapakita lang if may exam_result and step == 5 --}}
               @if ($showProceedButton && isset($examResult) &&in_array(strtolower($examResult->exam_status), ['done', 'no show']))
                    <button type="button" class="btn btn-submit" onclick="window.location.href='{{ route('applicant.exam.result') }}'">
                        Proceed
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
