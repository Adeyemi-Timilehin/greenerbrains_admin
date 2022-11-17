<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * Set auto-increment to false.
     *
     * @var bool
     */
     public $incrementing = false;
 
     /**
      * @var array
      */
     protected $fillable = [
         'id',
         'post_id',
         'comment',
         'ip_address',
         'user_id',
         'published'
     ];
     
     public function user()
     {
         return $this->belongsTo('App\User', 'user_id');
     }

     public function post()
     {
         return $this->belongsTo('App\Post', 'post_id');
     }
}
