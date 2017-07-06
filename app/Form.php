<?php

namespace App;

use App\Utilities\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
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
    public $dates = ['published_at', 'deleted_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function($form) {
            $form->uuid = Uuid::generate();
        });
    }

    public function scopePublished($query, $uuid)
    {
        return $query->whereUuid($uuid)->whereNotNull('published_at');
    }

    public function getNameAttribute()
    {
        return ($this->name_display == 'Y') ? $this->attributes['name'] : NULL;
    }
}
