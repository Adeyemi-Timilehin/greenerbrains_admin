<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
  protected $fillable = [
    'qst',
    'ans',
    'group_id',
    'is_published'
  ];

  public function faqGroup()
  {
      return $this->belongsTo('App\FaqGroup', 'group_id');
  }
}
