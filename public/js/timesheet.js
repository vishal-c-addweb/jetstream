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
            url:"/timesheet/showtask",
            type:'post',
            data:{projectId:projectId},
            dataType: 'json',
            success:function(response){
                //console.log(response);
                var temp = $('#taskname'); // cache it
                temp.empty();
                //$("#taskname").append("<option value=''>Select Task</option>");
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
    Open description Modal and Fetching Description ajax.
*/
function showDescription(id){
    $('#descriptionModal').modal('show');
    $.ajax({
            url:"/timesheet/showdescription",
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

/*
    fetching today and yesterday date. 
*/
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


/*
    Fetching timesheet by today date.
*/
$(document).ready(function(){
    
    $.ajax({
        url:"/timesheet/showbytoday",
        type:'post',
        dataType: 'json',
        success:function(response){
            console.log(response);
            var tabledata = '<form method="POST" id="tsheetForm" >' +
                        
                        '<input type="hidden" name="_token" value="' + document.getElementsByName('_token')[0].value + '">' +
                        
                        '<div class="mb-3">' +
                            '<h5 style="text-align:center;">Timesheet</h5>' +
                            
                        '</div>' +
                        '<div class="mb-3">' +
                            '<h6 style="text-align:center;">you are not added any timesheet yet</h6>' +
                            
                        '</div>' +
                        
                        '<div class="" style="margin-left:400px;">' +
                            '<a class="btn btn-success" href="timesheet"><i class="fa fa-plus">&nbsp;</i>Add Timesheet</a>' +
                        '</div>' +
                    '</form>'+
                    '<div class="col-md-6" style="margin-top:130px;">'+
                    '</div>'; 

            if(jQuery.isEmptyObject(response.timesheet))
            {
                $('#editTimesheet').append(tabledata);
            }
            else
            {
                var result = response.timesheet;
                var result1 = response.projects;
                var result2 = response.tasks;
                var timesheetDate = $('#edittimesheetDate').val();
                //console.log(result2);
                var project_name="";

                for(var j=0; j<result1.length;j++){
                    project_name += '<option value="' + result1[j].project_id + '">' + result1[j].project.name + '</option>';
                };

                $.each(result,function(i, result)
                {
                    var l = result.project_id;
                    
                    var hour = parseInt(result.hour);   
                    //alert(hour);
                    var minute = result.minute;
                    var a = minute.split(':');
                    var minute = (+a[0]) * 1 + (+a[1]) * 1 + (+a[2]);
                    
                    var task_name = "";
                    for(var m=0; m<result2.length;m++){  

                        task_name += '<option value="' + result2[m].id + '">' + result2[m].name + '</option>';
                        
                    };
                    $timesheet_data = '<form method="POST" action="/timesheet/update/' + result.id + '" id="timesheetForm' + result.id+ '" name="timesheetForm">' + 
                                        
                                        '<input type="hidden" name="_token" value="' + document.getElementsByName('_token')[0].value + '">' +
                                        
                                        '<div class="mb-3">' +
                                            '<h5 style="text-align:center;">Timesheet</h5>' +
                                        '</div>'+

                                        
                                        '<div class="mb-3" hidden>' +
                                            '<label for="exampleInputE" class="form-label">Date</label>' +
                                            '<input type="date" class="form-control" id="edittimesheetDate" name="edittimesheetdate" value="'+ timesheetDate +'" >' +
                                        '</div> ' +

                                        '<div class="mb-3">' +
                                            '<label for="exampleInputproject" class="form-label">Project</label>' +
                                            '<SELECT class="form-control projectId'+ l +'" name="projectid" id="projectId'+ l +'" onchange="task('+l+')">' + 
                                                //'<option value="' + result.project_id + '">' + result.project.name + '</option>' + 
                                                project_name+
                                            '</SELECT>'+
                                        '</div>'+
                                        
                                        '<div class="mb-3">' + 
                                            '<label for="exampleInputtask" class="form-label">Task</label>' + 
                                            '<SELECT class="form-control taskId'+ l +'" name="taskid" id="taskId'+ l +'">' +
                                                '<option value="' + result.task_id + '">' + result.task.name + '</option>' + 
                                                task_name + 
                                            '</SELECT>' +
                                        '</div>' +

                                        '<div class="mb-3">' + 
                                            '<label for="exampleInputhour" class="form-label">Hour</label>' + 
                                            '<SELECT name="hour" class="form-control hour'+l+'" id="hour'+l+'" >' +
                                            //'<option value=" '+ hour +' ">' + hour + ' </option>' +
                                                '<option value="0">0</option>' +
                                                '<option value="1">1</option>' +
                                                '<option value="2">2</option>' +
                                                '<option value="3">3</option>' +
                                                '<option value="4">4</option>' +
                                                '<option value="5">5</option>' +
                                                '<option value="6">6</option>' +
                                                '<option value="7">7</option>' +
                                                '<option value="8">8</option>' +
                                            '</SELECT>' +
                                        '</div>' +

                                        '<div class="mb-3">' + 
                                            '<label for="exampleInputminute" class="form-label">Minute</label>' +
                                            '<SELECT name="minute" class="form-control minute'+l+'" id="minute'+l+'">' +
                                            //'<option value=" '+ minute +' ">' + minute + ' </option>' +
                                                '<option value="00">0</option>' +
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
                                        '<button type="submit" class="btn btn-success">Update</button>' + 
                                                '<a href="/timesheet/delete/' + result.id + '" class="btn btn-danger">Delete</a>' +
                                        '</div>' +
                                    
                                    '</form>';

                        $("#editTimesheet").append($timesheet_data);   

                        $('.projectId'+l+' option[value='+result.project_id+']').prop('selected', true); 
                            
                        $('.minute'+l+' option[value='+minute+']').prop('selected', true);     
                        
                        $('.hour'+l+' option[value='+hour+']').prop('selected', true);    
                });
            }
        }
    });
})      

/*
    Fetching timesheet by yesterday date selectign from date input
*/
$('#edittimesheetDate').on('change',function(){
    var edittimesheetDate = $('#edittimesheetDate').val();

    
    $('#editTimesheet').empty();
    
    $.ajax({
        url:"/timesheet/showbydate",
        type:'post',
        data:{edittimesheetDate:edittimesheetDate},
        dataType: 'json',
        success:function(response){
            console.log(response);
            var tabledata = '<form method="POST" id="tsheetForm">' +

                                '<input type="hidden" name="_token" value="' + document.getElementsByName('_token')[0].value + '">' +
                                
                                '<div class="mb-3">' +
                                    '<h5 style="text-align:center;">Timesheet</h5>' +
                                    
                                '</div>' +
                                '<div class="mb-3">' +
                                    '<h6 style="text-align:center;">you are not added any timesheet yet</h6>' +
                                    
                                '</div>' +
                                
                                '<div class="" style="margin-left:400px;">' +
                                    '<a class="btn btn-success" href="timesheet"><i class="fa fa-plus">&nbsp;</i>Add Timesheet</a>' +
                                '</div>' +
                            '</form>'+
                            '<div class="col-md-6" style="margin-top:130px;">'+
                            '</div>'; 

                if(jQuery.isEmptyObject(response.timesheet))
                {
                    $('#editTimesheet').append(tabledata);
                }
                else
                {

                var result = response.timesheet;
                var result1 = response.projects
                var result2 = response.tasks;
                
                var timesheetDate = $('#edittimesheetDate').val();
                
                var project_name = "";
                for(var j=0; j<result1.length;j++){
                    project_name += '<option value="' + result1[j].project_id + '">' + result1[j].project.name + '</option>';
                }; 

                
                $.each(result,function(i, result)
                {
                    
                    var hour = parseInt(result.hour);   
                    var minute = result.minute;
                    var a = minute.split(':');
                    var minute = (+a[0]) * 1 + (+a[1]) * 1 + (+a[2]);
                    
                    var l = result.project_id; 
                    

                    $timesheet_data = '<form method="POST" action="/timesheet/update/' + result.id + '" id="timesheetForm' + result.id+ '" name="timesheetForm">' + 
                                        
                                        '<input type="hidden" name="_token" value="' + document.getElementsByName('_token')[0].value + '">' +

                                        '<div class="mb-3">' +
                                            '<h5 style="text-align:center;">Timesheet</h5>' +
                                        '</div>'+

                                        '<div class="mb-3" hidden>' +
                                            '<label for="exampleInputE" class="form-label">Date</label>' +
                                            '<input type="date" class="form-control" id="edittimesheetDate" name="edittimesheetdate" value="'+ timesheetDate +'" >' +
                                        '</div> ' +

                                        '<div class="mb-3">' +
                                            '<label for="exampleInputproject" class="form-label">Project</label>' +
                                            '<SELECT class="form-control projectId'+ l +'" name="projectid" id="projectId'+ l +'" onchange="task('+l+')">' + 
                                                //'<option value="' + result.project_id + '">' + result.project.name + '</option>' + 
                                                project_name+   
                                            '</SELECT>'+
                                        '</div>'+
                                    
                                        '<div class="mb-3">' + 
                                            '<label for="exampleInputtask" class="form-label">Task</label>' + 
                                            '<SELECT class="form-control taskId'+ l +'" name="taskid" id="taskId'+l+'">' +
                                                '<option value="' + result.task_id + '">' + result.task.name + '</option>' + 
                                                
                                            '</SELECT>' +
                                        '</div>' +

                                        '<div class="mb-3">' + 
                                            '<label for="exampleInputhour" class="form-label">Hour</label>' + 
                                            '<SELECT name="hour" class="form-control hour'+l+'" id="hour '+l+'" >' +
                                            //'<option value=" '+ hour +' ">' + hour + ' </option>' +
                                                '<option value="0">0</option>' +
                                                '<option value="1">1</option>' +
                                                '<option value="2">2</option>' +
                                                '<option value="3">3</option>' +
                                                '<option value="4">4</option>' +
                                                '<option value="5">5</option>' +
                                                '<option value="6">6</option>' +
                                                '<option value="7">7</option>' +
                                                '<option value="8">8</option>' +
                                            '</SELECT>' +
                                        '</div>' +

                                        '<div class="mb-3">' + 
                                            '<label for="exampleInputminute" class="form-label">Minute</label>' +
                                            '<SELECT name="minute" class="form-control minute'+ l +'" id="minute'+ l +'">' +
                                            //'<option value=" '+ minute +' ">' + minute + ' </option>' +
                                                '<option value="00">0</option>' +
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
                                            '<button type="submit" class="btn btn-success">Update</button>' + 
                                            '<a href="/timesheet/delete/' + result.id + '" class="btn btn-danger">Delete</a>' +
                                        '</div>' +
                                    
                                    '</form>';
                                
                        $("#editTimesheet").append($timesheet_data); 
                        $('.projectId'+l+' option[value='+result.project_id+']').prop('selected', true);   
                        $('.minute'+l+' option[value='+minute+']').prop('selected', true);     
                        $('.hour'+l+' option[value='+hour+']').prop('selected', true);   
                        //$('.projectId'+l+' option[value='+result.project_id+']').prop('selected', true);    
                    
                });
            }   
        }
    });
});
    
/*
    Fetching task name by project id.
*/
function task(id)
{
        
    var edittimesheetDate = $('#edittimesheetDate').val();
    //alert(id);
    var project_id = "projectId"+id;
    $(document).off('change').on('change', '.projectId'+id, function(e) {
        
        
        var projectId = $(this).val();
        var taskId = $('.taskId'+id).val();
        //console.log(projectId);

        $.ajax({
            url:"/timesheet/showbydate",
            type:'post',
            data:{projectId:projectId,edittimesheetDate:edittimesheetDate},
            dataType: 'json',
            success:function(response){
                console.log(response);
                var tabledata = '<form method="POST" id="tsheetForm">' +

                                    '<input type="hidden" name="_token" value="' + document.getElementsByName('_token')[0].value + '">' +
                                    
                                    '<div class="mb-3">' +
                                        '<h5 style="text-align:center;">Timesheet</h5>' +
                                        
                                    '</div>' +
                                    '<div class="mb-3">' +
                                        '<h6 style="text-align:center;">you are not added any timesheet yet</h6>' +
                                        
                                    '</div>' +
                                    
                                    '<div class="" style="margin-left:400px;">' +
                                        '<a class="btn btn-success" href="timesheet"><i class="fa fa-plus">&nbsp;</i>Add Timesheet</a>' +
                                    '</div>' +
                                '</form>'+
                                '<div class="col-md-6" style="margin-top:130px;">'+
                                '</div>'; 

                    if(jQuery.isEmptyObject(response.timesheet))
                    {
                        $('#editTimesheet').append(tabledata);
                    }
                    else
                    {

                    var result = response.timesheet;
                    var result1 = response.projects
                    var result2 = response.tasks;
                    var timesheetDate = $('#edittimesheetDate').val();
                    
                    $('#editTimesheet').empty();
                    $.each(result,function(i, result)
                    {
                        var hour = parseInt(result.hour);   
                        //alert(hour);
                        var minute = result.minute;
                        var a = minute.split(':');
                        var minute = (+a[0]) * 1 + (+a[1]) * 1 + (+a[2]);


                        var l = result.project_id; 
                        
                        var task_name = "";
                    
                        for(var m=0; m<result2.length;m++){
                            if('.taskId'+l == '.taskId'+id){
                                
                                task_name += '<option value="' + result2[m].id + '">' + result2[m].name + '</option>';
                            }
                            else
                            {   
                                task_name += '<option value="' + result.task_id + '">' + result.task.name + '</option>';
                                break;
                            }
                        };  
                        var project_name = "";
                        for(var j=0; j<result1.length;j++){
                            if('.projectId'+l == '.projectId'+id){
                                
                                project_name += '<option value="' + result1[j].project_id + '" >' + result1[j].project.name + '</option>';
                            }
                            else
                            {   
                                project_name += '<option value="' + result1[j].project_id + '" >' + result1[j].project.name + '</option>';      
                            }
                        }; 


                        $timesheet_data = '<form method="POST" action="/timesheet/update/' + result.id + '" id="timesheetForm' + result.id+ '" name="timesheetForm">' + 

                                            '<input type="hidden" name="_token" value="' + document.getElementsByName('_token')[0].value + '">' +

                                            '<div class="mb-3">' +
                                                '<h5 style="text-align:center;">Timesheet</h5>' +
                                            '</div>'+

                                            
                                            '<div class="mb-3" hidden>' +
                                                '<label for="exampleInputE" class="form-label">Date</label>' +
                                                '<input type="date" class="form-control" id="edittimesheetDate" name="edittimesheetdate" value="'+timesheetDate+'">' +
                                            '</div> ' +

                                            '<div class="mb-3">' +
                                                '<label for="exampleInputproject" class="form-label">Project</label>' +
                                                '<SELECT class="form-control projectId'+ l +'" name="projectid" id="projectId'+ l +'" onchange="task('+l+')">' + 
                                                    //'<option value="' + result.project_id + '">' + result.project.name + '</option>' + 
                                                    project_name+
                                                '</SELECT>'+
                                            '</div>'+
                                        
                                            '<div class="mb-3">' + 
                                                '<label for="exampleInputtask" class="form-label">Task</label>' + 
                                                '<SELECT class="form-control taskId'+ l +'" name="taskid" id="taskId'+ l +'">' +
                                                    
                                                //'<option value="select">Select Task</option>' +
                                                        task_name +
                                                        
                                                '</SELECT>' +
                                            '</div>' +

                                            '<div class="mb-3">' + 
                                                '<label for="exampleInputhour" class="form-label">Hour</label>' + 
                                                '<SELECT name="hour" class="form-control" id="hour'+ l +'" >' +
                                                //'<option value=" '+ hour +' ">' + hour + ' </option>' +
                                                    '<option value="0">0</option>' +
                                                    '<option value="1">1</option>' +
                                                    '<option value="2">2</option>' +
                                                    '<option value="3">3</option>' +
                                                    '<option value="4">4</option>' +
                                                    '<option value="5">5</option>' +
                                                    '<option value="6">6</option>' +
                                                    '<option value="7">7</option>' +
                                                    '<option value="8">8</option>' +
                                                '</SELECT>' +
                                            '</div>' +

                                            '<div class="mb-3">' + 
                                                '<label for="exampleInputminute" class="form-label">Minute</label>' +
                                                '<SELECT name="minute" class="form-control" id="minute'+ l +'">' +
                                                //'<option value=" '+ minute +' ">' + minute + ' </option>' +
                                                    '<option value="00">0</option>' +
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
                                            '<button type="submit" class="btn btn-success">Update</button>' + 
                                                    '<a href="timesheet/delete/' + result.id + '" class="btn btn-danger">Delete</a>' +
                                            '</div>' +
                                        
                                        '</form>';

                            $("#editTimesheet").append($timesheet_data); 
                            
                            $('.projectId'+l+' option[value='+result.project_id+']').prop('selected', true);
                            $('#minute'+l+' option[value='+minute+']').prop('selected', true);     
                            $('#hour'+l+' option[value='+hour+']').prop('selected', true);    
                                
                    });
                    $('.projectId'+id+' option[value='+projectId+']').prop('selected', true);  
                
                }
            }

        });
    });

}