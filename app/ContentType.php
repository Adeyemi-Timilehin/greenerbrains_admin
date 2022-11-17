<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
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
        'label'
    ];
}
