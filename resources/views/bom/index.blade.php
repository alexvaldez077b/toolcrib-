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
                    <a class="pull-right"></a>
                </li>
                <li class="list-group-item">
                    <b>Total cost</b>
                    <a class="pull-right"></a>
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
                        <div class="col-md-6">
                            <label for=""> Code: </label>
                            <input id="codeajax" class="form-control" disabled>
                            <label for=""> Part Number: </label>
                            <input id="pnajax"  class="form-control" disabled>
                            <label for=""> Description: </label>
                            <input id="descriptionajax" class="form-control" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for=""> Family: </label>
                            <input id="familyajax" class="form-control" disabled>
                            <label for=""> Currency: </label>
                            <input id="currencyajax" type="text" class="form-control" disabled>
                            <label for=""> Price: </label>
                            <input id="priceajax" type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>


            </form>
        </div>
        <div class="box-footer clearfix">
            <button id="addItemBom" class="btn btn-primary pull-right">
                <i class=" fa fa-plus "></i> Add </button>
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
                        <th>Price</th>
                        <th>Lead Time</th>
                        <th>used per unit</th>
                        <th>used per week</th>
                        <th>used per month</th>


                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $row)
                    <tr>

                        <td>{{ $row->code }}</td>
                        <td> {{$row->pn}} </td>
                        <td> {{$row->description}} </td>
                        <td> {{$row->localization}} </td>
                        <td> {{$row->price}} </td>
                        <td> {{$row->leadtime}} </td>
                        <td> {{$row->quantity}} </td>
                        
                        <td> {{ number_format(  ($row->quantity * $model->required_quantity) / 4.34 , 2) }} </td>
                        <td> {{ number_format(  $row->quantity * $model->required_quantity  , 2 )}} </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('customerUpdate',1) }}" type="button" class="btn btn-xs btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-xs btn-info">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <button type="button" class="btn btn-xs  btn-danger">
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
                <i class=" fa fa-plus "></i> New Entry </a>
            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right"></a>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>
</div>




<!--/div-->
<!-- /.row -->
@stop @section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>


<script>
    $(document).ready(e => {
        var table =  $('#records').DataTable();
        console.log( table.rows().data() );


        


        $('#items-select').select2({
            ajax: {
                url: '{{ route("itemAjax") }}',
                
                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            minimumInputLength: 4,
        });

        $('#items-select').change( e=>{

            $.ajax({
                url: '{{ route("item-description") }}',
                data: {
                    id: $('#items-select').val()
                },
                method: "get",
                success: e => {
                    $('#codeajax').val( e.code );
                    $('#descriptionajax').val( e.description );
                    $('#pnajax').val( e.pn );

                    $('#familyajax').val( e.family );
                    $('#currencyajax').val( e.currency );
                    $('#priceajax').val( e.price );
                    
                    console.log(e.description);
                },
                error: e =>{
                    console.log(e);
                }
            })
            
        } );


        $("#addItemBom").click( e=>{
            
            if(!$('#items-select').val() ||  $("#quantity-item").val() <= 0){
                swal('','Check the all fields','error');
                return;
            }

            $.ajax({
                url: '{{ route("addItemToBom") }}',
                data: {
                    item_id: $('#items-select').val(),
                    model_id: {{ $model->id }},
                    quantity: $("#quantity-item").val()

                },
                method: "get",
                success: e => {
                    
                    console.log(e);
                    
                    

                    table.row.add( [ e.data.code,
                                     e.data.pn,
                                     e.data.description,
                                     e.data.localization,
                                     e.data.price,
                                     e.data.leadtime,
                                     e.response.quantity,
                                     "---",
                                     "---",
                                     "--- "
                                      ]  ).draw();

                    
                    console.log(e);
                },
                error: e =>{
                    console.log(e);
                }
            })
        } );
        

    });

</script>
@stop
