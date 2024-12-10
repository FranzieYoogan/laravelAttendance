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
        // Get the current date and month
        $currentDate = date("Y-m-d");
        $currentMonth = date("m", strtotime($currentDate));
        $currentYear = date("Y", strtotime($currentDate)); // Get the current year
        
        // Total number of employees
        $total = DB::table('employee')->count();
        
        // Get the schedule data only for the current month and year using Query Builder
        $employeesMonth = DB::table('scheduleTime')
            ->whereYear('scheduleDate', $currentYear) // Filter by current year
            ->whereMonth('scheduleDate', $currentMonth) // Filter by current month
            ->get(); // Get data for this month only
    
        // Get the count of on-time employees
        $ontime = DB::table('scheduleTime')
                    ->where("scheduleDate", $currentDate)
                    ->where("scheduleOntime", 's')
                    ->count();
    
        // Get the count of late employees
        $late = DB::table('scheduleTime')
                  ->where("scheduleDate", $currentDate)
                  ->where("scheduleOntime", 'n')
                  ->count();
    
        // Log the values to check
        \Log::info('Ontime: ' . $ontime);
        \Log::info('Late: ' . $late);
        
        // Set default values if counts are zero
        if ($ontime == 0 && $late == 0) {
            $ontime = 0;
            $late = 0;
        } elseif ($ontime == 0) {
            $ontime = 0;
        } elseif ($late == 0) {
            $late = 0;
        }
    
        // Log values before returning to view
        \Log::info('Returning to view with: OnTime: ' . $ontime . ', Late: ' . $late);
    
        // Return view with filtered data
        return view('/dashboard', [
            'ontime' => $ontime,
            'late' => $late,
            'total' => $total,
            'allEmployees' => $employeesMonth // Pass the filtered data
        ]);
    }
    
    
    
    
    
    

    public function logout() {

        session()->forget('adminLogin');
        return redirect('/');

    }

}
