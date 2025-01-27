<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classes;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classes::updateOrCreate( // Search for this id
            ['name' => 'Mathematics', 'start_time' => '2023-10-26 14:30:15', 'end_time' => '2025-10-26 16:30:15'],
        );
        Classes::updateOrCreate( // Search for this id
            ['name' => 'Biology', 'start_time' => '2023-10-26 10:30:15', 'end_time' => '2025-10-26 12:30:15'],
        );
        Classes::updateOrCreate( // Search for this id
            ['name' => 'Biochemistry', 'start_time' => '2023-10-26 09:30:15', 'end_time' => '2025-10-26 16:30:15'],
        );
    }
}
