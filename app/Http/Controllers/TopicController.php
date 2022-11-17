<?php

namespace App\Http\Controllers;

use App\Category;
use App\ContentAccess;
use App\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\SubCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\CommonTrait;

class TopicController extends BaseController
{
    use CommonTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Show all employees from the database and return to view
        $topic = Topic::all();
        return $this->sendResponse($topic, "successful");
    }
    public function showAll()
    {
        $topics = Topic::all();
        if (isset($topics)) {
            return view('pages.topic.index', compact('topics'));
        } else {
            return back()
                ->with('error', 'Content not found');
        }
    }

    public function create()
    {
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $accesses = ContentAccess::all();

        if (isset($categories)) {
            return view('pages.topic.create', compact('categories', 'sub_categories', 'accesses'));
        } else {
            return back()
                ->with('error', 'Content not found');
        }
    }

    public function edit($id, Request $request)
    {
        
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $accesses = ContentAccess::all();
        
        if($request->label){
            $validator = Validator::make($request->all(), [
            'label' => 'required|string',
            'sub_category' => 'string',
            'category' => 'string'
        ]);

        if ($validator->fails()) {
            return back()
                ->with('error', $validator->errors());
        }
        // return response($request->all());
        $topic = Topic::findOrfail($request->id);
        $topic->name = Str::slug($request->label);
        $topic->label = $request->label;
        $topic->sub_category = $request->sub_category;
        $topic->category = $request->category;

        $topic->save();
        if (isset($topic)) {
            return view('pages.topic.edit', compact('categories', 'topic', 'sub_categories', 'accesses'))->with('success', 'update successful');
        } else {
            return back()
                ->with('error', 'Content not found');
        }
    }
        
        
        $topic = Topic::findOrfail($id);
        if (isset($topic)) {
            
            // return response($topic);
            return view('pages.topic.edit', compact('categories', 'topic', 'sub_categories', 'accesses'));
        } else {
            return back()
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

        $validator = Validator::make($input, [
            'label' => 'required|string',
            'sub_category' => 'required|string',
            'category' => 'required|string'
        ]);

        if ($validator->fails()) {
            return back()
                ->with('error', $validator->errors());
        }

        $input['id'] = uniqid("gb", false);
        $input['name'] = Str::slug($input['label']);
        $input['label'] = $input['label'];
        // return response($this->columnToId($input['sub_category'], 'name', new SubCategory()) ? $this->columnToId($input['sub_category'], 'name', new SubCategory()) : null);
        $input['sub_category'] = $this->columnToId($input['sub_category'], 'name', new SubCategory()) ? $this->columnToId($input['sub_category'], 'name', new SubCategory()) : null;
        $input['category'] = $this->columnToId($input['category'], 'name', new Category()) ? $this->columnToId($input['category'], 'name', new Category()) : null;

        $topic = Topic::create($input);
        $success = "Topic created successfully";

        if ($topic) {
            return view('pages.topic.index', compact('topics', 'success'));
        }
        return back()
            ->with('error', 'Error processing request');
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
            'label' => 'required|string',
            'sub_category' => 'string',
            'category' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input['id'] = uniqid("gb", false);
        $input['name'] = Str::slug($input['label']);
        $input['label'] = $input['label'];
        $input->sub_category = $this->columnToId($input['sub_category'], 'name', new SubCategory()) ? $this->columnToId($input['sub_category'], 'name', new SubCategory()) : null;
        $input->category = $this->columnToId($input['category'], 'name', new Category()) ? $this->columnToId($input['category'], 'name', new Category()) : null;

        $topic = Topic::create($input);

        return $this->sendResponse($topic, 'Topic created successfully.');
    }

    public function view($id)
    {
        $topics = Topic::findOrFail($id);
        if (isset($topics)) {
            return view('pages.topic.view', compact('topics'));
        } else {
            return back()
                ->with('error', 'topics not found');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Topic::with(['subCategory', 'contents'])->where('name', '=', $id)->first();

        if (is_null($topic)) {
            return $this->sendError('Topic not found.');
        }
        return $this->sendResponse($topic, 'Topic retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'label' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $topic->name = Str::slug($input['label']);
        $topic->label = $input['label'];
        $topic->sub_category_id = $this->columnToId($input['sub_category'], 'name', new SubCategory()) ? $this->columnToId($input['sub_category'], 'name', new SubCategory()) : null;
        $topic->save();

        return $this->sendResponse($topic, 'Topic updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();

        return $this->sendResponse([], 'Topic deleted successfully.');
    }
    public function delete($id)
    {
        $topic = Topic::findOrfail($id);
        

        if ($topic->delete()) {
            return back()
                ->with('success', 'topic delete successfully');
        } else {
            return back()
                ->with('error', 'failed to delete topic!');
        }
    }
}
