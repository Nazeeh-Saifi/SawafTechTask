<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

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
        $orders= Order::all();
        // $orders->makeHidden(["CustomerId"]);
        return response()->json([
            'success' => true,
            'message' => 'List of All orders',
            'orders' => $orders,
        ]);
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
        //
        
        $validatedRequest = $request->validate([
            "OrderDate" => "required",
            "CustomerId"=> "required",
            "Products"=> "required",
        ]);

        $newOrderNumber = Order::max("OrderNumber") + 1;
        

        $products = json_decode($request->input('Products'));
        
        $TotalAmount=0;
        foreach($products as $product){
            $TotalAmount += $product->UnitPrice * $product->Quantity;
        }

        $newOrder = Order::create([
            "OrderDate" => $request->input('OrderDate'),
            "CustomerId"=> $request->input('CustomerId'),
            "TotalAmount"=> $TotalAmount,
            "OrderNumber" => $newOrderNumber,
        ]);

        foreach($products as $product){
            $newOrder->products()->attach($product->id,["Quantity" => $product->Quantity, "UnitPrice" => $product->UnitPrice]);
        }

        
        if($newOrder){
            return response()->json([
                'success' => true,
                'message' => 'added a new product',
                'order' => $newOrder,
            ]);        
        }
        

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
        $order= Order::with("products")->findOrFail($id);
        return \response()->json(array(
            'success' => true,
            'message' => "get one order",
            "order" => $order,
        ));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // return json_decode($request->input('Products'));

        $validatedRequest = $request->validate([
            "OrderDate" => "required",
            "CustomerId"=> "required",
            "Products"=> "required",
        ]);

        $newOrderNumber = Order::max("OrderNumber") + 1;
        

        $products = json_decode($request->input('Products'));
        
        $TotalAmount=0;
        $syncArray=array();
        foreach($products as $product){
            $TotalAmount += $product->UnitPrice * $product->Quantity;
            $syncArray[$product->id] = ["Quantity" => $product->Quantity, "UnitPrice" => $product->UnitPrice];

        }

        $oldOrder = Order::findOrFail($id);
        $oldOrder->OrderDate =  $request->input('OrderDate');
        $oldOrder->CustomerId = $request->input('CustomerId');
        $oldOrder->TotalAmount = $TotalAmount;
        $saved = $oldOrder->save();
        
        // foreach($products as $product){
        //     $oldOrder->products()->sync([$product->id => ["Quantity" => $product->Quantity, "UnitPrice" => $product->UnitPrice]]);
        // }

        $oldOrder->products()->sync($syncArray);
        if($saved){
            return \response()->json(array(
                'success' => true,
                'message' => "updated an order",
                "order" => $oldOrder,
            ));
        }


        
        

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
        $order = Order::findOrFail($id);
        if($order->delete()){
            return \response()->json(array(
                'success' => true,
                'message' => "delete a order",
                "order" => $order,
            ));
        }
    }
}
