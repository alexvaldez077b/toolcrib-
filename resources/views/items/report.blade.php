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





<div class="container-fluid">


    <div class="row">
        <!-- accepted payments column -->

        <!-- /.col -->
        <div class="col-xs-4">
            <p class="lead">Expense forecast <span id="date"></span></p>

            <div class="table-responsive ">
                <table class="table table-striped">

                    <tr>
                        <th>1 United States Dollar equals</th>
                        <td id="currency"></td>
                    </tr>
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td id="subtotal"></td>
                    </tr>
                    <tr>
                        <th>Margin 5%</th>
                        <td id="margin"></td>
                    </tr>

                    <tr>
                        <th>Total:</th>
                        <td id="all">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->




    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Report</h3>
                @can('edit users')
                <div class="box-tools pull-right">
                    <div class="has-feedback">
                        <input type="text" id="dollar" class="form-control input-sm" placeholder="Dollar">
                        <span class="glyphicon glyphicon-search form-control-feedback"></span>
                    </div>
                </div><!-- /.box-tools -->
                @endcan
            </div>
            <div class="box-body">

                <table id="tbl" class="table">
                    <thead>
                        <tr>
                            <td>Item</td>
                            <th>Description</th>
                            <td>Total (monthly)</td>
                            <td>Price</td>
                            <td> <i class="fa fa-money"></i> (monthly) </td>
                            <td> Total DLL's </td>



                        </tr>


                    </thead>

                    <tbody>
                        @foreach($items as $row)
                        <tr>
                            <td>
                                <a href="{{ route('ItemView', $row->item_id) }}">
                                    {{$row->code}}
                                    <a>
                            </td>
                            <td> {{$row->description}} </td>
                            <td> {{ number_format( ceil( $row->total ) ,2 )}}, {{$row->umpurchase}} </td>
                            <td>
                                {{$row->price}} {{ $row->currency?"MXN":"USD" }}

                            </td>
                            <td> <span class="acum"> {{ number_format( ceil( $row->total ) * $row->price, 2) }} {{
                                    $row->currency?"MXN":"USD" }} </span> </td>
                            <td> <span class="temp">  </span> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
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

<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

<script>
    $(document).ready(e => {

        $("#date").text(moment().format("MMM  YYYY "));


    });
    @can('edit users')
    $("#dollar").keydown( e=>{

        if(e.keyCode != 13){
            return;
        }

            DLL = $("#dollar").val();

            $("#currency").text(DLL + " MXN");
            let cost = 0;

            $(".acum").each((index, elem) => {

                let temp = parseFloat($(elem).text().replace(/,/g, ''));

                if ($(elem).text().includes("MXN")) {
                    if (temp > 0) {
                        temp /= DLL;
                    }
                }


                
                $($('.temp')[index]).text(temp);

                cost += parseFloat(temp);
                console.log(index + ":" + temp + "," + " Acum: " + cost);
            
            
            }).promise().done(function () {

                $("#subtotal").text(numeral(cost).format('0,0[.]00 $'));
                $("#margin").text(numeral(cost * 0.05).format('0,0[.]00 $'));
                $("#all").text(numeral(cost * 1.05).format('0,0[.]00 $'));


                
            });



    } ) 
    @endcan

    let DLL = "";
    let PPU = 0;
    var table = null;
    $.ajax({
        url: "http://www.floatrates.com/daily/usd.json",
        method: "get",
        crossDomain: true,
        success: resp => {
            console.log(resp);
            DLL = parseFloat(resp.mxn.rate);
            $("#dollar").val( DLL )
            $("#currency").text(DLL + " MXN");
            let cost = 0;

            $(".acum").each((index, elem) => {

                let temp = parseFloat($(elem).text().replace(',', '').replace(',', '')).toFixed(3);

                if ($(elem).text().includes("MXN")) {
                    if (temp > 0) {
                        temp = temp / DLL;
                    }
                    
                    
                
                }

                $($('.temp')[index]).text(numeral(temp).format('0,0[.]00 $'));

                cost += parseFloat(temp);
                console.log(index + " : [" + temp + "," + parseFloat($(elem).text()) + "] Acum: " + cost);
            
            
            }).promise().done(function () {

                $("#subtotal").text(numeral(cost).format('0,0[.]00 $'));
                $("#margin").text(numeral(cost * 0.05).format('0,0[.]00 $'));
                $("#all").text(numeral(cost * 1.05).format('0,0[.]00 $'));


                table = $('#tbl').DataTable({
                    dom: 'B',
                    paging: false,
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ]
                });
            });

        },
        error: err => {

            DLL = 18;

        }
    })

</script>
@stop
