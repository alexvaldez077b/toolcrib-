<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 180); //3 minutes
use App\Item;
use Excel;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();

        return view('items.index')->with('items',$items);
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
    public function store(Request $req)
    {
        return response()->json( array( 'id' => $req->id, 'quantity' => $req->quantity ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
        return view('items.update');
    }

    public function upload(Request $request)
    {
        //
        Excel::load($request->csv, function($reader) {
 
            $excel = $reader->get();
     
            // iteracción
            $reader->each(function($row) {

                //code	description	localization	pn	stock	status	family	um_delivery	um_purchase	price	packing	lead_time	currency
                
                $result = Item::updateOrCreate(
                    ['code'          => $row->code]
                    ,
                    ['code'          => $row->code,
                    'description'   => $row->description,
                    'localization'  => $row->localization,
                    'pn'            => $row->pn,
                    'status'        => $row->status=="S"?true:false,
                    'stock'         => $row->stock,
                    'family'        => $row->family,
                    'umdelivery'   => $row->um_delivery,
                    'umpurchase'   => $row->um_purchase,
                    'price'         => $row->price,
                    'packing'       => $row->packing,
                    'leadtime'     => $row->lead_time,
                    'currency'      => $row->currency=="P"?true:false]
                );

     
            });
        
        });
        echo $result;
        //return redirect()->back();
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */

    public function filter(Request $req)
    {
        //
        $items = Item::where('status',true)->where('code',"like","%$req->q%")->orWhere('description',"like","%$req->q%")->get();
        


        $elms = [];

        foreach ($items as $row) {
            # code...
            array_push($elms, array( 'id'=> $row->id, 'text' => "$row->code || $row->description" )  );

        }

        return json_encode(array( 'results' => $elms));

    }
        
    public function details(Request $req)
    {
        return response()->json( Item::where('id',$req->id)->first());
    }

    public function destroy(Item $item)
    {
        //
    }
}
