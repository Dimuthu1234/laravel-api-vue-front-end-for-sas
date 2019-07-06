<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student_records';
    protected $fillable = ['class_room', 'teachers_name', 'student_firstname', 'student_lastname', 'gender', 'joined_year'];
}
