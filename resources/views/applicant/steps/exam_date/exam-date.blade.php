<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Entrance Exam Schedule</title>
  <style>
    .time-slot {
      background-color: #007f3e;
      color: white;
      border: none;
      padding: 15px 20px;
      margin: 10px;
      border-radius: 8px;
      font-size: 15px;
      text-align: center;
      cursor: pointer;
      width: 220px;
      transition: background-color 0.3s;
    }
    .time-slot:hover {
      background-color: #005f2e;
    }
    .date-header {
      font-weight: bold;
      font-size: 20px;
      margin-top: 40px;
      margin-bottom: 20px;
      text-align: center;
    }
    .hidden {
      display: none;
    }
  </style>
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4 text-center">Entrance Exam Schedule</h2>

  <div class="mb-4">
    <label class="form-label fw-bold">Select Date <span class="text-danger">*</span></label>
    <input type="date" id="datePicker" class="form-control" required min="{{ \Carbon\Carbon::today()->toDateString() }}">
  </div>

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
    @endforeach
  </div>
</div>

<script>
  const datePicker = document.getElementById('datePicker');
  const scheduleGroups = document.querySelectorAll('.schedule-group');
  const scheduleContainer = document.getElementById('schedule-container');

  datePicker.addEventListener('change', function () {
  const selectedDate = this.value;
  const today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD

  if (selectedDate < today) {
    Swal.fire({
      icon: 'warning',
      title: 'Unavailable Date',
      text: 'You cannot select a date that has already passed.',
      confirmButtonColor: '#007f3e'
    });
    this.value = ''; // Clear the invalid input
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



  scheduleContainer.addEventListener('click', function(e) {
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

          fetch("{{ route('applicant.saveExamSchedule') }}", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
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

  function formatTime(time) {
    const [hours, minutes, seconds] = time.split(':');
    let hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    hour = hour % 12 || 12;
    return hour + ':' + minutes + ' ' + ampm;
  }

  function convertTo24Hour(timeStr) {
    const [time, modifier] = timeStr.trim().split(' ');
    let [hours, minutes] = time.split(':');
    hours = parseInt(hours);
    if (modifier === 'PM' && hours !== 12) hours += 12;
    if (modifier === 'AM' && hours === 12) hours = 0;
    return `${String(hours).padStart(2, '0')}:${minutes}:00`;
  }
</script>

</body>
</html>
