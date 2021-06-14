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

class ProjectController extends Controller
{
    /**
     * Display project.
     * 
     * @return redirect to project page.
     */
    public function index()
    {
        $project = Project::with('user')->paginate(10);
        return view('timesheet.project',compact('project'));
    }
    /**
     * Insert project and current logged in database.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to project page.
     */
    public function store(Request $request)
    {   
        $user = auth()->user();
        $project = new Project();
        $project->name = $request->projectname;
        $project->created_by = $user->id;
        $project->save();
        session()->flash('message', 'Project added successfull!.');
        return redirect(route( 'project' ));   
    }
    /**
     * Delete Project By id.
     *
     * @param $id.
     * 
     * @return redirect to project page.
     */
    public function delete($id)
    {
    	Project::find($id)->delete();
        session()->flash('message', 'Project Deleted SuccessFully!.');
        return redirect(route('project'));
    }
}
