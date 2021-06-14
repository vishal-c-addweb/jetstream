<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\EmployeeNotFoundException;

use Carbon\Carbon;

use App\Models\Project;
use App\Models\User;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display Task.
     *
     * 
     * @return redirect to task page.
     */
    public function index()
    {
        $project = Project::all();
        $task = Task::with('project')->get();
        return view('timesheet.task',compact('project','task'));
    }
    /**
     * Insert task in database.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to task page.
     */
    public function store(Request $request)
    {   
        $user = auth()->user();
        $task = new Task();
        $task->name = $request->taskname;
        $task->project_id = $request->projectid;
        $task->created_by = $user->id;
        $task->save();
        session()->flash('message', 'Task added successfull!.');
        return redirect(route( 'task' ));   
    }
 
}
