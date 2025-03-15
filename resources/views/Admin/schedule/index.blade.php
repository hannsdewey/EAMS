@extends('layouts.admin')

@section('styles')
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
<style>
.modal-dialog {
    max-width: 600px;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Staff Shift Schedule</h3>
                    <div class="card-tools">
                        <select id="staff-filter" class="form-control">
                            <option value="">All Staff</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage Shift Schedule</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm">
                    <input type="hidden" id="schedule_id">
                    <div class="form-group">
                        <label>Staff Member</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">Select Staff</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Shift Start</label>
                        <input type="time" name="shift_start" id="shift_start" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Shift End</label>
                        <input type="time" name="shift_end" id="shift_end" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Break Start</label>
                        <input type="time" name="break_start" id="break_start" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Break End</label>
                        <input type="time" name="break_end" id="break_end" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deleteSchedule" style="display: none;">Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveSchedule">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
<script>
$(document).ready(function() {
    var calendar = $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: {
            url: '{{ route("admin.schedule.events") }}',
            data: function() {
                return {
                    user_id: $('#staff-filter').val()
                };
            }
        },
        selectable: true,
        selectHelper: true,
        select: function(start, end) {
            $('#scheduleModal').modal('show');
            $('#date').val(moment(start).format('YYYY-MM-DD'));
            $('#schedule_id').val('');
            $('#deleteSchedule').hide();
        },
        eventClick: function(event) {
            $.get('{{ route("admin.schedule.get") }}/' + event.id, function(data) {
                $('#schedule_id').val(data.id);
                $('#user_id').val(data.user_id);
                $('#date').val(moment(data.date).format('YYYY-MM-DD'));
                $('#shift_start').val(moment(data.shift_start).format('HH:mm'));
                $('#shift_end').val(moment(data.shift_end).format('HH:mm'));
                $('#break_start').val(data.break_start ? moment(data.break_start).format('HH:mm') : '');
                $('#break_end').val(data.break_end ? moment(data.break_end).format('HH:mm') : '');
                $('#deleteSchedule').show();
                $('#scheduleModal').modal('show');
            });
        },
        eventRender: function(event, element) {
            if (event.break_start && event.break_end) {
                element.find('.fc-title').append('<br/>Break: ' + 
                    moment(event.break_start).format('HH:mm') + ' - ' + 
                    moment(event.break_end).format('HH:mm'));
            }
        },
        eventColor: '#3c8dbc',
        timeFormat: 'H:mm',
        displayEventEnd: true,
    });

    $('#staff-filter').change(function() {
        calendar.fullCalendar('refetchEvents');
    });

    $('#saveSchedule').click(function() {
        var formData = {
            id: $('#schedule_id').val(),
            user_id: $('#user_id').val(),
            date: $('#date').val(),
            shift_start: $('#shift_start').val(),
            shift_end: $('#shift_end').val(),
            break_start: $('#break_start').val(),
            break_end: $('#break_end').val(),
        };

        $.ajax({
            url: formData.id ? 
                '{{ route("admin.schedule.update") }}/' + formData.id : 
                '{{ route("admin.schedule.store") }}',
            method: formData.id ? 'PUT' : 'POST',
            data: formData,
            success: function(response) {
                $('#scheduleModal').modal('hide');
                calendar.fullCalendar('refetchEvents');
            },
            error: function(xhr) {
                alert('Error saving schedule: ' + xhr.responseJSON.message);
            }
        });
    });

    $('#deleteSchedule').click(function() {
        if (confirm('Are you sure you want to delete this schedule?')) {
            $.ajax({
                url: '{{ route("admin.schedule.delete") }}/' + $('#schedule_id').val(),
                method: 'DELETE',
                success: function() {
                    $('#scheduleModal').modal('hide');
                    calendar.fullCalendar('refetchEvents');
                }
            });
        }
    });

    $('#scheduleModal').on('hidden.bs.modal', function() {
        $('#scheduleForm')[0].reset();
    });
});
</script>
@endpush 