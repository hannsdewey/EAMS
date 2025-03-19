@extends("Admin.Layouts.Master")
@section('Title', 'Schedule Management')
@section('Content')
<div class="container-scroller">
    <x-admin.layouts.header-dashboard/>
    <div class="container-fluid page-body-wrapper">
        <div class="theme-setting-wrapper">
        </div>
        <div class="side-bar-box" style="width: 250px;">
            <x-admin.layouts.side-bar/>
        </div>
        <div class="main-panel">
            <div class="content-wrapper p-3">
                <div class="row">
                    <div class="col-md-12 grid-margin">
                        <div class="row">
                            <div class="col-12 col-xl-12 mb-4 mb-xl-0 p-0">
                                <div class="bg-white">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Schedule Management</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addScheduleModal">
                                                    Add New Schedule
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Employee</th>
                                                            <th>Department</th>
                                                            <th>Position</th>
                                                            <th>Shift Start</th>
                                                            <th>Shift End</th>
                                                            <th>Break Start</th>
                                                            <th>Break End</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($schedules as $schedule)
                                                            <tr>
                                                                <td>{{ $schedule->user->name }}</td>
                                                                <td>{{ $schedule->user->department->name ?? '-' }}</td>
                                                                <td>{{ $schedule->user->position->name ?? '-' }}</td>
                                                                <td>{{ $schedule->shift_start }}</td>
                                                                <td>{{ $schedule->shift_end }}</td>
                                                                <td>{{ $schedule->break_start }}</td>
                                                                <td>{{ $schedule->break_end }}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-sm btn-info edit-schedule" 
                                                                            data-id="{{ $schedule->id }}"
                                                                            data-user="{{ $schedule->user_id }}"
                                                                            data-shift-start="{{ $schedule->shift_start }}"
                                                                            data-shift-end="{{ $schedule->shift_end }}"
                                                                            data-break-start="{{ $schedule->break_start }}"
                                                                            data-break-end="{{ $schedule->break_end }}">
                                                                        <i class="fas fa-edit"></i>
                                                                    </button>
                                                                    <button type="button" class="btn btn-sm btn-danger delete-schedule" 
                                                                            data-id="{{ $schedule->id }}">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            {{ $schedules->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Schedule Modal -->
<div class="modal fade" id="addScheduleModal" tabindex="-1" role="dialog" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addScheduleModalLabel">Add New Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addScheduleForm" action="{{ route('admin.schedule.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_id">Employee</label>
                        <select class="form-control" id="user_id" name="user_id" required>
                            <option value="">Select Employee</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="shift_start">Shift Start Time</label>
                        <input type="time" class="form-control" id="shift_start" name="shift_start" required>
                    </div>
                    <div class="form-group">
                        <label for="shift_end">Shift End Time</label>
                        <input type="time" class="form-control" id="shift_end" name="shift_end" required>
                    </div>
                    <div class="form-group">
                        <label for="break_start">Break Start Time</label>
                        <input type="time" class="form-control" id="break_start" name="break_start" required>
                    </div>
                    <div class="form-group">
                        <label for="break_end">Break End Time</label>
                        <input type="time" class="form-control" id="break_end" name="break_end" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Schedule Modal -->
<div class="modal fade" id="editScheduleModal" tabindex="-1" role="dialog" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editScheduleModalLabel">Edit Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editScheduleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_user_id">Employee</label>
                        <select class="form-control" id="edit_user_id" name="user_id" required>
                            <option value="">Select Employee</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_shift_start">Shift Start Time</label>
                        <input type="time" class="form-control" id="edit_shift_start" name="shift_start" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_shift_end">Shift End Time</label>
                        <input type="time" class="form-control" id="edit_shift_end" name="shift_end" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_break_start">Break Start Time</label>
                        <input type="time" class="form-control" id="edit_break_start" name="break_start" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_break_end">Break End Time</label>
                        <input type="time" class="form-control" id="edit_break_end" name="break_end" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Edit Schedule
    $('.edit-schedule').click(function() {
        var id = $(this).data('id');
        var userId = $(this).data('user');
        var shiftStart = $(this).data('shift-start');
        var shiftEnd = $(this).data('shift-end');
        var breakStart = $(this).data('break-start');
        var breakEnd = $(this).data('break-end');

        $('#edit_user_id').val(userId);
        $('#edit_shift_start').val(shiftStart);
        $('#edit_shift_end').val(shiftEnd);
        $('#edit_break_start').val(breakStart);
        $('#edit_break_end').val(breakEnd);

        $('#editScheduleForm').attr('action', '/admin/schedule/' + id);
        $('#editScheduleModal').modal('show');
    });

    // Delete Schedule
    $('.delete-schedule').click(function() {
        var id = $(this).data('id');
        if (confirm('Are you sure you want to delete this schedule?')) {
            $.ajax({
                url: '/admin/schedule/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error deleting schedule');
                }
            });
        }
    });
});
</script>
@endpush
@endsection 