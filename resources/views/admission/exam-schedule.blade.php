<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <title>Admissions | Exam Schedule</title>
</head>
<!-- Custom CSS for Modern Look -->
<style>
    #calendar {
        background: #fafafa;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .fc-toolbar-title {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
    }
    .fc-button {
        background: transparent;
        border: none;
        color: #007bff;
        font-size: 1.2rem;
    }
    .fc-button:hover {
        color: #0056b3;
    }
    .fc-daygrid-event {
        background-color: #ffe0b2; /* light pastel orange */
        border: none;
        border-radius: 6px;
        font-size: 0.85rem;
        padding: 2px 6px;
        color: #333;
    }
    .fc-daygrid-event-dot {
        display: none;
    }
    /* Fix FullCalendar prev/next buttons */
    .fc-prev-button, .fc-next-button {
        background-color: #007bff !important;
        border: none !important;
        color: white !important;
        padding: 5px 10px !important;
        font-size: 1rem !important;
        border-radius: 5px !important;
    }

    .fc-prev-button:hover, .fc-next-button:hover {
        background-color: #0056b3 !important;
        color: white !important;
    }
</style>
<body>

<nav class="navbar bg-dark p-3 d-flex justify-content-between">
    <p style="color: white" class="m-0">{{ auth()->user()->name }}</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
    </form>
</nav>

<div class="container mt-4">
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h3>Available Exam Dates</h3>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('examdate.create') }}" class="btn btn-primary">
                Add Date
            </a>
        </div>
    </div>

    <!-- FILTER FORM -->
    <form method="GET" action="{{ route('examschedule') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="exam_date" class="form-label">Exam Date</label>
            <input type="date" id="exam_date" name="exam_date" class="form-control" value="{{ request('exam_date') }}" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
        </div>
        <div class="col-md-4">
            <label for="educational_level" class="form-label">Educational Level</label>
            <select id="educational_level" name="educational_level" class="form-select">
    <option value="">-- All Levels --</option>
    <option value="gs_jhs" {{ request('educational_level') == 'gs_jhs' ? 'selected' : '' }}>
        Grade School + Junior High School (GS + JHS)
    </option>
    <option value="Senior High School" {{ request('educational_level') == 'Senior High School' ? 'selected' : '' }}>
        Senior High School (SHS)
    </option>
</select>

        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-success w-100">Filter</button>
        </div>
    </form>

    <!-- Display Exam Dates -->
    <div class="container">
    @forelse($examSchedules->groupBy('exam_date') as $date => $schedules)
    <div class="card mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
    <a href="{{ url('/admission/exam-attendance') }}?date={{ $date }}" class="text-white text-decoration-none">
        {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
    </a>

    <button type="button" class="btn btn-danger btn-sm delete-day-btn" data-date="{{ $date }}">Delete Day</button>
</div>



        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered align-middle mb-0">
                <thead class="table-light">
    <tr>
        <th>#</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Max Participants</th>
        <th>Remaining Slots</th> <!-- ✨ ADD THIS -->
        <th>Educational Level</th>
        <th>Action</th>
    </tr>
</thead>

                    <tbody>
                    @php 
    $filteredSchedules = $schedules->filter(function($schedule) {
        return in_array($schedule->educational_level, ['Grade School and Junior High School', 'Senior High School']);
    });
@endphp


    @foreach($filteredSchedules as $index => $schedule)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}</td>
            <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</td>
            <td>{{ $schedule->max_participants }}</td>
            <td>
    {{ $schedule->max_participants - \App\Models\ApplicantSchedule::where('exam_date', $schedule->exam_date)
        ->where('start_time', $schedule->start_time)
        ->where('end_time', $schedule->end_time)
        ->count() }}
</td>


            <td>{{ $schedule->educational_level }}</td>
            <td class="text-center">
                <form method="POST" action="{{ route('examdate.destroy', $schedule->id) }}" class="delete-form d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach

    @if($filteredSchedules->isEmpty())
        <tr>
            <td colspan="6" class="text-center text-muted">No Grade School or Junior High School exams scheduled for this date.</td>
        </tr>
    @endif
</tbody>

                </table>
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-info">
        No Exam Dates Available.
    </div>
@endforelse

</div>


    <!-- PAGINATION LINKS -->
    <div class="d-flex justify-content-center mt-4">
    @if ($examSchedules->hasPages())
        <nav>
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($examSchedules->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $examSchedules->previousPageUrl() }}" rel="prev">&laquo;</a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($examSchedules->links()->elements[0] as $page => $url)
                    @if ($page == $examSchedules->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($examSchedules->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $examSchedules->nextPageUrl() }}" rel="next">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>


</div>

<div id="calendar" class="mb-5"></div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 600,
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: ''
        },
        events: [
            @foreach($examSchedules as $schedule)
            {
                title: '{{ $schedule->educational_level }}',
                start: '{{ $schedule->exam_date }}',
                allDay: true
            },
            @endforeach
        ],
        dateClick: function(info) {
            const clickedDate = new Date(info.dateStr);
            const today = new Date();

            //reset
            today.setHours(0, 0, 0, 0);

            if (clickedDate < today) {
                //warning alert
                Swal.fire({
                    icon: 'warning',
                    title: 'Past Date',
                    text: 'You cannot select a past date.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return; 
            }

            // Navigate to the attendance page
            window.location.href = '/admission/exam-attendance?date=' + info.dateStr;
        },
        eventDidMount: function(info) {
    info.el.style.cursor = 'pointer';
}

    });

    calendar.render();
});


document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                });
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    const deleteDayButtons = document.querySelectorAll('.delete-day-btn');

    deleteDayButtons.forEach(button => {
        button.addEventListener('click', function () {
            const examDate = button.getAttribute('data-date');

            Swal.fire({
                title: 'Are you sure?',
                text: `This will delete ALL schedules for ${examDate}.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete all!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("{{ route('examdate.deleteDate') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            exam_date: examDate
                        })
                    })
                    .then(response => {
                        if (response.ok) {
                            Swal.fire('Deleted!', 'All schedules for the selected date have been deleted.', 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error!', 'Failed to delete schedules.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    });
                }
            });
        });
    });
});


</script>

</body>
</html>
