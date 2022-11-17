<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use App\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\CommonTrait;
use App\Traits\FileUploadTrait;
use App\Traits\EmailTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

  use CommonTrait, FileUploadTrait, EmailTrait;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $posts = Post::with(['user','comments'])->orderBy('created_at', 'desc')->paginate(10);
    if (isset($posts)) {
      if (isset($message)) {
        return view('pages.post.index')->with('posts', $posts);
      }
      return view('pages.post.index')->with('posts', $posts);
    } else {
      return redirect()->back()
        ->with('error', 'Posts not found');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $tags = Tag::all();

    if (isset($tags)) {
      return view('pages.post.create')->with('tags', $tags);
    } else {
      return redirect()->back()
        ->with('error', 'There are no tags found!');
    }
  }


  public function publishComment($id)
  {
    if ($id) {
      try {
        $comment = Comment::where('id', $id)->first();
        $comment->published = true;
        if ($comment->save()) {
          return redirect()->back()->with('success', 'Comment Published successfully');
        }
      } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Action failed!');
      }
    }
  }


  public function unpublishComment($id)
  {
    if ($id) {
      try {
        $comment = Comment::where('id', $id)->first();
        $comment->published = false;
        if ($comment->save()) {
          return redirect()->back()->with('success', 'Comment Unpublished successfully');
        }
      } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Action failed!');
      }
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
    $duplicate = Post::where('slug', '=', Str::slug($input['title']))->first();
    $validator = Validator::make($input, [
      'title' => 'required|string',
      'body' => 'required|string',
      'publish_date' => 'required'
    ]);

    // return error if duplicate available
    if (isset($duplicate)) {
      return redirect()->back()
        ->with('error', "We observed a duplicate title. That may be intentional, but this system does not support duplicate titles");
    }

    if ($validator->fails()) {
      return redirect()->back()
        ->with('error', $validator->errors());
    }

    // try {
      // handle post image 
      if (isset($input['image'])) {
        $input['image'] = $this->getBaseUrl() . $this->uploadFile($request->image, 'post-images');
      }

      $input['id'] = uniqid("gb", false);
      $input['slug'] = Str::slug($input['title']);
      $input['title'] = isset($input['title']) ? $input['title'] : '';
      $input['body'] = isset($input['body']) ? $input['body'] : '';
      $input['publish_date'] = isset($input['publish_date']) ? $input['publish_date'] : null;
      $input['status'] = isset($input['status']) ? $input['status'] : '';
      $input['user_id'] = isset(Auth::user()->id) ? Auth::user()->id : null;
      
      try {
        $post = Post::create($input);

        if ($post && isset($input['tags'])) {
          $post->tags()->sync($input['tags']);
        }
        if ($post) {
          return redirect()->route('post.show', ['id' => $post->id])->with('success', 'New Post added successfully');
        } else {
          return redirect()->back()
            ->with('error', 'Error processing request');
        }
      } catch (\Throwable $th) {
        return redirect()->back()->with('error', 'Error creating new Post!');
      }
      $post = Post::create($input);

      if ($post && isset($input['tags'])) {
        $post->tags()->sync($input['tags']);
      }
      if ($post) {
        return $this->index();
      } else {
        return redirect()->back()
          ->with('error', 'Error processing request');
      }
    // } catch (\Throwable $th) {
    //   return redirect()->back()
    //     ->with('error', $th);
    //   // return redirect()->back()
    //   //   ->with('error', 'Error adding new post!');
    // }
  }


  private function addLikes($id)
  {
    if ($id) {
      try {
        $post = Post::where('id', $id)->first();
        $likes = intval($post->likes, 10);
        $post->likes = ($likes + 1);
        if ($post->save()) return true;
      } catch (\Throwable $th) {
        return false;
      }
    }
  }


  // Verify and unverify post
  private function verifyPost($id)
  {
    if ($id) {
      try {
        $post = Post::where('id', $id)->first();
        $post->verified = true;
        if ($post->save()) return true;
      } catch (\Throwable $th) {
        return false;
      }
    }
  }

  private function unverifyPost($id)
  {
    if ($id) {
      try {
        $post = Post::where('id', $id)->first();
        $post->verified = false;
        if ($post->save()) return true;
      } catch (\Throwable $th) {
        return false;
      }
    }
  }

  private function addViews($id)
  {
    if ($id) {
      try {
        $post = Post::where('id', $id)->first();
        $views = intval($post->views, 10);
        $post->views = ($views + 1);
        if ($post->save()) return true;
      } catch (\Throwable $th) {
        return false;
      }
    }
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $post = Post::where('id', $id)->with(['tags', 'user', 'comments'])->first();

    if (isset($post)) {
      return view('pages.post.view')->with('post', $post);
    } else {
      return redirect()->back()
        ->with('error', 'Post not found');
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $tags = Tag::all();

    try {
      $post = Post::with(['user', 'tags', 'comments'])->where("id", "=", $id)->first();
      if (isset($post)) {
        $post = Post::with(['user','comments'])->where("id", "=", $id)->first();
        return view('pages.post.edit')->with('post', $post)->with('tags', $tags);
      } else {
        return redirect()->back()->with('error', 'Post not found');
      }
    } catch (\Throwable $th) {
      return redirect()->back()->with('error', 'Post not found');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $input = $request->all();
    $tags = Tag::all();

    if (count($request->all())) {
      $validator = Validator::make($request->all(), [
        'title' => 'required|string',
        'body' => 'string',
        'image' => 'image'
      ]);

      if ($validator->fails()) {
        return redirect()->back()
          ->with('error', $validator->errors());
      }

      $post = Post::with(['user'])->where('id', $request->id)->first();
      if (!$post) {
        return redirect()->back()->with('error', 'Post not found');
      }

      // handle post image 
      if (isset($input['image']) && $input['image'] !== '') {
        $input['image'] = $this->getBaseUrl() . $this->uploadFile($request->image, 'post-images');
        $post->image = $input['image'];
      }

      $post->title = $input['title'] ?  $input['title'] : $post->title;
      $post->slug = isset($input['title']) ?  Str::slug($input['title']) : $post->slug;
      $post->body = isset($input['body']) ? $input['body'] : $post->body;
      $post->publish_date = isset($input['publish_date']) ? $input['publish_date'] : $post->publish_date;
      $post->status = isset($input['status']) ? $input['status'] : $post->status;
      $post->user_id = isset($input['user_id']) ? $input['user_id'] : $post->user_id;
      $post->verified = isset($input['verified']) && $input['verified'] !== '' ? $input['verified'] : $post->verified;

      // try {
        $post->save();

        if (isset($post)) {
          if (isset($request->tags)) $post->tags()->sync($request->tags);

          return redirect()->back()->with('success', 'update successful')
            ->with('tags', $tags)
            ->with('post', $post);
        } else {
          return redirect()->back()->with('error', 'Post not found');
        }
      // } catch (\Throwable $th) {
      //   return redirect()->back()->with('error', 'Error while updating post!');
      // }
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function destroy(Post $post)
  {
    try {
      if ($post->delete()) {
        return redirect()->back()
          ->with('success', 'Post deleted successfully');
      } else {
        return redirect()->back()
          ->with('error', 'failed to delete post!');
      }
    } catch (\Throwable $th) {
      return redirect()->back()->with('error', 'Error attempting to delete post!');
    }
  }
}
