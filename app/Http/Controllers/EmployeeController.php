<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\EmployeeNotFoundException;

use Carbon\Carbon;

use App\Models\employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Team;

use DataTables;
use App\DataTables\UserDataTable;
use App\DataTables\EmployeeDataTable;

use App\Http\Requests\StorePostRequest;
use Jenssegers\Agent\Agent;

class EmployeeController extends Controller
{
    /**
     * Display employee data in yajra datatables.
     *
     * @param $request ajax request for fetching data.
     * 
     * @return redirect to employee page.
     */
    public function index(Request $request)
    {
        Log::info('Employee Information');
        $i = auth()->user()->currentTeam->id;
        if ($request->ajax()) {
            
        $employee = employee::with(['depart','team'])
                            ->where('team_id','=',$i)
                            ->orderBy('id','Asc');

        return Datatables::of($employee)
            ->editColumn('departmentName', function ($model) {
                return $model->departmentName;
            })
            ->editColumn('teamName', function ($model) {
                return $model->teamName;
            })
            ->rawColumns(['action'])
            ->addColumn('action',  function ($employeeAction) {
   
                $btn = '<a href="javascript:void(0)" onClick="editFunction('.$employeeAction->id.')"  style="width: 78px;" class="edit btn btn-success edit">Edit</a>';

                $btn = $btn.'<a href="/employee/delete/'.$employeeAction->id.'" style="margin-top:10px; width:78px;" data-toggle="tooltip" class="delete btn btn-danger">Delete</a>';
                
                $btn = $btn.'<a href="/report/'.$employeeAction->id.'" style="margin-top:10px; width:78px;" data-toggle="tooltip" class="view btn btn-primary">View</a>';
            
                return $btn;
            })
         ->toJson();
        }
        $department = Department::all();
        $employeeAll = employee::all();
        $team = Team::all();
        Log::info($employeeAll);
        Log::info($department);
        Log::info($team);
        return view('employee.employee',compact('department','team','employeeAll'));
    }

    /**
     * Get employee data using first name.
     *
     * @param $fname for fetching data.
     * 
     * @return redirect getfirstnamedata page.
     */
    public function showByFirstName($fname)
    {
        Log::info('Fetch Employee Information');
        try {
            $employeeByFirstName = employee::where('fname',$fname)->firstOrFail();
            Log::info('Employee informaion');
            Log::info($employeeByFirstName);
        } catch (ModelNotFoundException $exception) {
            Log::error('Employee not found');
            return view('errors.notfound');
        }
        //finally
        //{
         //   return view('errors.404');
        //}
        return view('employee.getfirstnamedata',compact('employeeByFirstName'));
    }

    /**
     * Insert employee data in database.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to employee page.
     */
    public function store(StorePostRequest $request)
    {
        Log::info('Employee Created');
        $employee = new employee;
        $employee->emp_id = $request->empid;
        $employee->fname = $request->fname;
        $employee->lname = $request->lname;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->gender = $request->gender;
        $employee->address= $request->address;
        $employee->salary = $request->salary;
        $employee->dep_id = $request->depid;
        $employee->team_id = $request->teamid;
        
        $employeeByID = employee::where('emp_id','=',$request->empid)->first();
        if(empty($employeeByID))
        {
            $employee->save();    
            Log::info($employee);
            session()->flash('message', 'Employee Created SuccessFully!.');
            return redirect()->route('employee');   
        }
        else
        {   
            session()->flash('message', 'Employee already exists with this employee ID!.');
            return redirect()->route('employee');
        }
    }  

    /**
     * edit employee data in modal and return response in json.
     *
     * @param $request for requesting data from form.
     * 
     * @return respons.
     */
    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $employee  = employee::where($where)->first();
        
        return Response()->json($employee);
    }

    /**
     * Update employee data using modal.
     *
     * @param $request for requesting data from form.
     * 
     * @return respons.
     */
    public function update(Request $request)
    {
        $id = $request->id;
 
        $employee   =   employee::updateOrCreate(
                    [
                     'id' => $id
                    ],
                    [
                    'emp_id'=>$request->empid,
                    'fname' => $request->fname, 
                    'lname' => $request->lname,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'gender' => $request->gender,
                    'address' => $request->address,
                    'salary' => $request->salary,
                    'dep_id' => $request->depid,
                    'team_id' => $request->teamid
                    ]);    
                         
        return Response()->json($employee);
    }

    /**
     * Delete employee by id From database.
     *
     * @param int $id.
     * 
     * @return redirect to employee page.
     */
    public function delete($id)
    {
        Log::info('Employee Deleted');
    	$deleteEmployee = employee::find($id)->delete();
    	Log::info($deleteEmployee);
        session()->flash('message', 'Employee Deleted SuccessFully!.');
        return redirect(route('employee'));
    }

    /**
     * Display User data Using livewire Datatables.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to user page.
     */
    public function user(Request $request)
    {
        Log::info('User');
        $user = User::all();
        // dd($request->user());
        // echo $request->user()->twoFactorQrCodeSvg();
        // $agent = new Agent();
        // echo $agent->platform();
        // echo $agent->browser();
        // echo $ip=\Request::ip();
  
        // exit();

        // echo $users = employee::all()->sortBy('fname');
        // exit();
        Log::info($user);
        // echo Carbon::now()."<br/>";
        // echo Carbon::today()."<br/>";
        // echo Carbon::yesterday()."<br/>";
        // echo Carbon::tomorrow()."<br/>";
        // echo Carbon::createFromFormat('Y-m-d H', '1975-05-21 22')->toDateTimeString()."<br/>";        

        $myDate = '12/08/2020';
        $date = Carbon::createFromFormat('m/d/Y', $myDate)
                        ->firstOfMonth()
                        ->format('Y-m-d');

        //dd($date);
        // $from = "2021-05-01";
        // $to = "2021-05-31";
        // $attendance = Attendence::where('employee_id',2)->whereBetween('att_date', [$from, $to])->where('att_status',1)->count();
        // echo $attendance;
        // exit();
        
        return view('user.user');
    }
    
}
