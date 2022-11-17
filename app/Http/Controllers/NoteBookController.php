<?php

namespace App\Http\Controllers;

use App\NoteBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\CommonTrait;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;

class NoteBookController extends BaseController
{
    use CommonTrait;

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
        $notebooks = Auth::user()->notebooks;
        return $this->sendResponse($notebooks, "successful");
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
            'user_id' => 'required',
            'subject_id' => 'string|required',
            'title' => 'string',
            'description' => 'string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Check duplicate
        $notebook = NoteBook::where([
            ['user_id', '=', $input['user_id']],
            ['subject_id', '=', $input['subject_id']]
        ]);

        $notebook = $notebook->first();

        if (!isset($notebook)) {
            $input['id'] = uniqid("gb", false);
            $newNoteBook = NoteBook::create($input);
            return $this->sendResponse($newNoteBook, 'notebook added successful');
        } else {
            return $this->sendError('User already has a notebook for this content!', [], 403);
        }

        return $this->sendError('There has been a problem!', [], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NoteBook  $noteBook
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'subject_id' => 'string|required'
        ]);

        $notebook = NoteBook::with(['subject', 'notes'])
            ->where([
                ['user_id', '=', $request->user_id],
                ['subject_id', '=', $request->subject_id]
            ]);
        $notebook = $notebook->first();

        if (is_null($notebook)) {
            return $this->sendError('Notebook not found.');
        }
        return $this->sendResponse($notebook, 'Successful.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NoteBook  $noteBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NoteBook $noteBook)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'subject_id' => 'string|required',
            'title' => 'string',
            'description' => 'string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $notebook = NoteBook::where([['user_id', '=', $input['user_id']], ['subject_id', '=', $input['subject_id']]]);
        $notebook = $notebook->first();

        $notebook['title'] = $input['title'] ? $input['title'] : $notebook['title'];
        $notebook['description'] = $input['description'] ? $input['description'] : $notebook['description'];

        $notebook->save();
        return $this->sendResponse($notebook, 'Notebook updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NoteBook  $noteBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(NoteBook $noteBook)
    {
        $noteBook->delete();

        return $this->sendResponse([], 'Notebook deleted successfully.');
    }
}
