   
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
            Open Add department Modal.
        */
        function create(){
        $('#departmentModal').modal('show');
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
    

  </script>

</body>

</html>