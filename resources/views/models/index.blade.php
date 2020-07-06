@extends('adminlte::page') @section('title') @section('content_header')
<h1>
    Dashboard
    <small>Version 2.0</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Customers</a>
    </li>
    <li class="active">Models</li>
    <li class="active">Index</li>
</ol>
@stop @section('content')
<!--div class="row"-->


<div class="container">

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
                    <th>Part Number</th>
                    <th>Family</th>
                    <th>required quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($items as $row)
                <tr class="{{ $row->status?"":"text-danger" }}">
                    <!-- 'customer_id', 'pn', 'family', 'required_quantity', 'status' -->
                    <td>  
                        <a href="{{ route('model_bom', $row->id )  }}"> 
                            {{$row->np}}.
                        </a>
                    </td>
                    <td> {{$row->family}} </td>
                    <td>
                         {{$row->required_quantity}}
                    </td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('modelUpdate',[$customerId,$row->id]) }}" type="button" class="btn btn-xs btn-primary"> <i class="fa fa-edit"></i></a>
                            
                            <button type="button" class="btn btn-xs btn-{{ $row->status?"success":"danger" }}"> ...</button>
                            
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
             

        </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
          <a href="{{ route('modelUpdate',[$customerId,-1]) }}" class="btn btn-success btn-flat pull-left"><i class=" fa fa-plus "></i> New Entry  </a>

          <a href="#" id="InputButton" class="btn btn-warning btn-flat pull-left"><i class=" fa fa-upload "></i> Load Model Items  </a>
          <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right"></a>
        </div>
        <!-- /.box-footer -->
</div>
<!-- /.box -->
</div>

</div>

<div id="InputFile" class="modal fade" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Load File 2 .CSV</h4>
            </div>
            <form action="{{ route('itemsFile3') }}" enctype="multipart/form-data" method="post">
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
<script>
    $(document).ready(e => {
        $('#records').DataTable();
    });

    $("#InputButton").click(e => {
            $('#InputFile').modal();
        });

</script>
@stop
