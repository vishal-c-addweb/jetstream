<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Livewire\StudentCrud;
use App\Http\Livewire\Counter;
use App\Http\Livewire\ShowPosts;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AssignProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum','verified'])->group(function () {

    Route::redirect('/','/dashboard');


    Route::get('/dashboard', function () {
        return view('dashboard');
        })->name('dashboard');

    /* User */

    Route::get('/user',[EmployeeController::class,'user'])->name('user');
    
    Route::get('/location',[EmployeeController::class,'location'])->name('location');

    Route::post('/location/store',[EmployeeController::class,'storeLocation'])->name('location.store');

    Route::get('/ipaddress',[EmployeeController::class,'IpAddress'])->name('ipaddress');

    Route::post('/ipaddress/store',[EmployeeController::class,'storeIpAddress'])->name('ipaddress.store');

    Route::post('/ipaddress/edit',[EmployeeController::class,'editIpAddress'])->name('ipaddress.edit');
    
    Route::post('/ipaddress/update',[EmployeeController::class,'updateIpAddress'])->name('ipaddress.update');

    Route::get('/ipaddress/delete/{id}',[EmployeeController::class,'deleteIp'])->name('ipaddress.delete');

    Route::get('/chat',[EmployeeController::class,'chat'])->name('chat');

    Route::post('/chat/store',[EmployeeController::class,'storeChatUser'])->name('chat.store');
    
    Route::post('/chat/chatuser',[EmployeeController::class,'chatUser'])->name('chat.chatuser');
    
    Route::post('/chat/sendmessage',[EmployeeController::class,'sendMessage'])->name('chat.sendmessage');
    
    Route::post('/chat/updatestatus',[EmployeeController::class,'updateStatus'])->name('chat.updatestatus');

    Route::get('/chats',[EmployeeController::class,'chats'])->name('chats');

    Route::get('/chats/{id}',[EmployeeController::class,'userChat'])->name('chats.userchat');

    Route::post('/chat/search',[EmployeeController::class,'search'])->name('chat.search');

});

    /* Employee */

Route::group(['middleware'=>'auth:sanctum','verified','prefix'=>'employee'],function () {
    
    Route::get('/', [EmployeeController::class,'index'])->name('employee');
    
    Route::get('/{fname}',[EmployeeController::class,'showByFirstName'])->name('employee.showbyfirstname');

    Route::post('/',[EmployeeController::class,'store'])->name('employee.store');

    Route::post('/edit',[EmployeeController::class,'edit'])->name('employee.edit');

    Route::post('/update',[EmployeeController::class,'update'])->name('employee.update');
    
    Route::get('/delete/{id}',[EmployeeController::class,'delete'])->name('employee.delete');
    
});

    /*Employee Attendence */

Route::group(['middleware'=>'auth:sanctum','verified','prefix'=>'attendance'],function () {

    Route::get('/', [AttendanceController::class,'index'])->name('attendance');

    Route::post('/status',[AttendanceController::class,'showStatus'])->name('attendance.showstatus');

    Route::post('/',[AttendanceController::class,'store'])->name('attendance.store');
});

    /* Report */

Route::group(['middleware'=>'auth:sanctum','verified','prefix'=>'report'],function () {

    Route::get('/',[AttendanceController::class,'report'])->name('report');
    
    Route::get('/{id}',[AttendanceController::class,'show'])->name('report.show');
    
    Route::post('/',[AttendanceController::class,'showByData'])->name('report.showbydata');
    
    Route::post('/today',[AttendanceController::class,'showTodayReport'])->name('report.showtoday');
    
    Route::post('/yesterday',[AttendanceController::class,'showYesterdayReport'])->name('report.showyesterday');

    Route::post('/lastweek',[AttendanceController::class,'showLastweekReport'])->name('report.showlastweek');

    Route::post('/calculate/salary',[AttendanceController::class,'calculateSalary'])->name('report.calculatesalary');

});
   
    /* Department */

Route::group(['middleware'=>'auth:sanctum','verified','prefix'=>'department'],function () {

    Route::get('/',[DepartmentController::class,'index'])->name('department');

    Route::post('/',[DepartmentController::class,'store'])->name('department.store');
    
    Route::get('/delete/{id}',[DepartmentController::class,'delete'])->name('department.delete');

});

    /* Student */

Route::group(['middleware'=>'auth:sanctum','verified','prefix'=>'student'],function () {

    Route::get('/',[StudentController::class,'index'])->name('student');

    Route::post('/',[StudentController::class,'store'])->name('student.store');
    
    Route::post('/edit',[StudentController::class,'edit'])->name('student.edit');
    
    Route::post('/update',[StudentController::class,'update'])->name('student.update');

    Route::get('/delete/{id}',[StudentController::class,'delete'])->name('student.delete');

});

/* Livewire */

Route::group(['middleware'=>'auth:sanctum','verified'],function () {

    Route::get('students', StudentCrud::class)->name('students');

    Route::get('counter', Counter::class);

    Route::get('showposts', ShowPosts::class);

});

    /* timesheet*/

Route::group(['middleware'=>'auth:sanctum','verified','prefix'=>'timesheet'],function () {

    Route::get('/timesheet',[TimesheetController::class,'index'])->name('timesheet');
 
    Route::post('/',[TimesheetController::class,'store'])->name('timesheet.store');
         
    Route::get('/edit',[TimesheetController::class,'edit'])->name('timesheet.edit');
    
    Route::post('/showtask',[TimesheetController::class,'showTask'])->name('timesheet.showtask');

    Route::post('/showdescription',[TimesheetController::class,'showDescription'])->name('timesheet.showdescription');
        
    Route::post('/showbydate',[TimesheetController::class,'showByDate'])->name('timesheet.showbydate');

    Route::post('/showbytoday',[TimesheetController::class,'showByToday'])->name('timesheet.showbytoday');
    
    Route::post('/update/{id}',[TimesheetController::class,'update'])->name('timesheet.update');

    Route::get('/delete/{id}',[TimesheetController::class,'delete'])->name('timesheet.delete');

});

Route::group(['middleware'=>'auth:sanctum','verified','prefix'=>'project'],function () {

    Route::get('/',[ProjectController::class,'index'])->name('project');
    
    Route::post('/',[ProjectController::class,'store'])->name('project.store');

    Route::get('/delete/{id}',[ProjectController::class,'delete'])->name('project.delete');
    
});

Route::group(['middleware'=>'auth:sanctum','verified','prefix'=>'assignproject'],function () {


    Route::get('/',[AssignProjectController::class,'index'])->name('assignproject');

    Route::post('/assignproject',[AssignProjectController::class,'store'])->name('assignproject.store'); 
    
    Route::get('/delete/{id}',[AssignProjectController::class,'delete'])->name('assignproject.delete');
});

Route::group(['middleware'=>'auth:sanctum','verified','prefix'=>'task'],function () {

    Route::get('/',[TaskController::class,'index'])->name('task');
    
    Route::post('/',[TaskController::class,'store'])->name('task.store');

});