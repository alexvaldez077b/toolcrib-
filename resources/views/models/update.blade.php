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
    <li class="active">Index</li>
</ol>
@stop @section('content')
<!--div class="row"-->


<div class="col col-md-6">


    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Quick Example</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->


        <form role="form" method="post" action="{{ route('model_Update') }}" >
            <div class="box-body">

                <div class="form-group">

                    @csrf
                    <label>Part Number</label>
                    <input type="hidden" class="form-control" value="{{ $customerId }}" name="customer_id">
                    <input type="hidden" class="form-control" value="{{ !empty($model)?$model->id:" -1 " }}" name="id">
                    <input type="text" class="form-control" name="np" value="{{ !empty($model)?$model->np:" " }}" required>
                </div>

                <div class="form-group">
                    <label>Family</label>
                    <input type="text" class="form-control" name="family" value="{{ !empty($model)?$model->family:" " }}" required>
                </div>

                <div class="form-group">
                    <label>Required Quantity</label>
                    <input type="number" class="form-control" name="required_quantity" value="{{ !empty($model)?$model->required_quantity:" " }}" required>
                </div>

                <div class="form-group">
                    <label for="exampleInputFile">Status</label>
                    <select name="status" class="form-control">
                        <option {{ !empty($model)&&!$model->status?"selected":"" }} value="0">Disabled</option>
                        <option {{ !empty($model)&&$model->status?"selected":"" }} value="1">Enabled</option>
                    </select>


                </div>



            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
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
