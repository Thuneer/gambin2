<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{


    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function user1()
    {
        return $this->belongsTo('App\User', 'user_id_1');
    }

    public function user2()
    {
        return $this->belongsTo('App\User', 'user_id_2');
    }
}
