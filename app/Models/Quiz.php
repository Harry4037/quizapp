<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model {

    use SoftDeletes;

    public function questions() {
        return $this->hasMany('App\Models\Question', 'quiz_id');
    }

}
