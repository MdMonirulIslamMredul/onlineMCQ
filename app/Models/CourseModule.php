<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'link', 'free_paid']; // Add this line to enable mass assignment

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public static function updateModule($titles, $links, $free_paid, $courseId)
    {
        // Delete existing modules that are not in the submitted data
        $existingModules = CourseModule::where('course_id', $courseId)->get();
        $submittedTitles = $titles;

        foreach ($existingModules as $module) {
            if (!in_array($module->title, $submittedTitles)) {
                $module->delete(); // Delete module if it's not in the submitted data
            }
        }

        // Create or update modules based on the submitted data
        self::newModule($titles, $links, $free_paid, $courseId);
    }

    public static function newModule($titles, $links, $free_paid, $courseId)
    {
        if (is_array($titles) && is_array($links) && is_array($free_paid)) {
            foreach ($titles as $key => $title) {
                // Ensure necessary keys exist in $links and $free_paid arrays
                if (isset($links[$key]) && isset($free_paid[$key])) {
                    $module = CourseModule::where('course_id', $courseId)
                                          ->where('title', $title)
                                          ->first();

                    if ($module) {
                        // Update existing module
                        $module->link = $links[$key];
                        $module->free_paid = $free_paid[$key];
                        $module->save();
                    } else {
                        // Create new module
                        CourseModule::create([
                            'course_id' => $courseId,
                            'title' => $title,
                            'link' => $links[$key],
                            'free_paid' => $free_paid[$key],
                        ]);
                    }
                }
            }
        }
    }
}
