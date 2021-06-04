<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Student;
use App\Http\Requests\StudentPostRequest;

class StudentApiController extends Controller
{   
    protected $user;

    /**
     * Create a new EmployeeApiController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user = $this->guard()->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if($student=Student::all()){
            return $this->success($student,200);
        }
        else{
            return $this->error("employee not found");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentPostRequest $request)
    {
        $student = new Student();
        $student->name = $request->sname;
        $student->age = $request->sage;
        $student->address = $request->saddress;
        $student->percentage = $request->spercentage;
        $student->school = $request->sschool;
        if($student->save()){
            return $this->success($student,201);
        }
        else{
            return $this->error("student not created");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($student=Student::where('id',$id)->firstOrFail()){
            return $this->success($student,200);
        }
        else
        {
            return $this->error("student not found");
        }   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentPostRequest $request, $id)
    {
        $student = Student::find($id);
        $student->name = $request->sname;
        $student->age = $request->sage;
        $student->address = $request->saddress;
        $student->percentage = $request->spercentage;
        $student->school = $request->sschool;
        if($student->save())
        {
            return $this->success($student,200);
        }
        else{
            return $this->error("student not updated");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($student=Student::destroy($id)){
            return response()->json(['data'=>$student],200);
        }
        else
        {
            return $this->error("student not found");
        }
    }
    /**
     * Search for a name.
     *
     * @param  int  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        if($student=Student::where('name','like','%'.$name.'%')->get()){
            return $this->success($student,200);
        }
        else
        {
            return $this->error("student not found");
        }
    }
    
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }

    /**
     * Get the message for success or error.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message)
    {
        return response()->json([
            'status' => false,
            'message'=>$message
        ],404);
    }
    /**
     * Get the data for success or error.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data)
    {   
        return response()->json([
            'data'=>$data->toarray()
        ]);
    }
}
