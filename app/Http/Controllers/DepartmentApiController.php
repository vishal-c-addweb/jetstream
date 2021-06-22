<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\DepPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentApiController extends Controller
{
    protected $user;

    /**
     * Create a new DepartmentApiController instance.
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
        $created_by = $this->guard()->payload()->get('sub');
        if($department = Department::Where('u_id',$created_by)->get()){
            return $this->success($department,200);
        }
        else{
            return $this->error("todo not found");
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(DepPostRequest $request)
    {
        $created_by = $this->guard()->payload()->get('sub');
        
        $department = new Department();
        $department->dep_name = $request->dname;
        $department->u_id = $created_by;

        if($department->save()){
            return $this->success($department,201);
        }
        else
        {
            return $this->error("department not found");
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
        $created_by = $this->guard()->payload()->get('sub');
        if($department = Department::where('dep_id',$id)->firstOrFail()){
            $cb = $department->u_id;
            if($cb == $created_by){
                return $this->success($department,200);
            }
            else
            {
                return $this->error("this is not your todo");
            }            
        }
        else
        {
            return $this->error("todo not found");
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
    public function update(DepPostRequest $request, $id)
    {
        $created_by = $this->guard()->payload()->get('sub');
        $department = Department::find($id);
        $department->dep_name = $request->dname;
        //$department->u_id = $created_by;

        $cb = $department->u_id;

        if($cb == $created_by){
            $department->u_id = $created_by;
            if($department->save()){
                return $this->success($department,200);
            }
            else
            {
                return $this->error("department not updated");
            }
        }
        else{
            return $this->error("you are not able to update");
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
        $department = Department::Where('dep_id',$id)->first();
        $createdById = $department->u_id;
        $created_by = $this->guard()->payload()->get('sub');
        
        if($createdById == $created_by){
            
            if($department=Department::destroy($id)){
                return response()->json(['data'=>$department],200);
            }
            else
            {
                return $this->error("department not found");
            }
        }
        else
        {
            return $this->error("you are not able to delete");
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
        $c = $this->guard()->payload()->get('sub');
        return response()->json([
            "user id"=>$c,
            'data'=>$data->toarray()
        ]);
    }
}
