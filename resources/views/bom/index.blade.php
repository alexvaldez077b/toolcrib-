@extends('adminlte::page') @section('title') @section('content_header')
<h1>
    Dashboard
    <small>Version 2.0</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Model</a>
    </li>
    <li class="active">Bom</li>
    <li class="active">Index</li>
</ol>
@stop @section('content')
<!--div class="row"-->
<div class="row">
    <div class="col-md-12">

    @if (session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
        @endif
    </div>
    <div class="col-md-2">

        

        <!-- Profile Image -->
        <div class="box box-info">
            <div class="box-body">


                <h3 class="profile-username text-center">{{ $model->pn }}</h3>

                <p class="text-muted text-center">{{ $model->family }}</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>amount required per month </b>
                        <a class="pull-right">{{ $model->required_quantity }}</a>
                        <button onclick="editQuantity( {{$model->id}} )" class="btn btn-block btn-primary btn-flat" > <i class="fa fa-edit"></i> Edit quantity </button>
                    </li>
                    <li class="list-group-item">
                        <b>amount required per week </b>
                        <a class="pull-right">{{ number_format( $model->required_quantity/4.3 , 2) }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>amount required per day </b>
                        <a class="pull-right">{{ number_format( $model->required_quantity/30.4, 2) }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>number of items required</b>
                        <a class="pull-right"> {{ $items->count() }} </a>
                    </li>
                    <li class="list-group-item">
                        <b>Total cost (PPU)</b>
                        <a class="pull-right">  <span id="PPU" ></span> </a>
                    </li>
                    <li class="list-group-item">
                        <b>Total cost (PPM)</b>
                        <a class="pull-right">  <span id="PPM" ></span> </a>
                    </li>
                </ul>


            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


    </div>
    <!-- /.col -->
    <div class="col-md-10">

        <div class="box box-success">
            <div class="box-body">
                <form action="">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for=""> Code </label>
                            <select class="form-control" name="" id="items-select">

                            </select>

                        </div>
                        <div class="form-group">
                            <label for=""> Quantity for Unit </label>
                            <input type="number" step="0.001" id="quantity-item" class="form-control">

                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label for=""> Code: </label>
                                <input id="codeajax" class="form-control" disabled>
                                <label for=""> Part Number: </label>
                                <input id="pnajax" class="form-control" disabled>
                                <label for=""> Description: </label>
                                <input id="descriptionajax" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for=""> Family: </label>
                                <input id="familyajax" class="form-control" disabled>
                                <label for=""> Currency: </label>
                                <input id="currencyajax" type="text" class="form-control" disabled>
                                <label for=""> Price: </label>
                                <input id="priceajax" type="text" class="form-control" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for=""> UM Delivery: </label>
                                <input id="delivery" class="form-control" disabled>
                                <label for=""> UM Purchase: </label>
                                <input id="purchase" type="text" class="form-control" disabled>
                                
                            </div>
                        </div>
                    </div>


                </form>
            </div>
            <div class="box-footer clearfix">
                @can('edit items')
                <button class="btn btn-warning" onclick=" $('#itemUpdateCtl').modal() "> Actions </button>
                <button id="addItemBom" class="btn btn-primary pull-right">
                    <i class=" fa fa-plus "></i> Add </button>
                @endcan
            </div>

        </div>

    </div>
    <div class="col col-md-10">


        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body ">
                <table class="table table-bordered" id="records">
                    <thead>
                        <tr>

                            <th>Code</th>
                            <th>Part Number</th>
                            <th>Description</th>
                            <th>Localization</th>
                            <th>U.M.</th>
                            <th>Price</th>
                            <th>Lead Time</th>
                            <th>used per unit</th>
                            <th>used per week</th>
                            <th>used per month</th>

                            <th>PPU</th>


                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($items as $row)
                        <tr>

                            <td>    <a href="{{ route('ItemView', $row->id) }}" >
                                        {{ $row->code }}
                                    </a> 
                                
                            </td>
                            <td> {{$row->pn}} </td>
                            <td> {{$row->description}} </td>
                            <td> {{$row->localization}} </td>
                            <td> {{ $row->umdelivery }} </td>
                            <td> {{$row->price}} {{$row->currency?"MXN":"USD"}} </td>
                            <td> {{$row->leadtime}} </td>
                            <td> {{$row->quantity?$row->quantity:0}}  </td>

                            <td> {{ number_format( ($row->quantity * $model->required_quantity) / 4.34 , 2) }}  </td>
                            <td> {{ number_format( $row->quantity * $model->required_quantity , 2 )}}  </td>

                            <td> {{$row->quantity * $row->price }} {{$row->currency?"MXN":"USD"}}  </td>

                            <td>
                                <div class="btn-group">
                                    <button onclick="update({{$model->id}},{{$row->id}},{{$row->quantity?$row->quantity:0}},`{{$row->description}}`)" class="btn btn-xs btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    

                                    <button onclick="delete_item({{$model->id}},{{$row->id}})" class="btn btn-xs  btn-danger">
                                        <i class="fa fa-close"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>



                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <a href="{{ route('itemUpdate') }}" class="btn btn-success btn-flat pull-left">
                    <i class=" fa fa-plus "></i> New Entry</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right"></a>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
</div>



<!-- Modal -->
<div id="itemUpdateCtl" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Item</h4>

        

      </div>
      <form action="{{ route('item_action') }}" method="post">
      <div class="modal-body">
        
            @csrf
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                You won't be able to revert this!
                
            </div>
            <input type="text" hidden name="model" value="{{ $model->id }}">
            <input type="text" hidden name="customer" value="{{$model->customer_id}}">
            <div class="form-group">
                <label for=""> ITEM CODE </label>
                <input class="form-control" required type="text" name="code" id="item_code">
            </div>
            <div class="form-group">
                <label for=""> ACTION </label>
                <select class="form-control" name="action" id="">
                    <option value="1">Insert or update</option>
                    <option value="2">Delete</option>
                </select>
            </div>
            <div class="form-group">
                <label for=""> QUANTITY </label>
                <input class="form-control" value="0" required type="number" min="0" name="quantity" >
            </div>
            <div class="form-group">
                <label  for=""> APPLY </label>
                <select class="form-control" name="scope">
                    <option value="0">This model</option>
                    <option value="1">All models (this customer)  </option>
                    <option value="2">All models (where use)  </option>
                    <option value="3">All model (All customers)</option>
                </select>
            </div>
        
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" type="submit"> <i class="fa fa-send"></i> Send</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>


<!--/div-->
<!-- /.row --><style>
    .swal2-popup {
        font-size: 1.6rem !important;
    }

</style>
@stop @section('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>


<script>
function editQuantity(id){
    swal({
            title:  `Enter new quantiity for this model`,
            input: 'number',
            inputPlaceholder: `Enter new quantity`
        }).then( val =>{

            if(val.value>0){
                swal({
                    title: 'Are you sure?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.value) {
                        
                        $.ajax({
                            url: `{{ route('update-quantityformodel') }}`,
                            method: 'get',
                            data: { modelid: id, quantity: val.value },
                            success: response =>{
                                if( response.status == 200 ){
                                        swal({
                                            //position: 'top-end',
                                            type: 'success',
                                            title: 'Your work has been saved',
                                            showConfirmButton: false,
                                            timer: 1000,
                                            onClose: () => {
                                                window.location.reload();
                                            }
                                            })
                                }
                                console.log(response);
                            },
                            error: err=>{
                                console.log(err);
                            }
                        })

                    }
                    })
            }
        } );
}
    function delete_item(modelId, itemId) {
        swal({
                    title: 'Are you sure?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.value) {
                        
                        $.ajax({
                            url: `{{ route('delete-itemforbom') }}`,
                            method: 'get',
                            data: { itemid: itemId, modelid: modelId },
                            success: response =>{
                                if( response.status == 200 ){
                                        swal({
                                            //position: 'top-end',
                                            type: 'success',
                                            title: 'Your work has been saved',
                                            showConfirmButton: false,
                                            timer: 1000,
                                            onClose: () => {
                                                window.location.reload();
                                            }
                                            })
                                }
                                console.log(response);
                            },
                            error: err=>{
                                console.log(err);
                            }
                        })

                        
                    }
                    })
        
    }
    function update(modelId, itemId, quantity, itemname) {
        swal({
            title:  `Enter new quantiity for ${itemname}`,
            input: 'number',
            inputPlaceholder: `Enter new quantiity for ${itemname}`
        }).then( val =>{

            if(val.value>0){
                swal({
                    title: 'Are you sure?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                    if (result.value) {
                        
                        $.ajax({
                            url: `{{ route('update-quantityforunit') }}`,
                            method: 'get',
                            data: { itemid: itemId, modelid: modelId, quantity: val.value },
                            success: response =>{
                                if( response.status == 200 ){
                                        swal({
                                            //position: 'top-end',
                                            type: 'success',
                                            title: 'Your work has been saved',
                                            showConfirmButton: false,
                                            timer: 1000,
                                            onClose: () => {
                                                window.location.reload();
                                            }
                                            })
                                }
                                console.log(response);
                            },
                            error: err=>{
                                console.log(err);
                            }
                        })

                        
                    }
                    })
            }
        } );

        
        console.log(modelId + " - " + itemId + " - " + quantity);
    }

    $(document).ready(e => {
        var table = $('#records').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        let DLL = "";
        let PPU = 0;
        $.ajax({
            url:"http://www.floatrates.com/daily/usd.json",
            method: "get",
            success: resp =>{
                console.log( resp );
                DLL = parseFloat(resp.mxn.rate);

                console.log(DLL);

                $(table.rows().data()).each( (index,element)=>{

                    if( element[10].includes("MXN")  ){
                        PPU += ( parseFloat(element[10]) / DLL );
                    }else{
                        PPU += parseFloat( element[10] );
                    }
                    

                    //console.log( element[10] );
                } );

                $("#PPU").html( PPU.toFixed(2) + " USD" );

                $("#PPM").html((PPU * {{ $model->required_quantity }}).toFixed(2) );

       

            },
            error: err=>{

                DLL = 18;

            }
        })
        

        //console.log(table.rows().data());

        
        

        


        $('#items-select').select2({
            ajax: {
                url: '{{ route("itemAjax2") }}',

                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            minimumInputLength: 4,
        });

        $('#items-select').change(e => {

            $.ajax({
                url: '{{ route("item-description") }}',
                data: {
                    id: $('#items-select').val()
                },
                method: "get",
                success: e => {

                    $('#codeajax').val(e.code);
                    $('#descriptionajax').val(e.description);
                    $('#pnajax').val(e.pn);

                    $('#familyajax').val(e.family);
                    $('#currencyajax').val(e.currency);
                    $('#priceajax').val(e.price);
                    $('#delivery').val(e.umdelivery)
                    $('#purchase').val(e.umpurchase)

                    console.log(e);
                },
                error: e => {
                    console.log(e);
                }
            })

        });


        $("#addItemBom").click(e => {

            if (!$('#items-select').val() || $("#quantity-item").val() <= 0) {
                swal('', 'Check the all fields', 'error');
                return;
            }

            $.ajax({
                url: '{{ route("addItemToBom") }}',
                data: {
                    item_id: $('#items-select').val(),
                    model_id: {{$model->id}},
                    quantity: $("#quantity-item").val()

                },
                method: "get",
                success: e => {

                    console.log(e);



                    table.row.add([e.data.code,
                        e.data.pn,
                        e.data.description,
                        e.data.localization,
                        e.data.price,
                        e.data.leadtime,
                        e.response.quantity,
                        "---",
                        "---",
                        "--- ",
			"",
			""
                    ]).draw();

 swal({
                                            //position: 'top-end',
                                            type: 'success',
                                            title: 'Your work has been saved',
                                            showConfirmButton: false,
                                            timer: 1000,
                                            onClose: () => {
                                                //window.location.reload();
                                            }
                                            })



                    console.log(e);
                },
                error: e => {
			swal('error', e.message, 'error')
                    console.log(e);
                }
            })
        });


    });

</script>
@stop
