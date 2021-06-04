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
                                    <th>Employee Id</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$employeeByFirstName->id}}</td>
                                    <td>{{$employeeByFirstName->emp_id}}</td>
                                    <td>{{$employeeByFirstName->fname}}</td>
                                    <td>{{$employeeByFirstName->lname}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>