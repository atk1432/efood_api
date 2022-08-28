<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusComment;
use App\Models\StatusResponse; 


class EconController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth:api');
    }

    public function send_econ(Request $request, $db) {

        $validated = $request->validate([
            'id' => 'required|min:0',
            'like' => 'nullable'
        ]);

        if ($db == 'comment') {
            if ($validated['like'] == 'like' || $validated['like'] == 'dislike') {
                StatusComment::updateOrCreate([
                    'comment_id' => $validated['id'],
                    'user_id' => auth()->user()->id
                ], [
                    'comment_id' => $validated['id'],
                    'like' => $validated['like'] === 'like' ? true : false,
                    'user_id' => auth()->user()->id
                ]);
            } else {
                $status = StatusComment::where([
                    ['comment_id', $validated['id']],
                    ['user_id', auth()->user()->id]
                ])->first();

                if ($status) $status->delete();
            }
        } else if ($db == 'response') {
            if ($validated['like'] == 'like' || $validated['like'] == 'dislike') {
                StatusResponse::updateOrCreate([
                    'response_id' => $validated['id'],
                    'user_id' => auth()->user()->id
                ], [
                    'response_id' => $validated['id'],
                    'like' => $validated['like'] === 'like' ? true : false,
                    'user_id' => auth()->user()->id
                ]);
            } else {
                $status = StatusResponse::where([
                    ['response_id', $validated['id']],
                    ['user_id', auth()->user()->id]
                ])->first();

                if ($status) $status->delete();
            }
        } else {
            abort(404);
        }
    }
}
