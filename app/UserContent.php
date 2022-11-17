<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $user_id
 * @property string $content_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Content $content
 */
class UserContent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content_id',
        'status'
    ];


    protected $table ="user_content";

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}
