@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Leave Request Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.leave.index') }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Staff Name</th>
                                    <td>{{ $leaveRequest->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Leave Type</th>
                                    <td>{{ $leaveRequest->leaveType->name }}</td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td>{{ $leaveRequest->start_date->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ $leaveRequest->end_date->format('Y-m-d') }}</td>
                                </tr>
                                <tr>
                                    <th>Duration</th>
                                    <td>{{ $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1 }} days</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $leaveRequest->status === 'approved' ? 'success' : 
                                            ($leaveRequest->status === 'rejected' ? 'danger' : 'warning') 
                                        }}">
                                            {{ ucfirst($leaveRequest->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @if($leaveRequest->approved_by)
                                    <tr>
                                        <th>Approved/Rejected By</th>
                                        <td>{{ $leaveRequest->approvedBy->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Approved/Rejected At</th>
                                        <td>{{ $leaveRequest->approved_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Reason for Leave</h5>
                            <p class="border p-3">{{ $leaveRequest->reason ?: 'No reason provided' }}</p>

                            @if($leaveRequest->status === 'pending')
                                <div class="mt-4">
                                    <form action="{{ route('admin.leave.approve', $leaveRequest->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-success"
                                                onclick="return confirm('Are you sure you want to approve this leave request?')">
                                            <i class="fas fa-check"></i> Approve Request
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.leave.reject', $leaveRequest->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-danger"
                                                onclick="return confirm('Are you sure you want to reject this leave request?')">
                                            <i class="fas fa-times"></i> Reject Request
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
