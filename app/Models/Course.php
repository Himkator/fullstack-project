<?php

namespace App\Models;

use ApiPlatform\Metadata\ApiResource;
use Illuminate\Database\Eloquent\Model;

#[ApiResource]
class Course extends Model
{
    protected $fillable = ['title', 'level', 'description', 'price', 'file_path', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function enrollments() {
        return $this->hasMany(Enrollment::class);
    }

    public function students() {
        return $this->belongsToMany(User::class, 'enrollments')
                    ->withTimestamps();
    }
}
