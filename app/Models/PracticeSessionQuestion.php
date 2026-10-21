<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticeSessionQuestion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dates = ['last_answered_at'];

    public function session()
    {
        return $this->belongsTo(PracticeSession::class, 'session_id');
    }

    public function question()
    {
        return $this->belongsTo(PracticeQuestion::class, 'question_id');
    }
}
