<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Additional attributes that should be mutated to dates.
     *
     * @var array
     */
    public $dates = ['published_at'];
}
