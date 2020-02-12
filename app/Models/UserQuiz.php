<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuiz extends Model
{
    public function user_quiz() {
        return $this->belongsTo('App\Models\Quiz', 'quiz_id');
    }
}
