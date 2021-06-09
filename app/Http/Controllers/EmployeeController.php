<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Exceptions\EmployeeNotFoundException;

use Carbon\Carbon;

use App\Models\employee;
use App\Models\Department;
use App\Models\User;
use App\Models\Student;
use App\Models\Attendence;
use App\Models\Team;
use App\Models\Project;
use App\Models\Task;
use App\Models\Timesheet;
use App\Models\ProjectToUser;

use DataTables;
use App\DataTables\StudentDataTable;
use App\DataTables\UserDataTable;
use App\DataTables\EmployeeDataTable;
use App\DataTables\DepartmentDataTable;
use App\DataTables\AttendenceDataTable;


use App\Http\Requests\StorePostRequest;
use App\Http\Requests\DepPostRequest;
use App\Http\Requests\StudentPostRequest;
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
    public function getEmployeeData(Request $request)
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

                $btn = $btn.'<a href="delete-employee/'.$employeeAction->id.'" style="margin-top:10px; width:78px;" data-toggle="tooltip" class="delete btn btn-danger">Delete</a>';
                
                $btn = $btn.'<a href="employee-report/'.$employeeAction->id.'" style="margin-top:10px; width:78px;" data-toggle="tooltip" class="view btn btn-primary">View</a>';
            
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
        return view('Employee.employee',compact('department','team','employeeAll'));
    }

    /**
     * Get employee data using first name.
     *
     * @param $fname for fetching data.
     * 
     * @return redirect getfnamedata page.
     */
    public function getEmployeeDataByFirstName($fname)
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
        return view('Employee.getfnamedata',compact('employeeByFirstName'));
    }

    /**
     * Insert employee data in database.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to employee page.
     */
    public function storeEmployeeData(StorePostRequest $request)
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
    public function editEmployeeData(Request $request)
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
    public function updateEmployeeData(Request $request)
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
    public function deleteEmployeeData($id)
    {
        Log::info('Employee Deleted');
    	$deleteEmployee = employee::find($id)->delete();
    	Log::info($deleteEmployee);
        session()->flash('message', 'Employee Deleted SuccessFully!.');
        return redirect(route('employee'));
    }

    /**
     * Display department data in yajra datatables.
     *
     * @param $request ajax request for fetching data.
     * 
     * @return redirect to department page.
     */
    public function getDepartmentData(Request $request)
    {
        if ($request->ajax()) {
           Log::info('Department Information');
           $department = Department::with('userd')->get();
           Log::info($department);
           return Datatables::of($department)
                ->editColumn('userName', function ($model) {
                   return $model->userName;
               })
               ->addColumn('action', function ($departmentAction) {
                   return '<a href="delete-department/'.$departmentAction->dep_id.'" class="delete btn btn-danger">Delete</a>';
               })
               ->toJson();
        }
        return view('Department.department');
    }
    
    /**
    * Insert department data in database.
    *
    * @param $request for requesting data from form.
    * 
    * @return redirect to department page.
    */
    public function storeDepartmentData(DepPostRequest $request)
    {
       Log::info('Department Create');
       $user = auth()->user();
       $department = new Department;
       $department->dep_name = $request->dname;
       $department->u_id = $user->id;
       $department->save();
       Log::info($department);
       session()->flash('message', 'Department Created SuccessFully!.');
       return redirect(route('department'));
    }

    /**
    * Delete department data by id from database.
    *
    * @param $id for find coloumn for delete.
    * 
    * @return redirect to department page.
    */
    public function deleteDepartmentData($id)
    {
       Log::info('Department Delete');
       $deleteDepartment = Department::find($id)->delete();
       Log::info($deleteDepartment);
       session()->flash('message', 'Department deleted SuccessFully!.');
       return redirect(route('department'));
    }

    /**
     * Display Student data in yajra datatables.
     *
     * @param StudentDataTable.
     * 
     * @return redirect to student page.
     */
    public function getStudentData(Request $request)
    {
        Log::info('Student Information');
        if ($request->ajax()) {
        $student = Student::all();
        return Datatables::of($student)
            ->rawColumns(['action'])
            ->addColumn('action',  function ($studentAction) {
   
                $btn = '<a href="javascript:void(0)" onClick="editFunctionStudent('.$studentAction->id.')"  style="width: 74px;" class="edit btn btn-success edit">Edit</a>';

                $btn = $btn.'<a href="delete-student/'.$studentAction->id.'" style="margin-top:10px;" data-toggle="tooltip" class="delete btn btn-danger">Delete</a>';

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
    public function storeStudentData(StudentPostRequest $request)
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
    public function editStudentData(Request $request)
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
    public function updateStudentData(Request $request)
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
    public function deleteStudentData($id)
    {   
        Log::info('Student Deleted');
    	$deleteStudent = Student::find($id)->delete();
    	Log::info($deleteStudent);
        session()->flash('message', 'Student Deleted SuccessFully!.');
        return redirect(route('student'));
    }

    /**
     * Display employee attendance Data.
     *
     * @return redirect to attendance page.
     */
    public function employeeAttendance()
    {
        $attendance = Attendence::with('employeeid')
                                ->orderBy('att_date','Asc')
                                ->get();

        $employee = employee::all();
        return view('Employee.attendance',compact('attendance','employee'));
    }
    
    /**
     * Get Employee status by date and employee id using ajax.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function getEmployeeStatus(Request $request)
    {
        $date = $request->date;
        $employeeId = $request->employeeId;
        $attendance = Attendence::where('employee_id',$employeeId)
                                ->where('att_date',$date)
                                ->orderBy('id', 'DESC')
                                ->first();

        return Response()->json($attendance);
    }

    /**
     * Insert Employee Attendance in attendence table.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to attendance page.
     */
    public function storeEmployeeAttendance(Request $request)
    {
        $attendance = new Attendence();
        $date = $request->datepicker;
        $employeeId = $request->employeeId;
        if($request->status == 'present'){
            $status=1;  
        } 
        elseif ($request->status == 'absent'){
            $status=0; 
        }   
        $att = Attendence::where('employee_id',$employeeId)
                            ->where('att_date',$date)
                            ->orderBy('id', 'DESC')
                            ->first();
        
        if($att)
        {
            $att->employee_id = $employeeId;
            $att->att_date = $date;
            $att->att_status = $status;
            $att->updated_at = Carbon::now();
            $att->save();
            session()->flash('message', 'Attendance Updated successfull!.');
            return redirect(route( 'attendance' )); 
        }
        else
        {
            $attendance->employee_id = $employeeId;
            $attendance->att_date = $date;
            $attendance->att_status = $status;
            $attendance->save();
            session()->flash('message', 'Attendance added successfull!.');
            return redirect(route( 'attendance' ));   
        }
    }
    
    /**
     * Display report of all Employee from Database.
     *
     * @return redirect to report page.
     */
    public function attendanceReport()
    {
        $attendance = Attendence::with('employeeid')->get();
        $employee = employee::all();
        return view('Employee.report',compact('attendance','employee'));
    }

    /**
     * Get Employee Report value by fromdate, todate and employeeid using ajax.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function getEmployeeReport(Request $request)
    {
        $fromDate = $request->fromTo;
        $toDate = $request->toFrom;
        $employeeId = $request->employeeId;
        $attendance = Attendence::with('employeeid')
                                ->where('employee_id',$employeeId)
                                ->whereBetween('att_date', [$fromDate, $toDate])
                                ->get();

        return Response()->json($attendance);
    }

    /**
     * Get employee attendence data using id.
     *
     * @param $id.
     * 
     * @return redirect to attendance page.
     */
    public function employeeReportByID($id)
    {
        $attendance = Attendence::with('employeeid')
                                ->where('employee_id',$id)
                                ->get();

        return view('Employee.report_by_id',compact('attendance'));
    }

    /**
     * Get today employee attendance data using ajax.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function getTodayReport(Request $request)
    {
        $date=Carbon::Today();
        $employeeId = $request->employeeId;
        if($employeeId == ''){
            
            $attendance=Attendence::with('employeeid')
                                    ->where('att_date',$date)
                                    ->get();
        }
        else{
            
            $attendance=Attendence::with('employeeid')
                                    ->where('employee_id',$employeeId)
                                    ->where('att_date',$date)
                                    ->get();
        }
        return Response()->json($attendance);
    }

    /**
     * Get yesterday employee attendance data using ajax.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function getYesterdayReport(Request $request)
    {
        $date=Carbon::Yesterday();
        $employeeId = $request->employeeId;
        if($employeeId == ''){
            
            $attendance = Attendence::with('employeeid')
                                    ->where('att_date',$date)
                                    ->get();
        }
        else{
            
            $attendance = Attendence::with('employeeid')
                                    ->where('employee_id',$employeeId)
                                    ->where('att_date',$date)
                                    ->get();
        }
        return Response()->json($attendance);
    }

    /**
     * Get getlastweek employee attendance data using ajax.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function getLastweekReport(Request $request)
    {
        $startOfWeek = Carbon::now()->startOfWeek(); 
        $endOfWeek = Carbon::now()->endOfWeek(); 
        $employeeId = $request->employeeId;
        if($employeeId == ''){
           
            $attendance = Attendence::with('employeeid')
                                    ->whereBetween('att_date', [$startOfWeek, $endOfWeek])
                                    ->get();
        }
        else
        {
           
            $attendance = Attendence::with('employeeid')
                                    ->where('employee_id',$employeeId)
                                    ->whereBetween('att_date', [$startOfWeek, $endOfWeek])
                                    ->get();
        }
        return Response()->json($attendance);
    }

    /**
     * Get employee salary using ajax.
     * 
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function calEmployeeSalary(Request $request)
    {
        $fromDate = $request->fromTo;
        $toDate = $request->toFrom;
        $employeeId = $request->employeeId;
        $salary = $request->employeeSalary;
        $present = Attendence::where('employee_id',$employeeId)
                                ->whereBetween('att_date', [$fromDate, $toDate])
                                ->where('att_status',1)
                                ->count();

        $absent = Attendence::where('employee_id',$employeeId)
                                ->whereBetween('att_date', [$fromDate, $toDate])
                                ->where('att_status',0)
                                ->count();

        $totalSalary = $present * $salary;
        if($employeeData = employee::where('id',$employeeId)->first()){
            $employee = $employeeData;
        }
        else{
            $employee = [];
        }
        return Response()->json(['data'=>['salary'=>$totalSalary,'presentdays'=>$present,'absentdays'=>$absent,'employee'=>$employee]]);
    }

    /**
     * Display User data Using livewire Datatables.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to user page.
     */
    public function getUserData(Request $request)
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

    /**
     * project  page.
     *
     * 
     * @return redirect to project page.
     */
    public function project()
    {
        $project = Project::with('user')->get();
        return view('timesheet.project',compact('project'));
    }
    /**
     * add project page.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to project_task page.
     */
    public function addProject(Request $request)
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
     * assign project  page.
     *
     * 
     * @return redirect to project page.
     */
    public function assignProject()
    {
        $user = User::all();
        $project = Project::all();
        $projectToUser = ProjectToUser::with('project','user')->get();
        return view('timesheet.assignproject',compact('user','project','projectToUser'));
    }
    /**
     * assign project  page.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to project_task page.
     */
    public function addAssignProject(Request $request)
    {
        $projectToUser = new ProjectToUser();
        $projectToUser->project_id = $request->projectid;
        $projectToUser->user_id = $request->userid;
        $projectToUser->save();
        session()->flash('message', 'Project Assigned successfull!.');
        return redirect(route( 'assignproject' ));  
    }
    /**
     * task page.
     *
     * 
     * @return redirect to task page.
     */
    public function task()
    {
        $project = Project::all();
        $task = Task::with('project')->get();
        return view('timesheet.task',compact('project','task'));
    }
    /**
     * add task page.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to task page.
     */
    public function addTask(Request $request)
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
    

    /**
     * timesheet page.
     *
     * 
     * @return redirect to addtimesheet page.
     */
    public function timesheet()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $project = ProjectToUser::with('project')->where('user_id',$user_id)->get();
        $timesheet = Timesheet::with('user','project','task')->get();
        return view('timesheet.timesheet',compact('project','timesheet'));
    }
    
    /**
     * add timesheet page.
     *
     * @param $request for requesting data from form.
     * 
     * @return redirect to addtimesheet page.
     */
    public function addTimesheet(Request $request)
    {   
        $user = auth()->user();
        $timesheetDate = $request->timesheetDate;
        $projectId = $request->projectid;
        
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
    public function getTaskname(Request $request)
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
    public function getDescription(Request $request)
    {
        $id = $request->id;
        $timesheet = Timesheet::where('id',$id)->get();
        return Response()->json($timesheet);
    }

    /**
     * Edit timesheet data.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function editTimesheet()
    {
        $user = auth()->user();
        $user_id = $user->id;
        $project = ProjectToUser::with('project')->where('user_id',$user_id)->get();
        return view('timesheet.edittimesheet',compact('project'));
    }

    /**
     * Edit timesheet by date using ajax.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function editTimesheetData(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $timesheetDate = Carbon::Today();
        $timesheet = Timesheet::with('project','user','task')->where('timesheet_date',$timesheetDate)->where('user_id',$id)->orderBy('id','DESC')->get();
        $project = ProjectToUser::with('project')->where('user_id',$id)->get();
        return Response()->json(['timesheet'=>$timesheet,'projects'=>$project]);
    }
    
    /**
     * Get timesheet by date using ajax.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return response.
     */
    public function getTimesheet(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $timesheetDate = $request->edittimesheetDate;
        $project = ProjectToUser::with('project')->where('user_id',$id)->get();
        $timesheet = Timesheet::with('project','user','task')->where('timesheet_date',$timesheetDate)->where('user_id',$id)->orderBy('id','DESC')->get();
        return Response()->json(['timesheet'=>$timesheet,'projects'=>$project]);
    }


}
