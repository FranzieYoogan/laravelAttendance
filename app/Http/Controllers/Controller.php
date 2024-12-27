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
    
        // Check if there is any existing schedule with the same name or timein
        $schedules = DB::select("SELECT scheduleName, scheduleTimein, scheduleTimeout FROM scheduletheone");
    
        foreach ($schedules as $schedule) {
            if ($schedule->scheduleName == $name || $schedule->scheduleTimein == $timein && 
            $schedule->scheduleTimeout == $timeout) {
                // If a duplicate is found, return the error message to the view
                return view('addschedule', ['error' => 'Duplicate schedule name or time. Please try again.']);
            }
        }
    
        // Insert the new schedule if no duplicates were found
        DB::insert("INSERT INTO `scheduletheone` (`scheduleName`, `scheduleTimein`, `scheduleTimeout`) 
                    VALUES (?, ?, ?)", [$name, $timein, $timeout]);
    
        // Redirect to the schedule page after successful insertion
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
    
        // Retrieve employees and schedules
        $employees = DB::select("SELECT employeeEmail, employeePassword, employeeTimein FROM employee");
        $schedule = DB::select("SELECT scheduleDate, scheduleEmail FROM scheduleTime");
    
        // Variable to track if a valid match is found
        $isValidEmployee = false;
    
        // Loop through employees to check for valid credentials
        foreach ($employees as $employee) {
            if ($employee->employeeEmail == $email) {
                // If email matches, check password
                if ($employee->employeePassword == $password) {
                    // If email and password are correct, now check the schedule
                    $isValidEmployee = true;
    
                    // Check if the employee has already checked in today
                    foreach ($schedule as $time) {
                        if ($time->scheduleEmail == $email && $time->scheduleDate == $currentDate) {
                            $error2 = true;  // Employee already checked in today
                            return view('/attendancelogin', ['error2' => $error2]);
                        }
                    }
    
                    // Check if the employee is on time or late
                    if ($currentTime <= $employee->employeeTimein) {
                        DB::insert("INSERT INTO scheduleTime (`scheduleOntime`, `scheduleDate`, `scheduleEmail`, `scheduleTIme`) VALUES (?, ?, ?, ?)", ['s', $currentDate, $email, $currentTime]);
                        $registered = true;
                        return view('/attendancelogin', ['registered' => $registered]);
                    } else {
                        DB::insert("INSERT INTO scheduleTime (`scheduleOntime`, `scheduleDate`, `scheduleEmail`, `scheduleTIme`) VALUES (?, ?, ?, ?)", ['n', $currentDate, $email, $currentTime]);
                        $registered = true;
                        return view('/attendancelogin', ['registered' => $registered]);
                    }
                } else {
                    // If the password is incorrect
                    $error = true;
                    return view('/attendancelogin', ['error' => $error]);
                }
            }
        }
    
        // If no matching employee found
        if (!$isValidEmployee) {
            $error = true;  // No employee with that email
            return view('/attendancelogin', ['error' => $error]);
        }
    
        // If we reach here, something went wrong (error handling)
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
            ->paginate(5);
    
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
            'employeesMonth' => $employeesMonth // Pass the filtered data
        ]);
    }

    public function showAttendance() {

        $currentDate = date("Y-m-d");

        $employeesDay = DB::table('scheduleTime')
        ->where('scheduleDate', $currentDate) 
        ->paginate(5); 

        // Get the count of on-time employees
        $ontime = DB::table('scheduleTime')
                    ->where("scheduleDate", $currentDate)
                    ->where("scheduleOntime", 's')
                    ->count();
    
        
        // $late = DB::table('scheduleTime')
        //           ->where("scheduleDate", $currentDate)
        //           ->where("scheduleOntime", 'n')
        //           ->count();
          
        // Set default values if counts are zero
        if ($ontime == 0) {
            $ontime = 0;
      
        }
    
    
    
        // Return view with filtered data
        return view('/attendance', [
            'ontime' => $ontime,
            'employeesDay' => $employeesDay
        ]);


    }
    
    public function showLate() {

        $currentDate = date("Y-m-d");

        $employeesDay = DB::table('scheduleTime')
        ->where('scheduleDate', $currentDate)
        ->where('scheduleOntime','n') 
        ->paginate(5); 

        
        $late = DB::table('scheduleTime')
                   ->where("scheduleDate", $currentDate)
                   ->where("scheduleOntime", 'n')
                   ->count();
          
        // Set default values if counts are zero
        if ($late == 0) {
            $late = 0;
      
        }
    
    
    
        // Return view with filtered data
        return view('/late', [
            'late' => $late,
            'employeesDay' => $employeesDay
        ]);

    }

    public function edit(Request $request) {

        $id = $request->input('id');

        return view('/edit2',['id' => $id]);

    }

    public function edit2(Request $request) {
        // Get inputs from the request
        $id = $request->input('id');
        $name = $request->input('name');
        $timein = $request->input('timein');
        $timeout = $request->input('timeout');
    
        // Fetch all schedules
        $schedules = DB::select("select * from scheduletheone");
    
        // Loop through each schedule to check for duplicates
        foreach ($schedules as $schedule) {
            // Fix the logic in the if condition
            if ($schedule->scheduleName == $name && $schedule->scheduleTimein == $timein && $schedule->scheduleTimeout == $timeout) {
                // If a match is found, return the error
                return view('/edit2', ['error' => 'duplicate values']);
            }
        }
    
        // If no duplicate is found, update the schedule
        DB::update(
            "update scheduletheone set scheduleName = ?, scheduleTimein = ?, scheduleTimeout = ? where scheduleTheOneId = ?",
            [$name, $timein, $timeout, $id]
        );
    
        // Redirect to schedule page
        return redirect('/schedule');
    }

    public function delete(Request $request) {

        $id = $request->input('id');

        DB::delete(`delete from scheduletheone where scheduleTheOneId = '$id' `);

        return view('/schedule');

    }

    public function editEmployee(Request $request) {

        $id = $request->input('id');
        $time = DB::select('select scheduleTimein, scheduleTimeout from scheduletheone');
        return view('editemployee2',['id' => $id, 'time' => $time]);


    }

    public function editEmployee2(Request $request) {

        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $scheduleTimein = $request->input('scheduleTimein');
        $scheduleTimeout = $request->input('scheduleTimeout');
        

        $employees = DB::select("select * from employee");

        foreach ($employees as $employee) {

            if($employee->employeeEmail != $email) {

                DB::update("update employee set employeeName = '$name', employeeEmail = '$email',
                employeePassword = '$password', employeeTimein = '$scheduleTimein', employeeTimeout = '$scheduleTimeout'
                where employeeId = '$id' ");
        
                return redirect('/employees');

            } else {

                return view('editemployee2', ['error' => 'duplicate']);

            }
            
        }
    

    }

    public function deleteEmployees(Request $request) {

        $id = $request->input('id');
        DB::delete(`delete from employee where employeeId = '$id' `);

        return view('/employees');
    }

    public function logout() {

        session()->forget('adminLogin');
        return redirect('/');

    }

}
