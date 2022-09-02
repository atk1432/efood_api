<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\UserInfo;
use App\Models\Cart;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $status = $request->get('status');

        $orders = Order::where([
            'user_id'  => auth()->user()->id,
            'status' => $status
        ])->get();

        if (!$orders) return [];

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {   
        $validated = $request->validated();
        $products = $validated['products'];
        $now = Carbon::now();

        unset($validated['products']);
        $user_info = UserInfo::create($validated);


        if (!$products) abort(400);

        $validator = function ($data) {
            $validated = Validator::make($data, [
                'product_id' => 'required',
                'amount' => 'required|integer|min:1'
            ]);

            if ($validated->stopOnFirstFailure()->fails()) {
                return false;
            }

            return true;

        };
        
        $order = Order::create([
            'user_info_id' => $user_info->id,
            'user_id' => auth()->user()->id
        ]);

        OrderProduct::insert(array_map(function ($data) use (
            $now, $validator, $user_info, $order
        ) {

            // Check validation
            if (!$validator($data)) abort(400);

            return [
                'order_id' => $order->id,
                'product_id' => $data['product_id'],
                'amount' => $data['amount'],
                'created_at' => $now,
                'updated_at' => $now
            ];

        }, $products));


        $carts = Cart::where(['user_id' => auth()->user()->id]);

        $carts->delete();

        return [ 'success' => true ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
