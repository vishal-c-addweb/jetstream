<x-app-layout>

    <div class="py-12">
        <!-- Get data by employee name-->  
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mt-6 text-gray-500">
                    <div class="card-body">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Employee Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Created at</th>
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
    </div>
</x-app-layout>