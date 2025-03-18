<!-- Sidebar -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ url('account-information') }}">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">Account Information</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('change-password') }}">
                <i class="icon-lock menu-icon"></i>
                <span class="menu-title">Change Password</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('staff.attendance.index') }}">
                <i class="icon-clock menu-icon"></i>
                <span class="menu-title">Attendance</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('staff.schedule.index') }}">
                <i class="icon-calendar menu-icon"></i>
                <span class="menu-title">Shift Schedule</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('staff.reports.index') }}">
                <i class="icon-chart menu-icon"></i>
                <span class="menu-title">Reports</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('staff.leave-requests.index') }}">
                <i class="icon-calendar menu-icon"></i>
                <span class="menu-title">Leave Requests</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('workflow-management') }}">
                <i class="icon-briefcase menu-icon"></i>
                <span class="menu-title">Workflow Management</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('bonus') }}">
                <i class="icon-gift menu-icon"></i>
                <span class="menu-title">Bonus</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('discipline') }}">
                <i class="icon-flag menu-icon"></i>
                <span class="menu-title">Discipline</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('salary-management') }}">
                <i class="icon-wallet menu-icon"></i>
                <span class="menu-title">Salary Management</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('identity-management') }}">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Face Recognition</span>
            </a>
        </li>
    </ul>
</nav> 