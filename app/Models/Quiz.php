<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model {

    public function questions() {
        return $this->hasMany('App\Models\Question', 'quiz_id');
    }

}
