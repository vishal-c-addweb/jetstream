@extends('template.main')

@section('body')

    <!-- main content start -->
    <div class="main-content" style="margin-top:50px;">
    
        <section class="template-cards" >
          <div class="card card_border">

            <div class="cards__heading">

                <h3>Ip Address</h3>
                
                <div style="text-align:center;">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ipModal">Add IpAddress</button>
                </div>

                @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            
            <div class="data-tables">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card card_border p-4">
                            <div class="table-responsive">
                                <!-- Fetch Project Data -->  
                                <div class="card-body mt-5">
                                    <table class="table table-bordered " id="timesheet-table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Ip Address</th>
                                                <th>Action</th>
                                                <th>Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ip as $i)
                                            <tr>
                                                <td>{{$i->id}}</td>
                                                <td>{{$i->user->name}}</td>
                                                <td>{{$i->user->email}}</td>
                                                <td>{{$i->ipaddress}}</td>
                                                <td><button onClick="edit({{ $i->id }})" class="btn btn-success">Edit</button></td>
                                                <td><a href="/ipaddress/delete/{{ $i->id }}" class="btn btn-danger">Delete</a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mt-20" >
                    </div>
                </div>
            </div>

          </div>
        </section>
    </div>
    <!-- main content end-->
  
    <!-- Modal -->
    <div class="modal fade" id="ipModal" tabindex="-1" role="dialog" aria-labelledby="ipModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="ipModalLabel">Add IpAddress</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('ipaddress.store') }}">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <h5 style="text-align:center;">Ip Address</h5>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputIpAddress" class="form-label">Ip Address</label>
                            <br/>
                            <input type="text" class="form-control" name="ipaddress"> 
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputUser" class="form-label">User</label>
                            <br/>
                            <select class="form-control" name="userid">
                                <option value="select">Select User</option> 
                                @foreach($user as $u)
                                    <option value="{{$u->id}}">{{$u->name}}</option> 
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" >Save</button>
                        </div>
                    </form>
                </div>
            
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editIpModal" tabindex="-1" role="dialog" aria-labelledby="editIpModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="editIpModalLabel">Edit IpAddress</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="javascript:void(0)" id="ipAddressForm" name="ipAddressForm" class="form-horizontal" method="POST">
                        <input type="text" id="ipId" name="ip" hidden>
                        
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <h5 style="text-align:center;">Edit Ip Address</h5>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputIpAddress" class="form-label">Ip Address</label>
                            <br/>
                            <input type="text" class="form-control" name="ipaddress" id="ipAddress"> 
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputUser" class="form-label">User</label>
                            <br/>
                            <select class="form-control" name="userid" id="userId" disabled>
                                @foreach($user as $u)
                                    <option value="{{$u->id}}">{{$u->name}}</option> 
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputUser" class="form-label">Email</label>
                            <br/>
                            <select class="form-control" name="emailid" id="emailId" disabled>
                                @foreach($user as $u)
                                    <option value="{{$u->id}}">{{$u->email}}</option> 
                                @endforeach
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btn-save">Update</button>
                        </div>
                    </form>
                </div>
            
            </div>
        </div>
    </div>

@endsection