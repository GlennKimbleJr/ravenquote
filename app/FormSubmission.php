<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormSubmission extends Model
{
    use SoftDeletes;

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
    public $dates = ['read_at', 'deleted_at'];

    /**
     * Always return the data field as json.
     * 
     * @return json
     */
    public function getDataAttribute()
    {
        return json_decode($this->attributes['data']);
    }

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
