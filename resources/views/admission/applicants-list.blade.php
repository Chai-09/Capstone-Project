@foreach($groupedSchedules as $level => $schedules)
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-header bg-success text-white fw-semibold">
            {{ $level }}
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered align-middle text-center m-0">
                <thead class="table-light">
                    <tr>
                        <th>Time</th>
                        <th>Max</th>
                        <th>Remaining</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                        <tr class="clickable-row"
                            data-date="{{ $schedule->exam_date }}"
                            data-start="{{ $schedule->start_time }}"
                            data-end="{{ $schedule->end_time }}"
                            style="cursor: pointer;">
                            <td class="text-success">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                            </td>
                            <td>{{ $schedule->max_participants }}</td>
                            <td>{{ $schedule->remaining_slots }}</td>
                            <td>
                                <form method="POST"
                                      action="{{ route('exam-schedule.destroy', $schedule->id) }}"
                                      class="delete-form d-inline"
                                      onclick="event.stopPropagation()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm delete-btn">
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
@endforeach
