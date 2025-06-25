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
                        Exam Schedules for <span id="modal-date" data-date=""></span>
                    </h5>
                   
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="schedule-modal-body">
                    <p>Loading...</p>
                </div>
                <div class="modal-footer justify-content-end">
    <button id="deleteAllBtn" class="btn btn-danger btn-sm" style="display: none;">
        Delete All Time Slots
    </button>
</div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    let calendar;

    document.addEventListener('DOMContentLoaded', function () {
        const deleteBtn = document.getElementById('deleteAllBtn');
        const modal = document.getElementById('scheduleModal');
        const modalDateEl = document.getElementById('modal-date');

        // Show/hide delete button on modal open
        modal.addEventListener('show.bs.modal', function () {
            const date = modalDateEl.textContent.trim();
            modalDateEl.setAttribute('data-date', date);
            deleteBtn.style.display = date ? 'inline-block' : 'none';
        });

        const calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 'auto',
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'addExamDateButton'
            },
            customButtons: {
                addExamDateButton: {
                    text: 'Add Exam Date',
                    click: () => window.location.href = "/add-exam-date"
                }
            },
            eventColor: '#198754',
            eventTextColor: 'white',
            events: window.allowedExamDates.map(date => ({
                title: 'Available',
                start: date,
                allDay: true
            })),
            dateClick: function (info) {
                const date = info.date;
                const dateStr = info.dateStr;

                if (!window.allowedExamDates.includes(dateStr)) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Unavailable Date',
                        text: 'No exam schedules are available on this date.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    return;
                }

                modalDateEl.textContent = dateStr;
                modalDateEl.setAttribute('data-date', dateStr);
                document.getElementById('schedule-modal-body').innerHTML = '<p>Loading...</p>';

                new bootstrap.Modal(modal).show();

                fetch(`/exam-schedule/time-slots/${dateStr}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('schedule-modal-body').innerHTML = html;
                    });
            }
        });

        calendar.render();

        // Delete button functionality
        deleteBtn.addEventListener('click', function () {
            const date = modalDateEl.getAttribute('data-date');
            if (!date) return;

            Swal.fire({
                title: 'Are you sure?',
                text: `This will delete all time slots for ${date}.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, delete all!',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/exam-schedule/delete-all/${date}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Remove date from frontend list
                        window.allowedExamDates = window.allowedExamDates.filter(d => d !== date);

                        // Refresh calendar events
                        calendar.removeAllEvents();
                        window.allowedExamDates.forEach(d => {
                            calendar.addEvent({
                                title: 'Available',
                                start: d,
                                allDay: true
                            });
                        });

                       Swal.fire({
    title: 'Deleted!',
    text: data.message,
    icon: 'success',
    confirmButtonText: 'OK'
}).then(() => {
    window.location.reload(); // 🔄 Refresh the whole page after delete
});

                    })
                    .catch(error => {
                        Swal.fire('Error', 'Could not delete slots.', 'error');
                    });
                }
            });
        });
    });
</script>

@endsection
