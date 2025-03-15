@extends("Staff.Layouts.Master")
@section('Title', 'Apply for Leave')
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
                                    <h5 class="card-title mb-4 font-weight-bold ml-2 mt-2 tx">Apply for Leave</h5>

                                    <form action="{{ route('staff.leave-requests.store') }}" method="POST">
                                        @csrf
                                        <div class="row m-0">
                                            <!-- Leave Type -->
                                            <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                                                <label class="fz85">Leave Type</label>
                                                <select name="leave_type_id" class="form-control" required>
                                                    <option value="">Select Leave Type</option>
                                                    @foreach($leaveTypes as $type)
                                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Start Date -->
                                            <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                                                <label class="fz85">Start Date</label>
                                                <input type="date" name="start_date" class="form-control" required>
                                            </div>

                                            <!-- End Date -->
                                            <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                                                <label class="fz85">End Date</label>
                                                <input type="date" name="end_date" class="form-control" required>
                                            </div>

                                            <!-- Reason -->
                                            <div class="col-12 p-0 px-2 mb-2">
                                                <label class="fz85">Reason</label>
                                                <textarea name="reason" class="form-control mr-2" required></textarea>
                                            </div>

                                            <!-- Submit Button -->
                                            <div class="col-12 p-0 pr-2 mb-2 text-center mt-3">
                                                <button class="btn bg text-white">Submit Leave Request</button>
                                            </div>
                                        </div>
                                    </form>

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
