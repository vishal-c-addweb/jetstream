<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\EmployeeNotFoundException;

use App\Models\Project;
use App\Models\Task;
use App\Models\Timesheet;
use App\Models\ProjectToUser;
use App\Models\User;


use Carbon\Carbon;

class TimesheetController extends Controller
{
    /**
     * Display timesheet data.
     *
     * 
     * @return redirect to timesheet page.
     */
    public function index()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $project = ProjectToUser::with('project')->where('user_id',$user_id)->get();
        $timesheet = Timesheet::with('user','project','task')->paginate(10);
        return view('timesheet.timesheet',compact('project','timesheet'));
    }
    
    /**
     * Insert timesheet data in database.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to timesheet page.
     */
    public function store(Request $request)
    {   
        $user = auth()->user();
        $timesheet = new Timesheet();
        $timesheet->user_id = $user->id;
        $timesheet->project_id = $request->projectid;
        $timesheet->task_id = $request->taskname;
        $timesheet->timesheet_date = $request->timesheetDate;
        $h = $request->hour;
        $hour = Carbon::createFromFormat('H', $h)->format('H:i:s');
        $timesheet->hour = $hour;
        $m = $request->minute;
        $minute = Carbon::createFromFormat('i', $m)->format('H:i:s');
        $timesheet->minute = $minute;
        $timesheet->description = $request->description;
        $timesheet->save();
        session()->flash('message', 'Timesheet added successfull!.');
        return redirect(route( 'timesheet' ));
        
    }

    /**
     * Get Task Name by projectid using ajax.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function showTask(Request $request)
    {
        $projectId = $request->projectId;
        $task = Task::where('project_id',$projectId)->get();
        return Response()->json($task); 
    }
    
    /**
     * Get Description by id using ajax.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function showDescription(Request $request)
    {
        $id = $request->id;
        $timesheet = Timesheet::where('id',$id)->get();
        return Response()->json($timesheet);
    }

    /**
     * redirect to edit timesheet data.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return redirect to edit timesheet page.
     */
    public function edit()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $project = ProjectToUser::with('project')->where('user_id',$user_id)->get();
        return view('timesheet.edittimesheet',compact('project'));
    }

    /**
     * Display timesheet data by today date using ajax.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function showByToday(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $timesheetDate = Carbon::Today();
        $timesheet = Timesheet::with('project','user','task')->where('timesheet_date',$timesheetDate)->where('user_id',$id)->orderBy('id','DESC')->get();
        $project = ProjectToUser::with('project')->where('user_id',$id)->get();
        //alert($array);
        $task = []; 
        return Response()->json(['timesheet'=>$timesheet,'projects'=>$project,'tasks'=>$task]);
    }
    
    /**
     * Display timesheet data by selected date using ajax.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function showByDate(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $timesheetDate = $request->edittimesheetDate;
        $projectId = $request->projectId;
        $task = Task::where('project_id',$projectId)->get();
        $project = ProjectToUser::with('project')->where('user_id',$id)->get();
        $timesheet = Timesheet::with('project','user','task')->where('timesheet_date',$timesheetDate)->where('user_id',$id)->orderBy('id','DESC')->get();
        return Response()->json(['timesheet'=>$timesheet,'projects'=>$project,'tasks'=>$task]);
    }

    /**
     * Update Timesheet By id.
     *
     * @param $id & $request for requesting data from form.
     * 
     * @return redirect to edittimesheet page.
     */
    public function update(Request $request,$id)
    {
        $user = auth()->user();
        $timesheet = Timesheet::find($id);
    	$timesheet->user_id = $user->id;
        $timesheet->project_id = $request->projectid;
        $timesheet->task_id = $request->taskid;
        $timesheet->timesheet_date = $request->edittimesheetdate;
        $h = $request->hour;
        $hour = Carbon::createFromFormat('H', $h)->format('H:i:s');
        $timesheet->hour = $hour;
        $m = $request->minute;
        $minute = Carbon::createFromFormat('i', $m)->format('H:i:s');
        $timesheet->minute = $minute;
        $timesheet->description = $request->description;
        $timesheet->save();
        session()->flash('message', 'Timesheet updated SuccessFully!.');
        return redirect(route('timesheet.edit'));
    }

    /**
     * Delete Timesheet By id.
     *
     * @param $id.
     * 
     * @return redirect to edittimesheet page.
     */
    public function delete($id)
    {
    	Timesheet::find($id)->delete();
        session()->flash('message', 'Timesheet Deleted SuccessFully!.');
        return redirect(route('timesheet.edit'));
    }
    
}
