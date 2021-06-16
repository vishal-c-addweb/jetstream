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
use App\Models\UserIp;
use App\Models\Department;
use App\Models\Team;
use App\Models\Location;

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
        // echo $ip = file_get_contents('https://api.ipify.org');
        // exit();

        // echo $users = employee::all()->sortBy('fname');
        // exit();
        Log::info($user);
        // echo Carbon::now()."<br/>";
        // echo Carbon::today()."<br/>";
        // echo Carbon::yesterday()."<br/>";
        // echo Carbon::tomorrow()."<br/>";
        // echo Carbon::createFromFormat('Y-m-d H', '1975-05-21 22')->toDateTimeString()."<br/>";        

        // $myDate = '12/08/2020';
        // $date = Carbon::createFromFormat('m/d/Y', $myDate)
        //                 ->firstOfMonth()
        //                 ->format('Y-m-d');

        //dd($date);
        // $from = "2021-05-01";
        // $to = "2021-05-31";
        // $attendance = Attendence::where('employee_id',2)->whereBetween('att_date', [$from, $to])->where('att_status',1)->count();
        // echo $attendance;
        // exit();
        
        return view('user.user');
    }
    /**
     * Diplay current user Location.
     *
     * @return redirect to Location page.
     */
    public function location(){

        $user = auth()->user();
        $today = Carbon::today();
        $user_id = $user->id;
        $location = Location::where('location_date',$today)->where('user_id',$user_id)->first();
        return view('user.location',compact('location'));
    }
    
    /**
     * Insert Latitude & longitude in database.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return redirect to Location page.
     */
    public function storeLocation(Request $request){
        
        $user = auth()->user();
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $user_id = $user->id;
        $date = Carbon::today();
        
        $location = Location::Create(
            [
            'latitude'=> $latitude,
            'longitude' => $longitude, 
            'user_id' => $user_id,
            'location_date' => $date,
            ]);    
            
        session()->flash('message', 'Location Stored SuccessFully!.');                 
        return Response()->json($location);
    }

    /**
     * Diplay ip Addres of user.
     *
     * @return redirect to Location page.
     */
    public function IpAddress(){
        $ip = UserIp::with('user')->get();
        $user = User::where('role',0)->get();
        if(auth()->user()->role == 1){
            return view('user.ipaddress',compact('ip','user'));
        }
        else{
            Session::flash('message', "you are not admin");
            return Redirect::back();
        }
    }
    /**
     * Insert ipaddress in database.
     *
     * @param $request for requesting data from ajax.
     * 
     * @return redirect to Location page.
     */
    public function storeIpAddress(Request $request){
        
        
        $ipAddress = $request->ipaddress; 
        $userId = $request->userid;   
        if(UserIp::where('ipaddress',$ipAddress)->where('user_id',$userId)->first())
        {       
            session()->flash('message', 'Ip Address Already exists with this user!.');         
        }
        else
        {
            $ip = new UserIp();
            $ip->ipaddress = $request->ipaddress; 
            $ip->user_id = $request->userid; 
            $ip->save(); 
            session()->flash('message', 'Ip Address Stored SuccessFully!.');                  
        }
        return redirect(route('ipaddress'));

    }  
    /**
     * edit ip address data in modal and return response in json.
     *
     * @param $request for requesting data from form.
     * 
     * @return respons.
     */
    public function editIpAddress(Request $request)
    {   
        $ipId = $request->id;
        $ip  = UserIp::where('id',$ipId)->with('user')->first();
        return Response()->json($ip);
    }
    /**
     * Update employee data using modal.
     *
     * @param $request for requesting data from form.
     * 
     * @return respons.
     */
    public function updateIpAddress(Request $request)
    {
        $id = $request->id;

        $ip = UserIp::updateOrCreate(
            [
                'id' => $id
            ],
            [
                'ipaddress'=>$request->ipAddress,
                'user_id' => $request->userId, 
            ]);    

        session()->flash('message', 'Ip Updated Deleted SuccessFully!.');             
        return Response()->json($ip);
    } 
    /**
    * Delete ip address by id From database.
    *
    * @param int $id.
    * 
    * @return redirect to ipaddress page.
    */
    public function deleteIp($id)
    {
        UserIp::find($id)->delete();
        session()->flash('message', 'Ip Address Deleted SuccessFully!.');
        return redirect(route('ipaddress'));
    }
}
