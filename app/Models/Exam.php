<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function subject(){
    	return $this->hasMany('App\Models\Subject', 'exam_id');
    }
}
