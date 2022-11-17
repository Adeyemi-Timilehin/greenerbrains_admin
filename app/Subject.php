<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/**
 * @property string $id
 * @property string $name
 * @property string $label
 * @property string $rating
 * @property string $access
 * @property string $description
 * @property string $category
 * @property string $created_at
 * @property string $updated_at
 * @property Category $category
 * @property Content $contents
 * @property Tag $tags
 * @property ContentAccess $access
 */
class Subject extends Model
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
    'label',
    'rating',
    'access',
    'description',
    'category',
    'thumbnail',
    'likes',
    'title',
    'summary',
    'language',
    'views',
    'price',
    'preview_video',
    'publisher_id'
  ];


  protected $with = ['tags'];

  public function category()
  {
    return $this->belongsTo(Category::class, 'category', 'id');
  }

  public function categories()
  {
    return $this->belongsToMany('App\Category', 'subject_category', 'subject_id', 'category_id');
  }

  public function contents()
  {
    return $this->hasMany(Content::class, 'subject_id');
  }

  public function tags()
  {
    return $this->belongsToMany(Tag::class);
  }

  public function access()
  {
    return $this->belongsTo('App\ContentAccess', 'access', 'id');
  }

  public function reviews()
  {
      return $this->hasMany(Review::class, 'subject_id');
  }

  public function publisher()
  {
      return $this->belongsTo('App\User', 'publisher_id');
  }

  public function is_free()
  {
    if (isset($this->access)) {
      return $this->access['name'] === 'free' ? true : false;
    }
    return false;
  }

}
