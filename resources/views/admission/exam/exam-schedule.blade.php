@extends('admission.admission-home')

@section('content')
<style>
    .offcanvas-end { width: 800px; }
</style>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Exam Schedule</h2>

    <a href="{{ route('examdate.create') }}" class="btn btn-primary mb-3">Add Exam Date</a>


    <div id="calendar" class="mb-5"></div>

    <!-- MODAL -->
    <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header bg-primary text-white">
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
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

                  const date = info.dateStr; // ✅ declare first

    console.log("Selected:", date);

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

                fetch(`/admission/exam/exam-schedule/by-date?date=${date}`)
                    .then(res => res.text())
                    .then(html => {
    document.getElementById('modal-date').innerText =
        new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

    document.getElementById('schedule-modal-body').innerHTML = html;

    // rebind click events inside modal
    document.querySelectorAll('.clickable-time').forEach(cell => {
        cell.addEventListener('click', function () {
            const date = this.dataset.date;
            const start = this.dataset.start;
            const end = this.dataset.end;

            window.location.href = `/admission/exam/exam-attendance?date=${date}&start=${start}&end=${end}`;
        });
    });

        // rebind delete buttons inside modal
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

        new bootstrap.Modal(document.getElementById('scheduleModal')).show();
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

