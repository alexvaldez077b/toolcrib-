<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 180); //3 minutes
use Auth;
use App\customerModel;
use App\Item;
use Excel;
use App\Bom;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
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
    public function index()
    {
        if(!Auth::user()->can('edit items')){
            abort(404);
        }

        $items = Item::all();

        return view('items.index')->with('items',$items);
    }

    public function view(Request $req)
    {
        if(!Auth::user()->can('edit items')){
            abort(404);
        }
        /*
        src
        
        */

        $data = DB::table('customer_models')
            ->join('customers', 'customer_models.customer_id', '=', 'customers.id')    
            ->join('boms', 'boms.model_id', '=', 'customer_models.id')
            ->where('boms.item_id',$req->id)
            ->where('customer_models.status',true)
            ->where('customer_models.required_quantity',">",0)
            
            ->get();
            
        //    print_r($data);

        $item = Item::where('id',$req->id)->first();

        //$data->sum('quantity')

        return view('items.view')->with('data',$data)->with('item',$item);

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
    public function report(Item $item)
    {
        if(!Auth::user()->can('edit items')){
            abort(404);
        }

        //SELECT 
        //boms.item_id, items.id, items.code, items.description, items.price, items.currency, sum(customer_models.required_quantity * boms.quantity) as total 
        //FROM `boms` 
        //left JOIN customer_models on customer_models.id = boms.model_id 
        //left JOIN items on items.id = boms.item_id 
        //GROUP BY boms.item_id

        $data = DB::table('boms')
                ->selectRaw('boms.item_id, items.umpurchase, items.id, items.code, items.description, items.price, items.currency, sum(customer_models.required_quantity * boms.quantity) as total ')
                ->leftJoin('customer_models','customer_models.id','=','boms.model_id')
                ->leftJoin('items','items.id','=','boms.item_id')
                ->where('customer_models.status',true)
                ->where('customer_models.required_quantity',">",0)

                ->groupBy('boms.item_id')
                ->get();


        

        return view( 'items.report', [ 'items' => $data ] );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */

     public function actions(Request $request){

        $item = Item::where('code',$request->code)->first();
        
        if( empty($item) ){
            return redirect()->back()->with("message","Item Not found!");
        }



        switch ($request->action) {
            case '1':
                # insert or updte

                if($request->scope == "2"){
                    Bom::where('item_id',$item->id)
                    ->update([ 'quantity'=> $request->quantity ]);

                    return redirect()->back()->with("message","UPDATED SUCCESSFULLY");

                }
                
                $models = DB::table('customer_models')
                ->where(function($query) use ($request)   {
                    switch ($request->scope) {
                        case '0':
                            # code...
                            $query->where('customer_models.id',$request->model);
                            break;
                        case '1':
                            $query->where('customer_id',$request->customer);
                            # code...
                            break;
                        case '2':
                            $query->where('customer_id',$request->customer);
                            break;
                        
                    }

                 })->get();


                 foreach ($models as $row) {
                     # code...
                     #'model_id', 'item_id', 'quantity',
                     
                     
                     Bom::updateOrCreate(
                        ['model_id' => $row->id, 'item_id' => $item->id],
                        ['model_id' => $row->id,  'item_id'=> $item->id, 'quantity' => $request->quantity ]
                    );
 
                }
                return redirect()->back()->with("message","UPDATED SUCCESSFULLY");
                 


                break;
            case '2':
                # delete

                $models = DB::table('customer_models')
                ->where(function($query) use ($request)   {
                    switch ($request->scope) {
                        case '0':
                            # code...
                            $query->where('customer_models.id',$request->model);
                            break;
                        case '1':
                            $query->where('customer_id',$request->customer);
                            # code...
                            break;
                        
                    }

                 })->get();


                 foreach ($models as $row) {
                     # code...
                     #'model_id', 'item_id', 'quantity',
                     
                     
                     Bom::where( 'model_id', $row->id )->where('item_id',$item->id)->delete();
 
                }
                 return redirect()->back()->with("message","UPDATED SUCCESSFULLY");
                break;
            
            default:
                # code...
                break;
        }



        return $item;

     }
    public function edit(Request $request)
    {
        if(!Auth::user()->can('edit items')){
            abort(404);
        }
        //
        
        $fileName = "";
        $validator = Validator::make($request->all(), [
            'fileToUpload' => 'required|file|max:1024',
        ]);
            
        

        

        if(!$validator->fails()){
            /*$request->validate([
                'fileToUpload' => 'required|file|max:1024',
            ]);*/
     
            $fileName = $request->code.time().'.'.request()->fileToUpload->getClientOriginalExtension();
     
            $request->fileToUpload->storeAs('public',$fileName);
        }
        

        if($request->id < 0)
        {
            Item::create( [ 
                    'code'          =>  $request->code,
                    'description'   =>  $request->description,
                    'localization'  =>  $request->localization,
                    'pn'            =>  $request->pn,
                    'status'        =>  $request->status==1?true:false,
                    'stock'         =>  $request->stock,
                    'family'        =>  $request->family,
                    'umdelivery'   =>   $request->umdelivery,
                    'umpurchase'   =>   $request->umpurchase,
                    'price'         =>  $request->price,
                    'packing'       =>  $request->packing,
                    'leadtime'     =>   $request->leadtime,
                    'currency'      =>  $request->currency==1?true:false,
                    'image'         =>  $fileName!=""?$fileName:null,
             ] );
        }else{
            $item = Item::where('id',$request->id)->first();
            Item::where('id', $request->id )->update( [
                    'code'          =>  $request->code,
                    'description'   =>  $request->description,
                    'localization'  =>  $request->localization,
                    'pn'            =>  $request->pn,
                    'status'        =>  $request->status==1?true:false,
                    'stock'         =>  $request->stock,
                    'family'        =>  $request->family,
                    'umdelivery'   =>   $request->umdelivery,
                    'umpurchase'   =>   $request->umpurchase,
                    'price'         =>  $request->price,
                    'packing'       =>  $request->packing,
                    'leadtime'     =>   $request->leadtime,
                    'currency'      =>  $request->currency==1?true:false,
                    'image'         =>  $fileName!=""?$fileName:$item->image,
            ] );
        }
        return redirect()->back()->with("message","successful operation");
    }


    /*
    .SELECT COUNT (*) AS contador, 
                MONTH(fecha) AS mes
        FROM ventas
    WHERE YEAR(fecha)= 2018
    GROUP BY MONTH(fecha)
    ORDER BY MONTH(fecha) ASC;
    */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        if(!Auth::user()->can('edit items')){
            abort(404);
        }

        //
        $item = Item::where( 'id', $request->id )->first();
        return view('items.update')->with('item',$item);
    }

    public function upload(Request $request)
    {
        if(!Auth::user()->can('edit items')){
            abort(404);
        }
        //
        Excel::load($request->csv, function($reader) {
 
            $excel = $reader->get();
     
            // iteracción
            $reader->each(function($row) {

                //code	description	localization	pn	stock	status	family	umdelivery	um_purchase	price	packing	lead_time	currency
                //echo $row . '<br><br>';
                
                $result = Item::updateOrCreate(
                    ['code'          => $row->code]
                    ,
                    ['code'          => $row->code,
                    'description'   => $row->description,
                    'localization'  => $row->localization,
                    'pn'            => $row->pn,
                    'status'        => true,
                    'stock'         => $row->stock,
                    'family'        => 0,
                    'umdelivery'   => "N/A",
                    'umpurchase'   => "N/A",
                    'price'         => $row->price,
                    'packing'       => 1,
                    'leadtime'     => 15,
                    'currency'      => $row->currency=="P"?true:false]
                );
                

     
            });
        
        });
        
        //return redirect()->back();
    }


    public function upload2(Request $request)
    {
        if(!Auth::user()->can('edit items')){
            abort(404);
        }
        //
        Excel::load($request->csv, function($reader) {
 
            $excel = $reader->get();
     
            // iteracción
            $reader->each(function($value) {

                //echo print($row);
                //code	description	localization	pn	stock	status	family	umWdelivery	um_purchase	price	packing	lead_time	currency
                /*
                
                */


                //foreach ($row as $value) {
                    # code...
                    $item = Item::where('code',$value->code)->first();

                    if($item){
                        
                        $item->description = $value->description;
                        $item->price = $value->price;

                        echo "Update",$item->save();

                        

                    }else{
                        echo $value->code , " : ", $value->price, "not found";
                    }

                    echo "<br>";


                
     
            });
        
        });
        
        //return redirect()->back();
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */

    

    public function destroy(Item $item)
    {
        //
    }
}
