<?php

namespace App\Http\Controllers;

use App\Category;
use App\Content;
use App\ContentAccess;
use App\ContentType;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Subject;
use Illuminate\Support\Facades\Validator;
use App\Traits\CommonTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
  use CommonTrait, FileUploadTrait;

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    //Show all employees from the database and return to view
    $category = Category::with(['subjects', 'contents'])->get();
    if ($request->subject) {
      $category_id =  $this->columnToId(Str::slug($request->subject), 'name', new Subject());
      $content = Category::where("subject", "=", $category_id)->get();
      return $this->sendResponse($content, "successful");
    }
    if ($request->content_type) {
      $content_type_id =  $this->columnToId(Str::slug($request->content_type), 'name', new ContentType());
      $content = Category::where("content_type", "=", $content_type_id)->get();
      return $this->sendResponse($content, "successful");
    }
    if ($request->content_access) {
      $content_access_id =  $this->columnToId(Str::slug($request->content_access), 'name', new ContentAccess());
      $content = Category::where("content_access", "=", $content_access_id)->get();
      return $this->sendResponse($content, "successful");
    }
    return $this->sendResponse($category, "successful");
  }

  public function getSubject($category = null, $id = null)
  {
    $category = Category::where('name', '=', $category)->with('subjects')->first();

    if (isset($category) && isset($id)) {
      $subject = Subject::where('name', '=', $id)->first();
      if (!isset($subject)) {
        $subject = Subject::where('id', '=', $id)->first();
      }
      return $this->sendResponse($subject, "successful");
    }
    $subject = $category['subjects'];
    return $this->sendResponse($subject, "successful");
  }

  public function getContent($category = null, $id = null)
  {
    $category = Category::where('name', '=', $category)->with('contents')->first();

    if (isset($category) && isset($id)) {
      $subject = Content::where('name', '=', $id)->first();
      if (!isset($subject)) {
        $subject = Content::where('id', '=', $id)->first();
      }
      return $this->sendResponse($subject, "successful");
    }
    $subject = $category['contents'];
    return $this->sendResponse($subject, "successful");
  }

  public function showAll($message = null)
  {
    $categories = Category::all();
    if (isset($categories)) {
      if (isset($message)) {
        return view('pages.content-category.index', compact('categories', 'message'));
      }
      return view('pages.content-category.index', compact('categories'));
    } else {
      return back()
        ->with('error', 'Content not found');
    }
  }


  public function create()
  {
    $accesses = ContentAccess::all();

    if (isset($accesses)) {
      return view('pages.content-category.create', compact('accesses'));
    } else {
      return back()
        ->with('error', 'Content not found');
    }
  }


  public function updateCategory($id, Request $request)
  {
    $validator = Validator::make($request->all(), [
      'label' => 'required|string'
    ]);

    if ($validator->fails()) {
      return back()
        ->with('error', $validator->errors());
    }

    $category = Category::where("id", "=", $request->id)->first();
    // return response($request->all());
    if (isset($category)) {
      $category->name = $request->label ? Str::slug($request->label) : $category->name;
      $category->label = $request->label ? $request->label : $category->label;
      $category->description = $request->description ? $request->description : $category->description;

      $category->save();
      return redirect()->back()->with('success', 'Category update successful!');
    } else {
      return back()->with('error', 'Category not found');
    }
  }

  public function edit($id, Request $request)
  {
    $category = Category::where('id', '=', $id)->first();
    if (isset($category)) {
      return view('pages.content-category.edit', compact('category'));
    } else {
      return back()
        ->with('error', 'Category not found');
    }
  }


  public function addNew(Request $request)
  {
    $input = $request->all();
    $duplicate = Category::where('name', '=', Str::slug($input['label']))->first();
    $validator = Validator::make($input, [
      'label' => 'required|string'
    ]);

    if (isset($duplicate)) {
      return back()
        ->with('error', "Duplicate name <strong>' $request->label '</strong> not supported. <br> You may consider changing category name or ignore if this was unintentional!");
    }
    if ($validator->fails()) {
      return back()
        ->with('error', $validator->errors());
    }

    if (isset($input['image'])) {
      $input['image'] = $this->getBaseUrl() . $this->uploadFile($request->image, 'thumbnails');
    }

    $input['id'] = uniqid("gb", false);
    $input['name'] = Str::slug($input['label']);
    $input['label'] = $input['label'];

    // $category = Category::create($input);
    $success = "Category added successfully";

    try {
      $category = Category::create($input);

      if (isset($category)) {
        return redirect()->route('category')->with('success', "<strong>$category->label</strong> category added successfully");
      } else {
        return redirect()->back()->with('error', "Failed to add new category <strong>$request->label</strong> !");
      }
    } catch (\Throwable $th) {
      return redirect()->back()->with('error', 'Error occured while attempting to add new category!');
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
    // $input = new Category();
    $input = $request->all();

    $validator = Validator::make($input, [
      'label' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }

    if (isset($input['image'])) {
      $input['image'] = $this->getBaseUrl() . $this->uploadFile($request->image, 'thumbnails');
    }

    $input['id'] = uniqid('gb', false);
    $input['name'] = Str::slug($input['label']);
    $input['label'] = $input['label'];

    $category = Category::create($input);

    return $this->sendResponse($category, 'Category created successfully.');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function view($id)
  {
    $category = Category::with(['subjects', 'contents'])->where('id', '=', $id)->first();

    if (is_null($category)) {
      return redirect()->back()->with('error', 'Category not found');
    }
    return view('pages.content-category.view')->with('category', $category);
  }
  /**
   * Display the specified resource.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $category = Category::with(['contents', 'subjects'])->where('id', '=', $id)->first() ? Category::with(['contents', 'subjects'])->where('id', '=', $id)->first() : Category::with(['contents', 'subjects'])->where('name', '=', $id)->first();

    if (!isset($category)) {
      return $this->sendError('Category not found.');
    }
    return $this->sendResponse($category, 'Category retrieved successfully.');
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Category $category)
  {
    $input = $request->all();

    $validator = Validator::make($input, [
      'label' => 'required',
    ]);

    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }
    if (isset($input['image'])) {
      $category->image = $this->getBaseUrl() . $this->uploadFile($request->image, 'thumbnails');
    }

    $category->name = Str::slug($input['label']);
    $category->label = $input['label'];
    $category->save();

    return $this->sendResponse($category, 'Category updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function destroy(Category $category)
  {
    $category->delete();

    return $this->sendResponse([], 'Category deleted successfully.');
  }


  public function delete($id)
  {
    $category = Category::findOrfail($id);

    if (isset($category)) {
      $name = $category->label;
      if ($category->delete()) {
        return back()
          ->with('success', "Category <strong>$name</strong> delete successfully");
      } else {
        return back()
          ->with('error', 'failed to delete category!');
      }
    } else {
      return back()
        ->with('error', 'Category not found!');
    }
  }
}
