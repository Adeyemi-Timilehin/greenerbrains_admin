<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
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
        'user_id',
        'content_id',
        'notebook_id',
        'title',
        'body',
        'page',
        'device'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function content()
    {
        return $this->belongsTo('App\Content', 'content_id');
    }

    public function notebook()
    {
        return $this->belongsTo('App\User', 'notebook_id');
    }
}
