<?php

namespace App\Http\Controllers;

use App\UserSubscribed;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class UserSubscribedController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userSubscribed = UserSubscribed::all();
        return $this->sendResponse($userSubscribed, "successful");
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
            'content_id' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input['id'] = uniqid("gb", false);
        $userSubscribed = UserSubscribed::create($input);

        return $this->sendResponse($userSubscribed, 'User suscription created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserSubscribed  $userSubscribed
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userSubscribed = UserSubscribed::find($id);

        if (is_null($userSubscribed)) {
            return $this->sendError('User subscription not found.');
        }
        return $this->sendResponse($userSubscribed, 'User subscription retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserSubscribed  $userSubscribed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserSubscribed $userSubscribed)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'min:1',
            'content_id' => 'min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $userSubscribed->save();

        return $this->sendResponse($userSubscribed, 'Content subscription updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserSubscribed  $userSubscribed
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSubscribed $userSubscribed)
    {
        $userSubscribed->delete();
        return $this->sendResponse([], 'Subscription deleted successfully.');
    }
}
