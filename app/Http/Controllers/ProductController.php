<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Type;
use Carbon\Carbon;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return ProductCollection::collection(Product::all());
        // return Product::all()->toArray();
        // return $request->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return ['hello'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {   
        $validated = $request->validated();
        $now = Carbon::now();
        
        // return $validated;
        $check_exist_errors = Type::check_exist($validated['types']);

        if ($check_exist_errors['success'] != true) 
        {   
            return $check_exist_errors;
        }

        $product = Product::create($validated);

        DB::table('product_type')->insert(
            array_map(function ($data) use ($now, $product) {
                return [
                    'product_id' => $product->id,
                    'type_id' => $data->id,
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }, $check_exist_errors['data'])
        );

        return [ 'success' => true ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {  
        $product = Product::findApi($product);

        return new ProductCollection($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $product)
    {
        $validated = $request->validated();
        $now = Carbon::now();

        $product = Product::find($product);

        if (!$product) return ['success' => false, 'errors' => 'Not found'];

        $product->update($validated);

        if ($validated != NULL && !empty($validated['types']) ) {
            $check_exist_errors = Type::check_exist($validated['types']);

            if ($check_exist_errors['success'] != true) 
            {   
                return $check_exist_errors;
            }

            DB::table('product_type')
                ->where('product_id', $product->id)
                ->delete();

            DB::table('product_type')->insert(
                array_map(function ($data) use ($now, $product) {
                    return [
                        'product_id' => $product->id,
                        'type_id' => $data->id,
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                }, $check_exist_errors['data'])
            );
        }

        return [ 'success' => true ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        $product = Product::find($product);

        $product->delete();

        return [ 'success' => true ];
    }
}
