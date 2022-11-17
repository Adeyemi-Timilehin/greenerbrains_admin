<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $title
 * @property string $body
 * @property string $media_id
 * @property string $category
 * @property string $description
 * @property string $published_date
 * @property string $publisher_id
 * @property boolean $is_published
 * @property string $content_type
 * @property string $rating
 * @property string $content_access
 * @property integer $position
 * @property string $subject_id
 * @property string $slug
 * @property string $created_at
 * @property string $updated_at
 * @property User $consumers
 * @property Media $subject
 * @property ContentCategory $contentCategory
 * @property ContentType $contentType
 */
class Content extends Model
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
        'title',
        'body',
        'thumbnail',
        'media_id',
        'category',
        'description',
        'published_date',
        'publisher_id',
        'is_published',
        'content_type',
        'rating',
        'content_access',
        'position',
        'subject_id',
        'slug'
    ];

    protected $with = ['contentCategory', 'subject', 'media', 'contentType'];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function contentCategory()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }

    public function contentType()
    {
        return $this->belongsTo(ContentType::class, 'content_type');
    }

    public function consumers()
    {
        return $this->belongsToMany('App\User', 'user_content');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
