<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeQuestion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function quiz()
    {
        return $this->belongsTo(PracticeQuiz::class, 'practice_quiz_id');
    }

    public function sessionQuestions()
    {
        return $this->hasMany(PracticeSessionQuestion::class, 'question_id');
    }
}
