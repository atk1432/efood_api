<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Product;


class CommentController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth:api', ['except' => 
            ['index', 'other_comments'] 
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($product)
    {
        if (auth()->user()) {
            $my_comments = Product::findOrFail($product)
                                    ->my_comments;
        } else {
            return [];
        }

        return CommentResource::collection($my_comments);

    }

    public function other_comments(Request $request, $product)
    {
        $offset = $request->get('offset') - 1 ?? 0;
        $limit = $request->get('limit') ?? 3;

        if (auth()->user()) {
            $comments = Product::findOrFail($product)
                                ->other_comments()
                                ->where('user_id', '<>', auth()->user()->id)
                                ->get();
        } else {
            $comments = Product::findOrFail($product)
                                ->other_comments;
        }

        $comments = json_decode(CommentResource::collection($comments)->toJson());

        return array_slice($comments, $offset, $limit);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $product)
    {
        $validated = $request->validate([
            'comment' => 'required|max:200',
            'rate' => 'required|min:1|max:5|integer'
        ]);

        $product = Product::findOrFail($product);

        $comment = Comment::create(
            array_merge($validated, [
                'product_id' => $product->id,
                'user_id' => auth()->user()->id
            ])
        );

        $count = count($product->comments);
        $rate = intval($validated['rate']);
        $initial = $product->rate * ($count - 1);

        $product->update(['rate' => 
            round(($initial + $rate) / $count, 1)
        ]);

        return new CommentResource($comment);
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
        //
    }
}
