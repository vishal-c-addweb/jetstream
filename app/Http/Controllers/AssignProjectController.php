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
use App\Models\ProjectToUser;

class AssignProjectController extends Controller
{
/**
     * Diplay Project Assigned to User.
     *
     * 
     * @return redirect to Assign project page.
     */
    public function index()
    {
        $user = User::all();
        $project = Project::all();
        $projectToUser = ProjectToUser::with('project','user')->paginate(10);
        return view('timesheet.assignproject',compact('user','project','projectToUser'));
    }
    /**
     * insert Assigned project to database.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to Assign project page.
     */
    public function store(Request $request)
    {
        $projectToUser = new ProjectToUser();
        $projectToUser->project_id = $request->projectid;
        $projectToUser->user_id = $request->userid;
        $projectToUser->save();
        session()->flash('message', 'Project Assigned successfull!.');
        return redirect(route( 'assignproject' ));  
    }
    /**
     * Delete Assign Project By id.
     *
     * @param $id.
     * 
     * @return redirect to Assign project page.
     */
    public function delete($id)
    {
    	ProjectToUser::find($id)->delete();
        session()->flash('message', 'Assigned Project Deleted SuccessFully!.');
        return redirect(route('assignproject'));
    }
    
}
