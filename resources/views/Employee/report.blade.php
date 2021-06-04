<x-app-layout>
            <br/>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="text-align:center;">
                <b>{{ __('Employee Attendance') }}</b>
            </h2>
            <!-- Modal -->
            <div class="modal fade exampleModal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Employee Salary</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
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
                                            <td id="employeeId"></td>
                                        </tr>
                                        <tr>
                                            <td>Name</td>
                                            <td>:-</td>
                                            <td id="employeeName"></td>
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
                                                <input type="date"  id="fromDate" name="fromDate" readonly />
                                                &nbsp;&nbsp;
                                                <input type="date"  id="toDate" name="toDate" readonly/>
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
                                            <td id="salaryPerday"></td>
                                        </tr>
                                        <tr>
                                            <td>Present Days</td>
                                            <td>:-</td>
                                        <td id="presentDay"></td>
                                        </tr>
                                        <tr>
                                            <td>Absent Days</td>
                                            <td>:-</td>
                                        <td id="absentDay"></td>
                                        </tr>
                                        <tr>
                                            <td>Total Salary</td>
                                            <td>:-</td>
                                        <td id="totalSalary"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        
                        </div>
                    </div>
            </div>
            <div class="py-12">

        <div class="container col-md-5">
            
            
            <div class="mb-3">
                
                <label for="from" class="form-label">From</label>
                <input type="date"  id="from" name="from" />
        
                <label for="to" class="form-label">to</label>
                <input type="date"  id="to" name="to" />

                <select name="emp" id="emp">
                    <option value="">Select Employee</option>
                    @foreach($employee as $e)
                    <option value="{{$e->id}}">{{$e->fname}}</option>
                    @endforeach
                </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                
                <button id="getReport" class="btn btn-primary" >Employee Report</button>&nbsp;&nbsp;
                <button id="getTodayReport" class="btn btn-primary" >Today Report</button>&nbsp;&nbsp;
                <button id="getYesterdayReport" class="btn btn-primary" >Yesterday Report</button>&nbsp;&nbsp;
             
            </div>
            <div class="mb-3">
            <label for="to" class="form-label" style="margin-left:40px;">Salary:</label>
                <input type="number"  id="sal" name="sal"> &nbsp;&nbsp;
                <button id="calEmployeeSalary" class="btn btn-primary">Calculate Salary</button>&nbsp;&nbsp;
                <button type="button" onClick="window.location.reload();" class="btn btn-primary">Refresh</button>&nbsp;&nbsp;
                <button id="getLastweekReport" class="btn btn-primary" >Lastweek Report</button>
            </div>

          
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mt-6 text-gray-500">
                    <div class="card-body">
                        <table class="table table-bordered data-table">
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

                            <tbody id="new">
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
                            <tbody id="sam">
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $(document).ready(function(){
            $("#getReport").click(function(){
                var fromTo = $("#from").val();
                var toFrom = $("#to").val();
                var employeeId = $("#emp").val();
                
                $.ajax({
                url:"{{ url('employee-report') }}",
                type:'post',
                data:{fromTo:fromTo,toFrom:toFrom,employeeId:employeeId},
                dataType: 'json',
                success:function(response){
                    //console.log(response);
                    var len = response.length;
                    $("#new").hide();
                    $('#sam').empty();
                    var clearHTML = '<tr> <td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                    for(var i=0; i<len; i++){
                        var id = response[i].id;
                        var name = response[i].employeeid.fname;
                        var date = response[i].att_date;
                        if(response[i].att_status == 1)
                        {
                            var status = "Present";
                        }
                        else
                        {
                            var status = "Absent";
                        }
                        var created_at = response[i].created_at;
                        var updated_at = response[i].updated_at;
                        let ca = moment(created_at);
                        let ua = moment(created_at);
                        
                        
                        var tr_str = "<tr>" +
                            "<td >" + id + "</td>" +
                            "<td >" + name + "</td>" +
                            "<td >" + date + "</td>" +
                            "<td >" + status + "</td>" +
                            "<td >" + ca.fromNow() + "</td>" +
                            "<td >" + ua.fromNow() + "</td>" +
                            "</tr>";

                            $("#sam").append(clearHTML);
                            $("#sam").append(tr_str);
                    }
                }
                });
            });
        });

        $(document).ready(function(){
            $("#getTodayReport").click(function(){
                var employeeId = $("#emp").val();
                $.ajax({
                url:"{{ url('today-report') }}",
                type:'post',
                data:{employeeId:employeeId},
                dataType: 'json',
                success:function(response){
                    //console.log(response);
                    var len = response.length;
                    $("#new").hide();
                    $('#sam').empty();
                    var clearHTML = '<tr> <td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                    for(var i=0; i<len; i++){
                        var id = response[i].id;
                        var name = response[i].employeeid.fname;
                        var date = response[i].att_date;
                        if(response[i].att_status == 1)
                        {
                            var status = "Present";
                        }
                        else
                        {
                            var status = "Absent";
                        }
                        var created_at = response[i].created_at;
                        var updated_at = response[i].updated_at;
                        let ca = moment(created_at);
                        let ua = moment(created_at);
                        
                        var tr_str = "<tr>" +
                            "<td >" + id + "</td>" +
                            "<td >" + name + "</td>" +
                            "<td >" + date + "</td>" +
                            "<td >" + status + "</td>" +
                            "<td >" + ca.fromNow() + "</td>" +
                            "<td >" + ua.fromNow() + "</td>" +
                            "</tr>";

                            $("#sam").append(clearHTML);
                            $("#sam").append(tr_str);
                    }
                }
                });
            });
        });

        $(document).ready(function(){
            $("#getYesterdayReport").click(function(){
                var employeeId = $("#emp").val();
                $.ajax({
                url:"{{ url('yesterday-report') }}",
                type:'post',
                data:{employeeId:employeeId},
                dataType: 'json',
                success:function(response){
                    //console.log(response);
                    var len = response.length;
                    $("#new").hide();
                    $('#sam').empty();
                    var clearHTML = '<tr> <td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                    for(var i=0; i<len; i++){
                        var id = response[i].id;
                        var name = response[i].employeeid.fname;
                        var date = response[i].att_date;
                        if(response[i].att_status == 1)
                        {
                            var status = "Present";
                        }
                        else
                        {
                            var status = "Absent";
                        }
                        var created_at = response[i].created_at;
                        var updated_at = response[i].updated_at;
                        let ca = moment(created_at);
                        let ua = moment(created_at);
                        
                        var tr_str = "<tr>" +
                            "<td >" + id + "</td>" +
                            "<td >" + name + "</td>" +
                            "<td >" + date + "</td>" +
                            "<td >" + status + "</td>" +
                            "<td >" + ca.fromNow() + "</td>" +
                            "<td >" + ua.fromNow() + "</td>" +
                            "</tr>";

                            $("#sam").append(clearHTML);
                            $("#sam").append(tr_str);
                    }
                }
                });
            });
        });

        $(document).ready(function(){
            $("#getLastweekReport").click(function(){
                var employeeId = $("#emp").val();
                $.ajax({
                url:"{{ url('lastweek-report') }}",
                type:'post',
                data:{employeeId:employeeId},
                dataType: 'json',
                success:function(response){
                    //console.log(response);
                    var len = response.length;
                    $("#new").hide();
                    $('#sam').empty();
                    var clearHTML = '<tr> <td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                    for(var i=0; i<len; i++){
                        var id = response[i].id;
                        var name = response[i].employeeid.fname;
                        var date = response[i].att_date;
                        if(response[i].att_status == 1)
                        {
                            var status = "Present";
                        }
                        else
                        {
                            var status = "Absent";
                        }
                        var created_at = response[i].created_at;
                        var updated_at = response[i].updated_at;
                        let ca = moment(created_at);
                        let ua = moment(created_at);
                        //console.log(da.fromNow());
                        
                        var tr_str = "<tr>" +
                            "<td >" + id + "</td>" +
                            "<td >" + name + "</td>" +
                            "<td >" + date + "</td>" +
                            "<td >" + status + "</td>" +
                            "<td >" + ca.fromNow() + "</td>" +
                            "<td >" + ua.fromNow() + "</td>" +
                            "</tr>";

                            $("#sam").append(clearHTML);
                            $("#sam").append(tr_str);
                    }
                }
                });
            });
        });

        $(document).ready(function(){
            $("#calEmployeeSalary").click(function(){
                var fromTo = $("#from").val();
                var toFrom = $("#to").val();
                var employeeId = $("#emp").val();
                var employeeSalary = $("#sal").val();
                $.ajax({
                url:"{{ url('calemployee-salary') }}",
                type:'post',
                data:{fromTo:fromTo,toFrom:toFrom,employeeId:employeeId,employeeSalary:employeeSalary},
                dataType: 'json',
                success:function(response){
                    //console.log(response);                 
                    if(response.data.salary){
                        $("#exampleModal").modal("toggle");
                    }        
                    else
                    {
                        alert("please enter Date,Salary perday, and Employee name!")
                    }           
                    $("#employeeId").html(response.data.employee.emp_id);
                    $("#employeeName").html(response.data.employee.fname);
                    $("#fromDate").val(fromTo);
                    $("#toDate").val(toFrom);
                    $("#salaryPerday").html(employeeSalary);
                    $("#presentDay").html(response.data.presentdays);
                    $("#absentDay").html(response.data.absentdays);
                    $("#totalSalary").html(response.data.salary);
                
                }
                });
            });
        });

    </script>

</x-app-layout>