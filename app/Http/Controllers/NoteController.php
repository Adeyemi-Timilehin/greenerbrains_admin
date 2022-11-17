<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\CommonTrait;
use App\Http\Controllers\API\BaseController as BaseController;

class NoteController extends BaseController
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
        $note = Note::with(['notebook','content'])->get();
        return $this->sendResponse($note, "successful");
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
            'content_id' => 'string',
            'notebook_id' => 'required|string',
            'title' => 'string',
            'body' => 'string',
            'page' => 'integer',
            'device' => 'string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Check duplicate with user_id and notebook_id
        $note = Note::where([
            ['user_id', '=', $input['user_id']],
            ['notebook_id', '=', $input['notebook_id']]
        ]);
        // while (!$note = Note::where([['user_id', '=', $input['user_id']],['notebook_id', '=', $input['notebook_id']]])) {
        //     # TODO attempt creating new notebook
        // }
        // check content_id exist
        if ($note && $request->content_id) {
            $note = $note->where('content_id', $request->content_id);
        }
        // check if page exist
        if ($note && $request->page) {
            $note = $note->where('page', $request->page);
        }

        $note = $note->first();

        // create new if not exist
        if (!isset($note)) {
            $input['id'] = uniqid("gb", false);
            $newNote = Note::create($input);
            return $this->sendResponse($newNote, 'note added successful');
        } else {
            return $this->sendError('User already has a note with same attribute for this content!', [], 403);
        }

        return $this->sendError('There has been a problem!', [], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'notebook_id' => 'required|string',
            'id'=> 'string'
        ]);

        $note = Note::with('contents')
            ->where([
                ['user_id', '=', $request->user_id],
                ['id', '=', $request->id],
                ['notebook_id', '=', $request->notebook_id]
            ]);
        $note = $note->first();

        if (is_null($note)) {
            return $this->sendError('Note not found.');
        }
        return $this->sendResponse($note, 'Successful.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'content_id' => 'string',
            'notebook_id' => 'required|string',
            'title' => 'string',
            'body' => 'string',
            'page' => 'required|integer',
            'device' => 'string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $note = Note::where([
            ['user_id', '=', $input['user_id']],
            ['notebook_id', '=', $input['notebook_id']]
        ]);
        // check content_id exist
        if ($note && $request->content_id) {
            $note = $note->where('content_id', $request->content_id);
        }
        // check if page exist
        if ($note && $request->page) {
            $note = $note->where('page', $request->page);
        }
        $note = $note->first();

        $note['title'] = $input['title'] ? $input['title'] : $note['title'];
        $note['body'] = $input['body'] ? $input['body'] : $note['body'];
        $note['device'] = $input['device'] ? $input['device'] : $note['device'];

        $note->save();
        return $this->sendResponse($note, 'Note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return $this->sendResponse([], 'Note deleted successfully.');
    }
}
