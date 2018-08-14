@extends('adminlte::page') @section('title') @section('content_header')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<h1>
    Dashboard
    <small>Version 2.0</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Home</a>
    </li>
    <li class="active"></li>
</ol>
@stop @section('content')
<div class="row">

    <div class="col-md-8">
        <!-- Form Element sizes -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Request for materials </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control">
                        </div>

                    </div>

                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="">Clinte</label>
                            <select class="form-control" name="" id="">
                                <option value="">
                                </option>
                            </select>
                        </div>

                    </div>


                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="">Model</label>
                            <select class="form-control" name="" id="">
                                <option value="">
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="col-xs-10">
                        <div class="form-group">
                            <label for="">Item</label>
                            <select class="form-control" name="" id="items">
                                <option value="">
                                </option>
                            </select>



                        </div>

                    </div>

                    <div class="col-xs-2">
                        <div class="form-group">
                            <label for="">Quantity</label>
                            <input type="number" step="1" min="0" id="quantity" class="form-control">
                        </div>

                    </div>

                    <div class="col-md-12">
                        <ul>
                            <li> Description:
                                <b id="ajax-description"> </b>
                            </li>
                            <li> Part Number:
                                <b id="ajax-pn"></b>
                            </li>
                            <li> Price:
                                <b id="ajax-price"></b>
                            </li>
                            <li> Total:
                                <b id="ajax-cost"></b>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="box-footer">
                <button id="formSubmit" type="submit" {{ isset(Auth::user()->id)?"":"disabled" }}  class="btn btn-primary btn-flat">Submit</button>
                <button id="getAuth" class="btn btn-success pull-right  btn-flat">Get Auth</button>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <!-- /.box -->
    </div>


    <div class="col-md-4">
        <div class="box box-success "></div>
    </div>

</div>
<!-- /.row -->

<style>
    .swal2-popup {
        font-size: 1.6rem !important;
    }

</style>


@stop @section('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.js"></script>

<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('3273122a56d0e8e8e4c3', {
      cluster: 'mt1',
      encrypted: true
    });

    var channel = pusher.subscribe('HOME');
    channel.bind('request', function(data) {
      alert(JSON.stringify(data));
    });
  </script>

<script>
    //id_auth
    var Auth = null;
    $(document).ready(e => {
        /*
        const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        toast({
            type: 'success',
            title: 'Signed in successfully'
        })*/



        $('#getAuth').click(e => {
            swal({
                title: 'Enter your username',
                input: 'email',
                inputPlaceholder: 'Enter your username',

            }).then((result) => {
                if (result.value) {

                    swal({
                        title: 'Enter your password',
                        input: 'password',
                        inputPlaceholder: 'Enter your password',

                    }).then(password => {
                        var _token = $('input[name="_token"]').val();


                        $.ajax({
                            url: "{{ route('getAuth') }}",
                            method: "post",
                            data: {
                                email: result.value,
                                password: password.value,
                                _token: _token
                            },
                            success: response => {

                                Auth = response;

                                if (response.status) {

                                    $("#formSubmit").removeAttr("disabled");

                                    const toast = swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });

                                    toast({
                                        type: 'success',
                                        title: 'Successful authorization'
                                    })
                                   


                                } else {
                                    const toast = swal.mixin({
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });

                                    toast({
                                        type: 'error',
                                        title: 'The authorization failed'
                                    })

                                }


                            },
                            error: err => {
                                alert(err);
                            }
                        });

                    });

                }
            });
        })


        $('#items').change(e => {

            $.ajax({
                url: '{{ route("item-description") }}',
                data: {
                    id: $('#items').val()
                },
                method: "get",
                success: e => {


                    $('#ajax-description').html(e.code + " || " + e.description);
                    $('#ajax-pn').html(e.pn);
                    $('#ajax-price').html(e.price + (e.currency == 0 ? " USD" :
                        " M.N."));

                    $('#ajax-cost').html(e.price * $('#quantity').val());

                    console.log(e);
                },
                error: e => {
                    console.log(e);
                }
            })

        });


        $('#items').select2({
            ajax: {
                url: '{{ route("itemAjax") }}',

                dataType: 'json'
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            minimumInputLength: 4,
        });
    });

</script>


@stop
