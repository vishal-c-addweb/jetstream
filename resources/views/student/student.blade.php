@extends('template.main')

@section('body')
<!-- //header-ends -->
<!-- main content start -->
<div class="main-content" style="margin-top:50px;">
    
    <!-- modals -->
    <section class="template-cards" >
        <div class="card card_border">
        <div class="cards__heading">
            <!-- if validation fails then don't close Modal. -->
            @if (count($errors) > 0)
            <script>
                $( document ).ready(function() {
                    $('#studentModal').modal('show');
                });
            </script>
        @endif
            <h3>Student </h3>
            
            <div style="text-align:center;">
                <!-- Button trigger modal -->
        <button type="button" onClick="openStudent()"  style="co" data-bs-toggle="modal" data-bs-target="#studentModal" class="bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Add Student</button>
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
                    <!-- Fetch Employee Data -->  
                    <div class="card-body">
                        <table class="table table-bordered" id="student-datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Address</th>
                                    <th>percentage</th>
                                    <th>School</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    </div>
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
  
<!--Add student Modal-->
<div class="modal fade bd-example-modal-lg" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="exampleModal1">
    <div class="modal-dialog modal-lg"> 
        <div class="modal-content">
            <div class="modal-header">
                    
                    <h4 class="modal-title" id="CompanyModal">Add Student</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            
            <div class="modal-body">
                <form method="POST" action="{{ route('add') }}" class="form-horizontal">                       
                    {{ csrf_field() }}
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="sname" >
                        
                        @error('sname')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Age</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="sage" >
                    
                        @error('sage')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Address</label></br>
                        <textarea name="saddress" class="form-control" cols="auto" rows="auto" ></textarea>
                        <br/>
                        
                        @error('saddress')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Percentage</label>
                        <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="spercentage" >
                        
                        @error('spercentage')
                        <span style="color: red;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">School</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="sschool" >
                        
                        @error('sschool')
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

<!-- Edit Student Modal -->
<div class="modal fade" id="studentEditModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    
    <div class="modal-content">
    
        <div class="modal-header">
            <h4 class="modal-title" id="StudentModal">Edit Student</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">

            <form action="javascript:void(0)" id="StudentForm" name="StudentForm" class="form-horizontal" method="POST" >
        
                <input type="hidden" name="id" id="studentId">
                {{ csrf_field() }}

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Name</label>
                    <input type="text" class="form-control" id="studentName" name="name" >
                    
                    @error('name')
                    <span style="color: red;">{{$message}}</span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Age</label>
                    <input type="number" class="form-control" id="studentAge" name="age" >
                    
                    @error('age')
                    <span style="color: red;">{{$message}}</span>
                    @enderror
                </div>  
                
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Address</label></br>
                    <textarea name="address" class="form-control" id="studentAddress" cols="auto" rows="auto" ></textarea>
                    <br/>
                    
                    @error('address')
                    <span style="color: red;">{{$message}}</span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Percentage</label>
                    <input type="number" class="form-control" id="studentPercentage"  name="percentage" >
                    
                    @error('percentage')
                    <span style="color: red;">{{$message}}</span>
                    @enderror
                </div>
        
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">School</label>
                    <input type="text" class="form-control" id="studentSchool" name="school" >
                    
                    @error('school')
                    <span style="color: red;">{{$message}}</span>
                    @enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-save1">Save 
                    </button>
                </div>
            </form>
        </div>        
    </div>
</div>
<!-- end bootstrap model -->  

@endsection