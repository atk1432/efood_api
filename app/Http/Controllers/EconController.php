<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StatusComment;
 

class EconController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth:api');
    }

    public function send_econ(Request $request, $db) {

        $validated = $request->validate([
            'commentId' => 'required|min:0',
            'like' => 'required|boolean'
        ])

        if ($db == 'comment') {
            if ($validated['like'] == true || $validated['like'] == false) {
                StatusComment::create([
                    'comment_id' => $validated['commentId'],
                    'like' => $validated['like'],
                    'user_id' => auth()->user()->id
                ]);
            }
        } else if ($db == 'response') {
            
        } else {
            abort(404);
        }
    }
}
