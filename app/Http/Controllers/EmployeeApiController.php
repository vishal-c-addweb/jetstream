<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Team;
use App\Models\employee;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeeApiController extends Controller
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
        if($employee = employee::all()){
            return $this->success($employee,200);
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
    public function store(StorePostRequest $request)
    {

        $employee =new employee;
        $employee->emp_id = $request->empid;
        $employee->fname = $request->fname;
        $employee->lname = $request->lname;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->salary = $request->salary;
        $employee->dep_id = $request->depid;
        $employee->team_id = $request->teamid;

        $dep=Department::where('dep_id','=',$request->depid)->first();
        $team=Team::where('id','=',$request->teamid)->first();
        $em=employee::where('emp_id','=',$request->empid)->first();
        if(empty($em)){

            if(!empty($dep)){

                if(!empty($team)){
                
                    if($employee->save()){
                        return $this->success($employee,201);
                    }
                    else{
                        return $this->error("employee not saved");
                    }
                }
                else{
                    return $this->error("Team not exist with this Id");
                }
            }
            else{
                return $this->error("Department not exist with this Id");
            }
        }
        else{
            return $this->error("Employee already exist with this Id");
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
        if($employee = employee::where('id',$id)->firstOrFail()){
            return $this->success($employee,200);
        }
        else
        {
            return $this->error("employee not found");
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
    public function update(StorePostRequest $request, $id)
    {
        $employee =employee::find($id);
        $employee->emp_id = $request->empid;
        $employee->fname = $request->fname;
        $employee->lname = $request->lname;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->gender = $request->gender;
        $employee->address = $request->address;
        $employee->salary = $request->salary;
        $employee->dep_id = $request->depid;
        $employee->team_id = $request->teamid;

        $dep=Department::where('dep_id','=',$request->depid)->first();
        $team=Team::where('id','=',$request->teamid)->first();
        if(!empty($dep)){

            if(!empty($team)){
            
                if($employee->save()){
                    return $this->success($employee,200);
                }
                else{
                    return $this->error("employee not updated");
                }
            }
            else{
                return $this->error("Team not exist with this Id");
            }
        }
        else{
            return $this->error("Department not exist with this Id");
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
        if($employee = employee::destroy($id)){
            return response()->json(['data'=>$employee],200);
        }
        else
        {
            return $this->error("Employee not found");
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
