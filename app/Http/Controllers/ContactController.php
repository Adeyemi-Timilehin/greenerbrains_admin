<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Contact;
use App\Review;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContactController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = Contact::all();
        return $this->sendResponse($contact, "successful");
    }

        /**
     * Fetches all contact message for web view
     *
     * @param   $message  // optional message incase it's called within this class and needs a carry-along message
     * @return \Illuminate\Http\Response
     */
    public function showAll($message = null){
        $reviews = Review::all();
        $messages = Contact::orderBy('created_at', 'desc')->paginate(3);
        // $messages = Contact::all();
        if(isset($message)){
            return view("pages.message.index")
            ->with('reviews', $reviews)
            ->with('contact_messages', $messages)
            ->with('message', $message);
        }

        return view("pages.message.index")
        ->with('reviews', $reviews)
        ->with('contact_messages', $messages)
        ->with('messages', $reviews);
    }

    /**
     * Show a contact message.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $contact_message = Contact::findOrFail($id);
        if (isset($contact_message)) {
            return view('pages.message.view')->with('contact_message', $contact_message);
        } else {
            return back()->with('error', 'Message not found');
        }
    }


    /**
     * Store a newly created contact message
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required|email|min:7',
            'subject' => 'string',
            'body' => 'required|string|min:5',
            'name' => 'required|string|min:3'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $request['id'] = uniqid("gb", false);
        $request['opened'] = false;
        try {
            if($contact = Contact::create($request)){
                return $this->sendResponse($contact, 'Message sent successfully.');
            }
        } catch (Exception $e) {
            return $this->sendError('Unsuccessful', $e);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::where('id','=',$id)->first();

        if (is_null($contact)) {
            return $this->sendError('Contact not found.');
        }
        return $this->sendResponse($contact, 'Contact retrieved successfully.');
    }

    /**
     * Remove a contact message from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::where('id','=',$id)->first();
        if($contact->delete())
        return $this->sendResponse([], 'Contact message deleted successfully.');
    }
}
