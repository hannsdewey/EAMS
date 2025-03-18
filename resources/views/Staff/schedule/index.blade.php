@extends("Staff.Layouts.Master")
@section('Title', 'My Schedule')
@section('Content')
<div class="container-scroller">
    <x-staff.layouts.header-dashboard/>
    <div class="container-fluid page-body-wrapper">
        <div class="theme-setting-wrapper">
        </div>
        <div class="side-bar-box" style="width: 250px;">
            <x-staff.layouts.side-bar/>
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
                                            <h3 class="card-title">My Schedule</h3>
                                            <div class="card-tools">
                                                <form action="{{ route('staff.schedule.index') }}" method="GET" class="form-inline">
                                                    <select name="year" class="form-control mr-2">
                                                        <option value="">Select Year</option>
                                                        @foreach($years as $y)
                                                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>
                                                                {{ $y }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <select name="month" class="form-control mr-2">
                                                        <option value="">Select Month</option>
                                                        @foreach($months as $m)
                                                            <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="calendar"></div>
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

@push('scripts')
<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
<script>
$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: '{{ route("staff.schedule.events") }}',
        eventClick: function(event) {
            if (event.url) {
                window.location.href = event.url;
            }
        }
    });
});
</script>
@endpush
@endsection 