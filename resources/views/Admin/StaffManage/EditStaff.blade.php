@extends("Admin.Layouts.Master")
@section('Title', 'Edit Staff')
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
                  <div class="bg-white p-2">
                   <h5 class="card-title mb-4 font-weight-bold ml-2 mt-2 tx">Edit Staff</h5>
                   <form id="form-edit-steff" method="post" action="{{url('admin/user-management/edit')."/".$id}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row m-0">
                      <div class="col-12 px-2">
                        <p class="font-weight-bold">| Personal information</p>
                      </div>
                      
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Nickname</label>
                        <input type="text" name="nick_name" class="form-control mr-2" value="{{$getStaff->nick_name}}" autocomplete="off" >
                      </div>
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Image</label>
                        <input type="file" name="image" class="form-control mr-2">
                      </div>

                      <div class="col-12 px-2 mt-3">
                        <p class="font-weight-bold">| Contact information & login</p>
                      </div>
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Phone</label>
                        <input type="number" name="phone" value="{{$getStaff->phone}}" class="form-control mr-2" autocomplete="off" >
                      </div>    
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Email</label>
                        <input type="text" name="email" value="{{$getStaff->email}}" class="form-control mr-2" autocomplete="off" >
                      </div>
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Password</label>
                        <input type="password" name="password" class="form-control mr-2" autocomplete="off" >
                      </div>
                      <div class="col-12 px-2 mt-3">
                        <p class="font-weight-bold">|Curriculum vitae</p>
                      </div>
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Sex</label>
                        <select name="sex" class="form-control" id="exampleFormControlSelect1">
                          <option value="0" {{ $getStaff->sex == 0 ? 'selected' : '' }}>Male</option>
                          <option value="1" {{ $getStaff->sex == 1 ? 'selected' : '' }}>Female</option>
                        </select>
                      </div>
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Date of birth</label>
                        <input type="date" value="{{\Carbon\Carbon::parse($getStaff->date_of_birth)->setTimezone('America/Los_Angeles')->format('Y-m-d')}}" name="date_of_birth" class="form-control mr-2" autocomplete="off" >
                      </div>
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Place of birth</label>
                        <input type="text" value="{{$getStaff->place_of_birth}}" name="place_of_birth" class="form-control mr-2" autocomplete="off" >
                      </div>
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Marriage Status</label>
                        <select name="marital_status" class="form-control" id="exampleFormControlSelect1">
                          <option value="0" {{ $getStaff->marital_status == 0 ? 'selected' : '' }}>Married</option>
                          <option value="1" {{ $getStaff->marital_status == 1 ? 'selected' : '' }}>Not married</option> 
                        </select>
                      </div>
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">ID number</label>
                        <input type="text" value="{{$getStaff->id_number}}" name="id_number" class="form-control mr-2" autocomplete="off" >
                      </div> 
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">passport date</label>
                        <input type="date" value="{{\Carbon\Carbon::parse($getStaff->date_range)->setTimezone('America/Los_Angeles')->format('Y-m-d')}}" name="date_range" class="form-control mr-2" autocomplete="off" >
                      </div> 
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Passport issuer</label>
                        <input type="text" name="passport_issuer" value="{{$getStaff->passport_issuer}}" class="form-control mr-2" autocomplete="off" >
                      </div> 
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Domicile</label>
                        <input type="text" name="hometown" value="{{$getStaff->hometown}}" class="form-control mr-2" autocomplete="off" >
                      </div> 
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Nationality</label>
                        <input type="text" name="nationality" value="{{$getStaff->nationality}}" class="form-control mr-2" autocomplete="off" >
                      </div>  

                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Nation</label>
                        <input type="text" name="nation" value="{{$getStaff->nation}}" class="form-control mr-2" autocomplete="off" >
                      </div>  
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Religion</label>
                        <input type="text" name="religion" value="{{$getStaff->religion}}" class="form-control mr-2" autocomplete="off" >
                      </div>
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Household</label>
                        <input type="text" name="permanent_residence" class="form-control mr-2" value="{{$getStaff->permanent_residence}}" autocomplete="off" >
                      </div> 
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Staying</label>
                        <input type="text" name="staying" class="form-control mr-2" value="{{$getStaff->staying}}" autocomplete="off" >
                      </div> 
                      <div class="col-12 px-2 mt-3">
                        <p class="font-weight-bold">| Job Information</p>
                      </div>  
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Employee Type</label>
                        <select name="employee_type" class="form-control" id="exampleFormControlSelect1">
                          @foreach($employee_type as $item)
                         <option  value="{{ $item->id }}" {{ $item->id == $getStaff->employee_type ? 'selected' : '' }}>{{ $item->name }}</option>
                          @endforeach

                        </select>
                      </div> 
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Qualifications</label>
                        <select name="level" class="form-control" id="exampleFormControlSelect1">
                          @foreach($level as $item)
                          <option  value="{{ $item->id }}" {{ $item->id == $getStaff->level ? 'selected' : '' }}>{{ $item->qualification_name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Specialize</label>
                        <select name="specializes" class="form-control" id="exampleFormControlSelect1">
                          @foreach($specializes as $item)
                          <option  value="{{ $item->id }}" {{ $item->id == $getStaff->specializes ? 'selected' : '' }}>{{ $item->name_specializes }}</option>
                          @endforeach
                        </select>
                      </div> 
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Department</label>
                        <select name="rooms" class="form-control" id="exampleFormControlSelect1">
                          @foreach($rooms as $item)
                          <option value="{{ $item->id }}" {{ $item->id == $getStaff->rooms ? 'selected' : '' }}>{{ $item->room_name }}</option>
                          @endforeach

                        </select>
                      </div>   
                      <div class="col-12 col-sm-6 col-md-4 p-0 px-2 mb-2">
                        <label class="fz85">Position</label>
                        <select name="positions" class="form-control" id="exampleFormControlSelect1">
                          @foreach($positions as $item)
                          <option value="{{ $item->id }}" {{ $item->id == $getStaff->positions ? 'selected' : '' }}>{{ $item->name_position }}</option>
                          @endforeach

                        </select>
                      </div> 
                      <div class="col-12 p-0  text-center">
                        @if (\Session::has('msg'))
                        <span class="text-success mt-2">{!! \Session::get('msg') !!}</span>
                        @endif
                      </div>
                      <div class="col-12 p-0 pr-2 mb-2 text-center mt-3">
                        <button class="btn bg text-white">Edit Staff</button>
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
<script src="{{ asset('index/js/jquery-3.6.0.js') }}"></script>
<script src="{{ asset('index/js/validate/jquery.validate.min.js') }}" ></script>
<script src="{{ asset('index/js/validate/validate.js') }}"></script>
@endsection








