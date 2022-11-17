<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class NewsEmail extends Model
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
    'email',
    'ip_address',
    'status'
  ];

  public static function create(Request $request)
  {
    $contact = new NewsEmail();

    $contact->id = $request->get('id') ? $request->get('id') : uniqid('gb', false);
    $contact->email = $request->get('email');
    $contact->status = $request->get('status') || 'activated';
    $contact->ip_address = $request->ip();

    $contact->save();

    return $contact;
  }


  public static function deleteOne(Request $request)
  {
    NewsEmail::where('id', $request->get('id'))->delete();
  }


  public static function deActivate(Request $request)
  {
    $contact = NewsEmail::where('id', $request->get('id'))->first();
    if (isset($contact)) {
      $contact->status = 'deactivated';
      $contact->save();
    }
  }


  public static function reActivate(Request $request)
  {
    $contact = NewsEmail::where('id', $request->get('id'))->first();
    if (isset($contact)) {
      $contact->status = 'activated';
      $contact->save();
    }
  }

  public static function readAll(Request $request)
  {
    return NewsEmail::where('email', $request->User()->email)->get();
  }
}
