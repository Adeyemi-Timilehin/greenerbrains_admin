<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
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
        'subject_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }

}
