$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/*
    Fetching employee data in table using ajax.
*/
$(document).ready(function() {
    $('#employee-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "/employee",
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
        url: "/employee/edit",
        data: { id: id },
        dataType: 'json',
        success: function(response){
            console.log(response);
            $('#employeeEditModalLabel').html("Edit Company");
            $('#employeeEditModal').modal('show');
            $('#id').val(response.id);
            $('#empid').val(response.emp_id);
            $('#fname').val(response.fname);
            $('#lname').val(response.lname);
            $('#phone').val(response.phone);
            $('#email').val(response.email);
            if(response.gender=="male")
            {
                $("#maleId").prop('checked',true);
            }
            else
            {
                $("#femaleId").prop('checked',true); 
            }
            $('#address').val(response.address);
            $('#salary').val(response.salary);
            $('#depid').val(response.dep_id);
            $('#teammid').val(response.team_id);
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
        url: "/employee/update",
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
    ajax: "/department",
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
    ajax: "/student",
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
    Edit student data in table using ajax.
*/
function editFunctionStudent(id){
    $.ajax({
        type:"POST",
        url: "/student/edit",
        data: { id: id },
        dataType: 'json',
        success: function(response){
                //console.log(res);
            $('#StudentModal').html("Edit Student");
            $('#studentEditModal').modal('show');
            $('#studentId').val(response.id);
            $('#studentName').val(response.name);
            $('#studentAge').val(response.age);
            $('#studentAddress').val(response.address);
            $('#studentPercentage').val(response.percentage);
            $('#studentSchool').val(response.school);
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
    Update student data in table using ajax.
*/
$('#StudentForm').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type:'POST',
        url: "/student/update",
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
