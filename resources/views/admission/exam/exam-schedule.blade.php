@extends('admission.admission-home')

@section('content')
<style>
    .offcanvas-end { width: 800px; }
</style>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Exam Schedule</h2>

    <a href="{{ route('examdate.create') }}" class="btn btn-primary mb-3">Add Exam Date</a>

    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="date" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Select Date --</option>
                    @foreach($schedules->keys() as $date)
                        <option value="{{ $date }}" {{ $selectedDate == $date ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>

    @foreach($schedules as $date => $daySchedules)
        @if ($selectedDate && $selectedDate !== $date)
            @continue
        @endif

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <div class="row align-items-center">
                    
                    <div class="col-md-3">
                        <select class="form-select form-select-sm time-filter" data-date="{{ $date }}">
                            <option value="">All Times</option>
                            @foreach($daySchedules as $s)
                                <option value="{{ \Carbon\Carbon::parse($s->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($s->end_time)->format('H:i') }}">
                                    {{ \Carbon\Carbon::parse($s->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($s->end_time)->format('h:i A') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select form-select-sm level-filter" data-date="{{ $date }}">
                            <option value="">All Levels</option>
                            @foreach($daySchedules->pluck('educational_level')->unique() as $level)
                                <option value="{{ $level }}">{{ $level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-end">
                        <button type="button" class="btn btn-danger btn-sm delete-day-btn" data-date="{{ $date }}">Delete Day</button>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 20%">Date</th>
                            <th style="width: 20%">Time</th>
                            <th style="width: 20%">Educational Level</th>
                            <th style="width: 10%">Max</th>
                            <th style="width: 10%">Remaining</th>
                            <th style="width: 20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daySchedules as $i => $schedule)
                            <tr data-date="{{ $schedule->exam_date }}">
                                @if ($i === 0)
                                    <td rowspan="{{ count($daySchedules) }}">
                                        {{ \Carbon\Carbon::parse($schedule->exam_date)->format('F j, Y') }}
                                    </td>
                                @endif

                                <td class="clickable-time"
                                    data-date="{{ $schedule->exam_date }}"
                                    data-start="{{ $schedule->start_time }}"
                                    data-end="{{ $schedule->end_time }}"
                                    style="cursor: pointer;">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} –
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                                </td>
                                <td>{{ $schedule->educational_level }}</td>
                                <td>{{ $schedule->max_participants }}</td>
                                <td>{{ $schedule->remaining_slots }}</td>
                                <td>
                                <form method="POST" action="{{ route('exam-schedule.destroy', $schedule->id) }}" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-outline-danger btn-sm delete-btn">
        <i class="bi bi-trash"></i>
    </button>
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

{{-- Calendar Offcanvas --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="calendarOffcanvas" aria-labelledby="calendarOffcanvasLabel">
  <div class="offcanvas-header bg-success text-white">
    <h5 class="offcanvas-title" id="calendarOffcanvasLabel">Applicants by Calendar Date</h5>
    <button type="button" class="btn-close text-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body" id="calendarOffcanvasBody">
    <p>Loading...</p>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        // ✅ ONLY make time cell clickable now
        document.querySelectorAll('.clickable-time').forEach(cell => {
            cell.addEventListener('click', function () {
                const date = this.dataset.date;
                const start = this.dataset.start;
                const end = this.dataset.end;

                window.location.href = `/admission/exam/exam-attendance?date=${date}&start=${start}&end=${end}`;
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


    



        document.querySelectorAll('.time-filter, .level-filter').forEach(filter => {
            filter.addEventListener('change', function () {
                const date = this.dataset.date;
                const timeVal = document.querySelector(`.time-filter[data-date="${date}"]`).value;
                const levelVal = document.querySelector(`.level-filter[data-date="${date}"]`).value;

                document.querySelectorAll(`tr[data-date="${date}"]`).forEach(row => {
                    const rowTimeRange = row.querySelector('.clickable-time')?.innerText.trim();
                    const rowLevel = row.querySelector('td:nth-child(3)')?.innerText.trim();

                    const timeMatch = !timeVal || rowTimeRange === timeVal;
                    const levelMatch = !levelVal || rowLevel === levelVal;

                    row.style.display = (timeMatch && levelMatch) ? '' : 'none';
                });
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                Swal.fire({
                    text: 'Are you sure you want to delete this schedule?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
