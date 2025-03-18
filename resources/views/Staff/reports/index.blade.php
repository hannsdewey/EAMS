@extends("Staff.Layouts.Master")
@section('Title', 'Reports')
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
                                            <h3 class="card-title">Reports</h3>
                                            <div class="card-tools">
                                                <form action="{{ route('staff.reports.index') }}" method="GET" class="form-inline">
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
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="card bg-primary text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Total Present</h5>
                                                            <h2>{{ $summary->total_present ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-danger text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Total Absent</h5>
                                                            <h2>{{ $summary->total_absent ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-warning text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Total Late</h5>
                                                            <h2>{{ $summary->total_late ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="card bg-success text-white">
                                                        <div class="card-body">
                                                            <h5 class="card-title">Total Leave</h5>
                                                            <h2>{{ $summary->total_leave ?? 0 }}</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive mt-4">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Date</th>
                                                            <th>Present</th>
                                                            <th>Absent</th>
                                                            <th>Late</th>
                                                            <th>Leave</th>
                                                            <th>Work Hours</th>
                                                            <th>Overtime</th>
                                                            <th>Shifts</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($reports as $report)
                                                            <tr>
                                                                <td>{{ $report->report_date }}</td>
                                                                <td>{{ $report->total_present }}</td>
                                                                <td>{{ $report->total_absent }}</td>
                                                                <td>{{ $report->total_late }}</td>
                                                                <td>{{ $report->total_leave }}</td>
                                                                <td>{{ $report->total_work_hours }}</td>
                                                                <td>{{ $report->total_overtime_hours }}</td>
                                                                <td>{{ $report->active_shifts }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-4">
                                                {{ $reports->links() }}
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