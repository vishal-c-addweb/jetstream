
                    if ($request->ajax()) {
            $student=Student::all();
            return Datatables::of($student)
               ->rawColumns(['action'])
                ->addColumn('action',  function ($user) {
   
                    $btn = '<a href="javascript:void(0)" onClick="edit('.$user->id.')"  style="width: 74px;" class="edit btn btn-success edit">Edit</a>';

                    $btn = $btn.'<a href="javascript:void(0)" onClick="delete('.$user->id.')" style="margin-left:10px;" data-toggle="tooltip" class="delete btn btn-danger">Delete</a>';

                    return $btn;
                })
               ->toJson();
            }
            return view('livewire.student.studentcrud');


            <script type="text/javascript">
        /*
            Fetching data in table using ajax.
        */
        $(document).ready(function() {
            $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('students') }}",
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

</script>