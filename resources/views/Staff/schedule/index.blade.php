@extends('layouts.staff')

@section('styles')
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Shift Schedule</h3>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
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
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: {
            url: '{{ route("staff.schedule.events") }}',
            error: function() {
                alert('Error loading schedule data');
            }
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
});
</script>
@endpush 