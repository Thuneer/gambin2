<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user() {

        return $this->belongsTo('App\User');

    }
    public function images()
    {
        return $this->morphToMany('App\Media', 'mediable');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

}
