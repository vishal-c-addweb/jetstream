@extends('template.main')

@section('body')
  <section>
    <!-- sidebar menu start -->
    <div class="sidebar-menu sticky-sidebar-menu">

      <!-- logo start -->
      <div class="logo">
        <h1><a href="index.html">Collective</a></h1>
      </div>

      <!-- if logo is image enable this -->
        <!-- image logo --
        <div class="logo">
          <a href="index.html">
            <img src="image-path" alt="Your logo" title="Your logo" class="img-fluid" style="height:35px;" />
          </a>
        </div>
        <!--//image logo -->

      <div class="logo-icon text-center">
        <a href="index.html" title="logo" ><img src="{{ asset ('images/logo.png') }}" alt="logo-icon" style="margin-left:10px;"> </a>
      </div>
      <!-- //logo end -->

      <div class="sidebar-menu-inner">

        <!-- sidebar nav start -->
        <ul class="nav nav-pills nav-stacked custom-nav">
          <li class="active"><a href="index.html"><i class="fa fa-tachometer"></i><span> Dashboard</span></a>
          </li>
          <li class="menu-list">
            <a href="#"><i class="fa fa-cogs"></i>
              <span>Elements <i class="lnr lnr-chevron-right"></i></span></a>
            <ul class="sub-menu-list">
              <li><a href="carousels.html">Carousels</a> </li>
              <li><a href="cards.html">Default cards</a> </li>
              <li><a href="people.html">People cards</a></li>
            </ul>
          </li>
          <li><a href="pricing.html"><i class="fa fa-table"></i> <span>Pricing tables</span></a></li>
          <li><a href="blocks.html"><i class="fa fa-th"></i> <span>Content blocks</span></a></li>
          <li><a href="forms.html"><i class="fa fa-file-text"></i> <span>Forms</span></a></li>
        </ul>
        <!-- //sidebar nav end -->
        <!-- toggle button start -->
        <a class="toggle-btn">
          <i class="fa fa-angle-double-left menu-collapsed__left"><span>Collapse Sidebar</span></i>
          <i class="fa fa-angle-double-right menu-collapsed__right"></i>
        </a>
        <!-- //toggle button end -->
      </div>

    </div>
    <!-- //sidebar menu end -->

    <!-- header-starts -->
    <div class="header sticky-header" >

      @include('navigation-menu')

    </div>

    <!-- //header-ends -->
    <!-- main content start -->
    <div class="main-content" style="margin-top:50px;">
      <!-- content -->
          <!-- if validation fails then don't close Modal. -->
          @if (count($errors) > 0)
      <script>
          $( document ).ready(function() {
              $('#empdadd').modal('show');
          });
      </script>
        @endif
        <!-- modals -->
        <section class="template-cards" >
          <div class="card card_border">
            <div class="cards__heading">
              <h3>Employee - <span> Data </span></h3>
              <div style="text-align:center;">
                <!-- Button trigger modal -->
                <button type="button" onClick="add()"  style="co" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bg-pink-700 text-white font-bold py-2 px-4 rounded my-3 ml-3 btn btn-primary" >Add Employee</button>
                
                <!-- Button trigger modal -->
                <a href="attendance" class="bg-green-700 text-white font-bold py-2 px-4 rounded my-3 ml-3" style="background-color:gray;">View Attendance</a>
                
                <!-- Button trigger modal -->
                <a href="report" class="bg-pink-700 text-white font-bold py-2 px-4 rounded my-3 ml-3" style="background-color:green;">Report Employee</a>
            </div>
            </div>
            
            <div class="data-tables">
            <div class="row">
              <div class="col-lg-12 mb-4">
                <div class="card card_border p-4">
                  <div class="table-responsive">
                      <!-- Fetch Employee Data -->  
                      <div class="card-body">
                          <table class="table table-bordered" style="border: 1px solid black;" id="ajax-crud-datatable">
                              <thead>
                              <tr>
                              <th>Id</th>
                              <th>Employee ID</th>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Phone</th>
                              <th>Email</th>
                              <th>Gender</th>
                              <th>Address</th>
                              <th>Salary</th>
                              <th>Department</th>
                              <th>Team</th>
                              <th style="width:280px;">Action</th>
                              </tr>
                              </thead>
                          </table>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
        </section>
        <!-- //modals -->

      </div>
      <!-- //content -->
    </div>
  <!-- main content end-->
    
  </section>
  
    <!--Add employee Modal-->
    <div class="modal fade bd-example-modal-lg" id="empdadd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="exampleModal1">
        <div class="modal-dialog modal-lg"> 
            <div class="modal-content">
                <div class="modal-header">
                        
                        <h4 class="modal-title" id="CompanyModal">Add Employee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                
                <div class="modal-body">
                    <form method="POST" action="{{ route('store') }}" class="form-horizontal">                       
                        {{ csrf_field() }}
                        
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Employee Id</label>
                            <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="empid" >
                            
                            @error('empid')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="fname" >
                        
                            @error('fname')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="lname" >
                        
                            @error('lname')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>  
                          
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Phone</label>
                            <input type="phone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="phone"  >
                            
                            @error('phone')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" >
                            
                            @error('email')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Gender</label></br>
                            
                            <input type="radio"  id="exampleCheck1" name="gender" value="male" >
                            <label class="form-check-label" for="exampleCheck1">Male</label>
                            
                            <input type="radio"  id="exampleCheck1" name="gender" value="female">
                            <label class="form-check-label" for="exampleCheck1">Female</label>
                            <br/>
                            
                            @error('gender')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Address</label></br>
                            <textarea name="address" class="form-control" cols="auto" rows="auto" ></textarea>
                            <br/>
                            
                            @error('address')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Salary</label>
                            <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="salary" >
                            
                            @error('salary')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Department Id</label>
                                
                            <SELECT name="depid" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                @foreach($department as $d)
                                    <option value="{{$d->dep_id}}">{{$d->   dep_name}}</option>
                                @endforeach
                            </SELECT>   
                            
                            @error('depname')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">                              
                            <label for="exampleInputEmail1" class="form-label">Team</label>
                            <SELECT name="teamid" class="form-control" id="teamid" >
                                @foreach($team as $t)
                                <option value="{{$t->id}}">{{$t->name}}</option>
                                @endforeach
                            </SELECT>
                            
                            @error('name')
                            <span style="color: red;">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->

    <!-- Edit employee Modal -->
    <div class="modal fade" id="company-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="CompanyModal">Edit Company</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="CompanyForm" name="CompanyForm" class="form-horizontal" method="POST" >
                    <input type="hidden" name="id" id="id">
                    {{ csrf_field() }}

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Employee Id</label>
                        <input type="number" class="form-control" id="empid" name="empid" readonly>
                        
                        @error('empid')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" >
                        
                        @error('fname')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" >
                        
                        @error('lname')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>  
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Phone</label>
                        <input type="phone" class="form-control" id="phone" name="phone"  >
                        
                        @error('phone')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="email"  name="email" >
                        
                        @error('email')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Gender</label><br/>
                        <div class="mb-3">
                        <input type="radio"   name="gender" value="male" id="malec">
                        <label class="form-check-label" for="exampleCheck1">Male</label>
                        <input type="radio"  name="gender" value="female" id="femalec">
                        <label class="form-check-label" for="exampleCheck1">Female</label>
                        </div>
                        
                        @error('gender')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Address</label></br>
                        <textarea name="address" class="form-control" id="address" cols="auto" rows="auto" ></textarea>
                        <br/>
                        
                        @error('address')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Salary</label>
                        <input type="number" class="form-control" id="salary" name="salary" >
                        
                        @error('salary')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Department </label>
                        <SELECT name="depid" class="form-control" id="depid">
                            @foreach($department as $d)
                            <option value="{{$d->dep_id}}">{{$d->dep_name}}</option>
                            @endforeach
                        </SELECT>
                        
                        @error('depname')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Team</label>
                        <SELECT name="teamid" class="form-control" id="teammid" >
                            @foreach($team as $t)
                            <option value="{{$t->id}}">{{$t->name}}</option>
                            @endforeach
                        </SELECT>
                        
                        @error('name')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-save2">Save 
                        </button>
                    </div>
                </form>
            </div>        
        </div>
    </div>
    <!-- end bootstrap model -->

@endsection
 