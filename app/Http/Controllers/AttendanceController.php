<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classes;
use App\Models\Attendance;
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

        Attendance::create([
            'student_id' => $roll,
            'class_id' => 3,
            'timestamp' => $currentTime,
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
        $roll_no = $this->verifyStudent($roll_no);
        // Log::debug('The Roll number is: ' . $roll_no); 

        if($roll_no === null) {
            return response()->json(['status' => 'error', 'message' => 'The roll number you entered is not in our record.']);
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post( 'http://127.0.0.1:5000/enroll', [
            'image' => $imageBase64,
            'roll_no' => $roll_no,
        ]);

        $result = $response->json();

        if ($result['status'] === 'success') {
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
        // Fetch a student record for debugging
        // $student = Student::first();
        $student = Student::where('id', 1171)->first();



        if ($student) {
            return response()->json([
                'status' => 'success',
                'student roll' => $student->id,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'No student found.',
            ]);
        }
    }

    

}