@extends("Admin.Layouts.Master")
@section('Title', 'Leave Request Details')
@section('Content')
<div class="container-scroller">
    <x-admin.layouts.header-dashboard/>
    <div class="container-fluid page-body-wrapper">
        <div class="theme-setting-wrapper"></div>
        <div class="side-bar-box" style="width: 250px;">
            <x-admin.layouts.side-bar/>
        </div>
        <div class="main-panel">
            <div class="content-wrapper px-0 py-3">
                <div class="row m-0">
                    <div class="col-md-12 grid-margin p-0">
                        <div class="row m-0">
                            <div class="col-12 col-xl-12 mb-4 mb-xl-0 p-0">
                                <div class="bg-white p-2">
                                    <h5 class="card-title mb-4 font-weight-bold ml-2 mt-2 tx">Leave Request Details</h5>

                                    <div class="card p-3">
                                        <p><strong>Employee:</strong> {{ $leaveRequest->user->name }}</p>
                                        <p><strong>Leave Type:</strong> {{ $leaveRequest->leaveType->name }}</p>
                                        <p><strong>Start Date:</strong> {{ $leaveRequest->start_date }}</p>
                                        <p><strong>End Date:</strong> {{ $leaveRequest->end_date }}</p>
                                        <p><strong>Reason:</strong> {{ $leaveRequest->reason ?? 'N/A' }}</p>
                                        <p><strong>Status:</strong> 
                                            <span class="badge bg-{{ $leaveRequest->status == 'approved' ? 'success' : ($leaveRequest->status == 'rejected' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($leaveRequest->status) }}
                                            </span>
                                        </p>
                                    </div>

                                    <a href="{{ route('admin.leave.index') }}" class="btn btn-secondary mt-3">Back</a>

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
