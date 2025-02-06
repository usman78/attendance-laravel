<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['roll_no'];

    protected $table = 'online_attendence';
    protected $primaryKey  = 'online_id';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'int';
    // public function student(){
    //     return $this->belongsTo(Student::class);
    // }

    // public function class(){
    //     return $this->belongsTo(Classes::class);
    // }
}
