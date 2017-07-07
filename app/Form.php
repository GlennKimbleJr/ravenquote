<?php

namespace App;

use App\FormField;
use App\FormSubmission;
use App\User;
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

    /**
     * Define an inverse one-to-one or many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fields()
    {
        return $this->hasMany(FormField::class);
    }

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submissions()
    {
        return $this->hasMany(FormSubmission::class);
    }
}
