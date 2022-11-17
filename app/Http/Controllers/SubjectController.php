<?php

namespace App\Http\Controllers;

use App\Category;
use App\Content;
use App\ContentAccess;
use App\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\SubjectsResource;
use App\Media;
use App\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\CommonTrait;
use App\Traits\FileUploadTrait;
use App\UserSubject;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Config;
use App\Http\Resources\UserResource;
use App\Traits\EmailTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class SubjectController extends BaseController
{
  use CommonTrait, FileUploadTrait, EmailTrait;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    //Show all employees from the database and return to view
    $subjects = Subject::with(['access', 'categories', 'contents']);
    if($request->category) {
        $request->category = str_replace('"', "",$request->category);
        $category = Category::where('label', $request->category)
            ->orWhere('name', $request->category)->first();

        if($category) {
            $subjects->where('category', ($category ? $category->id: ''))
            ->orWhere('category', ($category ? $category->name: ''))
            ->orWhere('category', ($category ? $category->label: ''));
        }
    }
    $subjects= $subjects->get();
    return $this->sendResponse(new SubjectsResource($subjects), "successful");
  }
  
  public function mySubjects()
  {
    //Show all user subscribed courses
    $subjects = Auth::user()->subscribed_subjects;
    return $this->sendResponse(new SubjectsResource($subjects), "successful");
  }


  public function showAll($message = null)
  {
    $subjects = Subject::with(['access', 'categories', 'contents'])->orderBy('created_at', 'desc')->paginate(10);
    if (isset($subjects)) {
      if (isset($message)) {
        return view('pages.subject.index', compact('subjects', 'message'));
      }
      return view('pages.subject.index', compact('subjects'));
    } else {
      return redirect()->back()
        ->with('error', 'Content not found');
    }
  }

  public function create()
  {
    $categories = Category::all();
    $contents = Content::all();
    $accesses = ContentAccess::all();
    $tags = Tag::all();

    if (isset($categories)) {
      return view('pages.subject.create', compact('categories', 'tags', 'contents', 'accesses'));
    } else {
      return redirect()->back()
        ->with('error', 'Content not found');
    }
  }

  public function subscribe(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'subject_id' => 'required|string',
      'user_id' => 'required',
      'payment_status' => 'string'
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    $duplicate = UserSubject::with('subject')->where([['user_id', $request->user_id], ['subject_id', $request->subject_id]])->first();
    if (isset($duplicate)) {
      return $this->sendResponse([], 'user is already subscribed to this course');
    }

    $input['id'] = uniqid("gb", false);
    $subject = Subject::where('id', '=', $input['subject_id'])->with(['access', 'categories', 'contents'])->first();

    if (isset($subject)) {
      // Let's determine if subject is free or paid
      /* NOTE: The tenary is to contain for different format of content access passed. i.e: whether an 'id' is passed or 'name' is passed */
      $subject_access_status = $subject->access === 'free' || 'premium' || 'paid' ? ContentAccess::where('name', $subject->access)->first() : ContentAccess::where('id', $subject->access)->first();
      $subject_access_status = $subject_access_status ? $subject_access_status['name'] : 'premium';

      // Subscribe for free or paid subject as case may be
      if ($subject_access_status !== 'free' && $input['payment_status'] == 'verified') {
        $user_sub = UserSubject::create([
          'id' => $input['id'],
          'user_id' => $input['user_id'],
          'subject_id' => $input['subject_id'],
          'status' => 'paid'
        ]);
        try {
          if ($this->sendSubscriptionEmail($request->user_id, $subject->label)) {;
          } else {;
          }
        } catch (\Exception $e) {;
        }
        return $this->sendResponse(new SubjectResource($subject), 'subscription successful');
      } else {
        $user_sub = UserSubject::create([
          'id' => $input['id'],
          'user_id' => $input['user_id'],
          'subject_id' => $input['subject_id'],
          'status' => 'free'
        ]);

        try {
          if ($this->sendSubscriptionEmail($request->user_id, $subject->label)) {;
          } else {;
          }
        } catch (\Exception $e) {;
        }

        return $this->sendResponse(new SubjectResource($subject), 'subscription successful');
      }
    } else {
      return $this->sendError('Subject not found!', [], 404);
    }

    return $this->sendError('There has been a problem!', [], 500);
  }

  public function sendSubscriptionEmail($user_id, $courseName)
  {
    //Retrieve the user from the database
    $user = DB::table('users')->where('id', $user_id)->select('name', 'email')->first();
    // try {
    //Here send the link with CURL with an external email API
    if (
      $this->customSendEmail([
        "to_email" => $user->email,
        "to_name" => $user->name,
        "from_name" => Config::get('mail.from.name'),
        "from_email" => Config::get('mail.from.address'),
        "subject" => "Subscription",
        "body" => $courseName
      ], "subscription")
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


  public function unSubscribe(Request $request)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'subject_id' => 'required|string',
      'user_id' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }
    try {
      $subscription = UserSubject::with('subject')->where([['user_id', '=', $request->user_id], ['subject_id', '=', $request->subject_id]])->first();
      if (isset($subscription)) {
        $subscription->delete();
        return $this->sendResponse([], 'Subscribed course removed succcessfully');
      }
    } catch (\Throwable $th) {
      return $this->sendError($th->getMessage(), [], 500);
    }

    return $this->sendError('There has been a problem!', [], 500);
  }

  public function updateSubject(Request $request, Subject $subject)
  {
    $input = $request->all();
    $categories = Category::all();
    $contents = Content::all();
    $accesses = ContentAccess::all();
    $tags = Tag::all();

    if (count($request->all())) {
      $validator = Validator::make($request->all(), [
        'label' => 'required|string',
        'category' => 'string',
        'rating' => 'max:5',
        'access' => 'string',
        'video' => 'image'
      ]);

      if ($validator->fails()) {
        return redirect()->back()
          ->with('error', $validator->errors());
      }

      $subject = Subject::with(['access', 'categories', 'contents'])->where('id', $request->id)->first();
      if (!$subject) {
        return redirect()->back()->with('error', 'Content not found');
      }

      // handle subject thumbnail
      if (isset($input['thumbnail']) && $input['thumbnail'] !== '') {
        $input['thumbnail'] = $this->getBaseUrl() . $this->uploadFile($request->thumbnail, 'thumbnails');
        $subject->thumbnail = $input['thumbnail'];
      }

      // handle preview video
      if (isset($input['preview_video']) && $input['preview_video'] !== '') {
        $input['preview_video'] = $this->getBaseUrl() . $this->uploadFile($request->preview_video, 'preview_videos');
        $subject->preview_video = $input['preview_video'];
      }

      $subject->name = $input['label'] ?  Str::slug($input['label']) : $subject->name;
      $subject->category = $input['category'] ? $this->columnToId($input['category'], 'name', new Category()) : $subject->category;
      $subject->label = $input['label'] ? $input['label'] : $subject->label;
      $subject->description = $input['description'] ? $input['description'] : $subject->description;
      $subject->summary = $input['summary'] ? $input['summary'] : $subject->summary;
      $subject->language = isset($input['language']) && $input['language'] !== '' ? $input['language'] : $subject->language;
      $subject->access = $input['access'] ? $input['access'] : $subject->access;
      $subject->price = isset($input['price']) ? $input['price'] : $subject->price;
      $subject->rating = isset($input['rating']) ? $input['rating'] : $subject->rating;

      try {
        $subject->save();

        if (isset($subject)) {
          if (isset($request->tags)) $subject->tags()->sync($request->tags);
          return redirect()->back()->with('success', 'update successful')
            ->with('categories', $categories)->with('tags', $tags)->with('subject', $subject)->with('contents', $contents)->with('accesses', $accesses);
        } else {
          return redirect()->back()->with('error', 'Content not found');
        }
      } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Error while updating content!');
      }
    }
  }

  public function edit($id)
  {
    $categories = Category::all();
    $contents = Content::all();
    $accesses = ContentAccess::all();
    $tags = Tag::all();

    $subject = Subject::with(['access', 'categories', 'contents'])->where("id", "=", $id)->first();
    if (isset($subject)) {
      return view('pages.subject.edit', compact('categories', 'tags', 'subject', 'accesses'));
    } else {
      return redirect()->back()
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
    $duplicate = Subject::with(['access', 'categories', 'contents'])->where('name', '=', Str::slug($input['label']))->first();
    $validator = Validator::make($input, [
      'label' => 'required|string',
      'access' => 'required|string',
      'rating' => 'max:10',
      'category' => 'required|string'
    ]);

    if (isset($duplicate)) {
      return redirect()->back()
        ->with('error', "Duplicate names not supported");
    }
    if ($validator->fails()) {
      return redirect()->back()
        ->with('error', $validator->errors());
    }

    // handle subject thumbnail
    if (isset($input['thumbnail'])) {
      $input['thumbnail'] = $this->getBaseUrl() . $this->uploadFile($request->thumbnail, 'thumbnails');
    }

    // handle price
    if (isset($input['price']) && isset($input['access']) && $input['price'] !== '' && $input['price'] !== '') {
      $input['price'] = $input['price'] && $input['access'] !== 'free' ? $input['price'] : 0;
    }

    // handle preview video
    if (isset($input['preview_video'])) {
      $input['preview_video'] = $this->getBaseUrl() . $this->uploadFile($request->preview_video, 'preview_videos');
    }

    $input['id'] = uniqid("gb", false);
    $input['name'] = Str::slug($input['label']);
    $input['label'] = $input['label'];
    $input['description'] = $input['description'] ? $input['description'] : '';
    $input['summary'] = $input['summary'] ? $input['summary'] : '';
    $input['language'] = $input['language'] ? $input['language'] : 'english';
    $input['access'] = $input['access'] ? $input['access'] : 'free';
    $input['category'] = $this->columnToId($input['category'], 'name', new Category()) ? $this->columnToId($input['category'], 'name', new Category()) : null;
    $subject = Subject::create($input);
    $success = "Subject added successfully";

    if ($subject && isset($input['tags'])) {
      $subject->tags()->sync($input['tags']);
    }
    if ($subject) {
      try {
        if ($this->sendNewCourseEmail($subject->label)) {;
        } else {;
        }
      } catch (\Exception $e) {;
      }
      return $this->showAll($success);
    } else {
      return redirect()->back()
        ->with('error', 'Error processing request');
    }
  }

  public function sendNewCourseEmail($courseName)
  {
    //Retrieve the user from the database
    // $user = DB::table('users')->where('id', $user_id)->select('name', 'email')->first();
    // try {
    //Here send the link with CURL with an external email API
    if (
      $this->customSendEmail([
        "to_email" => config('app.james_email'),
        "to_name" => config('app.name'),
        "from_name" => Config::get('mail.from.name'),
        "from_email" => Config::get('mail.from.address'),
        "subject" => "New Course",
        "body" => $courseName
      ], "new-course")
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
      'access' => 'string',
      'category' => 'required|string'
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    if (isset($input['thumbnail'])) {
      $input['thumbnail'] = $this->getBaseUrl() . $this->uploadFile($request->thumbnail, 'thumbnails');
    }
    if (isset($input['price'])) {
      $input['price'] = $input['price'] ? $input['price'] : 0;
    }

    $input['id'] = uniqid("gb", false);
    $input['name'] = Str::slug($input['label']);
    $input['label'] = $input['label'];
    $input['access'] = $input['access'];
    $input->category = $this->columnToId($input['category'], 'name', new Category()) ? $this->columnToId($input['category'], 'name', new Category()) : null;

    $subject = Subject::create($input);

    return $this->sendResponse(new SubjectResource($subject), 'Subject added successfully.');
  }


  /**
   * Show a subject message.
   *
   * @param  \App\Subject  $subject
   */
  public function view($id)
  {
    $subject = Subject::with(['tags', 'category', 'categories', 'contents', 'access'])->findOrFail($id);
    if ($subject->Category) {
      unset($subject->Category->subjects);
    }
    if (isset($subject)) {
      return view('pages.subject.view', compact('subject'));
    } else {
      return redirect()->back()
        ->with('error', 'subjects not found');
    }
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Subject  $subject
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $subject = Subject::with(['access', 'categories', 'contents'])->where('name', '=', $id)->first();
    if (!isset($subject)) {
      $subject = Subject::with(['access', 'categories', 'contents'])->where('id', '=', $id)->first();
    }

    if (is_null($subject)) {
      return $this->sendError('Subject not found.');
    }
    return $this->sendResponse(new SubjectResource($subject), 'Successful.');
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Subject  $subject
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Subject $subject)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'label' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    // handle subject thumbnail
    if (isset($input['thumbnail']) && $input['thumbnail'] !== '') {
      $input['thumbnail'] = $this->getBaseUrl() . $this->uploadFile($request->thumbnail, 'thumbnails');
      $subject->thumbnail = $input['thumbnail'];
    }

    // handle preview video
    if (isset($input['preview_video']) && $input['preview_video'] !== '') {
      $input['preview_video'] = $this->getBaseUrl() . $this->uploadFile($request->preview_video, 'preview_videos');
      $subject->preview_video = $input['preview_video'];
    }

    // handle price change
    if (isset($input['price']) && $input['price'] !== '') {
      $input['price'] = $input['price'] ? $input['price'] : 0;
    }

    $subject->name = $input['label'] ?  Str::slug($input['label']) : $subject->name;
    $subject->category = $input['category'] ? $this->columnToId($input['category'], 'name', new Category()) : $subject->category;
    $subject->label = $input['label'] ? $input['label'] : $subject->label;
    $subject->description = $input['description'] ? $input['description'] : $subject->description;
    $subject->summary = $input['summary'] ? $input['summary'] : $subject->summary;
    $subject->language = $input['language'] ? $input['language'] : $subject->language;
    $subject->access = $input['access'] ? $input['access'] : $subject->access;
    $subject->save();

    return $this->sendResponse(new SubjectResource($subject), 'Subject updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Subject  $subject
   * @return \Illuminate\Http\Response
   */
  public function destroy(Subject $subject)
  {
    $subject->delete();

    return $this->sendResponse([], 'Subject deleted successfully.');
  }
  public function delete($id)
  {
    $subject = Subject::findOrfail($id);


    if ($subject->delete()) {
      return redirect()->back()
        ->with('success', 'subject delete successfully');
    } else {
      return redirect()->back()
        ->with('error', 'failed to delete subject!');
    }
  }
}
