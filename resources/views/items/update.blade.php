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

<div class="row">

    <div class="col-md-12">
    
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
    </div>
    <div class="col col-md-6">
        
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Fomr</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            @if(!empty($item))
            <form role="form" method="post" action="{{ route('item_Update') }}" enctype="multipart/form-data">
                <div class="box-body">

                    <div class="form-group col-md-4">
                        @csrf
                        <label>Code</label>
                        <input type="hidden" class="form-control" name="id" value="{{ $item->id }}">
                        <input type="text" class="form-control" name="code" value="{{ $item->code }}" required>
                    </div>

                    <div class="form-group col-md-8">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description" value="{{ $item->description }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Localization </label>

                        <input type="text" class="form-control" name="localization" value="{{ $item->localization }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Part Number</label>

                        <input type="text" class="form-control" name="pn" value="{{ $item->pn }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Stock</label>

                        <input type="number" min="0" step="1" class="form-control" name="stock" value="{{ $item->stock }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Status</label>
                        <select class="form-control" name="status" id="">
                            <option {{ $item->status?"selected":"" }} value="1">Enabled</option>
                            <option {{ !$item->status?"selected":"" }} value="0">Disabled</option>
                        </select>

                    </div>

                    <div class="form-group col-md-4">
                        <label>Family</label>

                        <input type="number" class="form-control" name="family" value="{{ $item->family }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Unit delivery</label>
                        <select class="form-control" name="umdelivery" id="">
                            <option {{$item->um_delivery == "BOL" ? "selected":"" }}  value="BOL">BOL</option>
                            <option {{$item->um_delivery == "CAJ" ? "selected":"" }} value="CAJ">CAJ</option>
                            <option {{$item->um_delivery == "CUB" ? "selected":"" }} value="CUB">CUB</option>
                            <option {{$item->um_delivery == "GAL" ? "selected":"" }} value="GAL">GAL</option>
                            <option {{$item->um_delivery == "GRM" ? "selected":"" }} value="GRM">GRM</option>
                            <option {{$item->um_delivery == "KG" ? "selected":"" }} value="KG">KG</option>
                            <option {{$item->um_delivery == "KIT" ? "selected":"" }} value="KIT">KIT</option>
                            <option {{$item->um_delivery == "LBS" ? "selected":"" }} value="LBS">LBS</option>
                            <option {{$item->um_delivery == "LT" ? "selected":"" }} value="LT">LT</option>
                            <option {{$item->um_delivery == "MIL" ? "selected":"" }} value="MIL">MIL</option>
                            <option {{$item->um_delivery == "PAQ" ? "selected":"" }} value="PAQ">PAQ</option>
                            <option {{$item->um_delivery == "PZA" ? "selected":"" }} value="PZA">PZA</option>
                            <option {{$item->um_delivery == "ROL" ? "selected":"" }} value="ROL">ROL</option>
                            <option {{$item->um_delivery == "SER" ? "selected":"" }} value="SER">SER</option>
                            <option {{$item->um_delivery == "TUB" ? "selected":"" }} value="TUB">TUB</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Unit Purchase</label>
                        <select class="form-control" name="umpurchase" id="">
                            <option {{$item->um_delivery == "BOL" ? "selected":"" }}  value="BOL">BOL</option>
                            <option {{$item->um_delivery == "CAJ" ? "selected":"" }} value="CAJ">CAJ</option>
                            <option {{$item->um_delivery == "CUB" ? "selected":"" }} value="CUB">CUB</option>
                            <option {{$item->um_delivery == "GAL" ? "selected":"" }} value="GAL">GAL</option>
                            <option {{$item->um_delivery == "GRM" ? "selected":"" }} value="GRM">GRM</option>
                            <option {{$item->um_delivery == "KG" ? "selected":"" }} value="KG">KG</option>
                            <option {{$item->um_delivery == "KIT" ? "selected":"" }} value="KIT">KIT</option>
                            <option {{$item->um_delivery == "LBS" ? "selected":"" }} value="LBS">LBS</option>
                            <option {{$item->um_delivery == "LT" ? "selected":"" }} value="LT">LT</option>
                            <option {{$item->um_delivery == "MIL" ? "selected":"" }} value="MIL">MIL</option>
                            <option {{$item->um_delivery == "PAQ" ? "selected":"" }} value="PAQ">PAQ</option>
                            <option {{$item->um_delivery == "PZA" ? "selected":"" }} value="PZA">PZA</option>
                            <option {{$item->um_delivery == "ROL" ? "selected":"" }} value="ROL">ROL</option>
                            <option {{$item->um_delivery == "SER" ? "selected":"" }} value="SER">SER</option>
                            <option {{$item->um_delivery == "TUB" ? "selected":"" }} value="TUB">TUB</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Price</label>

                        <input type="text" class="form-control" name="price" value="{{ $item->price }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Packing</label>
                        <input type="text" class="form-control" name="packing" value="{{ $item->packing }}" required>

                    </div>

                    <div class="form-group col-md-4">
                        <label>Lead time</label>

                        <input type="text" class="form-control" name="leadtime" value="{{ $item->leadtime }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Currency</label>
                        <select class="form-control" name="currency" id="">
                            <option {{!$item->currency?"selected":""}} value="0">USD</option>
                            <option {{$item->currency?"selected":""}} value="1">MXN</option>
                        </select>

                    </div>



                    <div class="form-group col-md-12">
                        <label for="exampleInputFile">Image input</label>
                        <input type="file" name="fileToUpload">


                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            @else

            <form role="form" method="post" action="{{ route('item_Update') }}" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group col-md-4">
                        @csrf
                        <label>Code</label>
                        <input type="hidden" class="form-control" name="id" value="-1">
                        <input type="text" class="form-control" name="code" value="" required>
                    </div>

                    <div class="form-group col-md-8">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description" value="" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Localization </label>

                        <input type="text" class="form-control" name="localization" value="" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Part Number</label>

                        <input type="text" class="form-control" name="pn" value="" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Stock</label>

                        <input type="number" min="0" step="1" class="form-control" name="stock" value="" required>
                    </div>


                    <div class="form-group col-md-4">
                        <label>Status</label>
                        <select class="form-control" name="status" id="">
                            <option value="1">Enabled</option>
                            <option value="0">Disabled</option>
                        </select>

                    </div>

                    <div class="form-group col-md-4">
                        <label>Family</label>

                        <input type="number" class="form-control" name="family" value="" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Unit delivery</label>
                        <select class="form-control" name="umdelivery" id="">
                            <option   value="BOL">BOL</option>
                            <option   value="CAJ">CAJ</option>
                            <option   value="CUB">CUB</option>
                            <option   value="GAL">GAL</option>
                            <option   value="GRM">GRM</option>
                            <option   value="KG">KG</option>
                            <option   value="KIT">KIT</option>
                            <option   value="LBS">LBS</option>
                            <option   value="LT">LT</option>
                            <option   value="MIL">MIL</option>
                            <option   value="PAQ">PAQ</option>
                            <option   value="PZA">PZA</option>
                            <option   value="ROL">ROL</option>
                            <option   value="SER">SER</option>
                            <option   value="TUB">TUB</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Unit Purchase</label>

                        <select class="form-control" name="umpurchase" id="">
                            <option    value="BOL">BOL</option>
                            <option    value="CAJ">CAJ</option>
                            <option    value="CUB">CUB</option>
                            <option    value="GAL">GAL</option>
                            <option    value="GRM">GRM</option>
                            <option    value="KG">KG</option>
                            <option    value="KIT">KIT</option>
                            <option    value="LBS">LBS</option>
                            <option    value="LT">LT</option>
                            <option    value="MIL">MIL</option>
                            <option    value="PAQ">PAQ</option>
                            <option    value="PZA">PZA</option>
                            <option    value="ROL">ROL</option>
                            <option    value="SER">SER</option>
                            <option    value="TUB">TUB</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Price</label>

                        <input type="number" min="0" step="1" class="form-control" name="price" value="" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Packing</label>
                        <input type="number" min="0" step="1" class="form-control" name="packing" value="" required>

                    </div>

                    <div class="form-group col-md-4">
                        <label>Lead time</label>

                        <input type="number" min="0" step="1" class="form-control" name="leadtime" value="" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Currency</label>
                        <select class="form-control" name="currency" id="">
                            <option value="0">USD</option>
                            <option value="1">MXN</option>
                        </select>

                    </div>



                    <div class="form-group col-md-12">
                        <label for="exampleInputFile">Image input</label>
                        <input type="file" name="fileToUpload">


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
                <img class="profile-user-img img-responsive" style="width:100%; height:250px;" @if(!empty($item) && $item->image != null) src="{{ asset("../storage/app/public/$item->image") }}" @else src="{{ url('/img/default.png') }}" @endif alt="picture">

                <h3 class="profile-username text-center">thumbnail</h3>

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

</div>
@stop @section('js')
<script>
    $(document).ready(e => {
        $('#records').DataTable();
    });

	

    /*
    $("#id option").each(function(){
    $(this).attr('selected', true);
});
    */

</script>
@stop
