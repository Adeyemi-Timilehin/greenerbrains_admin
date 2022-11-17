<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * @property string $id
 * @property string $url
 * @property string $thumbnail
 * @property string $created_at
 * @property string $updated_at
 * @property Content $contents
 */
class Media extends Model
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
        'url',
        'thumbnail',
    ];


    public function contents()
    {
        return $this->hasMany(Content::class, 'media_id');
    }

}
