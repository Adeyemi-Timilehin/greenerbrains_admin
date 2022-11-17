<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Contact;
use App\Review;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReviewController extends BaseController
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $review = Review::all();
        return $this->sendResponse($review, "successful");
    }

        /**
     * Fetches all review message for web view
     *
     * @param   $message  // optional message incase it's called within this class and needs a carry-along message
     * @return \Illuminate\Http\Response
     */
    public function showAll($message = null){
        $reviews = Review::orderBy('created_at', 'desc')->paginate(5);
        $messages = Contact::all();
        if(isset($message)){
            return view("pages.review.index")
            ->with('reviews', $reviews)
            ->with('contact_messages', $messages)
            ->with('message', $message);
        }

        return view("pages.review.index")
        ->with('reviews', $reviews)
        ->with('contact_messages', $messages)
        ->with('messages', $reviews);
    }

    /**
     * Show a review message.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $review_message = Review::findOrFail($id);
        if (isset($review_message)) {
            return view('pages.review.view')->with('review', $review_message);
        } else {
            return back()->with('error', 'Review item not found');
        }
    }


    /**
     * Store a newly created review message
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'rating' => 'required|integer',
            'user_id' => 'string',
            'message' => 'string|min:5',
            'name' => 'required|string|min:5'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $request['id'] = uniqid("gb", false);
        $request['opened'] = false;
        try {
            if($review = Review::create($request->all())){
                return $this->sendResponse($review, 'successful');
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
        $review = Review::where('id','=',$id)->first();

        if (is_null($review)) {
            return $this->sendError('Review not found.');
        }
        return $this->sendResponse($review, 'Review retrieved successfully.');
    }

    /**
     * Remove a review message from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = Review::where('id','=',$id)->first();
        if($review->delete())
        return $this->sendResponse([], 'Review message deleted successfully.');
    }
}
