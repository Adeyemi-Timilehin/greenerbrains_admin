<?php

namespace App\Http\Controllers;

use App\Rating;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;


class RatingController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rating = Rating::all();
        return $this->sendResponse($rating, "successful");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'content_id' => 'required',
            'value' => 'numeric|min:0'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input['id'] = uniqid("gb", false);
        $rating = Rating::create($input);

        return $this->sendResponse($rating, 'Rating created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rating = Rating::find($id);

        if (is_null($rating)) {
            return $this->sendError('Rating not found.');
        }
        return $this->sendResponse($rating, 'Rating retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'value' => 'numeric|min:0',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $rating->value = $input['value'];
        $rating->save();

        return $this->sendResponse($rating, 'Content rating updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return $this->sendResponse([], 'Rating deleted successfully.');
    }
}
