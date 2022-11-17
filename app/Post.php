<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
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
      'title',
      'slug',
      'body',
      'image',
      'publish_date',
      'status',
      'user_id',
      'verfied',
      'likes',
      'views'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'post_tags', 'post_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id');
    }
}
