@extends("Admin.Layouts.Master")
@section('Title', 'Leave Types')
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
                                    <h5 class="card-title mb-4 font-weight-bold ml-2 mt-2 tx">Leave Types</h5>

                                    <a href="{{ route('admin.leave-types.create') }}" class="btn btn-primary mb-3">Add Leave Type</a>

                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($leaveTypes as $leaveType)
                                                <tr>
                                                    <td>{{ $leaveType->id }}</td>
                                                    <td>{{ $leaveType->name }}</td>
                                                    <td>{{ $leaveType->description }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.leave-types.edit', $leaveType->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                        <form action="{{ route('admin.leave-types.destroy', $leaveType->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                        </form>
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
