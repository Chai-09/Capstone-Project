<div class="card mb-4">
    <div class="card-body p-0">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Educational Level</th>
                    <th>Max</th>
                    <th>Remaining</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $schedule)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($schedule->exam_date)->format('F j, Y') }}</td>
                        <td class="clickable-time"
                            data-date="{{ $schedule->exam_date }}"
                            data-start="{{ $schedule->start_time }}"
                            data-end="{{ $schedule->end_time }}"
                            style="cursor: pointer;">
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                        </td>
                        <td>{{ $schedule->educational_level }}</td>
                        <td>{{ $schedule->max_participants }}</td>
                        <td>{{ $schedule->remaining_slots }}</td>
                        <td>
                            <form method="POST" action="{{ route('exam-schedule.destroy', $schedule->id) }}" class="delete-form d-inline">
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