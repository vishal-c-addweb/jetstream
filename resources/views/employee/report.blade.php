@extends('template.main')

@section('body')

    <!-- main content start -->
    <div class="main-content" style="margin-top:50px;">
       
        <!-- modals -->
        <section class="template-cards">

          <div class="card card_border">

            <div class="cards__heading">

                <h3>Report </h3>
                
                <div class="row mt-3">
                        
                        <div class="col-md-4">
                            <div class="col-md-5">
                                <label>Employee:</label>
                            </div>
                            <div class="col-md-7">
                                <select name="employeeId" id="employeeId" class="form-control">
                                    <option value="">Select Employee</option>
                                    @foreach($employee as $e)
                                    <option value="{{$e->id}}">{{$e->fname}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="col-md-5">
                                <label>Start Date:</label>
                            </div>
                            <div class="col-md-7">
                                <input type="date" class="form-control" id="startDate" name="startDate">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="col-md-5">
                                <label>End Date:</label>
                            </div>
                            <div class="col-md-7">
                                <input type="date" class="form-control" id="endDate" name="endDate">
                            </div>
                        </div>
                </div>

                <div class="row mt-3" style="margin-left:400px;">
                        
                        <div class="col-md-4 ml-3">
                            <button id="getReport" class="btn btn-primary" >Employee Report</button>
                        </div>
                
                </div>

                <div class="row mt-3" style="margin-left:260px;">
                    
                    <div class="col-md-3">
                        <label>Salary:</label>  
                        <input type="number"  id="salary" name="salary" class="form-control">
                    </div>

                    <div class="mb-3 mt-4">
                        <button id="calEmployeeSalary" class="btn btn-primary">Calculate Salary</button>
                    </div>

                    <div class="mb-3 mt-4">
                        &nbsp;&nbsp;<button type="button" onClick="window.location.reload();" class="btn btn-primary">Refresh</button>
                    </div>
    
                </div>

                <div class="row mt-3" style="margin-left:260px;">
                    
                    <button id="getTodayReport" class="btn btn-primary" >Today Report</button>&nbsp;&nbsp;
                    <button id="getYesterdayReport" class="btn btn-primary" >Yesterday Report</button>&nbsp;&nbsp;
                    <button id="getLastweekReport" class="btn btn-primary" >Lastweek Report</button>
                    
                </div>
        
            </div>
            
            <div class="data-tables">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        <div class="card card_border p-4">
                            <div class="table-responsive">
                                <!-- Fetch report Data -->  
                                <div class="card-body">

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Employee Id</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Created at</th>
                                                <th>Updated at</th>
                                            </tr>
                                        </thead>

                                        <tbody id="attendanceDetails">
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

                                        <tbody id="attendanceDetailsWithAjax">
                                        </tbody>
                                    </table>

                                    <div id="pagination">
                                        {{ $attendance->links() }}
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
    <!-- main content end-->
  
    <!-- Modal -->
    <div class="modal fade exampleModal" id="salaryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="salaryModalLabel">Employee Salary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="md-3">
                        <h1 style="text-align:center;">Employee Details</h1>
                        <br/>
                        <table>
                            <tbody>
                            <tr>
                                <td>Id</td>
                                <td>:-</td>
                                <td id="setEmployeeId"></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:-</td>
                                <td id="setEmployeeName"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <br/>
                    <div class="md-3">
                        <h1 style="text-align:center;">Salary Between</h1>
                        <br/>
                        <table >
                            <tbody>
                                <tr>
                                    <input type="date"  id="setStartDate" name="setStartDate" readonly />
                                    &nbsp;&nbsp;
                                    <input type="date"  id="setEndDate" name="setEndDate" readonly/>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <br/>
                    <div class="md-3">
                        <h1 style="text-align:center;">Salary Details</h1>
                        <br/>
                        <table >
                            <tbody>
                            <tr>
                                <td>Salary Perday</td>
                                <td>:-</td>
                                <td id="setSalaryPerday"></td>
                            </tr>
                            <tr>
                                <td>Present Days</td>
                                <td>:-</td>
                            <td id="setPresentDay"></td>
                            </tr>
                            <tr>
                                <td>Absent Days</td>
                                <td>:-</td>
                            <td id="setAbsentDay"></td>
                            </tr>
                            <tr>
                                <td>Total Salary</td>
                                <td>:-</td>
                            <td id="setTotalSalary"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            
            </div>
        </div>
    </div>

@endsection