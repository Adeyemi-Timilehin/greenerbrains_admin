<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $user_id
 * @property string $subject_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property Subject $subject
 */
class UserSubject extends Model
{
    // /**
    //  * Set auto-increment to false.
    //  *
    //  * @var bool
    //  */
    // public $incrementing = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'id',
        'user_id',
        'subject_id',
        'status'
    ];

    protected $table ="user_subject";

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }
}
