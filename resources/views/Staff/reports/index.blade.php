@extends('layouts.staff')

@section('styles')
<link href='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css' rel='stylesheet' />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Attendance Reports</h3>
                    <div class="card-tools">
                        <form action="{{ route('staff.reports.index') }}" method="GET" class="form-inline">
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
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                        <div class="col-md-6">
                            <canvas id="hoursChart"></canvas>
                        </div>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Present</th>
                                    <th>Absent</th>
                                    <th>Late</th>
                                    <th>Leave</th>
                                    <th>Work Hours</th>
                                    <th>Overtime Hours</th>
                                    <th>Active Shifts</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                    <tr>
                                        <td>{{ $report->report_date->format('Y-m-d') }}</td>
                                        <td>{{ $report->total_present }}</td>
                                        <td>{{ $report->total_absent }}</td>
                                        <td>{{ $report->total_late }}</td>
                                        <td>{{ $report->total_leave }}</td>
                                        <td>{{ $report->total_work_hours }}</td>
                                        <td>{{ $report->total_overtime_hours }}</td>
                                        <td>{{ $report->active_shifts }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No reports found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js'></script>
<script>
$(document).ready(function() {
    // Prepare data from PHP variables
    var summaryData = {
        present: {{ $summary->total_present ?? 0 }},
        absent: {{ $summary->total_absent ?? 0 }},
        late: {{ $summary->total_late ?? 0 }},
        leave: {{ $summary->total_leave ?? 0 }},
        workHours: {{ $summary->total_work_hours ?? 0 }},
        overtimeHours: {{ $summary->total_overtime_hours ?? 0 }}
    };

    // Attendance Status Chart
    var attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'pie',
        data: {
            labels: ['Present', 'Absent', 'Late', 'Leave'],
            datasets: [{
                data: [
                    summaryData.present,
                    summaryData.absent,
                    summaryData.late,
                    summaryData.leave
                ],
                backgroundColor: [
                    '#28a745',
                    '#dc3545',
                    '#ffc107',
                    '#17a2b8'
                ]
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Attendance Status Distribution'
            }
        }
    });

    // Hours Chart
    var hoursCtx = document.getElementById('hoursChart').getContext('2d');
    new Chart(hoursCtx, {
        type: 'bar',
        data: {
            labels: ['Work Hours', 'Overtime Hours'],
            datasets: [{
                label: 'Hours',
                data: [
                    summaryData.workHours,
                    summaryData.overtimeHours
                ],
                backgroundColor: [
                    '#007bff',
                    '#6610f2'
                ]
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Work Hours Distribution'
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
});
</script>
@endpush 