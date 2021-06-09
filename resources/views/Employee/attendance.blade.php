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
                            $('#departmentModal').modal('show');
                        });
                    </script>
                @endif
              <h3>Attendance </h3>
                
                <div style="text-align:center;">
                    <button type="button" onClick="addAttendance()"  style="margin-left:45px;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 ml-3">Add Attendance</button>

                    <a href="report" class="bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 ml-3">Report</a>

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
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Employee Id</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Updated at</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($attendance as $a)
                                    <tr>
                                        <td>{{$a->id}}</td>
                                        <td>{{$a->employeeid->fname}}</td>
                                        <td>{{$a->att_date}}</td>
                                        <td>
                                        @if ($a->att_status == 1)
                                            Present
                                        @else 
                                            Absent
                                        @endif
                                        </td>
                                        <td>{{$a->created_at->diffForHumans()}}</td>
                                        <td>{{$a->updated_at->diffForHumans()}}</td>
                                    </tr>
                                    @endforeach
                                    
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
      <!-- //content -->
    </div>
  <!-- main content end-->
  
<!-- Modal -->
<div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="attendanceModalLabel">Add Attendance</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('addpresent') }}">
                {{ csrf_field() }}

                <div class="mb-3">
                    <label for="exampleInputemployee" class="form-label">Employee Name</label>
                    <SELECT name="employeeId" class="form-control" id="employeeId" >
                        @foreach($employee as $e)
                            <option value="{{$e->id}}">{{$e->fname}}</option>
                        @endforeach
                    </SELECT>
                </div>

                <div class="mb-3">
                    <label for="exampleInputE" class="form-label">Date</label>
                    <input type="date" class="form-control" id="datepicker" name="datepicker">
                </div>

                <div class="mb-3">
                    <label for="exampleInputst" class="form-label">Status</label>
                    <br/>
                    <input type="radio" id="presentId" value="present" name="status" >
                    <label for="exampleInputst" class="form-label" >Present</label>&nbsp;&nbsp;&nbsp;
                    <input type="radio" id="absentId" value="absent" name="status" >
                    <label for="exampleInputst" class="form-label">Absent</label>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        
        </div>
    </div>
</div>

@endsection