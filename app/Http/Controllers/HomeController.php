<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Content;
use App\ContentAccess;
use App\ContentType;
use App\Subject;
use Illuminate\Support\Facades\Validator;
use App\Traits\CommonTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Str;


class HomeController extends Controller
{
  public function dashboard(Request $request)
  {
    return view('pages.index');
  }
}
