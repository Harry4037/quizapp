<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function testseries() {
        return $this->belongsTo('App\Models\TestSeries', 'test_series_id');
    }

    public function usertestseries() {
        return $this->belongsTo('App\Models\UserTestSeries', 'user_test_series_id');
    }
}
