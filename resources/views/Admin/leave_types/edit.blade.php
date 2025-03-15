@extends("Admin.Layouts.Master")
@section('Title', 'Edit Leave Type')
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
                                    <h5 class="card-title mb-4 font-weight-bold ml-2 mt-2 tx">Edit Leave Type</h5>

                                    <form action="{{ route('admin.leave-types.update', ['leaveType' => $leaveType->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')  {{-- Required for update requests --}}
                                        <div class="row m-0">
                                            <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                                                <label class="fz85">Name</label>
                                                <input type="text" name="name" class="form-control mr-2" value="{{ $leaveType->name }}" required>
                                            </div>  
                                            <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                                                <label class="fz85">Description</label>
                                                <textarea name="description" class="form-control mr-2">{{ $leaveType->description }}</textarea>
                                            </div> 
                                            <div class="col-12 p-0 pr-2 mb-2 text-center mt-3">
                                                <button class="btn bg text-white">Update</button>
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
