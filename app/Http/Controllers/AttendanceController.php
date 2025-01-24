<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Classes;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

    public function enrollFace(Request $request)
    {
        // Validate the uploaded image
        $request->validate([
            'image' => 'required',
            'name' => 'required',
        ]);

        // Send the image to Flask API
        $imageBase64 = $request->input('image');
        $name = $request->input('name');
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('http://127.0.0.1:5000/enroll', [
            'image' => $imageBase64,
            'name' => $name,
        ]);

        $result = $response->json();

        if ($result['status'] === 'success') {
            return response()->json(['status' => 'success', 'message' => $result['message']]);
        }

        return response()->json(['status' => 'error', 'message' => $result['message']]);
    }

}