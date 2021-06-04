<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Todo;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Requests\TodoPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoApiController extends Controller
{
    protected $user;
    
     /**
     * Create a new TodoApiController instance.
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
        $created_by=$this->guard()->payload()->get('sub');
        if($todos=Todo::Where('created_by',$created_by)->get()){
            return $this->success($todos,200);
        }
        else{
            return $this->error("Todo not found");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request.
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(TodoPostRequest $request)
    {
        $created_by=$this->guard()->payload()->get('sub');
        $todo = new Todo();
        $todo->title = $request->title;
        $todo->body = $request->body;
        $todo->completed = $request->completed;
        $todo->created_by = $created_by;

        if($todo->save()){
            return $this->success($todo,201);
        }
        else
        {
            return $this->error("Todo not created");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id.
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $created_by=$this->guard()->payload()->get('sub');
        if($todo=Todo::where('id',$id)->firstOrFail()){
            $cb = $todo->created_by;
            if($cb == $created_by){
                return $this->success($todo,200);
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
     * @param  int  $id.
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request.
     * 
     * @param  int  $id.
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(TodoPostRequest $request, $id)
    {
        $created_by=$this->guard()->payload()->get('sub');
        $todo =Todo::find($id);
        $todo->title = $request->title;
        $todo->body = $request->body;
        $todo->completed = $request->completed;
        $cb = $todo->created_by;

        if($cb == $created_by){
            if($todo->save()){
                return $this->success($todo,200);
            }
            else
            {
                return $this->error("todo not updated");
            }
        }
        else{
                return $this->error("you are not able to update");
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id.
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $todos = Todo::Where('id',$id)->first();
        $cb = $todos->created_by;
        $c = $this->guard()->payload()->get('sub');

        if($cb == $c){
            
            if($todo=Todo::destroy($id)){
                return response()->json(['data'=>$todo],200);
            }
            else
            {
                return $this->error("Todo not found");
            }
        }
        else
        {
            return $this->error("you are not able to delete");
        }
    }

    /**
     * Search the specified resource from storage.
     *
     * @param  int  $title
     * 
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        if($todo=Todo::where('title','like','%'.$title.'%')->get()){
            return $this->success($todo,200);
        }
        else
        {
            return $this->error("Todo not found");
        } 
    }
    /**
     * Query builder.
     *
     * 
     * 
     * @return \Illuminate\Http\Response
     */
    public function qb()
    {
        //$result = Student::all();
        
        //$result = Student::where('name','vk')->get();
        
        //$result = Student::where('name','vk')->first();
        
        //$result = Student::find(4);
        
        //$result = Student::pluck('age');
        
        //$result = Student::where('name','vk')->pluck('school');
        
        //$result = Student::pluck('percentage','name');
        
        //$result = $result->chunk(2);
        
        //$result = Student::all()->count();
        
        //$result = Student::all()->max('percentage');
        
        //$result = Student::all()->avg('percentage');
        
        // //doesntExist
        // if(Student::where('id','47')->exists()){
        //     return response()->json("yes");
        // }
        // else{
        //     return response()->json("no");
        // }
        //$result = Student::where('name','vk')->distinct()->get();
        
        //$result = Student::where('name','vk')->select('name');
        //$result = $result->addSelect('age')->get();
        
        //$result = Student::groupBy('id')->get();
        
        /* Carbon date and time */

        //$result = Carbon::now(); 
        $result = CarbonImmutable::now();
        return response()->json(['Data'=>$result]);
        
    }

    /**
     * Upload the image.
     *
     * @param  \Illuminate\Http\Request  $request.
     * 
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if($res=$request->file('file')->store('api-upload')){
            return $this->success($res,200);
        }
        else
        {
            return $this->error("not uploaded");
        } 
    }
    
    /**
     * Update the title.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatetitle(Request $request)
    {
        if($request->isMethod('patch')){
            $todo=$request->input();
            Todo::where('id',$todo['id'])->update(['title'=>$todo['title']]);
            return response()->json(['message'=>"Data updated"],201);
        }
        else{
            return $this->error("not updated");
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
     * Get the payload of token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function payload()
    {
        return response()->json($this->guard()->payload());
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
