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
  
              <h3><i class="fa fa-clock-o"></i>&nbsp;Edit Timesheet </h3>
                
                <div style="text-align:center; margin-left:250px;" class="mt-5 col-md-6" >
                    
                    <label for="exampleInputE" class="form-label">Date</label>
                    <input type="date" class="form-control" id="edittimesheetDate" name="edittimesheetDate" >
                
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
                        <div class="card-body col-md-6" id="editTimesheet" style=" margin-left:100px;">
                            <form method="POST" action="addtimesheet" id="tsheetForm">
                                {{ csrf_field() }}

                                <div class="mb-3">
                                    <h5 style="text-align:center;">Timesheet</h5>
                                    
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
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
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

@endsection