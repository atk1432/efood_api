<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\UserInfo;
use App\Models\Cart;
use App\Http\Request\OrderRequest;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $now = Carbon::now();

        $user_info = UserInfo::create($validated);

        $products = $validated['products'];

        $validator = function ($data) {
            $validated = Validator::make($data, [
                'product_id' => 'required|integer',
                'amount' => 'required|integer:min:1'
            ]);

            if ($validated->stopOnFirstFailure()->fails()) {
                return false
            }

            return true;

        };
        

        Cart::insert(array_map(function ($data) use ($now, $validator) {

            // Check validation
            if (!$validator($data) abort(400);

            return [
                'user_info_id' => $user_info->id,
                'user_id' => auth()->user()->id,
                'product_id' => $data->product_id,
                'amount' => $data->amount,
                'created_at' => $now,
                'updated_at' => $now
            ]
        }, $products));

        Order::create([
            'user_info_id' => $user_info->id,
            'user_id' => auth()->user()->id,
            'product_id' => 
        ]);

        return 
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
