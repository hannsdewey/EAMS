@extends("Admin.Layouts.Master")
@section('Title', 'Chi tiết Staff')
@section('Content')

<style type="text/css">
  @media only screen and (max-width: 900px) {
    td{
      white-space: nowrap;
    }

  }
  p{
    font-size: 85% !important;
  }
</style>
<div class="container-scroller">
  <x-admin.layouts.header-dashboard/>
  <div class="container-fluid page-body-wrapper">
    <div class="theme-setting-wrapper">
    </div>
    <div class="side-bar-box" style="width: 250px;">
      <x-admin.layouts.side-bar/>
    </div>
    <div class="main-panel">
      <div class="content-wrapper p-3">
        <div class="row">
          <div class="col-md-12 grid-margin">
            <div class="row bg-white p-3">
              
              <div class="col-12 col-md-3 col-xl-3 mb-4 mb-xl-0 pr-4 pl-0">
                <div class="bg-white shadow-sm w-100">
                  @if(isset($GetStaffs->image))
                  <img  src="{{ asset('images/staff')."/".$GetStaffs->image}}" style="object-fit: cover;" width="100%" height="100%">
                  @else
                  <img  src="{{ asset('images/staff/default.png')}}" style="object-fit: cover;" width="100%" height="100%">
                  @endif
                </div>
              </div>
              <div class="col-12 col-md-4 p-2">
                <h5 class="font-weight-bold tx">Details</h5>
                <p class=" mb-2">Full name: {{$GetStaffs->full_name}}</p>
                <p class=" mb-2">Nickname: {{$GetStaffs->nick_name}}</p>
                <p class=" mb-2">Sex: @if($GetStaffs->sex == 0)Male @else Female @endif</p>
                <p class=" mb-2">Date of birth: {{\Carbon\Carbon::parse($GetStaffs->date_of_birth)->format('d/m/Y')}}</p>
                <p class=" mb-2">Place of birth: {{$GetStaffs->place_of_birth}}</p>
                <p class=" mb-2">Phone: <a href="tel:{{$GetStaffs->phone}}">{{$GetStaffs->phone}}</a></p>
                 <p class=" mb-2">Email: <a href="mailto:{{$GetStaffs->email}}">{{$GetStaffs->email}}</a></p>
                <p class=" mb-2">Marriage Status: @if($GetStaffs->marital_status == 0) Not married @else Married @endif</p>
                <p class=" mb-2">ID number: {{$GetStaffs->id_number}}</p>
                <p class=" mb-2">passport date: {{\Carbon\Carbon::parse($GetStaffs->date_range)->format('d/m/Y')}}</p>
                <p class=" mb-2">Domicile: {{$GetStaffs->hometown}}</p>
                <p class=" mb-2">Nationality: {{$GetStaffs->passport_issuer}}</p>
                <p class=" mb-2">Passport issuer: {{$GetStaffs->nationality}}</p>
                <p class=" mb-2">Nation: {{$GetStaffs->nation}}</p>
                <p class=" mb-2">Religion: {{$GetStaffs->religion}}</p>  
              </div>
              <div class="col-12 col-md-5 p-2">
                 <p class=" mb-2">Household: {{$GetStaffs->permanent_residence}}</p>
                <p class=" mb-2">Staying: {{$GetStaffs->staying}}</p>
                <p class=" mb-2">Employee Type: {{$GetStaffs->employee_type}}</p>
                <p class=" mb-2">Qualifications: {{$GetStaffs->level}}</p>
                <p class=" mb-2">Specialize: {{$GetStaffs->specializes}}</p>
                <p class=" mb-2">Department: {{$GetStaffs->rooms}}</p>
                <p class=" mb-2">Position: {{$GetStaffs->positions  }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>   
  </div>

  @endsection











