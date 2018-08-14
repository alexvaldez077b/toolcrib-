<?php

namespace App\Http\Controllers;

use App\Bom;
use App\customerModel;
use App\Item;
use Illuminate\Http\Request;

class BomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $model = customerModel::where('id', $request->id)->first();

        $items = Bom::where('model_id', $request->id )->leftJoin('items', 'items.id', '=', 'boms.item_id') ->get();

        //print_r($items);

        return view('bom.index')->with( 'model', $model )->with('items' , $items);
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

        $bom = Bom::create([ 'model_id' => $request->model_id, 'item_id' => $request->item_id, 'quantity' => $request->quantity   ]);
        $item = Item::where('id', $request->item_id)->first();

        return response()->json( array( 'response' => $bom, 'data' => $item ) );


 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bom  $bom
     * @return \Illuminate\Http\Response
     */
    public function show(Bom $bom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bom  $bom
     * @return \Illuminate\Http\Response
     */
    public function edit(Bom $bom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bom  $bom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bom $bom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bom  $bom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bom $bom)
    {
        //
    }
}
