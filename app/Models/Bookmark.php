<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    public function testseriesDetail(){
		return $this->belongsTo('App\Models\TestSeries', 'test_series_id')->withTrashed();
  }
  public function usertestseriesDetail(){
    return $this->belongsTo('App\Models\UserTestSeries', 'user_test_series_id')->withTrashed();
}

}
