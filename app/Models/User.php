<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    protected $fillable = ['name', 'email', 'password', 'role', 'avatar'];

    /**
     * Get the classes the user is enrolled in (for students).
     */
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_student', 'student_id', 'class_id');
    }

    /**
     * Get the classes taught by the user (for teachers).
     */
    public function taughtClasses()
    {
        return $this->hasMany(ClassModel::class, 'teacher_id');
    }

    /**
     * Get the grades of the user.
     */
    public function grades()
    {
        return $this->hasMany(Grade::class, 'user_id');
    }

    /**
     * Get the attendances of the user.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }
}
