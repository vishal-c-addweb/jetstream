<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\EmployeeNotFoundException;

use App\Models\Department;
use App\Models\User;

use DataTables;
use App\DataTables\DepartmentDataTable;
use App\Http\Requests\DepPostRequest;

class DepartmentController extends Controller
{
    /**
     * Display department data in yajra datatables.
     *
     * @param $request ajax request for fetching data.
     * 
     * @return redirect to department page.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
           Log::info('Department Information');
           $department = Department::with('userd')->get();
           Log::info($department);
           return Datatables::of($department)
                ->editColumn('userName', function ($model) {
                   return $model->userName;
               })
               ->addColumn('action', function ($departmentAction) {
                   return '<a href="/department/delete/'.$departmentAction->dep_id.'" class="delete btn btn-danger">Delete</a>';
               })
               ->toJson();
        }
        return view('department.department');
    }
    
    /**
    * Insert department data in database.
    *
    * @param $request for requesting data from form.
    * 
    * @return redirect to department page.
    */
    public function store(DepPostRequest $request)
    {
       Log::info('Department Create');
       $user = auth()->user();
       $department = new Department;
       $department->dep_name = $request->dname;
       $department->u_id = $user->id;
       $department->save();
       Log::info($department);
       session()->flash('message', 'Department Created SuccessFully!.');
       return redirect(route('department'));
    }

    /**
    * Delete department data by id from database.
    *
    * @param $id for find coloumn for delete.
    * 
    * @return redirect to department page.
    */
    public function delete($id)
    {
       Log::info('Department Delete');
       $deleteDepartment = Department::find($id)->delete();
       Log::info($deleteDepartment);
       session()->flash('message', 'Department deleted SuccessFully!.');
       return redirect(route('department'));
    }
}
