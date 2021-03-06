@extends('adminlte::page') @section('title') @section('content_header')
<h1>
    Dashboard
    <small>Version 2.0</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Orders</a>
    </li>
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
                        <th>ID</th>
                        <th>Name</th>
                        <th>Model</th>
			<th>Area</th>
                        <th>Customer</th>
                        <th>Created At</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $row)
                    <tr >
                        <th>
                        <a href="{{ route('view_order',$row->id) }}">
                        Order #{{ $row->id }}
                        </a>
                        
                        </th>
                        <td>{{ $row->user }}</td>
                        <td>{{ $row->np }}</td>
			<td>{{ $row->area==1?"SMT":"FINAL" }} {{ $row->area==2?"NA":"" }} </td>
                        <td>{{ $row->name }} </td>
                        
                        
                        <td>{{ $row->created_at }}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer clearfix">
            <a href="" class="btn btn-success btn-flat pull-left">
                <i class=" fa fa-plus "></i> New Entry </a>
            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right"></a>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>
<!--/div-->
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


</script>

<script>
    var table = null;

    $(document).ready(e => {
        table = $('#records').DataTable();
    });

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('3273122a56d0e8e8e4c3', {
        cluster: 'mt1',
        encrypted: true
    });

    var channel = pusher.subscribe('HOME');

    channel.bind('request', function (data) {
        console.log(data);
        const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 30000
        });

        toast({
            type: 'success',
            title: `You have a new order pending: #${data.order.id}`
        })
        table.row.add([
            `<a href="{{ url('orders/view/') }}${data.order.id}" >#${data.order.id}</a>`,
            data.order.name,
            data.model.np,
            data.customer.name,
            data.order.created_at,
            

        ]).draw();

        //alert(JSON.stringify(data));
    });

    function closeOrder(arg, quantity,parent) {
        //table.row( parent ).remove().draw();
        


        swal({
            title: 'delivered quantity',
            type: 'question',
            input: 'range',
            inputAttributes: {
                min: 0,
                max: quantity,
                step: quantity % 1 == 0 ? 1 : 0.1,
            },
            inputValue: 0
        }).then(val => {

            swal({
                title: 'Are you sure?',
                text:  "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes...'
            }).then((result) => {
                if (result.value) {
                    $.ajax( {
                        url: "{{ url('/orders/close/') }}",
                        method: 'get',
                        data: { id: arg, delivered: val.value },
                        success: response=>{
                            if(response.status){
                                table.row( parent ).remove().draw();
                            }
                            

                        },
                        error: err=>{
                            swal("" , JSON.stringify(err), 'error' );
                        }
                    } )
                }
            })

            // val.value
        })
        
        
        

    }
    /*
        table.row.add( [ e.data.code,
         e.data.pn,
         e.data.description,
        ]  ).draw();
    */

</script>
@stop
