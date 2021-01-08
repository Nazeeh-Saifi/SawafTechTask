<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products= Product::all();
        $products->makeHidden(["SupplierId"]);
        return response()->json([
            'success' => true,
            'message' => 'List of All products',
            'products' => $products,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedRequest = $request->validate([
            "ProductName" => "required|max:50",
            "SupplierId" => "required",
            "UnitPrice" => "required"
        ]);

        $newProduct = Product::create([
            "ProductName" => $request->input('ProductName'),
            "SupplierId" => $request->input('SupplierId'),
            "UnitPrice" => $request->input('UnitPrice')
        ]);
        if($newProduct){
            return response()->json([
                'success' => true,
                'message' => 'added a new product',
                'product' => $newProduct,
            ]);        }
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
        $product = Product::findOrFail($id);
        return response()->json([
            'success' => true,
            'message' => 'one product',
            'product' => $product,
        ]); 
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
        $validatedRequest = $request->validate([
            "ProductName" => "required|max:50",
            "SupplierId" => "required",
            "UnitPrice" => "required"
        ]);

        $oldProduct = Product::findOrFail($id);

        $oldProduct->ProductName = $request->input('ProductName');
        $oldProduct->SupplierId = $request->input('SupplierId');
        $oldProduct->UnitPrice = $request->input('UnitPrice');
        $oldProduct->save();

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
        $product = Product::findOrFail($id);
        if($product->delete()){
            return \response()->json(array(
                'success' => true,
                'message' => "delete a product",
                "product" => $product,
            ));
        }
        
    }
}
