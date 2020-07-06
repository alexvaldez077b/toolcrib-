<?php

namespace App\Http\Controllers;

use App\order_items;
use Illuminate\Http\Request;

class OrderItemsController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\order_items  $order_items
     * @return \Illuminate\Http\Response
     */
    public function show(order_items $order_items)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\order_items  $order_items
     * @return \Illuminate\Http\Response
     */
    public function edit(order_items $order_items)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\order_items  $order_items
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, order_items $order_items)
    {
        //
        order_items::where('id_order', $req->order)
                  ->where('id_item', $req->id)
                  ->update(['delivered' => $req->delivered ]);
    
                  return response()
                  ->json(['message' => true ]);
                  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\order_items  $order_items
     * @return \Illuminate\Http\Response
     */
    public function destroy(order_items $order_items)
    {
        //
    }
}
