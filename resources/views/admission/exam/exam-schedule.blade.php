@extends('admission.admission-home')

@section('content')
    <style>
        .offcanvas-end { width: 800px; }
    </style>
    
<div class="container mt-5">
    <h2 class="mb-4 text-center">Exam Schedule</h2>

    <a href="{{ route('examdate.create') }}" class="btn btn-primary">
        Add Exam Date
    </a>

    @foreach($schedules as $date => $daySchedules)
        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <a href="{{ route('exam.attendance') }}?date={{ $date }}" class="text-white text-decoration-underline">
                    {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                </a>
                <button type="button" class="btn btn-danger btn-sm delete-day-btn" data-date="{{ $date }}">Delete Day</button>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Level</th>
                            <th>Max</th>
                            <th>Remaining</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    @foreach($daySchedules as $i => $schedule)
    <tr class="time-click" data-date="{{ $schedule->exam_date }}" data-start="{{ $schedule->start_time }}" data-end="{{ $schedule->end_time }}">
        <td>{{ $i + 1 }}</td>
        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
        <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
        <td>{{ $schedule->educational_level }}</td>
        <td>{{ $schedule->max_participants }}</td>
        <td>{{ $schedule->remaining_slots }}</td>
        <td>
            <form method="POST" action="{{ route('exam-schedule.destroy', $schedule->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>

                </table>
            </div>
        </div>
    @endforeach

    <div id="calendar" class="mb-5"></div>
</div>

<!-- Calendar Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="calendarOffcanvas" aria-labelledby="calendarOffcanvasLabel">
  <div class="offcanvas-header bg-success text-white">
    <h5 class="offcanvas-title" id="calendarOffcanvasLabel">Applicants by Calendar Date</h5>
    <button type="button" class="btn-close text-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body" id="calendarOffcanvasBody">
    <p>Loading...</p>
  </div>
</div>

<!-- Schedule Modal 
<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="scheduleModalLabel">Applicants by Schedule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="scheduleModalBody">
        <p>Loading...</p>
      </div>
    </div>
  </div>
</div> -->

<script>
    const allowedDates = [
        @foreach($schedules as $date => $slots)
            '{{ $date }}',
        @endforeach
    ];

    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 600,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            validRange: {
                start: new Date().toISOString().split('T')[0]
            },
            eventColor: '#198754',
            eventTextColor: 'white',
            events: allowedDates.map(date => ({ title: 'Available', start: date, allDay: true })),
            dateClick: function(info) {
                const date = info.dateStr;
                if (!allowedDates.includes(date)) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Unavailable Date',
                        text: 'No exam schedules are available on this date.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }

                fetch(`/admission/exam/exam-schedule/applicants/by-date?date=${date}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('calendarOffcanvasBody').innerHTML = html;
                        new bootstrap.Offcanvas(document.getElementById('calendarOffcanvas')).show();
                    });
            }
        });

        calendar.render();

        document.querySelectorAll('.time-click').forEach(row => {
    row.addEventListener('click', function () {
        const date = this.dataset.date;
        const start = this.dataset.start.slice(0, 8); // "HH:MM:SS"
        const end = this.dataset.end.slice(0, 8);

        fetch(`/admission/exam/exam-schedule/applicants/by-time?date=${date}&start=${start}&end=${end}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('scheduleModalBody').innerHTML = html;
                new bootstrap.Modal(document.getElementById('scheduleModal')).show();
            });
    });
});



        document.querySelectorAll('.delete-day-btn').forEach(button => {
            button.addEventListener('click', function () {
                const date = this.dataset.date;
                Swal.fire({
                    title: 'Are you sure?',
                    text: `This will delete all schedules on ${date}.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete all!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('exam-schedule.deleteDate') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ exam_date: date })
                        }).then(() => location.reload());
                    }
                });
            });
        });
    });
</script>

@endsection