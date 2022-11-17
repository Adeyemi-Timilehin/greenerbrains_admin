<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
  /**
     * Set auto-increment to false.
     *
     * @var bool
     */
    // public $incrementing = false;

    protected $table ="post_tags";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'tag_id',
    ];

    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }
    public function tag()
    {
        return $this->belongsTo('App\Tag', 'tag_id');
    }
}
