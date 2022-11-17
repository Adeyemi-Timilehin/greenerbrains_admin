<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqGroup extends Model
{
  protected $fillable = [
    'label',
    'name',
    'description',
    'is_published'
  ];

  public function faqs()
  {
      return $this->hasMany('App\Faq', 'group_id');
  }
}
