<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $user_id
 * @property string $content_id
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Content $content
 */
class UserSubscribed extends Model
{
    /**
     * Set auto-increment to false.
     *
     * @var bool
     */
    // public $incrementing = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function content()
    {
        return $this->belongsTo('App\Content', 'content_id');
    }
}
