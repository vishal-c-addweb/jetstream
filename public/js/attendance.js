        /*
            Open Add Attendance Modal.
        */
            function addAttendance(){
                $('#attendanceModal').modal('show');
            
            }
            
            /* 
                Fetch employee status by employeeId and date. 
            */
            $('#employeeId').on('change',function(){
                var employeeId = $('#employeeId').val();
                var date = $('#datepicker').val();
                $.ajax({
                    url:"/attendance/status",
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
    
            /* 
                Fetch employee status by date and employeeId. 
            */
            $('#datepicker').on('change',function(){
                
                var employeeId = $('#employeeId').val();
                var date = $(this).val();
                //console.log(d);
                $.ajax({
                    url:"/attendance/status",
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
    
            /* 
                Fetch employee attendance by fromDate,toDate and employeeId. 
            */
            $(document).ready(function(){
                $("#getReport").click(function(){
                    var startDate = $("#startDate").val();
                    var endDate = $("#endDate").val();
                    var employeeId = $("#employeeId").val();
                    
                    $.ajax({
                        url:"/report",
                        type:'post',
                        data:{startDate:startDate,endDate:endDate,employeeId:employeeId},
                        dataType: 'json',
                        success:function(response){
                            //console.log(response);
                            var len = response.length;
                            $("#attendanceDetails").hide();
                            $("#pagination").hide();
                            $('#attendanceDetailsWithAjax').empty();
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
    
                                    $("#attendanceDetailsWithAjax").append(clearHTML);
                                    $("#attendanceDetailsWithAjax").append(tr_str);
                            }
                        }
                    });
                });
            });
    
            /* 
                Fetch Today attendance report for all employee or for one employee. 
            */
            $(document).ready(function(){
                $("#getTodayReport").click(function(){
                    var employeeId = $("#employeeId").val();
                    $.ajax({
                    url:"/report/today",
                    type:'post',
                    data:{employeeId:employeeId},
                    dataType: 'json',
                    success:function(response){
                        //console.log(response);
                        var len = response.length;
                        $("#attendanceDetails").hide();
                        $("#pagination").hide();
                        $('#attendanceDetailsWithAjax').empty();
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
    
                                $("#attendanceDetailsWithAjax").append(clearHTML);
                                $("#attendanceDetailsWithAjax").append(tr_str);
                        }
                    }
                    });
                });
            });
    
            /* 
                Fetch Yesterday attendance report for all employee or for one employee. 
            */
            $(document).ready(function(){
                $("#getYesterdayReport").click(function(){
                    var employeeId = $("#employeeId").val();
                    $.ajax({
                    url:"/report/yesterday",
                    type:'post',
                    data:{employeeId:employeeId},
                    dataType: 'json',
                    success:function(response){
                        //console.log(response);
                        var len = response.length;
                        $("#attendanceDetails").hide();
                        $("#pagination").hide();
                        $('#attendanceDetailsWithAjax').empty();
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
    
                                $("#attendanceDetailsWithAjax").append(clearHTML);
                                $("#attendanceDetailsWithAjax").append(tr_str);
                        }
                    }
                    });
                });
            });
    
            /* 
                Fetch Lastweek attendance report for all employee or for one employee. 
            */
            $(document).ready(function(){
                $("#getLastweekReport").click(function(){
                    var employeeId = $("#employeeId").val();
                    $.ajax({
                    url:"/report/lastweek",
                    type:'post',
                    data:{employeeId:employeeId},
                    dataType: 'json',
                    success:function(response){
                        //console.log(response);
                        var len = response.length;
                        $("#attendanceDetails").hide();
                        $("#pagination").hide();
                        $('#attendanceDetailsWithAjax').empty();
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
    
                                $("#attendanceDetailsWithAjax").append(clearHTML);
                                $("#attendanceDetailsWithAjax").append(tr_str);
                        }
                    }
                    });
                });
            });
    
            /* 
                Calculate Employee Salary fromDate,toDate,employeeId and Salaryperday. 
            */
            $(document).ready(function(){
                $("#calEmployeeSalary").click(function(){
                    var startDate = $("#startDate").val();
                    var endDate = $("#endDate").val();
                    var employeeId = $("#employeeId").val();
                    var employeeSalary = $("#salary").val();
                    $.ajax({
                        url:"/report/calculate/salary",
                        type:'post',
                        data:{startDate:startDate,endDate:endDate,employeeId:employeeId,employeeSalary:employeeSalary},
                        dataType: 'json',
                        success:function(response){
                            console.log(response);                 
                            if(response.data.salary){
                                $("#salaryModal").modal("toggle");
                                $("#setEmployeeId").html(response.data.employee.emp_id);
                                $("#setEmployeeName").html(response.data.employee.fname);
                                $("#setStartDate").val(startDate);
                                $("#setEndDate").val(endDate);
                                $("#setSalaryPerday").html(employeeSalary);
                                $("#setPresentDay").html(response.data.presentdays);
                                $("#setAbsentDay").html(response.data.absentdays);
                                $("#setTotalSalary").html(response.data.salary);
                            }        
                            else
                            {
                                alert("please enter Date,Salary perday, and Employee name!")
                            }           
                        
                        }
                    });
                });
            });
        
    