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
                        <td> {{$row->pn}} </td>
                        <td> {{$row->family}} </td>
                        <td>
                             {{$row->required_quantity}}
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('modelUpdate',[$customerId,$row->id]) }}" type="button" class="btn btn-primary"> <i class="fa fa-edit"></i></a>
                                <a href="{{ route('model_bom', $row->id )  }}" class="btn btn-info"> <i class="fa fa-eye"></i></a>

                                <button type="button" class="btn btn-{{ $row->status?"success":"danger" }}"> ...</button>
                                
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

                

            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
              <a href="{{ route('modelUpdate',[$customerId,-1]) }}" " class="btn btn-success btn-flat pull-left"><i class=" fa fa-plus "></i> New Entry  </a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right"></a>
            </div>
            <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>



<!--/div-->
<!-- /.row -->
@stop @section('js')
<script>
    $(document).ready(e => {
        $('#records').DataTable();
    });

</script>
@stop
