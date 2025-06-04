document.addEventListener('DOMContentLoaded', () => {
    const allowedDates = window.allowedExamDates || [];

    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
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
        events: allowedDates.map(date => ({
            title: 'Available',
            start: date,
            allDay: true
        })),
        dateClick: function (info) {
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

            renderScheduleModal(date);
        }
    });

    calendar.render();
});

// Show modal and bind delete/click events
function renderScheduleModal(date) {
    fetch(`/admission/exam/exam-schedule/by-date?date=${date}`)
        .then(res => res.text())
        .then(html => {
            const modalDateText = new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            document.getElementById('modal-date').innerText = modalDateText;
            document.getElementById('schedule-modal-body').innerHTML = html;

            bindModalEvents();

            const modal = new bootstrap.Modal(document.getElementById('scheduleModal'));
            modal.show();
        });
}

// Re-bind events inside modal content
function bindModalEvents() {
    document.querySelectorAll('.clickable-row').forEach(cell => {
        cell.addEventListener('click', function () {
            const { date, start, end } = this.dataset;
            window.location.href = `/admission/exam/exam-attendance?date=${date}&start=${start}&end=${end}`;
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
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
}

document.addEventListener('DOMContentLoaded', () => {
    const deleteDayBtn = document.getElementById('delete-day-btn');
    const deleteDayForm = document.getElementById('delete-day-form');

    if (deleteDayBtn) {
        deleteDayBtn.addEventListener('click', () => {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete all exam schedules for the selected date.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete all!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteDayForm.submit();
                }
            });
        });
    }
});
