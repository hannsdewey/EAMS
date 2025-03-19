@extends("Admin.Layouts.Master")
@section('Title', 'Leave')
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
                                    <h5 class="card-title mb-4 font-weight-bold ml-2 mt-2 tx">Leave Requests</h5>

                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Employee</th>
                                                <th>Leave Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($leaveRequests as $request)
                                                <tr>
                                                    <td>{{ $request->user->name }}</td>
                                                    <td>{{ $request->leaveType->name }}</td>
                                                    <td>{{ $request->start_date }}</td>
                                                    <td>{{ $request->end_date }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $request->status == 'approved' ? 'success' : ($request->status == 'rejected' ? 'danger' : 'warning') }}">
                                                            {{ ucfirst($request->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.leave-requests.show', $request->id) }}" class="btn btn-info btn-sm">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if($request->status == 'pending')
                                                            <a href="{{ route('admin.leave-requests.approve', $request->id) }}" class="btn btn-success btn-sm">Approve</a>
                                                            <a href="{{ route('admin.leave-requests.reject', $request->id) }}" class="btn btn-danger btn-sm">Reject</a>
                                                        @endif
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
