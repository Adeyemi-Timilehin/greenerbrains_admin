<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
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
        'category_id'
    ];

    public function category()
    {
        return null; //$this->belongsTo(Category::class, 'category_id');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class, 'sub_category_id');
    }
}
