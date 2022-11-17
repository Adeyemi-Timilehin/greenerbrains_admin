<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * @property string $id
 * @property string $subject
 * @property string $email
 * @property string $message
 * @property string $ip_address
 * @property string $opened
 * @property string $created_at
 * @property string $updated_at
 */
class Contact extends Model
{
    /**
     * Set auto-increment to false.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = "messages";

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'subject',
        'email',
        'body',
        'name',
        'ip_address'
    ];


    public static function create(Request $request) {
        $contact = new Contact();

        $contact->id = $request->get('id');
        $contact->subject = $request->get("subject") ? $request->get("subject") : "";
        $contact->email = $request->get('email');
        $contact->name = $request->get('name');
        $contact->body = $request->get('body');
        $contact->ip_address = $request->ip();

        $contact->save();

        return $contact;

    }


    public static function deleteOne(Request $request) {
        Contact::where('id',$request->get('id'))->delete();
    }

    public static function readAll(Request $request) {
        return Contact::where('user_id',$request->User()->id)->get();
    }
}
