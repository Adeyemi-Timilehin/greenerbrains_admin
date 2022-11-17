<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $rating
 * @property string $user_id
 * @property string $message
 * @property string $opened
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class Review extends Model
{
     /**
     * Set auto-increment to false.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = "reviews";

    /**
     * @var array
     */
    protected $fillable = [
      'id',
      'rating',
      'user_id',
      'message',
      'opened',
      'subject_id',
      'name'
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
