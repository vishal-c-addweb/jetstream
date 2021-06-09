        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
     
        /*
            Fetching employee data in table using ajax.
        */

        $('#ajax-crud-datatable').DataTable({
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
        function add(){
            $('.bd-example-modal-lg').modal('show');
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
            $('#CompanyModal').html("Edit Company");
            $('#company-modal').modal('show');
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
        $('#CompanyForm').submit(function(e) {

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
            $("#company-modal").modal('hide');
            var oTable = $('#ajax-crud-datatable').dataTable();
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
            $('.data-table').DataTable({
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
        function create(){
            $('#departmentModal').modal('show');
        } 

         /*
            Fetching data in table using ajax.
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
        function openStudent(){
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
    