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
                            <th>family</th>
                            <th>Lead Time</th>
                            <th>UM Delivery</th>
                            <th>UM Purchase</th>
                            <th>Price</th>
                            <th>Priority</th>
                            <th>Currency</th>

                            <th>Stock</th>

                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($items as $row)
                        <tr>
                            <td> {{$row->code}} </td>
                            <td> {{$row->pn}} </td>
                            <td> {{$row->description}} </td>
                            <td> {{$row->localization}} </td>
                            <td> {{$row->family}} </td>
                            <td> {{$row->leadtime}} </td>
                            <td> {{$row->umdelivery}} </td>
                            <td> {{$row->umpurchase}} </td>
                            <td> {{$row->price}} </td>
                            <td> {{$row->priority}} </td>
                            <td> {{$row->currency}} </td>
                            <td> {{$row->stock}} </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('ItemUpdate',1) }}" type="button" class="btn btn-xs btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-xs btn-info">
                                        <i class="fa fa-eye"></i>
                                    </button>

                                    <button type="button" class="btn btn-xs btn-{{ $row->status?"success":"danger"}}">
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



<!--/div-->
<!-- /.row -->
@stop @section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.8.9/jquery.csv.min.js"></script>
<script>
    $(document).ready(e => {
        $('#records').DataTable();

        $("#InputButton").click(e => {
            $('#InputFile').modal();
        });


        // 

    });

</script>
@stop
