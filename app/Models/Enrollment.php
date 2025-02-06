<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = ['roll_no', 'enroll'];

    protected $table = 'online_enrollment';
    protected $primaryKey  = 'roll_no';

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
