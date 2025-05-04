@extends('applicant.index')

@section('content')
<div class="container mt-5">
  <div class="step-form">
    <div class="form-section">
      <h2 class="mb-4 text-center">Entrance Exam Schedule</h2>
      <label class="form-label fw-bold">Select Date <span class="text-danger">*</span></label>
      <input type="date" id="datePicker" class="form-control" required min="{{ \Carbon\Carbon::today()->toDateString() }}">
      <input type="hidden" id="saveExamScheduleRoute" value="{{ route('applicant.saveExamSchedule') }}">
    </div>
    
    <div class="form-section">
        <div id="schedule-container">
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
              $showInitially = $carbonDate->between($today, $twoWeeksLater);
            @endphp

            <div class="schedule-group hidden" data-date="{{ $date }}">
              <div class="date-header">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</div>
                <div class="d-flex flex-wrap justify-content-center">
                  @foreach ($schedules as $schedule)
                    <button type="button" class="time-slot">
                      {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                    </button>
                  @endforeach
                </div>
              </div>
            </div>    
          @endforeach  
        </div>
      </div>
  </div>
</div>
@endsection