<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ResponseResource;
use App\Models\Comment;
use App\Models\Response;


class ResponseController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api', ['except' => 
            [ 'index' ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $db)
    {   
        if ($db == 'comment') {
            $responses = Comment::findOrFail($id)->responses;
        } else if ($db == 'response') {
            $responses = Response::findOrFail($id)->responses;
        } else {
            abort(404);
        }

        return ResponseResource::collection($responses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id, $db)
    {
        $validated = $request->validate([
            'comment' => 'required|max:200',
        ]);

        if ($db == 'comment') {
            $response = Response::create(array_merge(
                $validated, [
                    'comment_id' => $id,
                    'user_id' => auth()->user()->id
                ]
            ));
        } else if ($db == 'response') {
            $response = Response::create(array_merge(
                $validated, [
                    'response_id' => $id,
                    'user_id' => auth()->user()->id
                ]
            ));
        } else {
            abort(404);
        }

        return new ResponseResource($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
