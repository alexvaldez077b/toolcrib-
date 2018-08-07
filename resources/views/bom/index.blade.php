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

<div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-info">
        <div class="box-body">
           

            <h3 class="profile-username text-center">{{ $model->pn }}</h3>

            <p class="text-muted text-center">{{ $model->family }}</p>

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>amount required per month  </b>
                    <a class="pull-right">{{ $model->required_quantity }}</a>
                </li>
                <li class="list-group-item">
                    <b>amount required per week  </b>
                    <a class="pull-right">{{ number_format( $model->required_quantity/4.3 , 2) }}</a>
                </li>
                <li class="list-group-item">
                    <b>amount required per day  </b>
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

<div class="col col-md-9">


    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title"></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body ">
            <table class="table table-bordered" id="records">
                <thead>
                    <tr>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Header</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>2.</td>
                        <td>Clean database</td>
                        <td>
                            <!--div class="progress progress-xs">
                                <div class="progress-bar progress-bar-yellow" style="width: 70%"></div>
                            </div-->
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('customerUpdate',1) }}" type="button" class="btn btn-primary">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-info">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <button type="button" class="btn btn-danger">
                                    <i class="fa fa-close"></i>
                                </button>

                            </div>
                        </td>
                    </tr>
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



<!--/div-->
<!-- /.row -->
@stop @section('js')
<script>
    $(document).ready(e => {
        $('#records').DataTable();
    });

</script>
@stop
