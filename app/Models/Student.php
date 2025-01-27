<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $connection = 'oracle';
    protected $table = 'students';
    public function classes(){
        return $this->belongsToMany(Classes::class);
    }
}
