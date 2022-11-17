<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\CommonTrait;
use App\Traits\FileUploadTrait;

class MediaController extends BaseController
{
    use CommonTrait, FileUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Show all media from the database and return to view
        $media = Media::all();
        return $this->sendResponse($media, "successful");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $media = Media::find($id)->with(['contents'])->get();

        if (is_null($media)) {
            return $this->sendError('Media not found.');
        }
        return $this->sendResponse($media, 'Media retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        return response()->json("Unknown resource", 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        $media->delete();

        return $this->sendResponse([], 'Media deleted successfully.');
    }
}
