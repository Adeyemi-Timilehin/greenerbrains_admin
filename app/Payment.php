<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
      'subject_id',
      'user_id',
      'payment_id',
      'status',
      'reference',
      'channel',
      'currency',
      'amount',
      'domain',
      'paid_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }
}
