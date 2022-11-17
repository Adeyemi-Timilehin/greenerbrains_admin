<?php

namespace App\Http\Controllers;

use App\Category;
use App\Content;
use App\ContentAccess;
use App\ContentTag;
use App\ContentType;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Topic;
use Illuminate\Support\Facades\Validator;
use App\Traits\CommonTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Str;
use App\Http\Resources\ContentResource;
use App\Http\Resources\ContentsResource;
use App\Subject;
use App\Tag;
use App\User;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Config;
use App\Http\Resources\UserResource;
use App\Traits\EmailTrait;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ContentController extends BaseController
{
  use CommonTrait, FileUploadTrait, EmailTrait;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $content = Content::where("is_published", "=", 1)->get();
    if ($request->category) {
      $category_id =  $this->columnToId(Str::slug($request->category), 'name', new Category());
      $content = Content::where("is_published", "=", 1)->where("category", "=", $category_id)->get();
      return $this->sendResponse(new ContentsResource($content), "successful");
    }
    if ($request->content_type) {
      $content_type_id =  $this->columnToId(Str::slug($request->content_type), 'name', new ContentType());
      $content = Content::where("is_published", "=", 1)->where("content_type", "=", $content_type_id)->get();
      return $this->sendResponse(new ContentsResource($content), "successful");
    }
    if ($request->content_access) {
      $content_access_id =  $this->columnToId(Str::slug($request->content_access), 'name', new ContentAccess());
      $content = Content::where("is_published", "=", 1)->where("content_access", "=", $content_access_id)->get();
      return $this->sendResponse(new ContentsResource($content), "successful");
    }
    return $this->sendResponse(new ContentsResource($content), "successful");
  }

  public function createContent(Request $request)
  {
    $input = $request->all();
    $validator = Validator::make($request->all(), [
      'title' => 'required|string',
      'category' => 'string|min:3',
      'description' => 'string|min:10',
      'is_published' => 'boolean',
      'content_type' => 'min:1',
      'content_access' => 'required',
      'subject_id' => 'required',
      'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    if (isset($input['thumbnail'])) {
      $input['thumbnail'] = $this->getBaseUrl() . $this->uploadFile($request->thumbnail, 'thumbnails');
    }

    if (isset($input['media'])) {
      $input['media_id'] = $this->saveMedia($request->media, 'media', $input['thumbnail'] ? $input['thumbnail'] : NULL);
    } else if (isset($input['media_url'])) {
      $input['media_id'] = $this->saveMediaURL($request->media_url, $input['thumbnail'] ? $input['thumbnail'] : NULL);
    }


    // if ($request->content_type == "text") {
    //     unset($input['media']);
    //     unset($input['media_url']);
    //     unset($input['thumbnail']);
    // } else if ($request->content_type == "video") {
    //     unset($input['body']);
    // }


    $input['id'] = uniqid("gb", false);
    $input['rating'] = $request->rating ? $request->rating : 0;
    $input['body'] = $request->body ? $request->body : '';
    $input['slug'] = Str::limit(Str::slug($input['title']), 60, '') . "-" . Str::random();
    $input['category'] = $request->category ? $this->columnToId($input['category'], 'name', new Category()) : $input['category'];
    $input['content_type'] = $this->columnToId(Str::slug('video'), 'name', new ContentType());
    // $input['content_type'] = $request->content_type ? $this->columnToId(Str::slug('video'), 'name', new ContentType()) : $input['content_type'];
    $input['content_access'] = $request->content_access;
    $input['is_published'] = $request->publish == "on" ? true : false;
    $input['published_date'] = $request->published_date ? $request->published_date : date('Y-m-d H:i:s');
    $content = Content::create($input);


    if ($content && isset($input['tags'])) {
      $content->tags()->sync($input['tags']);
    }

    try {
      if ($this->sendNewContentEmail($request->email, $content->title)) {;
      } else {;
      }
    } catch (\Exception $e) {;
    }
    return $this->getAll('Content created successfully.');
  }



  public function sendNewContentEmail($email, $courseName)
  {
    //Retrieve the user from the database
    $user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
    // try {
    //Here send the link with CURL with an external email API
    if (
      $this->customSendEmail([
        "to_email" => $email,
        "to_name" => $user->name,
        "from_name" => Config::get('mail.from.name'),
        "from_email" => Config::get('mail.from.address'),
        "subject" => "New Content",
        "body" => $courseName
      ], "new-content")
    ) {
      return true;
    }
    return false;
    // } catch (\Exception $e) {
    //     // return response($e);
    //     // return $this->sendError($e, [], $code = 400);
    //     // return false;
    // }
  }

  /**
   * Fetches all contents for web view
   *
   * @param   $message  // optional message incase it's called within this class and needs a carry-along message
   * @return \Illuminate\Http\Response
   */
  public function getAll($message = null)
  {
    if (!Auth::check()) {
      // Session::flash('error', 'Unauthorized activity!');
      // return redirect()->back();
    }

    $contents = Content::orderBy('updated_at', 'desc')->paginate(10);
    if (isset($message)) {
      return view("pages.content.index")
        ->with('contents', $contents)
        ->with('message', $message);
    }

    return view("pages.content.index")
      ->with('contents', $contents);
  }

  /**
   * Registers a content viewed by a user
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function registerConsumedContent(Request $request)
  {
    $input = $request->all();
    $validator = Validator::make($request->all(), [
      'user_id' => 'required',
      'content_id' => 'required',
      'status' => 'string'
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    $user = User::with('consumed_contents')->where("id", "=", $input['user_id']);
    if (isset($user)) {
      try {
        $user = $user->first();
        $user->consumed_contents()->attach($input['content_id']);
      } catch (Exception $e) {
        return $this->sendError($e->getTraceAsString());
      }
      return $this->sendResponse($request->all(), 'Registered successfully.');
    }
    return $this->sendError('User not found.');
  }


  /**
   * Returns a list of contents a user has consumed.
   *
   * @return \Illuminate\Http\Response
   */
  public function getConsumedContents(Request $request)
  {
    try {
      if ($request->user()) {
        $contents = $request->user()->consumed_contents;
        if (isset($contents)) {
          for ($i = 0; $i < count($contents); $i++) {
            if (isset($contents[$i]['contentCategory'])) unset($contents[$i]['contentCategory']);
            if (isset($contents[$i]['subject'])) unset($contents[$i]['subject']);
            if (isset($contents[$i]['pivot'])) unset($contents[$i]['pivot']);
            if (isset($contents[$i]['contentType'])) unset($contents[$i]['contentType']);
          }
        }
        return $this->sendResponse(new ContentsResource($contents), "successful");
      } else {
        return $this->sendError('You need to signin to perform this action!', []);
      }
    } catch (\Throwable $th) {
      return $this->sendError('Error.', $th->getTraceAsString());
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
    $validator = Validator::make($request->all(), [
      'title' => 'required|string',
      'body' => 'string|min:5',
      'category' => 'string|min:3',
      'description' => 'string|min:10',
      'is_published' => 'boolean',
      'content_type' => 'min:1',
      'content_access' => 'required',
      'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }



    if (isset($input['thumbnail'])) {
      $input['thumbnail'] = $this->getBaseUrl() . $this->uploadFile($request->thumbnail, 'thumbnails');
    }

    if (isset($input['media'])) {
      $input['media_id'] = $this->saveMedia($request->media, 'media', $input['thumbnail'] ? $input['thumbnail'] : NULL);
    } else if (isset($input['media_url'])) {
      $input['media_id'] = $this->saveMediaURL($request->media_url, $input['thumbnail'] ? $input['thumbnail'] : NULL);
    }


    if ($request->content_type == "text") {
      unset($input['media']);
      unset($input['media_url']);
      unset($input['thumbnail']);
    } else if ($request->content_type == "video") {
      unset($input['body']);
    }


    $input['id'] = uniqid("gb", false);
    $input['slug'] = Str::limit(Str::slug($input['title']), 60, '') . "-" . Str::random();
    $input['category'] = $request->category ? $this->columnToId($input['category'], 'name', new Category()) : $input['category'];
    $input['content_type'] = $request->content_type ? $this->columnToId(Str::slug($input['content_type']), 'name', new ContentType()) : $input['content_type'];
    $input['content_access'] = $request->content_access ? $this->columnToId(Str::slug($input['content_access']), 'name', new ContentAccess()) : $input['content_access'];
    $input['is_published'] = $request->publish == "on" ? true : false;
    $input['published_date'] = $request->published_date ? $request->published_date : date('Y-m-d H:i:s');
    $content = Content::create($input);



    return $this->sendResponse($content, 'Content created successfully.');
  }



  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Content  $content
   * @return \Illuminate\Http\Response
   */
  public function view($id)
  {
    $content = Content::findOrFail($id);
    if (isset($content)) {
      // return response($content);
      return view('pages.content.view', compact('content'));
    } else {
      return redirect()->back()
        ->with('error', 'Content not found');
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Content  $content
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $categories = Category::all();
    $content_types = ContentType::all();
    $subjects = Subject::all();
    $accesses = ContentAccess::all();
    $tags = Tag::all();

    if (isset($categories)) {
      return view('pages.content.create', compact('categories', 'tags', 'content_types', 'subjects', 'accesses'));
    } else {
      return redirect()->back()
        ->with('error', 'Content not found');
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Content  $content
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $categories = Category::all();
    $content_types = ContentType::all();
    $subjects = Subject::all();
    $accesses = ContentAccess::all();
    $content = Content::where('id', '=', $id)->first();
    $tags = Tag::all();
    if (isset($content)) {
      return view('pages.content.edit', compact('content', 'categories', 'tags', 'content_types', 'subjects', 'accesses'));
    } else {
      return redirect()->back()
        ->with('error', 'Content not found');
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Content  $content
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $content = Content::where("is_published", "=", 1)->where('id', '=', $id)->first();

    if (is_null($content)) {
      return $this->sendError('Content not found.');
    }
    return $this->sendResponse(new ContentResource($content), 'Content retrieved successfully.');
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Content  $content
   * @return \Illuminate\Http\Response
   */
  public function unPublishContent($id = null)
  {
    if (!isset($id)) {
      return redirect()->back()->with('error', 'No defined content parameter!');
    }

    $content = Content::where('id', $id)->first();

    try {
      if ($content) {
        $content->is_published = false;
        $content->save();
        return redirect()->back()->with('content', $content)
          // ->with('message', "Content '$content->title' unpublished successfully")
          ->with('success', "Content '<strong>$content->title</strong>' unpublished successfully");
      } else {
        return redirect()->back()->with('error', 'Content not found');
      }
    } catch (\Throwable $th) {
      return redirect()->back()->with('error', 'Content not found');
    }
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Content  $content
   * @return \Illuminate\Http\Response
   */
  public function publishContent($id = null)
  {
    if (!isset($id)) {
      return redirect()->back()->with('error', 'No defined content parameter!')->with('message', "successful");
    }
    $content = Content::where('id', $id)->first();

    try {
      if ($content) {
        $content->is_published = true;
        $content->save();
        return redirect()->back()->with('content', $content)
          // ->with('message', "Content '$content->title' published successfully")
          ->with('success', "Content '<strong>$content->title</strong>' published successfully");
      } else {
        return redirect()->back()->with('error', 'Content not found');
      }
    } catch (\Throwable $th) {
      return redirect()->back()->with('error', 'Content not found');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Content  $content
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Content $content)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'title' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    $content = $input;
    $content->save();

    return $this->sendResponse($content, 'Content updated successfully.');
  }


  public function updateContent(Request $request, $id)
  {
    if (!isset($id)) {
      return redirect()->back();
    }
    $content = Content::where('id', $id)->first();
    // dd($content);
    $input = $request->all();
    $validator = Validator::make($request->all(), [
      'title' => 'required|string',
      'category' => 'string|min:3',
      'description' => 'string|min:10',
      'is_published' => 'boolean',
      'content_type' => 'min:1',
      'subject_id' => 'required',
      'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    if (isset($input['thumbnail']) && $input['thumbnail'] !== '') {
      $content['thumbnail'] = $this->getBaseUrl() . $this->uploadFile($request->thumbnail, 'thumbnails');
    }

    if (isset($input['media']) && $input['media'] !== '') {
      $content['media_id'] = $this->saveMedia($request->media, 'media', (isset($input['thumbnail']) ? $input['thumbnail'] : $content->thumbnail));
    } else if (isset($input['media_url']) && $input['media_url'] !== '') {
      $content['media_id'] = $this->saveMediaURL($request->media_url, (isset($input['thumbnail']) ? $input['thumbnail'] : $content->thumbnail));
    }



    if (isset($content)) {
      $content['body'] = isset($request->body) && $request->body !== '' ? $request->body : $content->body;
      $content['rating'] = isset($request->rating) && $request->rating !== '' ? $request->rating : $content->rating;
      $content['category'] = isset($request->category) ? $this->columnToId($input['category'], 'name', new Category()) : $content->category;
      // $input['content_type'] = $this->columnToId(Str::slug('video'), 'name', new ContentType());
      // $input['content_type'] = $request->content_type ? $this->columnToId(Str::slug('video'), 'name', new ContentType()) : $input['content_type'];
      $content['content_access'] = isset($request->content_access) ? $request->content_access : $content->content_access;
      $content['is_published'] = isset($request->publish) ? ($request->publish === "on" ? true : false) : $content->is_published;
      $content['published_date'] = isset($request->published_date) ? $request->published_date : $content->published_date;

      // Update title and slug if title updates exists
      if (isset($request->title)) {
        $content['title'] = $request->title !== '' ? $request->title : $content->title;
        $content['slug'] = Str::limit(Str::slug($request->title), 60, '') . "-" . Str::random();
      }

      if (isset($input['tags'])) {
        $content->tags()->sync($input['tags']);
      }

      if ($content->save()) {
        return redirect()->back()
          ->with('success', 'Content updated successfully');
      } else {
        return redirect()->back()
          ->with('error', "Content update wasn't successfull!");
      }
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Content  $content
   * @return \Illuminate\Http\Response
   */
  public function destroy(Content $content)
  {
    $content->delete();

    return $this->sendResponse([], 'Content deleted successfully.');
  }

  public function delete($id)
  {
    if (!isset($id)) {
      return redirect()->back()->with('error', 'Unidentified content!');
    }

    $content = Content::where('id', $id)->first();

    if (!$content) {
      return redirect()->back()->with('error', 'Content not found!');
    }

    if ($content->delete()) {
      return redirect()->back()->with('success', 'Content deleted successfully');
    } else {
      return redirect()->back()
        ->with('error', 'failed to delete content!');
    }
  }
}
