<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\EmployeeNotFoundException;

use App\Models\User;
use App\Models\Student;

use DataTables;
use App\DataTables\StudentDataTable;


use App\Http\Requests\StudentPostRequest;

class StudentController extends Controller
{
   /**
     * Display Student data in yajra datatables.
     *
     * @param StudentDataTable.
     * 
     * @return redirect to student page.
     */
    public function index(Request $request)
    {
        Log::info('Student Information');
        if ($request->ajax()) {
        $student = Student::all();
        return Datatables::of($student)
            ->rawColumns(['action'])
            ->addColumn('action',  function ($studentAction) {
   
                $btn = '<a href="javascript:void(0)" onClick="editFunctionStudent('.$studentAction->id.')"  style="width: 74px;" class="edit btn btn-success edit">Edit</a>';

                $btn = $btn.'<a href="/student/delete/'.$studentAction->id.'" style="margin-left:5px;" data-toggle="tooltip" class="delete btn btn-danger">Delete</a>';

                return $btn;
            })
         ->toJson();
        }
        return view('student.student');
    }

    /**
     * Insert student data in database.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to employee page.
     */
    public function store(StudentPostRequest $request)
    {
        Log::info('Student Created');
        $student = new Student;
        $student->name = $request->sname;
        $student->age = $request->sage;
        $student->address = $request->saddress;
        $student->percentage = $request->spercentage;
        $student->school = $request->sschool;
        $student->save();    
        Log::info($student);
        session()->flash('message', 'Student Created SuccessFully!.');
        return redirect()->route('student');   
    } 

    /**
     * edit student data in modal.
     *
     * @param $request for requesting data from form.
     * 
     * @return respons.
     */
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $student  = Student::where($where)->first();
        
        return Response()->json($student);
    }

    /**
     * Update student data using modal and return json response.
     *
     * @param $request for requesting data from form.
     * 
     * @return respons.
     */
    public function update(Request $request)
    {
        $id = $request->id;
 
        $student   =   Student::updateOrCreate(
                    [
                     'id' => $id
                    ],
                    [
                    'name'=>$request->name,
                    'age' => $request->age,
                    'address' => $request->address,
                    'percentage' => $request->percentage,
                    'school' => $request->school
                    ]);                     
        return Response()->json($student);
    }

    /**
    * Delete student data by id from database.
    *
    * @param $id for find coloumn for delete.
    * 
    * @return redirect to student page.
    */
    public function delete($id)
    {   
        Log::info('Student Deleted');
    	$deleteStudent = Student::find($id)->delete();
    	Log::info($deleteStudent);
        session()->flash('message', 'Student Deleted SuccessFully!.');
        return redirect(route('student'));
    }
}
