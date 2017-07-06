<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Always return the data field as json.
     * 
     * @return json
     */
    public function getDataAttribute()
    {
        return json_decode($this->attributes['data']);
    }
}
