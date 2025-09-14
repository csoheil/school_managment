<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $fillable = ['name', 'description', 'teacher_id'];

    /**
     * Get the teacher of the class.
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the students enrolled in the class.
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'class_student', 'class_id', 'student_id');
    }

    /**
     * Get the schedules of the class.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }

    /**
     * Get the exams of the class.
     */
    public function exams()
    {
        return $this->hasMany(Exam::class, 'class_id');
    }
}
