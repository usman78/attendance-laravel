<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::updateOrCreate(
            ['id' => '1174'], 
            ['name' => 'Asim'] 
        );

        Student::updateOrCreate(
            ['id' => '1175'],
            ['name' => 'Imran'] 
        );

        Student::updateOrCreate(
            ['id' => '1176'], 
            ['name' => 'Trump'] 
        );
    }
}
