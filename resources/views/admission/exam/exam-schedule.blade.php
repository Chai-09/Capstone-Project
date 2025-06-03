@extends('admission.admission-home')

@section('content')

<script>
    window.allowedExamDates = [
        @foreach($schedules as $date => $slots)
            '{{ $date }}',
        @endforeach
    ];
</script>


<div class="dashboard">
  <div class="content">
    <h2 class="text-white mb-4 fw-semibold">Exam Schedule</h2>
  </div>
</div>

<div>
    <div id="calendar"></div>

    <!-- MODAL -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="scheduleModalLabel">
                        Exam Schedules for <span id="modal-date"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="schedule-modal-body">
                    <p>Loading...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

@endsection

