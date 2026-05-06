<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


#[ApiResource]
class User extends Model {
    use HasRoles;

    protected $fillable = ['login', 'email', 'password'];

    public function courses() {
        return $this->hasMany(Course::class);
    }

    public function enrollments() {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledCourses() {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withTimestamps();
    }
}