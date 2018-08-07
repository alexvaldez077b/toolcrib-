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
    <li class="active">Update</li>
</ol>
@stop @section('content')


<div class="col col-md-6">


    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Fomr</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form">
            <div class="box-body">
                <div class="form-group">


                    <label >Name</label>
                    <input type="hidden" class="form-control" name="ID" >
                    <input type="text" class="form-control" name="customerName"  required>
                </div>
               
                <div class="form-group">
                    <label for="exampleInputFile">Image input</label>
                    <input type="file" name="image">

          
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


<!--div class="row"-->
<div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-primary">
        <div class="box-body box-profile">
            <img class="profile-user-img img-responsive" src="{{ url('/img/default.png') }}" alt=" picture">

            <h3 class="profile-username text-center">customer Name</h3>
            
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

    <!-- About Me Box -->
    
    <!-- /.box -->
</div>
<!-- /.col -->


<!--/div-->
<!-- /.row -->
@stop @section('js')
<script>
    $(document).ready(e => {
        $('#records').DataTable();
    });

</script>
@stop
