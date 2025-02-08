


<nav class="sidebar sidebar-offcanvas" id="sidebar" style="position:fixed;">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#tongquan" aria-expanded="false" aria-controls="tongquan">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Overview</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="tongquan">
        <ul class="nav flex-column sub-menu">
          {{-- <li class="nav-item"> <a class="nav-link" href="{{url('admin/thiet-lap')}}">Thống kê</a></li> --}}
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/user-management')}}">List of users</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/account-management')}}">Account management</a></li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#nhanvien" aria-expanded="false" aria-controls="nhanvien">
        <i class="icon-layout menu-icon"></i>
        <span class="menu-title">Room location</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="nhanvien">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/department-manager')}}">Department</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/position-management')}}">Position</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/level-management')}}">Qualifications</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/professional-management')}}">Specialize</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/manage-employee-type')}}">Employee Type</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#salary" aria-expanded="false" aria-controls="salary">
        <i class="icon-columns menu-icon"></i>
        <span class="menu-title">Salary Management</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="salary">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/salary-management')}}">Salary</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/salary-management/payroll')}}">Payroll</a></li>  
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/workflow-management')}}">
        <i class="icon-bar-graph menu-icon"></i>
        <span class="menu-title">Workflow management</span>
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
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/bonus')}}">Bonus</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/discipline')}}">Discipline</a></li>
          
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#taikhoan" aria-expanded="false" aria-controls="taikhoan">
        <i class="icon-head menu-icon"></i>
        <span class="menu-title">Account</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="taikhoan">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/account-information')}}">Account information</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/change-password')}}">Change Password</a></li>
        </ul>
      </div>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{url('admin/identity-management')}}">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Identity management</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#email-campagn" aria-expanded="false" aria-controls="email-campagn">
        <i class="icon-ban menu-icon"></i>
        <span class="menu-title">Email Management</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="email-campagn">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/email-marketing/email-template')}}">Email templates</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/email-marketing/email-config')}}">Email config</a></li>
          <li class="nav-item"> <a class="nav-link" href="{{url('admin/email-marketing/send-mail/add')}}">Send mail</a></li>
          
        </ul>
      </div>
    </li>


  </ul>
</nav>
