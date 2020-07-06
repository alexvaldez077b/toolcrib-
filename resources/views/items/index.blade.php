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
    <li class="active">Index</li>
</ol>
@stop @section('content')
<!--div class="row"-->

<div class="row">
    <div class="col col-md-12">


        <div class="box box-primary">
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
                            <th>Status</th>
                            <th>Lead Time</th>
                            <th>UM Delivery</th>
                            <th>UM Purchase</th>
                            <th>Price</th>
                            
                            <th>Stock</th>

                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($items as $row)
                        <tr>
                            <td> 
                                    <a href="{{ route('ItemView', $row->id) }}" >
                                    {{$row->code}}
                                    <a>
                            </td>
                            <td> {{$row->pn}} </td>
                            <td> {{$row->description}} </td>
                            <td> {{$row->localization}} </td>
                            <td> {{$row->status?"Active":"Inactive"}} </td>
                            <td> {{$row->leadtime}} </td>
                            <td> {{$row->umdelivery}} </td>
                            <td> {{$row->umpurchase}} </td>
                            <td> {{$row->price}} {{ $row->currency?"MXN":"USD" }} </td>
                            
                            
                            <td> {{$row->stock}} </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('ItemUpdate',$row->id) }}" type="button" class="btn btn-xs btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    

                                    <a href="#" class="btn btn-xs btn-{{ $row->status?"success":"danger"}}">
                                        <i class="fa fa-close"></i>
                                    </a>

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

                <button id="InputButton2" class="btn btn-info btn-flat pull-right">Temp CSV/EXCEL</button>
                <button id="InputButton" class="btn btn-warning btn-flat pull-right">Import CSV/EXCEL</button>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
</div>



<!-- Modal -->
<div id="InputFile" class="modal fade" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Load File .CSV</h4>
            </div>
            <form action="{{ route('itemsFile') }}" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for=""> CSV FILE: </label>
                        <input id="fileupload" name="csv" type="file">

                    </div>




                    <table id="tableUpload" class="table table-responsive ">
                        <thead id="header_table"> </thead>
                        <tbody id="body_table"> </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat btn-success">
                        <i class="fa fa-send "></i>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>


<!-- Modal -->
<div id="InputFile2" class="modal fade" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Load File 2 .CSV</h4>
            </div>
            <form action="{{ route('itemsFile2') }}" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label for=""> CSV FILE: </label>
                        <input id="fileupload" name="csv" type="file">

                    </div>




                    <table id="tableUpload" class="table table-responsive ">
                        <thead id="header_table"> </thead>
                        <tbody id="body_table"> </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-flat btn-success">
                        <i class="fa fa-send "></i>
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>


<!--/div-->
<!-- /.row -->
@stop @section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.8.9/jquery.csv.min.js"></script>

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
        $('#records').DataTable(
            {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        }
        );

        $("#InputButton").click(e => {
            $('#InputFile').modal();
        });

         $("#InputButton2").click(e => {
            $('#InputFile2').modal();
        });


        // 

    });

</script>
@stop
