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
  
              <h3>Task</h3>
                
                <div style="text-align:center;">
                    
                    <button type="button" onClick="addTask()"  style="margin-left:45px;" data-bs-toggle="modal" data-bs-target="#taskModal" class="bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 ml-3">Add Task</button>
                    
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
                                            <th>Task</th>
                                            <th>Project</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($task as $t)
                                        <tr>
                                            <td>{{$t->id}}</td>
                                            <td>{{$t->name}}</td>
                                            <td>{{$t->project->name}}</td>
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
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="taskModalLabel">Add Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('addtask') }}">
                {{ csrf_field() }}

                <div class="mb-3">
                    <h5 style="text-align:center;">Task</h5>
                </div>

                <div class="mb-3">
                    <label for="exampleInputtask" class="form-label">Task Name</label>
                    <br/>
                    <input type="text" class="form-control" name="taskname" id="taskName"> 
                </div>

                <div class="mb-3">
                    <label for="exampleInputtask" class="form-label">Project</label>
                    <SELECT name="projectid" class="form-control" id="projectId" >
                        <option value="select">Select Project</option>
                        @foreach($project as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </SELECT>
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