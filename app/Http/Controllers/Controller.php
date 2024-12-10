<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Controller
{

    public function login(Request $request)
    {
        
        $admin = DB::select("select * from adminuser");

       
        $email = $request->input('email');
        $password = $request->input('password');
    

        $error = false;

        foreach ($admin as $key) {
            
            if ($key->adminLogin == $email && $key->adminPassword == $password) {
                
                session()->put('adminLogin', $key->adminLogin);
                
                
                return redirect('/dashboard');
            }
        }

        
        $error = true;

      
        return view('welcome', ['error' => $error]);
    }

    public function showSchedule() {

        $time = DB::select('select * from scheduletheone');

        return view('/schedule',['time' => $time]);

    }

    public function newEmployees(Request $request) {

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $scheduleTimein = $request->input('scheduleTimein');
        $scheduleTimeout = $request->input('scheduleTimeout');

        DB::insert("insert into employee (`employeeName`,`employeeEmail`,`employeePassword`,
        `employeeTImein`, `employeeTImeout`) 
        values (?, ?,?,?,?)", [$name, $email,$password,$scheduleTimein,$scheduleTimeout]);

        return redirect('/employees');

    }

    public function getTImes() {

        $time = DB::select('select * from scheduletheone');

        return view('/addemployees',['time' => $time]);

    }


    public function showEmployees() {

        $employees = DB::select('select * from employee');

        return view('/employees',['employees' => $employees]);

    }

    public function newSchedule(Request $request) {

        $name = $request->input('name');
        $timein = $request->input('timein');
        $timeout = $request->input('timeout');

        DB::insert("INSERT INTO `scheduletheone` (`scheduleName`, `scheduleTimein`, `scheduleTimeout`) 
                VALUES (?, ?, ?)", [$name, $timein, $timeout]);

        return redirect('/schedule');

    }

    public function attendanceLogin(Request $request) {

        $email = $request->input('email');
        $password = $request->input('password');
        $currentTime = date("H:i:s");
        $currentDate = date("Y-m-d");
        $error = "";
        $error2 = "";
        $registered = "";
    
        // Correct the SQL query
        $employees = DB::select("SELECT employeeEmail, employeePassword, employeeTimein FROM employee");
        $schedule = DB::select("SELECT scheduleDate, scheduleEmail FROM scheduleTime");
    
        // Iterate through the schedule
        foreach ($schedule as $time) {
            if ($time->scheduleEmail == $email && $time->scheduleDate != $currentDate) {
                // Now we loop through employees to check credentials
                foreach ($employees as $employee) {
        
                    // Check if email and password match
                    if ($employee->employeeEmail != $email || $employee->employeePassword != $password) {
                        $error = true;
                        return view('/attendancelogin', ['error' => $error]);
                    } else {
                        // Check if the employee's email and password match and if they are on time
                        if ($employee->employeeEmail == $email && $employee->employeePassword == $password && $currentTime <= $employee->employeeTimein) {
                            DB::insert("INSERT INTO scheduleTime (`scheduleOntime`, `scheduleDate`, `scheduleEmail`, `scheduleTIme`) VALUES (?, ?, ?, ?)", ['s', $currentDate, $email, $currentTime]);
                            $registered = true;
                            return view('/attendancelogin', ['registered' => $registered]);
                        } else if ($employee->employeeEmail == $email && $employee->employeePassword == $password && $currentTime > $employee->employeeTimein) {
                            DB::insert("INSERT INTO scheduleTime (`scheduleOntime`, `scheduleDate`, `scheduleEmail`, `scheduleTIme`) VALUES (?, ?, ?, ?)", ['n', $currentDate, $email, $currentTime]);
                            $registered = true;
                            return view('/attendancelogin', ['registered' => $registered]);
                        }
                    }
                }
            }
        }
    
        // If we reach here, either the employee didn't match or some other issue
        $error2 = true;
        return view('/attendancelogin', ['error2' => $error2]);
    }

    public function showGraph() {
        $currentDate = date("Y-m-d");
        $total = DB::table('employee')->count();

        $ontime = DB::table('scheduleTime')
                    ->where("scheduleDate", $currentDate)
                    ->where("scheduleOntime", 's')
                    ->count();
    
        $late = DB::table('scheduleTime')
                  ->where("scheduleDate", $currentDate)
                  ->where("scheduleOntime", 'n')
                  ->count();
    
        // Debugging: Log values to check
        \Log::info('Ontime: ' . $ontime);
        \Log::info('Late: ' . $late);
    
        if ($ontime == 0 && $late == 0) {
            $ontime = 0;
            $late = 0;
        } elseif ($ontime == 0) {
            $ontime = 0;
        } elseif ($late == 0) {
            $late = 0;
        }
    
        // Debugging: Log again before returning the view
        \Log::info('Returning to view with: OnTime: ' . $ontime . ', Late: ' . $late);
    
        return view('/dashboard', ['ontime' => $ontime, 'late' => $late,'total' => $total]);
    }
    
    
    
    

    public function logout() {

        session()->forget('adminLogin');
        return redirect('/');

    }

}
