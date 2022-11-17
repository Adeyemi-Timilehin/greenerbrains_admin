<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /**
     * Set auto-increment to false.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'rating',
        'body',
        'image',
        'verified',
        'email'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
