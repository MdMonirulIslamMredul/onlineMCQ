<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeQuiz extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(categories::class, 'category_id');
    }

    public function questions()
    {
        return $this->hasMany(PracticeQuestion::class, 'practice_quiz_id');
    }

    public function sessions()
    {
        return $this->hasMany(PracticeSession::class, 'practice_quiz_id');
    }

    public function userSession($userId)
    {
        return $this->hasOne(PracticeSession::class, 'practice_quiz_id')->where('user_id', $userId);
    }
}
