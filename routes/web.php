<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Livewire\StudentCrud;
use App\Http\Livewire\Counter;
use App\Http\Livewire\ShowPosts;

use App\Http\Controllers\EmployeeController;

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
        Log::debug('Log Activate!');
        return view('dashboard');
        })->name('dashboard');

    /* Employee */
    
    Route::get('/employee', [EmployeeController::class,'getEmployeeData'])->name('employee');
    
    Route::get('/employee/{fname}',[EmployeeController::class,'getEmployeeDataByFirstName'])->name('employeeFirstname');

    Route::post('/employee',[EmployeeController::class,'storeEmployeeData'])->name('store');

    Route::post('/edit-employee',[EmployeeController::class,'editEmployeeData'])->name('edit-employee');

    Route::post('/update-employee',[EmployeeController::class,'updateEmployeeData'])->name('update-employee');
    
    Route::get('/delete-employee/{id}',[EmployeeController::class,'deleteEmployeeData'])->name('delete-employee');
    
    /*Employee Attendence */

    Route::get('attendance', [EmployeeController::class,'employeeAttendance'])->name('attendance');

    Route::post('getstatus',[EmployeeController::class,'getEmployeeStatus'])->name('getstatus');

    Route::post('addpresent',[EmployeeController::class,'storeEmployeeAttendance'])->name('addpresent');

    Route::get('report',[EmployeeController::class,'attendanceReport'])->name('report');
    
    Route::post('employee-report',[EmployeeController::class,'getEmployeeReport'])->name('employee-report');
    
    Route::get('employee-report/{id}',[EmployeeController::class,'employeeReportByID']);
    
    Route::post('today-report',[EmployeeController::class,'getTodayReport'])->name('today-report');
    
    Route::post('yesterday-report',[EmployeeController::class,'getYesterdayReport'])->name('yesterday-report');

    Route::post('lastweek-report',[EmployeeController::class,'getLastweekReport'])->name('lastweek-report');

    Route::post('calemployee-salary',[EmployeeController::class,'calEmployeeSalary'])->name('calemployee-salary');

    /* Department */
    
    Route::get('/department',[EmployeeController::class,'getDepartmentData'])->name('department');

    Route::post('/department',[EmployeeController::class,'storeDepartmentData'])->name('create');
    
    Route::get('/delete-department/{id}',[EmployeeController::class,'deleteDepartmentData'])->name('delete-department');
    
    /* Student */

    Route::get('/student',[EmployeeController::class,'getStudentData'])->name('student');

    Route::post('/student',[EmployeeController::class,'storeStudentData'])->name('add');
    
    Route::post('/edit-student',[EmployeeController::class,'editStudentData'])->name('edit-student');
    
    Route::post('/update-student',[EmployeeController::class,'updateStudentData'])->name('update-student');

    Route::get('/delete-student/{id}',[EmployeeController::class,'deleteStudentData'])->name('delete-student');
   
   /* Livewire */

    Route::get('students', StudentCrud::class)->name('students');

    Route::get('counter', Counter::class);

    Route::get('showposts', ShowPosts::class);
    
    /* User */

    Route::get('/user',[EmployeeController::class,'getUserData'])->name('user');

    /* template */
    Route::get('/employee-temp',function(){
        return view('template.employee');
    });

    
});