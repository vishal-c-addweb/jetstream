   
</section>

<!-- move top -->
<button onclick="topFunction()" id="movetop" class="bg-primary" title="Go to top">
  <span class="fa fa-angle-up"></span>
</button>
<script>
  // When the user scrolls down 20px from the top of the document, show the button
  window.onscroll = function () {
    scrollFunction()
  };

  function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
      document.getElementById("movetop").style.display = "block";
    } else {
      document.getElementById("movetop").style.display = "none";
    }
  }

  // When the user clicks on the button, scroll to the top of the document
  function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
  }
</script>
<!-- /move top -->


<script src="{{ asset ('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset ('js/jquery-1.10.2.min.js') }}"></script>

<!-- chart js -->
<script src="{{ asset ('js/Chart.min.js') }}"></script>
<script src="{{ asset ('js/utils.js') }}"></script>
<!-- //chart js -->

<!-- Different scripts of charts.  Ex.Barchart, Linechart -->
<script src="{{ asset ('js/bar.js') }}"></script>
<script src="{{ asset ('js/linechart.js') }}"></script>
<!-- //Different scripts of charts.  Ex.Barchart, Linechart -->


<script src="{{ asset ('js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset ('js/scripts.js') }}"></script>

<!-- close script -->
<script>
  var closebtns = document.getElementsByClassName("close-grid");
  var i;

  for (i = 0; i < closebtns.length; i++) {
    closebtns[i].addEventListener("click", function () {
      this.parentElement.style.display = 'none';
    });
  }
</script>
<!-- //close script -->

<!-- disable body scroll when navbar is in active -->
<script>
  $(function () {
    $('.sidebar-menu-collapsed').click(function () {
      $('body').toggleClass('noscroll');
    })
  });
</script>
<!-- disable body scroll when navbar is in active -->

 <!-- loading-gif Js -->
 <script src="{{ asset ('js/modernizr.js') }}"></script>
 <script>
     $(window).load(function () {
         // Animate loader off screen
         $(".se-pre-con").fadeOut("slow");;
     });
 </script>
 <!--// loading-gif Js -->

<!---moment js-->
<script src="{{ asset('js/moment.min.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset ('js/bootstrap.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script> 



<script>
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
     
        /*
            Fetching employee data in table using ajax.
        */

        $('#employee-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('employee') }}",
            columns: [
            { data: 'id', name: 'id' },
            { data: 'emp_id', name: 'emp_id' },
            { data: 'fname', name: 'fname' },
            { data: 'lname', name: 'lname' },
            { data: 'phone', name: 'phone' },
            { data: 'email', name: 'email' },
            { data: 'gender', name: 'gender' },
            { data: 'address', name: 'address' },
            { data: 'salary', name: 'salary' },
            { data: 'depart.dep_name', name: 'dep_name' },
            { data: 'team.name', name: 'name' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        /*
            Open Add employee Modal.
        */
        function addEmployee(){
            $('#employeeModal').modal('show');
        } 
        
        

        /*
            Edit employee data in table using ajax.
        */
        function editFunction(id){
            $.ajax({
            type:"POST",
            url: "{{ url('edit-employee') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
                console.log(res);
            $('#employeeEditModalLabel').html("Edit Company");
            $('#employeeEditModal').modal('show');
            $('#id').val(res.id);
            $('#empid').val(res.emp_id);
            $('#fname').val(res.fname);
            $('#lname').val(res.lname);
            $('#phone').val(res.phone);
            $('#email').val(res.email);
            if(res.gender=="male")
            {
                $("#malec").prop('checked',true);
            }
            else
            {
                $("#femalec").prop('checked',true); 
            }
            $('#address').val(res.address);
            $('#salary').val(res.salary);
            $('#depid').val(res.dep_id);
            $('#teammid').val(res.team_id);
            }
            });
        }  


        /*
            Update employee data in table using ajax.
        */
        $('#employeeForm').submit(function(e) {

            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
            type:'POST',
            url: "{{ url('update-employee')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (data) => {
            $("#employeeEditModal").modal('hide');
            var oTable = $('#employee-datatable').dataTable();
            oTable.fnDraw(false);
            $("#btn-save").html('Submit');
            $("#btn-save").attr("disabled", false);
            },
            error: function(data){
            //console.log(data);
            }
            });
        });
        
         /*
            Fetching deparment data in table using ajax.
        */
        $(document).ready(function() {
            $('#department-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('department') }}",
            columns: [
                {data: 'dep_id'},
                {data: 'dep_name'},
                {data: 'userd.name'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
            });
        });

        /*
            Open Add department Modal.
        */
        function addDepartment(){
            $('#departmentModal').modal('show');
        } 

         /*
            Fetching student data in table using ajax.
        */
        $(document).ready(function() {
            $('#student-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('student') }}",
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'age'},
                {data: 'address'},
                {data: 'percentage'},
                {data: 'school'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
            });
        });

        /*
            Edit data in table using ajax.
        */
        function editFunctionStudent(id){
            $.ajax({
            type:"POST",
            url: "{{ url('edit-student') }}",
            data: { id: id },
            dataType: 'json',
            success: function(res){
                    //console.log(res);
                $('#StudentModal').html("Edit Student");
                $('#studentEditModal').modal('show');
                $('#studentId').val(res.id);
                $('#studentName').val(res.name);
                $('#studentAge').val(res.age);
                $('#studentAddress').val(res.address);
                $('#studentPercentage').val(res.percentage);
                $('#studentSchool').val(res.school);
            }
            });
        }  

        /*
            Open Add Student Modal.
        */
        function addStudent(){
            $('#studentModal').modal('show');
        
        }  

        /*
            Update data in table using ajax.
        */
        $('#StudentForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
            type:'POST',
            url: "{{ url('update-student')}}",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: (data) => {
                $("#studentEditModal").modal('hide');
                var oTable = $('#student-datatable').dataTable();
                oTable.fnDraw(false);
                $("#btn-save1").html('Submit');
                $("#btn-save1").attr("disabled", false);
                },
                error: function(data){
                //console.log(data);
            }
            });
        });

        /*
            Open Add Attendance Modal.
        */
        function addAttendance(){
            $('#attendanceModal').modal('show');
        
        }
        

        $('#employeeId').on('change',function(){
            var employeeId = $('#employeeId').val();
            var date = $('#datepicker').val();
            //console.log(d);
            $.ajax({
                url:"{{ url('getstatus') }}",
                type:'post',
                data:{date:date,employeeId:employeeId},
                dataType: 'json',
                success:function(response){
                    console.log(response);
                    if(response.att_status == 1)
                    {
                        $('#presentId').prop('checked', true);
                        $('#absentId').prop('checked', false);
                    }
                    else if(response.att_status == 0)
                    {
                        $('#presentId').prop('checked', false);
                        $('#absentId').prop('checked', true);
                    }
                    else 
                    { 
                        $('#presentId').prop('checked', false);
                        $('#absentId').prop('checked', false);
                    }
                }
            });
        });

        $('#datepicker').on('change',function(){
            
            var employeeId = $('#employeeId').val();
            var date = $(this).val();
            //console.log(d);
            $.ajax({
                url:"{{ url('getstatus') }}",
                type:'post',
                data:{date:date,employeeId:employeeId},
                dataType: 'json',
                success:function(response){
                    console.log(response);
                    if(response.att_status == 1)
                    {
                        $('#presentId').prop('checked', true);
                        $('#absentId').prop('checked', false);
                    }
                    else if(response.att_status == 0)
                    {
                        $('#presentId').prop('checked', false);
                        $('#absentId').prop('checked', true);
                    }
                    else 
                    { 
                        $('#presentId').prop('checked', false);
                        $('#absentId').prop('checked', false);
                    }
                }
            });
            
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
                    $("#attendanceDetails").hide();
                    $('#ajaxattendanceDetails').empty();
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

                            $("#ajaxattendanceDetails").append(clearHTML);
                            $("#ajaxattendanceDetails").append(tr_str);
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
                    $("#attendanceDetails").hide();
                    $('#ajaxattendanceDetails').empty();
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

                            $("#ajaxattendanceDetails").append(clearHTML);
                            $("#ajaxattendanceDetails").append(tr_str);
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
                    $("#attendanceDetails").hide();
                    $('#ajaxattendanceDetails').empty();
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

                            $("#ajaxattendanceDetails").append(clearHTML);
                            $("#ajaxattendanceDetails").append(tr_str);
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
                    $("#attendanceDetails").hide();
                    $('#ajaxattendanceDetails').empty();
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

                            $("#ajaxattendanceDetails").append(clearHTML);
                            $("#ajaxattendanceDetails").append(tr_str);
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
                        $("#salaryModal").modal("toggle");
                    }        
                    else
                    {
                        alert("please enter Date,Salary perday, and Employee name!")
                    }           
                    $("#employeeId1").html(response.data.employee.emp_id);
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

<script>
    function showPassword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    }
    function showBothPassword() {
    var x = document.getElementById("password");
    var y = document.getElementById("password_confirmation");
    if (x.type === "password" && y.type === "password") {
        x.type = "text";
        y.type = "text";
    } else {
        x.type = "password";
        y.type = "password";
    }
    }

</script>

<script>
    /*
        Open Timesheet Modal.
    */
    function addTimesheet(){
        $('#timesheetModal').modal('show');
    } 

    $('#projectId').on('change',function(){
            var projectId = $('#projectId').val();
            //console.log(projectId);
            $.ajax({
                url:"{{ url('gettaskname') }}",
                type:'post',
                data:{projectId:projectId},
                dataType: 'json',
                success:function(response){
                    //console.log(response);
                    var temp = $('#taskname'); // cache it
                    temp.empty();
                    $("#taskname").append("<option value=''>Select Task</option>");
                    $.each(response, function (i, response) {      // bind the dropdown list using json result              
                        $('<option>',
                        {
                            value: response.id,
                            text: response.name
                        }).html(response.name).appendTo("#taskname");
                    });
                }
            });
    });  
    /*
        Open project Modal.
    */
    function addProject(){
        $('#projectModal').modal('show');
    } 
    /*
        Open Task Modal.
    */
    function addTask(){
        $('#taskModal').modal('show');
    }
    /*
        Open assignProject Modal.
    */
    function assignProject(){
        $('#assignProjectModal').modal('show');
    }
    
    /*
        Open description Modal.
    */
    function description(id){
        $('#descriptionModal').modal('show');
        $.ajax({
                url:"{{ url('getdescription') }}",
                type:'post',
                data:{id:id},
                dataType: 'json',
                success:function(response){
                    //console.log(response);
                    $.each(response, function(index, element){
                        console.log(element.description);
                        $('#paraId').text(element.description);
                    });
                    
                }
            });
    }

    $(function() {
        $(document).ready(function () {
            
        var todaysDate = new Date(); // Gets today's date
            // Max date attribute is in "YYYY-MM-DD".  Need to format today's date accordingly
            
            var year = todaysDate.getFullYear(); 
            //alert(year);						// YYYY
            var month = ("0" + (todaysDate.getMonth() + 1)).slice(-2);	// MM
            //alert(month);
            var day = ("0" + todaysDate.getDate()).slice(-2);			// DD
            //alert(day);
            var yday = ("0" + (todaysDate.getDate() - 1)).slice(-2);
            //alert(yday);
            var maxDate = (year +"-"+ month +"-"+ day); // Results in "YYYY-MM-DD" for today's date 
            //alert(maxDate);
            var minDate = (year +"-"+ month +"-"+ yday);
            //alert(minDate);
            $('#timesheetDate').attr('max',maxDate);
            $('#timesheetDate').attr('min',minDate);
            $('#timesheetDate').attr('value',maxDate);
            
            $('#edittimesheetDate').attr('max',maxDate);
            $('#edittimesheetDate').attr('min',minDate);
            $('#edittimesheetDate').attr('value',maxDate);
            
            //fetching todays timesheet data
            var timesheetDate = $('#timesheetDate').val();
            //alert(timesheetDate);
           
        });
        
        
        /* Edit Timesheet */
        $.ajax({
            url:"{{ url('edittimesheetdata') }}",
            type:'post',
            dataType: 'json',
            success:function(response){
                console.log(response);
                if(jQuery.isEmptyObject(response.timesheet))
                {
                    $('#tsheetForm').show();
                }
                else
                {
                    $('#tsheetForm').hide();
                    var result = response.timesheet;
                    var result1 = response.projects;
                    var len = result1.length;
                    
                    for($i=0;$i<len;$i++)
                    {
                        var tr_data = '<option value="' + result1[i].id + '">' + result1[i].project.name + '</option>';
                    }
                    $.each(result,function(i, result)
                    {
                       
                        var hour = parseInt(result.hour);   
                        //alert(hour);
                        var minute = result.minute;
                        var a = minute.split(':');
                        var minute = (+a[0]) * 1 + (+a[1]) * 1 + (+a[2]);
                        $timesheet_data = '<form method="POST" action="javascript:void(0)" id="timesheetForm(' + result.id+ ')" name="timesheetForm">' + 
                                            '{{ csrf_field() }}' +
                                          
                                            '<div class="mb-3">' +
                                                '<h5 style="text-align:center;">Timesheet</h5>' +
                                            '</div>'+
                                          
                                            '<div class="mb-3">' +
                                                '<label for="exampleInputproject" class="form-label">Project</label>' +
                                                '<SELECT class="form-control" name="projectid" id="projectId" class="prj">' + 
                                                    '<option value="' + result.project_id + '">' + result.project.name + '</option>' + 
                                                
                                                '</SELECT>'+
                                            '</div>'+
                                          
                                            '<div class="mb-3">' + 
                                                '<label for="exampleInputtask" class="form-label">Task</label>' + 
                                                '<SELECT class="form-control" name="taskid" id="taskId">' +
                                                    '<option value="' + result.task_id + '">' + result.task.name + '</option>' + 
                                                '</SELECT>' +
                                            '</div>' +

                                            '<div class="mb-3">' + 
                                                '<label for="exampleInputhour" class="form-label">Hour</label>' + 
                                                '<SELECT name="hour" class="form-control" id="hour" >' +
                                                '<option value=" '+ hour +' ">' + hour + ' </option>' +
                                                    '@for($i=0;$i<=8;$i++)'+
                                                        '<option value="{{$i}}">{{$i}}</option>' +
                                                        
                                                    '@endfor' +
                                                '</SELECT>' +
                                            '</div>' +

                                            '<div class="mb-3">' + 
                                                '<label for="exampleInputminute" class="form-label">Minute</label>' +
                                                '<SELECT name="minute" class="form-control" id="minute">' +
                                                '<option value=" '+ minute +' ">' + minute + ' </option>' +
                                                    '<option value="0">0</option>' +
                                                    '<option value="15">15</option>' +
                                                    '<option value="30">30</option>' +
                                                    '<option value="45">45</option>' +
                                                '</SELECT>' +
                                            '</div>' +

                                            '<div class="mb-3">' +
                                                '<label for="exampleInputdescription" class="form-label">Description</label><br/>' +
                                                '<textarea id="description" name="description" class="form-control">' + result.description + '</textarea>' +
                                            '</div>' +

                                            '<div class="modal-footer">' +
                                            '<button type="submit" class="btn btn-success" onClick="updateTsheet(' + result.id + ')">Update</button>' + 
                                                    '<button type="submit" class="btn btn-danger" onClick="deleteTsheet(' + result.id + ')">Delete</button>' +
                                            '</div>' +
                                        
                                        '</form>';

                            $("#editTimesheet").append($timesheet_data);   
                
                    });
                }
            }
        });

    });
    
    $('#edittimesheetDate').on('change',function(){
            var edittimesheetDate = $('#edittimesheetDate').val();
            //console.log(projectId);
            $('#editTimesheet').empty();
            $.ajax({
                url:"{{ url('gettimesheet') }}",
                type:'post',
                data:{edittimesheetDate:edittimesheetDate},
                dataType: 'json',
                success:function(response){
                    console.log(response);
                    if(jQuery.isEmptyObject(response.timesheet))
                    {
                        $('#tsheetForm').show();
                    }
                    else
                    {
                        $('#tsheetForm').hide();
                        var result = response.timesheet;
                        var result1 = response.projects;
                        var len = result1.length;
                        
                        for($i=0;$i<len;$i++)
                        {
                            var tr_data = '<option value="' + result1[i].id + '">' + result1[i].project.name + '</option>';
                        }
                        $.each(result,function(i, result)
                        {
                        
                            var hour = parseInt(result.hour);   
                            //alert(hour);
                            var minute = result.minute;
                            var a = minute.split(':');
                            var minute = (+a[0]) * 1 + (+a[1]) * 1 + (+a[2]);
                            $timesheet_data = '<form method="POST" action="javascript:void(0)" id="timesheetForm(' + result.id+ ')" name="timesheetForm">' + 
                                                '{{ csrf_field() }}' +
                                            
                                                '<div class="mb-3">' +
                                                    '<h5 style="text-align:center;">Timesheet</h5>' +
                                                '</div>'+
                                            
                                                '<div class="mb-3">' +
                                                    '<label for="exampleInputproject" class="form-label">Project</label>' +
                                                    '<SELECT class="form-control" name="projectid" id="projectId" class="prj">' + 
                                                        '<option value="' + result.project_id + '">' + result.project.name + '</option>' + 
                                                    
                                                    '</SELECT>'+
                                                '</div>'+
                                            
                                                '<div class="mb-3">' + 
                                                    '<label for="exampleInputtask" class="form-label">Task</label>' + 
                                                    '<SELECT class="form-control" name="taskid" id="taskId">' +
                                                        '<option value="' + result.task_id + '">' + result.task.name + '</option>' + 
                                                    '</SELECT>' +
                                                '</div>' +

                                                '<div class="mb-3">' + 
                                                    '<label for="exampleInputhour" class="form-label">Hour</label>' + 
                                                    '<SELECT name="hour" class="form-control" id="hour" >' +
                                                    '<option value=" '+ hour +' ">' + hour + ' </option>' +
                                                        '@for($i=0;$i<=8;$i++)'+
                                                            '<option value="{{$i}}">{{$i}}</option>' +
                                                            
                                                        '@endfor' +
                                                    '</SELECT>' +
                                                '</div>' +

                                                '<div class="mb-3">' + 
                                                    '<label for="exampleInputminute" class="form-label">Minute</label>' +
                                                    '<SELECT name="minute" class="form-control" id="minute">' +
                                                    '<option value=" '+ minute +' ">' + minute + ' </option>' +
                                                        '<option value="0">0</option>' +
                                                        '<option value="15">15</option>' +
                                                        '<option value="30">30</option>' +
                                                        '<option value="45">45</option>' +
                                                    '</SELECT>' +
                                                '</div>' +

                                                '<div class="mb-3">' +
                                                    '<label for="exampleInputdescription" class="form-label">Description</label><br/>' +
                                                    '<textarea id="description" name="description" class="form-control">' + result.description + '</textarea>' +
                                                '</div>' +

                                                '<div class="modal-footer">' +
                                                    '<button type="submit" class="btn btn-success" onClick="updateTsheet(' + result.id + ')">Update</button>' + 
                                                    '<button type="submit" class="btn btn-danger" onClick="deleteTsheet(' + result.id + ')">Delete</button>' +
                                                '</div>' +
                                            
                                            '</form>';

                                $("#editTimesheet").append($timesheet_data);   
                    
                        });
                    }
                }
            });
    });


    function updateTsheet(id){
        $.ajax({
            url:"{{ url('updatetimesheet') }}",
            type:'post',
            dataType: 'json',
            data : {id:id},
            success:function(response){
                console.log(response);
            }
        });
    };
    
    function deleteTsheet(id){
        $.ajax({
            url:"{{ url('deletetimesheet') }}",
            type:'post',
            dataType: 'json',
            data : {id:id},
            success:function(response){
                console.log(response);
            }
        });
    };
    
</script>

@livewireScripts

</body>

</html>