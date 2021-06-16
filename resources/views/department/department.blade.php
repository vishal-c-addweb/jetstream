@extends('template.main')

@section('body')

    <!-- main content start -->
    <div class="main-content" style="margin-top:50px; margin-right:-10px;">
       
        <!-- modals -->
        <section class="template-cards" >
          <div class="card card_border">

            <div class="cards__heading">
                @if (count($errors) > 0)
                    <script>
                        $( document ).ready(function() {
                            $('#departmentModal').modal('show');
                        });
                    </script>
                @endif

                <h3>Department </h3>
                
                <div style="text-align:center;">
                    <!-- Button trigger modal -->
                    <button type="  button" onclick="addDepartment()" style="co" data-bs-toggle="modal" data-bs-target="#departmentModal" class="bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Add Department</button>
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
                                <!-- Fetch Department Data -->  
                                <div class="card-body">
                                    <table class="table table-bordered " id="department-datatable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Department Name</th>
                                                <th>Created By</th>
                                                <th>Remove</th>
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
        </section>
        <!-- //modals -->
    </div>
    <!-- main content end-->
  
    <!-- Modal -->
    <div class="modal fade" id="departmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            
                <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('department.store') }}">
                            {{ csrf_field() }}

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Department Name</label>
                                <input type="text" class="form-control" id="dnameid" aria-describedby="emailHelp" name="dname">
                                
                                @error('dname')
                                <span style="color: red;">{{$message}}</span>
                                @enderror
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"data-dismiss="modal" aria-label="Close">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                    </form>                
                </div> 
            </div>     
        </div>                                             
    </div>  

@endsection
 