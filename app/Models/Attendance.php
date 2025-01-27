<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['student_id', 'class_id', 'timestamp'];

    protected $table = 'attendance';
    // public function student(){
    //     return $this->belongsTo(Student::class);
    // }

    // public function class(){
    //     return $this->belongsTo(Classes::class);
    // }
}
