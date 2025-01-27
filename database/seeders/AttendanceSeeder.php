<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attendance;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example logic: Seed attendance for a student
        // Replace this with your database query and logic

        // $student = Student::where('name', 'John Doe')->first();
        // $class = Classes::where('name', 'Mathematics')->first();

        Attendance::create([
            'student_id' => 1171,
            'class_id' => 2,
            'timestamp' => now(),
        ]);
    }
}
