<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $name
 * @property string $email
 * @property string $status
 * @property string $type
 * @property string $provider
 * @property string $created_at
 * @property string $updated_at
 * @property Subject $subscribed_subjects
 * @property UserSubscribed $subscribed_content
 * @property Content $consumed_contents
 */
class User extends Authenticatable implements JWTSubject
{
  use Notifiable;

  // protected $fillable = [
  //     'name', 'email', 'password',
  // ];

  // protected $hidden = [
  //     'password', 'remember_token',
  // ];

  protected $fillable = [
    'name',
    'email',
    'password',
    'gender',
    'country',
    'image',
    'status',
    'type',
    'created_at',
    'updated_at',
    'provider',
    'provider_id',
    'token',
    'verified'
  ];

  protected $hidden = ['password', 'deleted_at', 'remember_token', 'token', 'api_token', 'email_verified_at', 'id'];

  protected $with = ['subscribed_subjects', 'roles', 'interests'];

  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  public function getJWTCustomClaims()
  {
    return [];
  }

  public function canAccessSubject($id = null)
  {
    if (!isset($id) || !isset($this->subscribed_subjects)) {
      return false;
    }
    foreach ($this->subscribed_subjects as $key => $subject) {
      if ($subject->id === $id) return true;
    }
    return false;
  }

  public function canAccessContent($id = null)
  {
    if (!isset($id) || !isset($this->subscribed_contents)) {
      return false;
    }
    foreach ($this->subscribed_contents as $key => $content) {
      if ($content->id === $id) return true;
    }
    return false;
  }

  public function subscribed_contents()
  {
    return $this->hasMany('App\UserSubscribed', 'user_id');
  }

  public function subscribed_subjects()
  {
    return $this->belongsToMany('App\Subject', 'user_subject');
  }

  public function consumed_contents()
  {
    return $this->belongsToMany('App\Content', 'user_content');
  }

  public function identities()
  {
    return $this->hasMany('App\SocialIdentity');
  }

  public function notebooks()
  {
    return $this->hasMany('App\NoteBook', 'user_id');
  }

  public function interests()
  {
    return $this->belongsToMany('App\Tag', 'user_interests', 'user_id', 'tag_id');
  }

  public function comments()
  {
      return $this->hasMany('App\Comment', 'user_id');
  }

  public function roles()
  {
    return $this->belongsToMany('App\Role', 'user_roles', 'user_id', 'role_id');
  }

  public function posts()
  {
      return $this->hasMany('App\Post', 'user_id');
  }

  public function payments()
  {
      return $this->hasMany('App\Payment', 'user_id');
  }

  ////////////////////////////////////////////////////////////////


  // checks whether a user has a certain role
  public function hasRole($role_name)
  {
    if (!isset($role_name) || !isset($this->roles)) {
      return false;
    }

    // if array was passed as argument
    if (gettype($role_name) === 'array') {
      // check for multiple role
      foreach ($this->roles as $key => $role) {
        foreach ($role_name as $key => $name) {
          if ($name === $role->name) return true;
        }
      }
    } else { // if string was passed as argument
      foreach ($this->roles as $key => $role) {
        if ($role->name === $role_name) return true;
      }
    }
    return false;
  }
}
