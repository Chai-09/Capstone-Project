@extends('admission.admission-home')

@section('content')

<style>
    .remove-timeframe-btn {
        float: right;
        font-size: 1.5rem;
        color: red;
        cursor: pointer;
        border: none;
        background: none;
    }
</style>

<nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admission.exam.schedule') }}" class="text-decoration-none">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </li>   
    </ol>
</nav>

<hr>

<div class="container mt-5 mx-auto" style="max-width: 720px;">
    <div class="card shadow p-4 rounded-4 border-0">
        <h5 class="text-dark fw-bold mb-4"><i class="bi bi-calendar-plus me-2"></i>Add Exam Date</h5>

        <form action="{{ route('examdate.store') }}" method="POST">
            @csrf

            @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


            <div class="row mb-3">
                <div class="col">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" name="start_date" required>
                </div>
                <div class="col">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" name="end_date" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Educational Level</label>
                <select class="form-select" id="educational_level" name="educational_level" required>
                    <option value="">-- Select Level --</option>
                    <option value="Grade School and Junior High School">Grade School and Junior High School</option>
                    <option value="Senior High School">Senior High School</option>
                </select>
            </div>
            <div class="mb-3" id="grade-school-checkbox" style="display: none;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="kinder_to_grade3" id="kinder_to_grade3">
                    <label class="form-check-label" for="kinder_to_grade3">
                        Kinder to Grade 3 Only
                    </label>
                </div>
            </div>


            <div class="mb-3">
                <label class="form-label">Venue</label>
                <input type="text" class="form-control" name="venue" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Max Participants</label>
                <input type="number" class="form-control" name="max_participants" min="1" required>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label">Start Time</label>
                    <input type="time" class="form-control" id="start_time" name="start_time">
                </div>
                <div class="col">
                    <label class="form-label">End Time</label>
                    <input type="time" class="form-control" id="end_time" name="end_time">
                </div>
            </div>

            <div id="side-options" style="display: none;">
                <div class="mb-3">
                    <label class="form-label">Time Duration</label>
                    <select class="form-select" id="duration_select" name="duration">
                        <option value="">-- Select Duration --</option>
                        <option value="15">15 minutes</option>
                        <option value="30">30 minutes</option>
                        <option value="60">1 hour</option>
                        <option value="120">2 hours</option>
                        <option value="180">3 hours</option>
                        <option value="custom">Custom (minutes)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Select Days of the Week to Exclude</label>
                    <div class="d-flex flex-wrap gap-3">
                        @php
                            $weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        @endphp
                        @foreach($weekdays as $day)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="weekdays[]" value="{{ $day }}" id="day_{{ strtolower($day) }}">
                                <label class="form-check-label" for="day_{{ strtolower($day) }}">
                                    {{ $day }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>


                <div class="mb-3" id="custom_duration_div" style="display: none;">
                    <label class="form-label">Custom Time (minutes)</label>
                    <input type="number" class="form-control" name="custom_duration" min="1">
                </div>

                

                <div class="mb-3">
                    <label class="form-label">Generated Time Slots</label>
                    <ul class="list-group" id="time_slots_preview"></ul>
                </div>
            </div>

            <div class="position-fixed bottom-0 end-0 m-4 z-3" style="max-width: 300px;">
                <div class="bg-white shadow-lg p-3 border rounded">
                    <div class="d-flex  gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const eduSelect = document.getElementById('educational_level');
    const durationSelect = document.getElementById('duration_select');
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    const customDiv = document.getElementById('custom_duration_div');
    const sideOptions = document.getElementById('side-options');

    eduSelect.addEventListener('change', () => {
    const value = eduSelect.value;
    const gradeSchoolCheckbox = document.getElementById('grade-school-checkbox');

    if (value === 'Grade School and Junior High School') {
        durationSelect.value = '60';
        customDiv.style.display = 'none';
    } else if (value === 'Senior High School') {
        durationSelect.value = '180';
        customDiv.style.display = 'none';
        gradeSchoolCheckbox.style.display = 'none';
    } else {
        durationSelect.value = '';
        gradeSchoolCheckbox.style.display = 'none';
    }

    generateTimeSlots();
});


    durationSelect.addEventListener('change', () => {
        customDiv.style.display = durationSelect.value === 'custom' ? 'block' : 'none';
        generateTimeSlots();
    });

    function toggleSideOptions() {
        const hasStart = startTime.value !== '';
        const hasEnd = endTime.value !== '';
        sideOptions.style.display = (hasStart && hasEnd) ? 'block' : 'none';
    }

    function formatTime(date) {
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12; // Convert 0 (midnight) to 12
    minutes = minutes < 10 ? '0' + minutes : minutes;
    return `${hours}:${minutes} ${ampm}`;
}

function formatTime24(date) {
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    return `${hours}:${minutes}`;
}


function formatTimeStr(timeStr) {
    const [h, m] = timeStr.split(':').map(Number);
    const date = new Date();
    date.setHours(h, m);
    return formatTime(date);
}


    function parseTimeToDate(timeStr) {
        const [h, m] = timeStr.split(":").map(Number);
        const d = new Date();
        d.setHours(h, m, 0, 0);
        return d;
    }

    function isExcluded(slotStart, slotEnd, exclusions) {
        return exclusions.some(([exStart, exEnd]) => {
            return slotStart < exEnd && slotEnd > exStart;
        });
    }

    function generateTimeSlots() {
    const previewList = document.getElementById('time_slots_preview');
    previewList.innerHTML = '';

    const startVal = startTime.value;
    const endVal = endTime.value;
    const startDateVal = document.querySelector('input[name="start_date"]').value;
    const endDateVal = document.querySelector('input[name="end_date"]').value;
    if (!startVal || !endVal || !startDateVal || !endDateVal) return;

    const start = parseTimeToDate(startVal);
    const end = parseTimeToDate(endVal);

    let durationMins = 0;
    const selected = durationSelect.value;

    if (selected === 'custom') {
        const customVal = document.querySelector('input[name="custom_duration"]').value;
        durationMins = parseInt(customVal || 0);
    } else {
        durationMins = parseInt(selected || 0);
    }

    if (durationMins <= 0 || start >= end) return;

    const maxAllowedDuration = (end.getTime() - start.getTime()) / 60000;

    if (selected === 'custom' && durationMins > maxAllowedDuration) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Custom Time',
            text: `Custom time (${durationMins} mins) exceeds the selected time range (${formatTimeStr(startTime.value)} to ${formatTimeStr(endTime.value)}).`,
            confirmButtonColor: '#d33',
        });
        return;
    }

    if (durationMins > 0 && maxAllowedDuration % durationMins !== 0) {
    Swal.fire({
        icon: 'error',
        title: 'Invalid Time Duration',
        text: `Selected duration (${durationMins} mins) does not fit evenly into the total time range (${formatTimeStr(startTime.value)} to ${formatTimeStr(endTime.value)}).`,

        confirmButtonColor: '#d33',
    });
    return;
}


    // ✅ Get excluded weekdays (like Friday)
    const excludedWeekdays = Array.from(document.querySelectorAll('input[name="weekdays[]"]:checked'))
        .map(cb => cb.value); // e.g., ['Friday', 'Thursday']

    // ✅ Check if at least one day in the range is allowed
    let hasAllowedDay = false;
    let dateCursor = new Date(startDateVal);
    const endDate = new Date(endDateVal);

    while (dateCursor <= endDate) {
        const weekday = dateCursor.toLocaleDateString('en-US', { weekday: 'long' });
        if (!excludedWeekdays.includes(weekday)) {
            hasAllowedDay = true;
            break;
        }
        dateCursor.setDate(dateCursor.getDate() + 1);
    }

    if (!hasAllowedDay) return; // ❌ all days excluded, do not generate slots

    // ✅ Generate time slots once only (not per day)
    const cursor = new Date(start);
    while (cursor.getTime() + durationMins * 60000 <= end.getTime()) {
    const slotEnd = new Date(cursor.getTime() + durationMins * 60000);

    const display = `${formatTime(cursor)} - ${formatTime(slotEnd)}`;        // 🟢 User sees: 8:00 AM - 9:00 AM
    const hidden = `${formatTime24(cursor)}-${formatTime24(slotEnd)}`;      // ✅ Laravel gets: 08:00-09:00

    const li = document.createElement('li');
    li.className = 'list-group-item d-flex justify-content-between align-items-center';
    li.innerHTML = `
        ${display}
        <input type="hidden" name="time_slots[]" value="${hidden}" />
        <button type="button" class="btn btn-sm btn-outline-danger ms-auto" onclick="this.parentElement.remove()">Remove</button>
    `;
    previewList.appendChild(li);

    cursor.setTime(cursor.getTime() + durationMins * 60000);
}


}




    // Listeners
    startTime.addEventListener('input', () => { toggleSideOptions(); generateTimeSlots(); });
    endTime.addEventListener('input', () => { toggleSideOptions(); generateTimeSlots(); });
    document.querySelector('input[name="custom_duration"]').addEventListener('input', generateTimeSlots);

    // Add exclude timeframe
    document.getElementById('add-exclude-btn').addEventListener('click', function () {
        const container = document.getElementById('excluded-times');
        const div = document.createElement('div');
        div.className = 'd-flex gap-2 mb-2';
        div.innerHTML = `
            <input type="time" class="form-control excluded-start" placeholder="Start" />
            <input type="time" class="form-control excluded-end" placeholder="End" />
            <button type="button" class="btn btn-outline-danger btn-sm remove-exclude">&times;</button>
        `;
        container.appendChild(div);
    });

    // Remove an excluded range
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-exclude')) {
            e.target.closest('.d-flex').remove();
            generateTimeSlots();
        }
    });

    
</script>
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
@endif

@endsection
