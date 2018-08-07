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
        @if( ! empty($customer))
    

        <!-- form start -->
        <form role="form" method="post" action="{{ route('customer_Update') }}" >
            <div class="box-body">
                <div class="form-group">

                    @csrf
                    <label >Name</label>
                    <input type="hidden" class="form-control" value="{{ $customer->id }}" name="id" >
                    <input type="text" class="form-control" name="name" value="{{ $customer->name }}"  required>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Status</label>
                    <select name="status" class="form-control" >
                        <option {{ !$customer->status?"selected":"" }} value="0">Disabled</option>
                        <option {{ $customer->status?"selected":"" }} value="1">Enabled</option>
                    </select>

          
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

        //

        @else

        <form role="form" method="post" action="{{ route('customer_Update') }}" >
            <div class="box-body">
                <div class="form-group">

                    @csrf
                    <label >Name</label>
                    <input type="hidden" class="form-control" value="-1" name="id" >
                    <input type="text" class="form-control" name="name" value=""  required>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Status</label>
                    <select name="status" class="form-control" >
                        <option  value="0">Disabled</option>
                        <option selected value="1">Enabled</option>
                    </select>

          
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

        @endif


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
