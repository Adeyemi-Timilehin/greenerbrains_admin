<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectCategory extends Model
{
    /**
     * Set auto-increment to false.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table ="subject_category";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject_id',
        'category_id',
    ];

    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }
}
