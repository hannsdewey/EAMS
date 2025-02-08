@extends("Admin.Layouts.Master")
@section('Title', 'List Email Templates
')
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
                         <h5 class="card-title float-left mb-2 tx">List Email Templates
</h5>
                         <div class="float-right"> 
                          <form method="get">    
                            <div class="form-group mb-3" style="display: flex"> 
                              <a href="{{url('admin/email-marketing/email-template/add')}}">
                                <div class="btn btn-success mr-2" style="width: 140px;">Create Email templates</div>      
                              </a> 
                              {{-- <input type="text" class="form-control"  placeholder="Name" name="keyword">
                              <button type="submit" class="btn bg text-white ml-2" style="width: 120px;">Search</button> --}}
                            </div>
                          </form> 
                        </div>
                        <div style="clear: both;"></div>
                        <div class="table-responsive">
                          <table class="table table-hover table-striped">
                            <thead>
                              <th>ID</th>
                              <th width="35%">Email subject</th>
                              <th width="25%">Type</th>
                              <th>Operation</th>
                            </thead>
                            <tbody>
                             <p style="display: none">{{$idup = 1}}</p>
                             @foreach($getEmailTemplate as $item)
                             <tr>
                              <td>{{$item->id}}</td>
                              <td>{{$item->template_title}}</td>
                              <td>
                                @if($item->id >2 )
                                Email created
                                @else
                                System email
                                @endif
                              </td>
                              <td>
                                <a href="{{url('/admin/email-marketing/email-template/edit')."/".$item->id}}">
                                  <button class="btn btn-primary">Edit</button>    
                                </a>
                                @if($item->id >2 )
                                <button class="btn btn-danger" data-toggle="modal" data-target="#exampleModalBlock{{$item->id}}">Delete</button>    
                                @endif
                              </td>
                            </tr>
                            <div class="modal fade mt-5" id="exampleModalBlock{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Email templates</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                   <p>You Agree Delete these Email templates?</p>
                                 </div>
                                 <div class="p-2">
                                   <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Cancel</button>
                                   <a  href="{{url('/admin/email-marketing/email-template/delete')."/".$item->id}}">
                                    <button type="button" class="btn btn-danger float-right mr-2">
                                      Agree                   
                                    </button>
                                  </a>
                                  <div style="clear: both"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                          @endforeach


                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="float-right pr-3">
             {{ $getEmailTemplate->links('pagination::bootstrap-4') }}
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















