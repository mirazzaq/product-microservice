<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return $this->successResponse($products);
    }

    public function show($product)
    {
        $product = Product::findOrFail($product);
        return $this->successResponse($product);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:1|max:200'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return $this->errorResponse($validator->errors()->all(), 422);
        }

        $product = Product::create($request->all());
        return $this->successResponse($product);

    }

    public function update(Request $request, $product)
    {
        $rules = [
            'name' => 'max:255',
            'price' => 'numeric|min:1|max:200'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            return $this->errorResponse($validator->errors()->all(), 422);
        }
        $product = Product::findOrFail($product);
        $product = $product->fill($request->all());

        if ($product->isClean()) {
            return $this->errorResponse('at least one value must be change',
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product->save();
        return $this->successResponse($product);
    }


    public function destroy($product)
    {

        $product = Product::findOrFail($product);
        $product->delete();
        return $this->successResponse($product);
    }

}
