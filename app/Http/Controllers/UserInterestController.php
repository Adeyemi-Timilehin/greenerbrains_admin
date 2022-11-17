<?php

namespace App\Http\Controllers;

use App\UserInterest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\CommonTrait;
use App\Http\Controllers\API\BaseController as BaseController;

class UserInterestController extends BaseController
{
    use CommonTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interest = UserInterest::all();
        return $this->sendResponse($interest, "successful");
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
            'tag_id' => 'string|required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Check duplicate
        $interest = UserInterest::where([
            ['user_id', '=', $input['user_id']],
            ['tag_id', '=', $input['tag_id']]
        ]);

        $interest = $interest->first();

        if (!isset($interest)) {
            $input['id'] = uniqid("gb", false);
            $newUserInterest = UserInterest::create($input);
            return $this->sendResponse($newUserInterest, 'notebook added successful');
        } else {
            return $this->sendError('User already has a notebook for this content!', [], 403);
        }

        return $this->sendError('There has been a problem!', [], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserInterest  $noteBook
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'subject_id' => 'string|required'
        ]);

        $interest = UserInterest::with(['subject','notes'])
            ->where([
                ['user_id', '=', $request->user_id],
                ['subject_id', '=', $request->subject_id]
            ]);
        $interest = $interest->first();

        if (is_null($interest)) {
            return $this->sendError('Notebook not found.');
        }
        return $this->sendResponse($interest, 'Successful.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserInterest  $noteBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserInterest $noteBook)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'subject_id' => 'string|required',
            'title' => 'string',
            'description' => 'string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $interest = UserInterest::where([['user_id', '=', $input['user_id']], ['subject_id', '=', $input['subject_id']]]);
        $interest = $interest->first();
        
        $interest['title'] = $input['title'] ? $input['title'] : $interest['title'];
        $interest['description'] = $input['description'] ? $input['description'] : $interest['description'];

        $interest->save();
        return $this->sendResponse($interest, 'Notebook updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserInterest  $noteBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserInterest $noteBook)
    {
        $noteBook->delete();

        return $this->sendResponse([], 'Notebook deleted successfully.');
    }
}
