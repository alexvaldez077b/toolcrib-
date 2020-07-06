<?php

namespace App\Http\Controllers;
use Auth;
use App\Bom;
ini_set('max_execution_time', 600); //3 minutes

use App\customerModel;
use App\Item;
use Excel;
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
        if(!Auth::user()->can('edit models')){
            abort(404);
        }
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
        if(!Auth::user()->can('edit models')){
            abort(404);
        }

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
    public function uploadBoom(Request $request)
    {
        if(!Auth::user()->can('edit models')){
            abort(404);
        }

        $in = 0;
        Excel::load($request->csv, function($reader) {
 
            $excel = $reader->get();
     
            // iteracción
            $reader->each(function($row) {

                

                $idmodel = CustomerModel::where('np',$row->model)->first();
                $iditem = item::where('code','like',"%$row->item%")->first();

                

                try{
                    if( $idmodel && $iditem ){
                        
                        
                        $bom = Bom::create([ 'model_id' => $idmodel->id, 'item_id' => $iditem->id, 'quantity' => $row->quantity   ]);
                        echo "INSER: [ ",$iditem->code, ",", $idmodel->np,"] OK <br>";
                        echo $in . " Add items";
                        $in++;
                    }
                }
                catch( \Exception $e ){
                    echo "INSER: [ ",$row->item, ",", $row->model,"] Fail <br>";
                }
            });
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bom  $bom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!Auth::user()->can('edit models')){
            abort(404);
        }
        //
        Bom::where('model_id',$request->modelid)
                  ->where('item_id',$request->itemid)
                  ->update( ['quantity' => $request->quantity] );  

        return response()->json( [ 'status' => 200 ] );


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bom  $bom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if(!Auth::user()->can('edit models')){
            abort(404);
        }
        //
        Bom::where('model_id',$request->modelid)
                  ->where('item_id',$request->itemid)
                  ->delete();
        return response()->json( [ 'status' => 200 ] );

    }
}
