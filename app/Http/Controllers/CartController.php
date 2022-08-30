<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Models\Cart;


class CartController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = auth()->user()->carts;

        return CartResource::collection($carts);
    }

    public function amount()
    {
        $count_carts = count(auth()->user()->carts);

        return $count_carts;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required'
        ]);

        $cart = Cart::where([
            ['product_id' => $validated['product_id']],
            ['user_id' => auth()->user()->id]
        ])->first();

        if (!$cart) {
            $cart = Cart::create(array_merge(
                $validated,
                [ 'user_id' => auth()->user()->id ]
            ));
        } 

        return new CartResource($cart);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($cart)
    {
        $cart = Cart::where([
            'product_id' => $cart,
            'user_id' => auth()->user()->id
        ])->first();

        if (!$cart) return [];

        return new CartResource($cart);
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
