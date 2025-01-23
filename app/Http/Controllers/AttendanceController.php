<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classes;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AttendanceController extends Controller
{
    public function verifyFace(Request $request)
    {
        // Validate the uploaded image
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Send the image to Flask API
        $image = $request->file('image');
        $response = Http::attach(
            'image',
            file_get_contents($image->getRealPath()),
            $image->getClientOriginalName()
        )->post('http://127.0.0.1:5000/verify');

        // if($response->successfull()){
        //     $result = $response->json();
        // }

        
        $result = $response->json();

        if ($result['status'] === 'success') {
            
            $message = $this->markAttendance($result['message']);
            return response()->json(['status' => 'success', 'message' => $message]);
        }

        return response()->json(['status' => 'error', 'message' => $result['message']]);
    }

    private function markAttendance($studentName)
    {
        // Example logic: Find student by name and mark attendance
        // Replace this with your database query and logic
        $currentTime = now();

        // Example: Ensure this is during class time (to implement later)
        // $classSchedule = ... (fetch schedule from DB)

        // Example response
        return "Attendance marked for $studentName at $currentTime.";
    }
}

