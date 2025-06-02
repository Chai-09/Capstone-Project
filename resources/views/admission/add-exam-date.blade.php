@extends('admission.admission-home')

@section('content')

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
    <title>Admissions | Dashboard</title>

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
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Add Exam Date</h2>

    <form action="{{ route('examdate.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="exam_date" class="form-label">Exam Date</label>
            <input type="date" class="form-control" id="exam_date" name="exam_date" required>
        </div>

        <div id="timeframes">
            <div class="timeframe border p-3 mb-4 position-relative">
                <button type="button" class="remove-timeframe-btn" onclick="removeTimeframe(this)">×</button>
                <h5 class="mb-3">Timeframe 1</h5>
                <div class="mb-3">
                    <label class="form-label">Start Time</label>
                    <input type="time" class="form-control" name="start_time[]" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">End Time</label>
                    <input type="time" class="form-control" name="end_time[]" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Max Participants</label>
                    <input type="number" class="form-control" name="max_participants[]" required min="1">
                </div>
                <div class="mb-3">
    <label class="form-label">Educational Level</label>
    <select class="form-select" name="educational_level[]" required>
        <option value="">-- Select Level --</option>
        <option value="Grade School and Junior High School">Grade School + Junior High School (GS + JHS)</option>
        <option value="Senior High School">Senior High School (SHS)</option>
    </select>
</div>

            </div>
        </div>

        <div class="text-center d-flex justify-content-center gap-3">
    <button type="button" id="addTimeframe" class="btn btn-success">Add</button>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('admission.exam.schedule') }}" class="btn btn-secondary">Back to Exam Schedule</a>
</div>


    </form>
</div>

<script>
    let timeframeCount = 1;

    document.getElementById('addTimeframe').addEventListener('click', function() {
        timeframeCount++;

        const container = document.getElementById('timeframes');
        const newTimeframe = document.createElement('div');
        newTimeframe.classList.add('timeframe', 'border', 'p-3', 'mb-4', 'position-relative');
        newTimeframe.innerHTML = `
            <button type="button" class="remove-timeframe-btn" onclick="removeTimeframe(this)">×</button>
            <h5 class="mb-3">Timeframe ${timeframeCount}</h5>
            <div class="mb-3">
                <label class="form-label">Start Time</label>
                <input type="time" class="form-control" name="start_time[]" required>
            </div>
            <div class="mb-3">
                <label class="form-label">End Time</label>
                <input type="time" class="form-control" name="end_time[]" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Max Participants</label>
                <input type="number" class="form-control" name="max_participants[]" required min="1">
            </div>
            <div class="mb-3">
    <label class="form-label">Educational Level</label>
    <select class="form-select" name="educational_level[]" required>
        <option value="">-- Select Level --</option>
        <option value="Grade School and Junior High School">Grade School + Junior High School (GS + JHS)</option>
        <option value="Senior High School">Senior High School (SHS)</option>
    </select>
</div>

        `;

        container.appendChild(newTimeframe);
    });

    function removeTimeframe(button) {
        button.parentElement.remove();
        // Optional: Recalculate Timeframe numbers after removal
        const timeframes = document.querySelectorAll('#timeframes .timeframe');
        timeframeCount = 0;
        timeframes.forEach((frame, index) => {
            timeframeCount++;
            frame.querySelector('h5').innerText = `Timeframe ${index + 1}`;
        });
    }

    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    @endif
</script>

</body>
</html>

@endsection