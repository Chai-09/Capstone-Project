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

            <div class="mb-3">
                <label for="exam_date" class="form-label">Exam Date</label>
                <input type="date" class="form-control" id="exam_date" name="exam_date" required>
            </div>

            <div id="timeframes">
                <div class="timeframe bg-light rounded-3 shadow-sm p-4 mb-4 position-relative border">
                    <button type="button" class="remove-timeframe-btn" onclick="removeTimeframe(this)">×</button>
                    <h5 class="mb-3 fw-regular">Timeframe 1</h5>
                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="time" class="form-control" name="start_time[]" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input type="time" class="form-control" name="end_time[]" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Venue</label>
                        <input type="text" class="form-control" name="venue[]" required>
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

            <div class="position-fixed bottom-0 end-0 m-4 z-3" style="max-width: 300px;">
                <div class="bg-white shadow-lg p-3 border rounded">
                    <div class="d-flex  gap-2">
                        <button type="button" id="addTimeframe" class="btn btn-success w-100">
                            <i class="bi bi-plus-circle"></i> Add Timeframe
                        </button>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save"></i> Save
                        </button>
                    </div>
                </div>
            </div>


        </form>
    </div>
</div>
<script>
    let timeframeCount = 1;

    document.getElementById('addTimeframe').addEventListener('click', function() {
        timeframeCount++;

        const container = document.getElementById('timeframes');
        const newTimeframe = document.createElement('div');
        newTimeframe.classList.add('timeframe', 'bg-light', 'p-3', 'mb-4', 'shadow-sm', 'rounded-3' ,'position-relative', 'border');
        newTimeframe.innerHTML = `
            <button type="button" class="remove-timeframe-btn" onclick="removeTimeframe(this)">×</button>
            <h5 class="mb-3 fw-regular">Timeframe ${timeframeCount}</h5>
            <div class="mb-3">
                <label class="form-label">Start Time</label>
                <input type="time" class="form-control" name="start_time[]" required>
            </div>
            <div class="mb-3">
                <label class="form-label">End Time</label>
                <input type="time" class="form-control" name="end_time[]" required>
            </div>
            <div class="mb-3">
                        <label class="form-label">Venue</label>
                        <input type="text" class="form-control" name="venue[]" required>
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

@endsection