<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeSession extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = ['completed_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quiz()
    {
        return $this->belongsTo(PracticeQuiz::class, 'practice_quiz_id');
    }

    public function sessionQuestions()
    {
        return $this->hasMany(PracticeSessionQuestion::class, 'session_id');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function getProgressPercentAttribute()
    {
        if ($this->total_questions == 0) {
            return 0;
        }
        return min(100, round(($this->mastered_questions / $this->total_questions) * 100));
    }
}
