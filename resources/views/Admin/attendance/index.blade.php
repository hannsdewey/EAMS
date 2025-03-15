@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Staff Attendance Records</h3>
                    <div class="card-tools">
                        <form action="{{ route('admin.attendance.index') }}" method="GET" class="form-inline">
                            <select name="user_id" class="form-control mr-2">
                                <option value="">All Staff</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="year" class="form-control mr-2">
                                <option value="">Select Year</option>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="month" class="form-control mr-2">
                                <option value="">Select Month</option>
                                @foreach($months as $month)
                                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="day" class="form-control mr-2">
                                <option value="">Select Day</option>
                                @foreach($days as $day)
                                    <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Clock In</th>
                                    <th>Break In</th>
                                    <th>Break Out</th>
                                    <th>Clock Out</th>
                                    <th>Work Hours</th>
                                    <th>Overtime</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance->user->name }}</td>
                                        <td>{{ $attendance->date->format('Y-m-d') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $attendance->status == 'present' ? 'success' : 
                                                ($attendance->status == 'absent' ? 'danger' : 
                                                ($attendance->status == 'late' ? 'warning' : 'info')) }}">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $attendance->clock_in ? $attendance->clock_in->format('H:i:s') : '-' }}</td>
                                        <td>{{ $attendance->break_in ? $attendance->break_in->format('H:i:s') : '-' }}</td>
                                        <td>{{ $attendance->break_out ? $attendance->break_out->format('H:i:s') : '-' }}</td>
                                        <td>{{ $attendance->clock_out ? $attendance->clock_out->format('H:i:s') : '-' }}</td>
                                        <td>{{ $attendance->work_hours ?? '-' }}</td>
                                        <td>{{ $attendance->overtime_hours ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No attendance records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $attendances->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 