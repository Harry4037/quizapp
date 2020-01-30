<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestSeries extends Model
{
    use SoftDeletes;
    public function subject() {
        return $this->belongsTo('App\Models\Subject', 'subject_id');
    }
    public function exam() {
        return $this->belongsTo('App\Models\Exam', 'exam_id');
    }
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
