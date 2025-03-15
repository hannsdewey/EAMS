@extends("Staff.Layouts.Master")
@section('Title', 'Leave Request Details')
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
                                    <h5 class="card-title mb-4 font-weight-bold ml-2 mt-2 tx">Leave Request Details</h5>

                                    <div class="row m-0">
                                        <div class="col-md-6">
                                            <p><strong>Leave Type:</strong> {{ $leaveRequest->leaveType->name }}</p>
                                            <p><strong>Start Date:</strong> {{ $leaveRequest->start_date }}</p>
                                            <p><strong>End Date:</strong> {{ $leaveRequest->end_date }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Status:</strong> 
                                                @if($leaveRequest->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($leaveRequest->status == 'approved')
                                                    <span class="badge badge-success">Approved</span>
                                                @else
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            </p>
                                            <p><strong>Reason:</strong> {{ $leaveRequest->reason }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <a href="{{ route('staff.leave-requests.index') }}" class="btn btn-secondary">Back to List</a>
                                    </div>

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
