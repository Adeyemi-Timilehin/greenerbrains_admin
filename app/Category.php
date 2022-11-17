<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property string $label
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property Subject $subjects
 * @property Content $contents
 */
class Category extends Model
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
        'label',
        'description',
        'image'
    ];

    protected $with = ['subjects'];

    public function subjects()
    {
        return  $this->hasMany(Subject::class, 'category');
    }

    public function contents()
    {
        return $this->hasMany(Content::class, 'category');
    }
}
