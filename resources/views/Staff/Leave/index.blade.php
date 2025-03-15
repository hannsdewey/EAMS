@extends("Staff.Layouts.Master")
@section('Title', 'My Leave Requests')
@section('Content')
<div class="container-scroller">
    <x-staff.layouts.header-dashboard/>
    <div class="container-fluid page-body-wrapper">
        <div class="theme-setting-wrapper"></div>
        <div class="side-bar-box" style="width: 250px;">
            <x-staff.layouts.side-bar/>
        </div>
        <div class="main-panel">
            <div class="content-wrapper px-0 py-3">
                <div class="row m-0">
                    <div class="col-md-12 grid-margin p-0">
                        <div class="row m-0">
                            <div class="col-12 col-xl-12 mb-4 mb-xl-0 p-0">
                                <div class="bg-white p-2">
                                    <h5 class="card-title mb-4 font-weight-bold ml-2 mt-2 tx">My Leave Requests</h5>

                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Leave Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($leaveRequests as $index => $leave)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $leave->leaveType->name }}</td>
                                                <td>{{ $leave->start_date }}</td>
                                                <td>{{ $leave->end_date }}</td>
                                                <td>
                                                    @if($leave->status == 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif($leave->status == 'approved')
                                                        <span class="badge badge-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('staff.leave-requests.show', $leave->id) }}" class="btn btn-sm btn-info">View</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                </div> <!-- End bg-white -->
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End content-wrapper -->
        </div> <!-- End main-panel -->
    </div> <!-- End page-body-wrapper -->
</div>
@endsection
