<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteBook extends Model
{
    /**
     * Set auto-increment to false.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = 'notebooks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'subject_id',
        'title',
        'description'
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