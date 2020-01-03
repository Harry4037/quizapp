<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model {

    public function users() {
        return $this->hasMany('App\Models\User', 'user_type_id');
    }

}
