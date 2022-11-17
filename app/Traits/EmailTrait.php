<?php
namespace App\Traits;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

trait EmailTrait {

    public function customSendEmail($data = [], $template){
        // Check that data array is not empty
        if(!count($data)) {
            return false;
        }

        // attempt sending an email
        try {
            $to_name = $data['to_name'] ? $data['to_name'] : null;
            $to_email = $data['to_email'] ? $data['to_email'] : null;
            $data = $data;
            Mail::send('emails.'. $template, $data, function($message) use ($to_name, $to_email, $data) {
                $message->to($to_email, $to_name)->subject($data['subject']);
                $message->from($data['from_email'],$data['from_name']);
            });
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }
}
