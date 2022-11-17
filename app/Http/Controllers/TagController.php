<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\CommonTrait;

class TagController extends BaseController
{
    use CommonTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tag = Tag::all();
        return $this->sendResponse($tag, "successful");
    }

    public function showAll($message = null)
    {
        $tags = Tag::all();
        if (isset($tags)) {
            if(isset($message)){
            return view('pages.tag.index', compact('tags','message'));
            }
            return view('pages.tag.index', compact('tags'));
        } else {
            return redirect()-> back()
                ->with('error', 'Content not found');
        }
    }

    public function create()
    {
        return view('pages.tag.create');
    }

    public function edit($id, Request $request)
    {
        if($request->label){
            $validator = Validator::make($request->all(), [
                'label' => 'required|string',
               ]);

            if ($validator->fails()) {
                return redirect()-> back()
                    ->with('error', $validator->errors());
            }

            $tag = Tag::findOrfail($request->id);
            $tag->name = Str::slug($request->label);
            $tag->label = $request->label;

            $tag->save();
            if (isset($tag)) {
                return view('pages.tag.edit', compact('tag'))->with('success', 'update successful');
            } else {
                return redirect()-> back()
                    ->with('error', 'Content not found');
            }
        }


        $tag = Tag::where("id", "=", $id)->first();
        if (isset($tag)) {
            return view('pages.tag.edit', compact('tag'));
        } else {
            return redirect()-> back()
                ->with('error', 'Content not found');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addNew(Request $request)
    {
        $input = $request->all();
        $duplicate = Tag::where('name','=',Str::slug($input['label']))->first();
        $validator = Validator::make($input, [
            'label' => 'required|string'
        ]);

        if(isset($duplicate)){
            return redirect()-> back()
                ->with('error', "Duplicate tag <strong>' $request->label '</strong> not supported. <br> You may consider changing tag name or ignore if this was unintentional!");
        }
        if ($validator->fails()) {
            return redirect()-> back()
                ->with('error', $validator->errors());
        }

        $input['id'] = uniqid("gb", false);
        $input['name'] = Str::slug($input['label']);
        $input['label'] = $input['label'];

        $success = "Tag added successfully";

        try {
          $tag = Tag::create($input);
          
          if (isset($tag)) {
            return redirect()->back()->with('success', "$tag->label tag added successful");
          } else {
            return redirect()->back()->with('error', "Failed to add new tag <strong>$request->label</strong> !");
          }
        } catch (\Throwable $th) {
          return redirect()->back()->with('error', 'Error occured while attempting to add new tag!');
        }

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
            'label' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input['id'] = uniqid("gb", false);
        $input['name'] = Str::slug($input['label']);
        $input['label'] = $input['label'];
        

        try {
          $tag = Tag::create($input);
          
          if (isset($tag)) {
            return view('pages.tag.index')->with('success', "$tag->label tag added successful");
          } else {
            return redirect()->back()->with('error', "Failed to add new tag <strong>$request->label</strong> !");
          }
        } catch (\Throwable $th) {
          return redirect()->back()->with('error', 'Error occured while attempting to add new tag!');
        }
    }

    public function view($id)
    {
        $tag = Tag::findOrFail($id);
        if (isset($tags)) {
            return view('pages.tag.view', compact('tag'));
        } else {
            return redirect()-> back()
                ->with('error', 'tag not found');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Tag::all()->where('name', '=', $id)->first();

        if (is_null($tag)) {
            return $this->sendError('Tag not found.');
        }
        return $this->sendResponse($tag, 'Successful.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function updateTag(Request $request, Tag $tag)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'label' => 'required',
        ]);

        if ($validator->fails()) {
          return redirect()->back()->with('error', $validator->errors());
        }

        $tag->name = Str::slug($input['label']);
        $tag->label = $input['label'];
        try {
          $tag->save();
          if (isset($tag)) {
            return redirect()->back()->with('success', "$tag->label tag update successful");
          } else {
            return redirect()->back()->with('error', 'Tag update failed!');
          }
        } catch (\Throwable $th) {
          return redirect()->back()->with('error', 'Update failed!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'label' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $tag->name = Str::slug($input['label']);
        $tag->label = $input['label'];
        $tag->save();

        return $this->sendResponse($tag, 'Tag updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Tag $tag)
    // {
    //     $tag->delete();

    //     return $this->sendResponse([], 'Tag deleted successfully.');
    // }

    public function delete($id)
    {
        $tag = Tag::where("id", "=", $id)->first();
        $label = $tag->label ? $tag->label : '';
        if ($tag->delete()) {
            return redirect()-> back()
                ->with('success', " '$label' tag deleted successfully");
        } else {
            return redirect()-> back()
                ->with('error', "failed to delete '$label' tag!");
        }
    }
}
