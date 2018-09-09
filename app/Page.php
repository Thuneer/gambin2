<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Kalnoy\Nestedset\NodeTrait;

class Page extends Model
{
    use Sluggable, NodeTrait {
        NodeTrait::replicate insteadof Sluggable;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'permalink' => [
                'source' => 'title'
            ]
        ];
    }


}
