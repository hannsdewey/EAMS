@extends("Admin.Layouts.Master")
@section('Title', 'Attendance Management')
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
                                            <h3 class="card-title">Attendance Management</h3>
                                            <div class="card-tools">
                                                <a href="{{ route('admin.attendance.today') }}" class="btn btn-primary">
                                                    Today's Status
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Employee</th>
                                                            <th>Status</th>
                                                            <th>Check In</th>
                                                            <th>Check Out</th>
                                                            <th>Total Hours</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($attendances as $attendance)
                                                            <tr>
                                                                <td>{{ $attendance->date }}</td>
                                                                <td>{{ $attendance->user->name }}</td>
                                                                <td>
                                                                    <span class="badge badge-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'late' ? 'warning' : 'danger') }}">
                                                                        {{ ucfirst($attendance->status) }}
                                                                    </span>
                                                                </td>
                                                                <td>{{ $attendance->check_in }}</td>
                                                                <td>{{ $attendance->check_out }}</td>
                                                                <td>{{ $attendance->total_hours }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-4">
                                                {{ $attendances->links() }}
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