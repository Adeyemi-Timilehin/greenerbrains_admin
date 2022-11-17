<?php

namespace App\Http\Controllers;

use App\ContentAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContentAccessController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contentAccess = ContentAccess::all();
        return $this->sendResponse($contentAccess, "successful");
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
            'label' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input['id'] = uniqid("gb", false);
        $input['name'] = Str::slug($input['label']);
        $contentAccess = ContentAccess::create($input);

        return $this->sendResponse($contentAccess, 'Content access created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ContentAccess  $contentAccess
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contentAccess = ContentAccess::where('name','=',$id)->first();

        if (is_null($contentAccess)) {
            return $this->sendError('Content access not found.');
        }
        return $this->sendResponse($contentAccess, 'Content access retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContentAccess  $contentAccess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContentAccess $contentAccess)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'label' => 'min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $contentAccess->save();

        return $this->sendResponse($contentAccess, 'Content access updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContentAccess  $contentAccess
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContentAccess $contentAccess)
    {
        $contentAccess->delete();
        return $this->sendResponse([], 'Content access deleted successfully.');
    }
}
