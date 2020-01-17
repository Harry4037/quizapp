<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    public function questionDetail(){
		return $this->belongsTo('App\Models\Question', 'question_id');
  }

    public function subjectDetail(){
    return $this->belongsTo('App\Models\Subject', 'subject_id', 'id' );
}
}
