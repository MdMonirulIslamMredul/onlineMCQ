<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function courseCateory()
    {
        return $this->belongsTo(CourseCategory::class, 'catID', 'id');
    }

    public function courseModules()
    {
        return $this->hasMany(CourseModule::class, 'course_id', 'id');
    }
}
