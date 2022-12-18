<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderItem;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Storage;

class ProductController extends Controller
{
    public function uploadFile (Request $request) {
        if($request->file()) {
            $fileName = time().'_'.$request->file->hashName();
            $filePath = Storage::putFile('public/products/', $request->file('file'));
            $storageName = basename($filePath);
        }

        return $storageName;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|max:255',
            'type' => 'required|in:"hot dish", "cold dish", "drink", "dessert"',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
         ]);
        $request->validate([
         ]);
		
        if($request->file()) {
            $storageName = $this->uploadFile($request);
        }
 
        $product = new Product([
            "name"=>$request->get('name'),
            "type"=>$request->get('type'),
            "description"=>$request->get('description'), 
            "photo_url"=>$storageName,
            "price"=>$request->get('price'),
		]);
		
		$product->save();

        return response()->json(['message' => 'success']);
    
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:"hot dish", "cold dish", "drink", "dessert"',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'photo_url'=> 'required|string|max:255'
         ]);

        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->type = $request->input('type');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        $requestPhotoUrl = $request->input('photo_url');
        $currentProductPhotoUrl = $product->photo_url;

        if ($requestPhotoUrl != $currentProductPhotoUrl) {
            if($request->file()) {
                $request->validate([
                    'file' => 'required|mimes:jpg,jpeg,png|max:2048',
                ]);
                $storageName = $this->uploadFile($request);
                $product->photo_url = $storageName;
            }
        }
        else {
            $product->photo_url = $request->input('photo_url');
        }

        
        $product->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $orders = OrderItem::where('product_id', $id)->delete();
        
        $product = Product::findOrFail($id);
        $product->delete();
    }
}
