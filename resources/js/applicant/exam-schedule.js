document.addEventListener('DOMContentLoaded', function () {
    const datePicker = document.getElementById('datePicker');
    const route = document.getElementById('saveExamScheduleRoute').value;
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const scheduleGroups = document.querySelectorAll('.schedule-group');
    const scheduleContainer = document.getElementById('schedule-container');

    datePicker.addEventListener('change', function () {
        const selectedDate = this.value;
        const today = new Date().toISOString().split('T')[0];

        if (selectedDate < today) {
            Swal.fire({
                icon: 'warning',
                title: 'Unavailable Date',
                text: 'You cannot select a date that has already passed.',
                confirmButtonColor: '#007f3e'
            });
            this.value = '';
            return;
        }

        let found = false;
        scheduleGroups.forEach(group => {
            if (group.getAttribute('data-date') === selectedDate) {
                group.classList.remove('hidden');
                found = true;
            } else {
                group.classList.add('hidden');
            }
        });

        if (!found) {
            Swal.fire({
                icon: 'info',
                title: 'No available schedules',
                text: 'There are no exam times available for the selected date.',
                confirmButtonColor: '#007f3e'
            });
        }
    });

    scheduleContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('time-slot')) {
            const timeText = e.target.innerText;
            const dateGroup = e.target.closest('.schedule-group');
            const dateText = dateGroup.querySelector('.date-header').innerText;

            Swal.fire({
                title: 'Confirm Your Selection',
                html: `<b>Date:</b> ${dateText}<br><b>Time:</b> ${timeText}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#007f3e',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const [startTimeRaw, endTimeRaw] = timeText.split(' to ');
                    const dateFormatted = dateGroup.getAttribute('data-date');

                    fetch(route, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrf
                        },
                        body: JSON.stringify({
                            exam_date: dateFormatted,
                            start_time: convertTo24Hour(startTimeRaw),
                            end_time: convertTo24Hour(endTimeRaw)
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Schedule Selected!',
                                text: 'Please wait for further instructions.',
                                confirmButtonColor: '#007f3e'
                            }).then(() => {
                                window.location.href = "/applicant/steps/reminders/reminders";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message,
                            });
                        }
                    });
                }
            });
        }
    });

    function convertTo24Hour(timeStr) {
        const [time, modifier] = timeStr.trim().split(' ');
        let [hours, minutes] = time.split(':');
        hours = parseInt(hours);
        if (modifier === 'PM' && hours !== 12) hours += 12;
        if (modifier === 'AM' && hours === 12) hours = 0;
        return `${String(hours).padStart(2, '0')}:${minutes}:00`;
    }
});
