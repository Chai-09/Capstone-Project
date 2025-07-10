@extends('applicant.index')

@section('content')
<div class="exam-date">
  <div class="step-form">
    <div class="form-section">
      <h2 class="mb-4 text-center">Entrance Exam Schedule</h2>
      <label class="fw-semibold">Select Date<span class="text-danger">*</span></label>
      <input type="text" id="datePicker" class="form-control" placeholder="Select a date" value="{{ old('exam_date') }}"
      @if(isset($currentStep) && $currentStep > 4)
        readonly disabled style="background-color: #e9ecef; cursor: not-allowed;"
      @endif>
      <input type="hidden" id="saveExamScheduleRoute" value="{{ route('applicant.saveExamSchedule') }}">
    </div>

    <div class="form-section">
      <div id="schedule-container"
       @if (isset($currentStep) && $currentStep > 4)
         style="pointer-events: none; opacity: 0.6;"
       @endif>
        @php
          use Carbon\Carbon;
          $today = Carbon::today();
          $twoWeeksLater = Carbon::today()->addDays(14);
          $groupedSchedules = $examSchedules->groupBy(function($item) {
              return \Carbon\Carbon::parse($item->exam_date)->format('Y-m-d');
          });
        @endphp

        @foreach ($groupedSchedules as $date => $schedules)
          @php
            $carbonDate = Carbon::parse($date);
          @endphp
          <div class="schedule-group hidden" data-date="{{ $date }}">
            <br><label class="fw-semibold">Available Time<span class="text-danger">*</span></label>
            <div class="date-header">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</div>
            <div class="dates">
              @foreach ($schedules as $schedule)
                <button type="button" class="time-slot"
                   @if (isset($currentStep) && $currentStep > 4)
                  disabled style="pointer-events: none; opacity: 0.6; cursor: not-allowed;"
                  @endif>
                  {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                </button>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="form-row">
      @if (isset($currentStep) && $currentStep > 4)
        <div class="alert alert-info">
          Your entrance exam has already been scheduled. Kindly proceed to the next step.
        </div>
      @endif
        </div>
  </div>
</div>
@endsection

{{--  Pass available dates to JS --}}
<script>
  window.availableExamDates = @json($examSchedules->pluck('exam_date')->unique()->values());
</script>

