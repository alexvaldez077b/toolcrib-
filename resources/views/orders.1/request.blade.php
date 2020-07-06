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

    <div class="col-md-7">

        <div class="box box-info">

            <div class="box-body">



                <form action="#">



                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="">Clinte</label>
                            <select class="form-control" name="" id="clients">
                                @foreach( $customers as $row )
                                <option value="{{$row->id}}"> {{$row->name}} </option>
                                @endforeach
                            </select>
                        </div>

                    </div>


                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="">Model</label>
                            <select class="form-control" name="" id="models">
                                <option value="">
                                </option>
                            </select>
                        </div>

                    </div>



                    <div class="col-xs-8">
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
                            <input type="number" step="1" min="1" id="quantity" class="form-control">
                        </div>

                    </div>
                    
                    
                   
                    

                </form>








            </div>
            <div class="box-footer">
            <div class="col-xs-12">
                        <div class="form-group">
                            <button id="add-item-package" class="btn btn-block btn-lg btn-primary pull-right" > <i class="fa fa-plus"></i> Add </button>
                        </div>
                            
                        

                    </div>


            </div>

        </div>

        <!-- PRODUCT LIST -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Recently Added Products</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <ul id="products" class="products-list product-list-in-box">
                    
                    <!-- /.item -->
                   
                </ul>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                <button onclick='submitForm()' class="uppercase btn btn-success">Send</button>
                <button onclick='remove()' class="uppercase btn btn-danger">Clear</button>
            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->

        <!-- Form Element sizes -->

        <!-- /.box -->
        <!-- /.box -->
    </div>


    <div class="col-md-5">
        <div class="box box-success ">
            <div class="box-header">
                <h3>Orders Opened</h3>
            </div>
            <div class="box-body">
                <ul id="list-orders" class="products-list product-list-in-box">
                    @foreach($orders as $row)
                    <li class="item" id="order-{{ $row->id }}">
                        <div class="product-img">
                            <img src="{{ url('/img/default.png') }}" alt="Product Image">
                        </div>
                        <div class="product-info">
                            <a href="javascript:void(0)" class="product-title">Order: #{{$row->id}} || {{$row->code}}
                                <span class="label label-warning pull-right">{{ $row->quantity }}</span>
                            </a>
                            <span class="product-description">
                                {{$row->description}}
                            </span>
                        </div>
                    </li>
                    <!-- /.item -->
                    @endforeach
                </ul>


            </div>

        </div>
    </div>

</div>
<!-- /.row -->

<style>
    .swal2-popup {
        font-size: 1.6rem !important;
    }

</style>


@stop @section('js')

<link rel="stylesheet" href="{{ asset('css/smart_wizard.css') }}">
<link rel="stylesheet" href="{{ asset('css/smart_wizard_theme_dots.css') }}">

<script src="{{ asset('js/jquery.smartWizard.js') }}"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.26.11/sweetalert2.all.js"></script>

<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<script>
    // Enable pusher logging - don't include this in production

    function submitForm() {
            if ($('#models').val() && package.length >0 ) {

                $.ajax({
                    url: "{{ route('setRequest') }}",
                    method: "get",
                    data: {
                        client: $("#clients").val(),
                        _token: $('input[name="_token"]').val(),
                        
                        model_id: $('#models').val(),
                        auth: Auth != null ? Auth.user.id : -1,

                        name: $("#id_user").val() + " " + $('#name').val(),
                        items: package
                    },
                    success: response => {
                        //clear form
                        $("#clients").val("");
                        $("#quantity").val("");
                        $("#models").html("");
                        $("#name").val("");
                        $("#items").val("");
                        console.log(response);

                    },
                    error: err => {

                    }
                });


            } else {
                alert("Please complete all entries....");
            }
        }

    Pusher.logToConsole = true;

    var pusher = new Pusher('3273122a56d0e8e8e4c3', {
        cluster: 'mt1',
        encrypted: true
    });

    var channel = pusher.subscribe('HOME');
    channel.bind('request', function (data) {
        $("#list-orders").append(
            `
                    <li class="item" id="order-${data.order.id}">
                        <div class="product-img">
                            <img src="{{ url('/img/default.png') }}" alt="Product Image">
                        </div>
                        <div class="product-info">
                            <a href="javascript:void(0)" class="product-title">Order: #${data.order.id} || ${data.item.code}
                                <span class="label label-warning pull-right">${data.order.quantity}</span>
                            </a>
                            <span class="product-description">
                            ${data.item.description}
                            </span>
                        </div>
                    </li>
        `
        //list.splice( list.indexOf('foo'), 1 );
        );
    });

    channel.bind('close-orders', function (data) {

        const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 15000
        });

        toast({
            type: 'success',
            title: `#${data.order.id} delivered...`
        })

        let ID = `#order-${data.order.id}`;
        console.log(ID);
        $(ID).remove();


    });

</script>

<script>
    //id_auth
    var Auth = null;
    var package = [];

    function remove(){
        package = [];
        $('#products').html("");




    }

    $(document).ready(e => {

        $("#add-item-package").click( (e)=>{
            e.preventDefault();

            $.ajax({
                url: '{{ route("item-description") }}',
                data: {
                    id: $('#items').val(),
                    model: $("#models").val()
                },
                method: "get",
                success: e => {

                    console.log(e)

                    package.push( { id: e.id, quantity: $('#quantity').val()  } );

                    console.log( package )
                    /*
                    code: "2CHM027"
                    created_at: "2018-08-13 09:20:40"
                    currency: 0
                    description: "KES-951-PEN NO-CLEAN FLUX PEN 951 LW-SOLIDS"
                    family: 2
                    id: 12
                    image: "2CHM0271540413227.jpeg"
                    leadtime: 20
                    localization: "GAVETA 2"
                    packing: 20
                    pn: "KES-951"
                    price: 5
                    priority: 0
                    status: 1
                    stock: 7
                    umdelivery: null
                    umpurchase: null
                    updated_at: "2018-12-15 12:22:14"
                    */

                    $("#products").append(`
                        <li id="item-${package.length-1}" class="item">
                            <div class="product-img">
                                <img src="{{ url('../storage/app/public/') }}/${e.image}" alt="Image">
                            </div>
                            <div class="product-info">
                                <a href="javascript:void(0)" class="product-title">${e.code}
                                    
                                    <span class="label label-warning pull-right">${ $('#quantity').val() }</span>
                                    
                                </a>
                                <span class="product-description">
                                    ${e.description}
                                </span>
                            </div>
                        </li>
                    `)
                    //



                    /*
                    $('#ajax-description').html(e.code + " || " + e.description);
                    $('#ajax-pn').html(e.pn);
                    $('#ajax-price').html(e.price + (e.currency == 0 ? " USD" :
                        " M.N."));

                    $('#ajax-cost').html(e.price * $('#quantity').val());

                    $("#image-ajax").attr('src',
                        `{{ url('../storage/app/public/') }}/${e.image}`);

                    console.log(e);
                    */
                },
                error: e => {
                    console.log(e);
                }
            })



        } )

        $('#smartwizard').smartWizard({
            selected: 0, // Initial selected step, 0 = first step 
            keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
            autoAdjustHeight: false, // Automatically adjust content height
            cycleSteps: false, // Allows to cycle the navigation of steps
            backButtonSupport: false, // Enable the back button support
            useURLhash: true, // Enable selection of the step based on url hash
            lang: { // Language variables
                next: 'Next',
                previous: 'Previous'
            },
            toolbarSettings: {
                toolbarPosition: 'bottom', // none, top, bottom, both
                toolbarButtonPosition: 'right', // left, right
                showNextButton: true, // show/hide a Next button
                showPreviousButton: true, // show/hide a Previous button
                toolbarExtraButtons: [

                    $('<button></button>').text('Finish')
                    @if(!isset(Auth::user()->id))
                    .attr('disabled', 'disabled')
                    @endif
                    .attr('id', 'authbutton')
                    .addClass('btn btn-info')
                    .on('click', submitForm),

                    $('<button></button>').text('Reset')
                    .addClass('btn btn-danger auth')
                    .on('click', function () {
                        $('#smartwizard').smartWizard("reset");
                    })
                ]
            },
            anchorSettings: {
                anchorClickable: true, // Enable/Disable anchor navigation
                enableAllAnchors: false, // Activates all anchors clickable all times
                markDoneStep: true, // add done css
                enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
            },
            contentURL: null, // content url, Enables Ajax content loading. can set as data data-content-url on anchor
            disabledSteps: [], // Array Steps disabled
            errorSteps: [], // Highlight step with errors
            theme: 'dots',
            transitionEffect: 'slide', // Effect on navigation, none/slide/fade
            transitionSpeed: '500'
        });


        $("#clients").change(e => {
            $.ajax({
                url: "{{ route('getModelsbyClient') }}",
                method: "get",
                data: {
                    id: $("#clients").val()
                },
                success: response => {
                    $("#models").html("");
                    response.forEach(elem => {
                        console.log("--------------");
                        $("#models").append(
                            `
                            <option value="${elem.id}">${elem.np}</option>
                        `
                        );

                        console.log(elem);
                        console.log("--------------");
                    });

                    //console.log(response);
                },
                error: err => {
                    alert(err);
                }
            });
        });

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

                                    $("#authbutton").removeAttr("disabled");

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

        $("#models").change(e => {
            $.ajax({
                url: '{{ route("itemAjax") }}',

                dataType: 'json',
                data: {
                    model: $("#models").val(),
                },
                success: response => {
                    console.log("Clear items");
                    $("#items").html("");


                    $.each(response.results, (index, elem) => {

                        console.log(elem);
                        $("#items").append(
                            `
                            <option value="${elem.id}">${elem.text}</option>
                        `
                        );



                    });




                },
                error: (x, y, z) => {
                    swal('error', y, 'error');
                }




            });
        });
        $('#items').change(e => {

            

        });


        $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {


        });


        /*
        .select2({
            ajax: {
                url: '{{ route("itemAjax") }}',

                dataType: 'json',
                data: function (params) {
                var query = {
                    search: params.term,
                    model: $("#models").val(),
                    
                }

                // Query parameters will be ?search=[term]&type=public
                return query;
                }
                // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            },
            minimumInputLength: 0,
        });
        */
        $("#clients").val(null).trigger('change');

        $("#items").select2();

        $("#quantity").change(e => {

            $('#ajax-cost').html(parseFloat($('#ajax-price').text()) * $('#quantity').val());



        })

    });

</script>


@stop
