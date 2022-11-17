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
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
  public function Student(Request $request)
  {
         $students = DB::table('student_regs')->get();
 
        return view('pages.student.index', ['students' => $students]);
  }
}
