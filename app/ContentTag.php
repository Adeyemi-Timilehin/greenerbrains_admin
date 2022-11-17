<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentTag extends Model
{
    /**
     * Set auto-increment to false.
     *
     * @var bool
     */
    // public $incrementing = false;

    protected $table ="content_tag";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_id',
        'tag_id',
    ];

    public function content()
    {
        return $this->belongsTo('App\Content', 'content_id');
    }
    public function tag()
    {
        return $this->belongsTo('App\Tag', 'tag_id');
    }
}
