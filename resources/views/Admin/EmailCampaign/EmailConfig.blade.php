@extends("Admin.Layouts.Master")
@section('Title', 'Change configuration email')
@section('Content')
<div class="container-scroller">
  <x-admin.layouts.header-dashboard/>
  <div class="container-fluid page-body-wrapper">
    <div class="theme-setting-wrapper">
    </div>
    <div class="side-bar-box" style="width: 250px;">
      <x-admin.layouts.side-bar/>
    </div>
    <div class="main-panel">
      <div class="content-wrapper px-0 py-3">
        <div class="row m-0">
          <div class="col-md-12 grid-margin p-0">
            <div class="row m-0">
              <div class="col-12 col-xl-12 mb-4 mb-xl-0 p-0">
                <div>
                  <div class="bg-white p-4">
                    <h4 class="mb-4">Change configuration email</h4>
                    <form method="post" action="{{url('admin/email-marketing/email-config')}}">
                      @csrf
                      <div class="row m-0">
                        <div class="col-12 p-0 mb-2">
                          <label class="fz95">Email server</label>
                          <input type="text" name="mail_host" class="form-control mr-2" value="{{ $getEmailConfig->mail_host ?? '' }}" required>
                        </div>
                        <div class="col-12 p-0 mb-2">
                          <label class="fz95">Gate</label>
                          <input type="text" name="mail_port" class="form-control mr-2" value="{{ $getEmailConfig->mail_port ?? '' }}" required>
                        </div>
                        <div class="col-12 p-0 mb-2">
                          <label class="fz95">Username</label>
                          <input type="text" name="mail_username" class="form-control mr-2" value="{{ $getEmailConfig->mail_username ?? '' }}" required>
                        </div>
                        <div class="col-12 p-0 mb-2">
                          <label class="fz95">Password</label>
                          <input type="password" name="mail_password" class="form-control mr-2" value="{{ $getEmailConfig->mail_password ?? '' }}" required>
                        </div>
                        <div class="col-12 p-0 mb-2">
                          <label class="fz95">Encryption</label>
                          <input type="text" name="mail_encryption" class="form-control mr-2" value="{{ $getEmailConfig->mail_encryption ?? '' }}" required>
                        </div>
                        <div class="col-12 p-0 mb-2">
                          <label class="fz95">From Address</label>
                          <input type="text" name="mail_from_address" class="form-control mr-2" value="{{ $getEmailConfig->mail_from_address ?? '' }}" required>
                        </div>
                        <div class="col-12 p-0 mb-2">
                          <label class="fz95">From Name</label>
                          <input type="text" name="mail_from_name" class="form-control mr-2" value="{{ $getEmailConfig->mail_from_name ?? '' }}" required>
                        </div>
                        <div class="col-12 p-0 mb-2">
                          <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
