<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property string $label
 * @property string $created_at
 * @property string $updated_at
 * @property Content $contents
 * @property Subject $subjects
 */
class Tag extends Model
{
    // /**
    //  * Set auto-increment to false.
    //  *
    //  * @var bool
    //  */
    public $incrementing = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'label',
    ];

    // protected $with = ['contents', 'subjects'];

    public function contents()
    {
        return $this->belongsToMany('App\Content');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Subject');
    }
}
