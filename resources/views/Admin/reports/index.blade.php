@extends("Admin.Layouts.Master")
@section('Title', 'Reports')
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
                                            <h3 class="card-title">Reports</h3>
                                            <div class="card-tools">
                                                <form action="{{ route('admin.reports.index') }}" method="GET" class="form-inline">
                                                    <select name="department" class="form-control mr-2">
                                                        <option value="">All Departments</option>
                                                        @foreach($departments as $department)
                                                            <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                                                                {{ $department->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <select name="position" class="form-control mr-2">
                                                        <option value="">All Positions</option>
                                                        @foreach($positions as $position)
                                                            <option value="{{ $position->id }}" {{ request('position') == $position->id ? 'selected' : '' }}>
                                                                {{ $position->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit" class="btn btn-primary">Filter</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <!-- Attendance Summary -->
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <div class="card bg-primary text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Total Days</h5>
                                                            <h2>{{ $attendanceSummary->total_days ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-success text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Present Days</h5>
                                                            <h2>{{ $attendanceSummary->present_days ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-warning text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Late Days</h5>
                                                            <h2>{{ $attendanceSummary->late_days ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-danger text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Absent Days</h5>
                                                            <h2>{{ $attendanceSummary->absent_days ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Leave Summary -->
                                            <div class="row mb-4">
                                                <div class="col-md-3">
                                                    <div class="card bg-info text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Total Leave Requests</h5>
                                                            <h2>{{ $leaveSummary->total_requests ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-success text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Approved Requests</h5>
                                                            <h2>{{ $leaveSummary->approved_requests ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-warning text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Pending Requests</h5>
                                                            <h2>{{ $leaveSummary->pending_requests ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-danger text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Rejected Requests</h5>
                                                            <h2>{{ $leaveSummary->rejected_requests ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Employee List -->
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Employee</th>
                                                            <th>Department</th>
                                                            <th>Position</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($users as $user)
                                                            <tr>
                                                                <td>{{ $user->name }}</td>
                                                                <td>{{ $user->department->name ?? '-' }}</td>
                                                                <td>{{ $user->position->name ?? '-' }}</td>
                                                                <td>
                                                                    <span class="badge badge-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                                                                        {{ ucfirst($user->status) }}
                                                                    </span>
                                                                </td>
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