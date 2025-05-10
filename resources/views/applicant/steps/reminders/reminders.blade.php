@extends('applicant.index')

@section('content')

<div class="container mt-5">
    <h2 class="text-center">Reminders</h2>
    <p class="text-center">Your exam schedule has been successfully selected! Please be reminded of your upcoming examination.</p>

    @if ($schedule)
        <p><strong>Admission Number:</strong> {{ $schedule->admission_number }}</p>

        <p><strong>Applicant's Name:</strong> {{ $schedule->applicant_name }}</p>
        <p><strong>Date of Exam:</strong> {{ \Carbon\Carbon::parse($schedule->exam_date)->format('F d, Y') }}</p>
        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</p>
    @else
        <p class="text-danger">Please wait for further announcements.</p>
    @endif
</div>

{{-- Proceed button magpapakita lang if may exam_result and step == 5 --}}
@if ($showProceedButton)
    <div class="text-center mt-4">
        <a href="{{ route('applicant.exam.result') }}" class="btn btn-success">
            Proceed to Exam Result
        </a>
    </div>
@endif


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

@endsection
