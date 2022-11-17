<?php

namespace App\Http\Controllers;

use App\ContentType;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ContentTypeController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contentType = ContentType::all();
        return $this->sendResponse($contentType, "successful");
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
        $contentType = ContentType::create($input);

        return $this->sendResponse($contentType, 'Content type created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ContentType  $contentType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contentType = ContentType::where('name','=',$id)->first();

        if (is_null($contentType)) {
            return $this->sendError('Content type not found.');
        }
        return $this->sendResponse($contentType, 'Content type retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContentType  $contentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContentType $contentType)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'label' => 'min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $contentType->save();

        return $this->sendResponse($contentType, 'Content type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContentType  $contentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContentType $contentType)
    {
        $contentType->delete();
        return $this->sendResponse([], 'Content type deleted successfully.');
    }
}
