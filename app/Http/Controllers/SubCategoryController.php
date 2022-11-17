<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\CommonTrait;

class SubCategoryController extends BaseController
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
        $subCategory = SubCategory::all();
        return $this->sendResponse($subCategory, "successful");
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
            'label' => 'string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input['id'] = uniqid("gb", false);
        $input['name'] = Str::slug($input['label']);
        $input['label'] = $input['label'];
        $input['category_id'] = $this->columnToId($input['category'], 'name', new Category()) ? $this->columnToId($input['category'], 'name', new Category()) : $input['category'];

        $subCategory = SubCategory::create($input);

        return $this->sendResponse($subCategory, 'Sub-Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subCategory = SubCategory::with(['topics'])->where('name','=',$id)->first();

        if (is_null($subCategory)) {
            return $this->sendError('SubCategory not found.');
        }
        return $this->sendResponse($subCategory, 'Sub-Category retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'label' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $subCategory->name = Str::slug($input['label']);
        $subCategory->label = $input['label'];
        $subCategory->category_id = $this->columnToId($input['category'], 'name', new Category()) ? $this->columnToId($input['category'], 'name', new Category()) : $input['category'];
        $subCategory->save();

        return $this->sendResponse($subCategory, 'Sub-Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();

        return $this->sendResponse([], 'Sub-Category deleted successfully.');
    }
}
