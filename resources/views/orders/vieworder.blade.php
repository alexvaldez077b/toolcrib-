@extends('adminlte::page') @section('title') @section('content_header')
<h1>
    Dashboard
    <small>Version 2.0</small>
</h1>
<ol class="breadcrumb">
     @role('Admin')
     <li>
        {{Auth::user()->roles->first()->name}}
    </li>
    @endrole
     
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Home</a>
    </li>
    <li class="active">Dashboard</li>
</ol>
@stop @section('content')
<div class="row">
    <div class="col-md-12">
        
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 ">
    <div class="box box-solid box-info">
        <div class="box-header">
            <h2>Items list</h2>
            
            <ul>
                <li> Order #{{$order->id}} </li>
                <li> Name: {{$order->name}} </li>
		<li> Area: {{ $order->area == 1?"SMT":"FINAL" }} {{ $order->area==2?"N/A":"" }}  </li>
                <li> Created_at: {{$order->created_at}} </li>
            </ul>

            <div class="box-tools pull-right">

            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            @if($order->status < 2)
            
            <button class="btn btn-success" onclick="closeOrder({{$order->id}},this)"> {{ $order->status == 0 ? "Close order":"Save order" }}   <i class="fa fa-save"></i> </button>
            
            @endif
            </div>
        </div>
        <div class="box-body">
            <table id='items' class="table table-responsive">
                <thead>
                    <tr>
                        <th> Code</th>
                        <th> Description</th>
                        <th> Quantity </th>
                        <th> Delivery </th>
                        <th> Actions </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $key => $row )
                        <tr>
                            <td> {{ $row->code }}</td>
                            <td> {{ $row->description }}</td>
                            <td> {{ $row->quantity }}</td>
                            <td> {{ $row->delivered }} </td>
                            <td> 
                            @if(is_null($row->delivered))
                            <button id="btn{{$order->id}}{{$row->id}}" class="btn btn-danger" onclick="provide( {{$order->id}}, {{$row->id}}, {{$row->quantity}}, this )"> provide </button> 
                            @endif
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <!-- /.col -->
    
</div>
<!-- /.row -->
<style>
.swal2-popup {
  font-size: 1.6rem !important;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />
@stop

@section("js")

<script>
    function closeOrder(){
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            
        }).then(function (value) {
            if(value.value){
                
                location.replace(`{{ $order->status == 0 ? route('closeOrder',$order->id): url("orders/register?id=$order->id") }}`)
            }
            console.log(value)
            
        //success method
        })      
    

    }

    function provide(order,item, quantity, control) {
        //table.row( parent ).remove().draw();
        

        swal({
            title: 'delivered quantity',
            type: 'question',
            input: 'range',
            inputAttributes: {
                min: 0,
                max: quantity,
                step: quantity % 1 == 0 ? 1 : 0.1,
            },
            inputValue: 0
        }).then(val => {

            swal({
                title: 'Are you sure?',
                text:  "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes...'
            }).then((result) => {
                if (result.value) {
                    $.ajax( {
                        url: "{{ route('provideOrder') }}",
                        method: 'get',
                        data: { id: item, order: order , delivered: val.value },
                        success: response=>{

                            console.log(response);

                            if(response.message){
                                $(`#${control.id}`).remove();
                                
                                //table.row( parent ).remove().draw();
                            }
                            

                        },
                        error: err=>{
                            swal("" , JSON.stringify(err), 'error' );
                        }
                    } )
                }
            })

            // val.value
        })
        
        
        

    }

    $(document).ready( ()=>{
        $('#items').DataTable();
    } )

</script>

@stop
