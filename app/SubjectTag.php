<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectTag extends Model
{
    /**
     * Set auto-increment to false.
     *
     * @var bool
     */
    // public $incrementing = false;

    protected $table ="subject_tag";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject_id',
        'tag_id',
    ];

    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }
    public function tag()
    {
        return $this->belongsTo('App\Tag', 'tag_id');
    }
}
