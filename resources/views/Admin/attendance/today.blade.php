@extends("Admin.Layouts.Master")
@section('Title', "Today's Attendance")
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
                                            <h3 class="card-title">Today's Attendance Status</h3>
                                            <div class="card-tools">
                                                <span class="badge badge-primary">{{ now()->format('l, F j, Y') }}</span>
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
                                                            <th>Status</th>
                                                            <th>Check In</th>
                                                            <th>Check Out</th>
                                                            <th>Total Hours</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($attendances as $attendance)
                                                            <tr>
                                                                <td>{{ $attendance->user->name }}</td>
                                                                <td>{{ $attendance->user->department->name ?? '-' }}</td>
                                                                <td>{{ $attendance->user->position->name ?? '-' }}</td>
                                                                <td>
                                                                    <span class="badge badge-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'late' ? 'warning' : 'danger') }}">
                                                                        {{ ucfirst($attendance->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $attendance->check_in ? $attendance->check_in->format('H:i') : '-' }}</td>
                                                                <td>{{ $attendance->check_out ? $attendance->check_out->format('H:i') : '-' }}</td>
                                                                <td>{{ $attendance->total_hours ?? '-' }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
</div>
@endsection 