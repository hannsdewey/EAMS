@extends("Admin.Layouts.Master")
@section('Title', 'Identity management')
@section('Content')
<style type="text/css">
  @media only screen and (max-width: 900px) {
    td{
      white-space: nowrap;
    }
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
            <div class="row">
              <div class="col-12 col-xl-12 mb-4 mb-xl-0 p-0">
                <div>
                  <div>

                   <div class="bg-white">
                    <div class="col-lg-12 grid-margin stretch-card">
                      <div class="card">
                        <div class="card-body px-0">
                         <h5 class="card-title float-left mb-2 tx">Identity management</h5>
                         <div class="float-right"> 
                          <form method="get">    
                            <div class="form-group mb-3" style="display: flex"> 
                              <a href="{{url('admin/user-management/add-employees')}}">
                                <div class="btn btn-success mr-2" style="width: 120px;">Add user</div>      
                              </a>                
                              <input type="text" class="form-control"  placeholder="Enter ID / Code / Name" name="keyword">
                              <button type="submit" class="btn bg text-white ml-2" style="width: 120px;">Search</button>
                            </div>
                          </form> 
                        </div>
                        <div style="clear: both;"></div>
                        <div class="table-responsive">
                          <table class="table table-hover table-striped">
                            <thead>
                              <th width="3%">#</th>
                              <th width="4%">Code</th>
                              <th width="5%">Avatar</th>
                              <th width="15%">name</th>
                              <th width="10%">Status</th>
                              <th width="15%">Operation</th>
                            </thead>
                            <tbody>
                             <p style="display: none">{{$idup = 1}}</p>
                             @foreach($GetListStaffs as $item)
                             <tr>
                              <td>{{$idup++}}</td>

                              <td>NV{{$item->user_id}}</td>
                              <td>
                                @if(isset($item->image))
                                <img src="{{ asset('images/staff')."/".$item->image}}">
                                @else
                                <img src="{{ asset('images/staff/default.png')}}">
                                @endif
                              </td>
                              <td>
                                {{$item->full_name}}
                              </td>
                              
                              
                              <td>
                                @if($item->status == 0)
                                Working
                                @elseif($item->status == 1)
                                Quit one's job
                                @elseif($item->status == 2)
                                Take a break
                                @endif
                              </td>
                              <td>
                                <a href="{{url('admin/identity-management/view-data')."/".$item->id}}">
                                  <button class="btn bg mr-2 text-white">View data</button>
                                </a>
                                <a href="{{url('admin/identity-management/register-again')."/".$item->id}}">
                                  <button class="btn btn-danger mr-2">Register Again</button>
                                </a>
                                                       
                              </td>
                            </tr>
                           

                          
                        @endforeach


                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="float-right pr-3">
           {{ $GetListStaffs->links('pagination::bootstrap-4') }}
         </div>
         <div style="clear: both"></div>
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











