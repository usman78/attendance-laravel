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
            ['id' => '1177'], 
            ['name' => 'Tashif'] 
        );

        Student::updateOrCreate(
            ['id' => '1178'],
            ['name' => 'Imran Khan'] 
        );

        Student::updateOrCreate(
            ['id' => '1179'], 
            ['name' => 'Raza'] 
        );
        Student::updateOrCreate(
            ['id' => '1180'], 
            ['name' => 'Faizan'] 
        );

        Student::updateOrCreate(
            ['id' => '1181'],
            ['name' => 'Bilal'] 
        );

        Student::updateOrCreate(
            ['id' => '1182'], 
            ['name' => 'Ali'] 
        );
    }
}
