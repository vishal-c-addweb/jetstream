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
  
              <h3><i class="fa fa-clock-o"></i>&nbsp;Timesheet </h3>
                
                <div style="text-align:center;">
                    <button type="button" onClick="addTimesheet()"  style="margin-left:45px;" data-bs-toggle="modal" data-bs-target="#timesheetModal" class="bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 ml-3">Add Timesheet</button>
                    <a href="edittimesheet" class="btn btn-success"><i class="fa fa-plus">&nbsp;</i>Edit</a>

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
                            <table class="table table-bordered " id="timesheet-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>User</th>
                                            <th>Project</th>
                                            <th>Task</th>
                                            <th>Date</th>
                                            <th>Hour</th>
                                            <th>Minute</th>
                                            <th>Discription</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($timesheet as $t)
                                        <tr >
                                            <td>{{$t->id}}</td>
                                            <td>{{$t->user->name}}</td>
                                            <td>{{$t->project->name}}</td>
                                            <td>{{$t->task->name}}</td>
                                            <td>{{$t->timesheet_date}}</td>
                                            <td>{{$t->hour}}</td>
                                            <td>{{$t->minute}}</td>
                                            <td><button type="button" onClick="description({{ $t->id }})"  class="btn btn-primary">View</button></td>
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
<div class="modal fade" id="timesheetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="timesheetModalLabel">Add Timesheet</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="editTsheet">
            <form method="POST" action="{{ route('addtimesheet') }}">
                {{ csrf_field() }}

                <div class="mb-3">
                    <h5 style="text-align:center;">Timesheet</h5>
                    
                </div>


                <div class="mb-3">
                    <label for="exampleInputE" class="form-label">Date</label>
                    <input type="date" class="form-control inspectionDate" id="timesheetDate" name="timesheetDate" >
                </div>

                <div class="mb-3">
                    <label for="exampleInputproject" class="form-label">Project</label>
                    <SELECT name="projectid" class="form-control" id="projectId">
                        <option value="select">Select Project</option>
                        
                        @foreach($project as $p)
                         <option value="{{ $p->project_id }}">{{ $p->project->name }}</option>
                        @endforeach
                        
                    </SELECT>
                </div>

                <div class="mb-3">
                    <label for="exampleInputtask" class="form-label">Task</label>
                    <SELECT name="taskname" class="form-control" id="taskname" >
                        <option value="select">Select Task</option>
                    </SELECT>
                </div>
                
                <div class="mb-3">
                    <label for="exampleInputhour" class="form-label">Hour</label>
                    <SELECT name="hour" class="form-control" id="hour" >
                        @for($i=0;$i<=8;$i++)
                        <option value="{{$i}}">{{$i}}</option>
                        @endfor
                    </SELECT>
                </div>

                <div class="mb-3">
                    <label for="exampleInputminute" class="form-label">Minute</label>
                    <SELECT name="minute" class="form-control" id="minute" >
                        <option value="0">0</option>
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="45">45</option>
                    </SELECT>
                </div>

                <div class="mb-3">
                    <label for="exampleInputdescription" class="form-label">Description</label>
                    <br/>
                    <textarea id="description" name="description" class="form-control"></textarea>
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

<!-- Modal -->
<div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="descriptionModalLabel">Description</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="">
                {{ csrf_field() }}

                <div class="mb-3">
                    <h5 style="text-align:center;">Description</h5>
                    
                </div>

                <div class="mb-3">
                    <p id="paraId"></p>
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