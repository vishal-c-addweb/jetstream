<x-app-layout>

    
    <div class="py-12">
        <!-- Button trigger modal -->
        <button type="button" onClick="add()"  style="margin-left:45px;" data-bs-toggle="modal" data-bs-target="#exampleModal" class="bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 ml-3">Add Attendance</button>

        <a href="report" class="bg-blue-700 text-white font-bold py-2 px-4 rounded my-3 ml-3">Report</a>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Attendance</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('addpresent') }}">
                        {{ csrf_field() }}

                        <div class="mb-3">
                            <label for="exampleInputemployee" class="form-label">Employee Name</label>
                            <SELECT name="employeeId" class="form-control" id="employeeId" >
                                @foreach($employee as $e)
                                    <option value="{{$e->id}}">{{$e->fname}}</option>
                                @endforeach
                            </SELECT>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputE" class="form-label">Date</label>
                            <input type="date" class="form-control" id="datepicker" name="datepicker">
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputst" class="form-label">Status</label>
                            <br/>
                            <input type="radio" id="presentId" value="present" name="status" >
                            <label for="exampleInputst" class="form-label" >Present</label>&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="absentId" value="absent" name="status" >
                            <label for="exampleInputst" class="form-label">Absent</label>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                
                </div>
            </div>
        </div>

        <!---flash message -->
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

        <!-- Get data by employee name-->  
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
                                    <th>Created At</th>
                                    <th>Updated at</th>
                                </tr>
                            </thead>
                            <tbody>

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
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        function add()
        {
            $('#exampleModal').show();
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

        </script>
    </div>
    
</x-app-layout>