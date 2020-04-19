<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotFoundExcepton;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use App\Product;
use App\Responses\Response;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function productList(Request $request)
    {
        $products = Product::latest()->paginate($request->rowsPerPage);
        $response = (new Response())->make(1, 'Product List Fetched', $products);
        return response()->json($response, 200);
    }

    public function storeProduct(StoreProductRequest $request)
    {
        $product = new Product();
        if($request->has('image') && $request->file('image')) {
            $path = $request->file('image')->storeAs(
                'products', (string)Str::uuid()
            );
            $product->image_path = $path;
        }
        $product->image_path = $path;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->description = $request->description;
        $product->save();
        $response = (new Response())->make(1, 'Product Added');
        return response()->json($response, 200);
    }

    public function updateProduct($id, Request $request)
    {
        $product = Product::find($id);
        if($product) {
            $product->name = $request->name;
            $product->price = $request->price;
            if($request->has('image') && $request->file('image')) {
                $path = $request->file('image')->storeAs(
                    'products', (string)Str::uuid()
                );
                $product->image_path = $path;
            }
            $product->discount = $request->discount;
            $product->description = $request->description;
            $product->save();
        } else {
            throw new ProductNotFoundExcepton('Product Not Found');
        }
        $response = (new Response())->make(1, 'Product Updated');
        return response()->json($response, 200);
    }

    public function deleteProduct($id)
    {
        Product::whereId($id)->delete();
        $response = (new Response())->make(1, 'Product Removed');
        return response()->json($response, 200);
    }

    public function toggleDisable($id)
    {
        $product = Product::find($id);
        $product->status = $product->status ? 0 : 1;
        $product->save();
        $response = (new Response())->make(1, 'Product Updated');
        return response()->json($response, 200);
    }
}
