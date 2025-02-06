<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Classes;
use App\Models\Attendance;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Log;

class AttendanceController extends Controller
{
    public function verifyFace(Request $request)
    {
        // Validate the uploaded image
        $request->validate([
            'image' => 'required',
        ]);

        // Send the image to Flask API
        $imageBase64 = $request->input('image');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://127.0.0.1:5000/verify', [
            'image' => $imageBase64,
        ]);

        $result = $response->json();

        if ($result['status'] === 'success') {
            $message = $this->markAttendance($result['identity']);
            return response()->json(['status' => 'success', 'message' => $message]);
        }

        return response()->json(['status' => 'error', 'message' => $result['message']]);
    }

    private function markAttendance($roll)
    {

        $currentTime = now();
        // $attendance = Attendance::where('student_id', $roll);
        // $class = Classes::where('start_time', '<=', $currentTime->format('H:i:s'))
        //     ->where('end_time', '>=', $currentTime->format('H:i:s'))
        //     ->first();
        
        // if (!$class) {
        //     return "No class is currently in session.";
        // }

        $existingAttendance = Attendance::where('roll_no', $roll)
            ->whereDate('attnd_date_time', $currentTime)
            ->first();

        if ($existingAttendance) {
            return "Attendance already marked for today.";
        }

        Attendance::create([
            'roll_no' => $roll,
        ]);
        

        // Example: Ensure this is during class time (to implement later)
        // $classSchedule = ... (fetch schedule from DB)

        // Example response
        return "Attendance marked for $roll at $currentTime.";
    }

    public function enrollFace(Request $request)
    {
        // Validate the uploaded image
        $request->validate([
            'image' => 'required',
            'roll_no' => 'required',
        ]);



        // Send the image to Flask API
        $imageBase64 = $request->input('image');
        $roll_no = $request->input('roll_no');

        // Verify if the student exists
        // $roll_no = $this->verifyStudent($roll_no);
        // Log::debug('The Roll number is: ' . $roll_no); 

        $enroll = Enrollment::where('roll_no', $roll_no)->first();

        Log::debug('The Roll number is of the student is: ' . $enroll);

        if($enroll) {
            return response()->json(['status' => 'error', 'message' => 'The roll number is already enrolled.']);
        }

        // if($roll_no === null) {
        //     return response()->json(['status' => 'error', 'message' => 'The roll number you entered is not in our record.']);
        // }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post( 'http://127.0.0.1:5000/enroll', [
            'image' => $imageBase64,
            'roll_no' => $roll_no,
        ]);

        $result = $response->json();

        if ($result['status'] === 'success') {
            Enrollment::create([
                'roll_no' => $roll_no,
                'enroll' => 1,
            ]);
            return response()->json(['status' => 'success', 'message' => $result['message']]);
        }

        return response()->json(['status' => 'error', 'message' => $result['message']]);
    }

    private function verifyStudent($roll_no)
    {
        // Example logic: Find student by roll number
        // Replace this with your database query and logic
        $student = Student::where('id', (int)$roll_no)->first();

        Log::debug('The Roll number is of the student is: ' . $roll_no);

        if (!$student) {
            return null;
        }

        return $student->id;
    }

    public function debugStudent()
    {
        // DB::insert("INSERT INTO ADMINS (ID, NAME, EMAIL, PASSWORD, CREATED_AT, UPDATED_AT) 
        //             VALUES (:id, :name, :email, :password, :created_at, :updated_at)", [
        //     'id' => 1, 
        //     'name' => 'Test Admin', 
        //     'email' => 'admin@afmdc.com', 
        //     'password' => bcrypt('afmdc321'), // Hash password
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
    
        $admin = Admin::first();



        if ($admin) {
            return response()->json([
                'status' => 'success',
                'Admin Credentials: ' => $admin,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No admin found.',
            ]);
        }
    }

    

}