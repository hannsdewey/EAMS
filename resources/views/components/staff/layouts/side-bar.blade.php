<nav class="sidebar sidebar-offcanvas" id="sidebar" style="position:fixed;">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#tongquan" aria-expanded="false" aria-controls="tongquan">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Account</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="tongquan">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{url('account-information')}}">Account information</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('change-password')}}">Change Password</a></li>
        </ul>
      </div>
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
      <a class="nav-link" data-toggle="collapse" href="#staffLeave" aria-expanded="false" aria-controls="staffLeave">
          <i class="ti-calendar menu-icon"></i>
          <span class="menu-title">My Leave</span>
          <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="staffLeave">
          <ul class="nav flex-column sub-menu">
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('staff.leave-requests.index') }}">My Leave Requests</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('staff.leave-requests.create') }}">Apply for Leave</a>
              </li>
          </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{url('workflow-management')}}">
        <i class="icon-bar-graph menu-icon"></i>
        <span class="menu-title">Workflow management</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{url('salary-management')}}">
        <i class="icon-wallet menu-icon"></i>
        <span class="menu-title">Salary Management</span>
      </a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#khenthuong" aria-expanded="false" aria-controls="khenthuong">
        <i class="icon-grid-2 menu-icon"></i>
        <span class="menu-title">Reward-discipline</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="khenthuong">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{url('bonus')}}">Bonus</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('discipline')}}">Discipline</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{url('identity-management')}}">
        <i class="icon-user menu-icon"></i>
        <span class="menu-title">Face Recognition</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{url('register-faces')}}">
        <i class="icon-camera menu-icon"></i>
        <span class="menu-title">Face Registration</span>
      </a>
    </li>
  </ul>
</nav>
