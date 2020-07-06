@extends('adminlte::page') @section('title') @section('content_header')
<h1>
    Dashboard
    <small>Version 2.0</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Items</a>
    </li>
    <li class="active">Details</li>
</ol>
@stop @section('content')

<div class="row">



    <div class="col-md-12">
        @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
    </div>

    <div class="container">

        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header"></div>
                <div class="box-body">
                    <canvas id="myChart" height="50"> </canvas>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-8">
        <div class="box box-info">
            <div class="box-header">
                datatable
            </div>
            <div class="box-body">

                <table id="tbl" class="table">
                    <thead>
                        <tr>
                            <td>Customer</td>
                            <td>Model</td>
                            <td>demand</td>
                            <td>Quantity (M)</td>

                        </tr>


                    </thead>

                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td> {{$row->name}} </td>
                            <td> 
                                <a href="{{ route('model_bom', $row->model_id )  }}"> 
                                {{$row->np}} 
                                </a> 
                            </td>
                            <td> {{$row->required_quantity}} </td>
                            <td>
                                <span class="acum">{{$row->quantity*$row->required_quantity}}</span>
                                {{$item->umdelivery}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="col-md-4">


        <div class="box box-primary">
            <div class="box box-header">
                @if( $item->stock
                < $data->sum('quantity') )
                    <div class="alert alert-danger">
                        <p> the inventory is below the minimum limit </p>
                    </div>
                    @endif
            </div>
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive" style="width:150px; height:150px; " @if($item->image!="")
                src="{{ URL::asset("../storage/app/public/$item->image") }}" @else src="{{ url('/img/default.png') }}"
                @endif alt="picture">
                <h3 class="text-muted text-center">{{$item->code}}</h3>

                <ul class="list-group list-group-unbordered">

                    <li class="list-group-item">
                        <b>Description</b>
                        <p>{{ $item->description }}</p>
                    </li>
                    <li class="list-group-item">
                        <b>Lead Time</b>
                        <a class="pull-right">{{ $item->leadtime }}</a>
                    </li>

                    <li class="list-group-item">
                        <b>Stock</b>
                        <a class="pull-right">{{ $item->stock }}</a>
                    </li>

                    <li class="list-group-item">
                        <b>Min</b>
                        <a class="pull-right" id="min"></a>
                    </li>
                    <li class="list-group-item">
                        <b>Max</b>
                        <a class="pull-right" id="max"></a>
                    </li>

                    <li class="list-group-item">
                        <b>Min $</b>
                        <a class="pull-right" id="min-price"></a>
                    </li>
                    <li class="list-group-item">
                        <b>Max $</b>
                        <a class="pull-right" id="max-price"></a>
                    </li>






                </ul>

                <a href="#" class="btn btn-primary btn-block">
                    <b>Follow</b>
                </a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>



</div>


@stop @section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

<script>
    $(document).ready(e => {

        let min = 0;

        $(".acum").each((index, elem) => {
            console.log(index + " -> " + $(elem).text())
            min += parseFloat($(elem).text());

        }).promise().done(function () {
            console.log('Did things to every .element, all done.');
            $('#tbl').DataTable(
            {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        }
        );

        });



        $("#min").html(min.toFixed(2) + "  {{$item->umdelivery}}");
        $("#max").html((min * 1.25).toFixed(2) + "  {{$item->umdelivery}}");
        $("#min-price").html(((min * {{$item -> price}}).toFixed(2) + "{{ $item->currency?'MXN':'USD' }}"));
        $("#max-price").html((((min * 1.25) * {{$item -> price}}).toFixed(2) + "{{ $item->currency?'MXN':'USD' }}"));

        console.log(min);

        var ctx = $("#myChart");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [moment().subtract(2, 'months').format("MMM"), moment().subtract(1, 'months').format(
                    "MMM"), moment().format("MMM")],

                datasets: [{
                        label: 'Max',
                        data: [min * 1.25, min * 1.25, min * 1.25],
                        backgroundColor: "rgb(255, 0, 0)",
                        "fill": false,
                        "borderColor": "rgb(255, 0, 0)",
                        "lineTension": 0.1
                    },
                    {
                        label: 'Min',
                        data: [min, min, min],
                        backgroundColor: "rgb(0, 0, 255)",
                        "fill": false,
                        "borderColor": "rgb(0, 0, 255)",
                        "lineTension": 0.1
                    },
                ],

            },
            options: {
                

                showLines: true,

            }
        });
    });



    /*
    $("#id option").each(function(){
    $(this).attr('selected', true);
});
    */

</script>
@stop
