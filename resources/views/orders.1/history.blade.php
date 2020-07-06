@extends('adminlte::page') @section('title') @section('content_header')



<h1>Dashboard</h1>
@stop @section('content')
<div class="row">

    <div class="col-md-12">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif @if (session('ERROR'))
        <div class="alert alert-danger">
            {{ session('ERROR') }}
        </div>
        @endif

        <!-- TABLE: LATEST ORDERS -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Users</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <form action="">

                    <div class="container">
                        Date: <input class="form-control" id="date" name="date" />

                    </div>

                </form>
                <hr>
                <div class="table-responsive">
                    <table id="records" class="table no-margin">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Description</th>
                                <th>Quantity </th>
                                <th>Delivery</th>
                                <th>Authorized by</th>
                                <th>Required by </th>
                                <th>Customer</th>
                                <th>Model</th>
                                <th>Created At</th>
                                <th> Updated At </th>
                                <th> Delivery Time </th>
                                <th> Status </th> 
                                @can('edit orders')
                                <th> Registered </th>
                                @endcan

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $row)
                            <tr id='tr-{{$row->id}}'>
                                <td>{{ $row->code }}</td>
                                <td> {{ $row->description }} </td>
                                <td> {{ $row->quantity }} </td>
                                <td> {{ $row->delivered }} </td>
                                <td> {{ $row->auth }} </td>
                                <td> {{ $row->name }} </td>
                                <td> {{$row->cliente}} </td>
                                <td> {{ $row->np }} </td>
                                <td> {{ $row->created_at }} </td>
                                <td> {{ $row->updated_at }} </td>
                                <td> {{ $row->delivery_time }} </td>
                                <td> {{ $row->status }} </td>

                                @can('edit orders')
                                <td>
                                @if($row->status == 1)
                                    <input id="{{$row->id}}" type="checkbox">
                                @else
                                    <label class="text-success" for="">registered</label>
                                @endif
                                </td>
                                @endcan
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">

            </div>
            <!-- /.box-footer -->
        </div>
        <!-- /.box -->
    </div>
</div>





@stop @section('js')

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/all.css" />

<script>
    var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

    $('#date').daterangepicker({
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
            format: 'YYYY-MM-DD HH:mm '
        }
    }, (start, end, label) => {
        //var years = moment().diff(start, 'years');
        self.location =
            `{{ route('history') }}?start=${start.format("YYYY-MM-DD HH:mm")}&end=${end.format("YYYY-MM-DD HH:mm")}`;
        //alert("You are " +  + " - "+  + " ||  "+ label );
    });

    $('#records').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });





    $(document).ready(e => {
        $('input:checkbox').each(function(){
            var self = $(this)
            

            //label.remove();
            self.iCheck({
                checkboxClass: 'icheckbox_flat',
                radioClass: 'iradio_flat',
                increaseArea: '20%' // optional
            });
        });

        $('input:checkbox').on('ifChecked', function(event){
            var self = $(this);
            var id = self.attr('id');
            console.log(self.val() +  " "+ id)

            $.ajax({
                url: `{{ route('registered-order') }}`,
                method: 'get',
                data: { 'id': id},
                success: resp =>{

                    $('#tr-'+id).remove();

                },
                error: (error, errorStr)=>{
                    swal('Alert'. errorStr, 'error')
                }
            })


        });
       
        $('#records').DataTable();

        $('#password2').keyup(function () {
            if ($('#password').val() == $('#password2').val()) {
                $('#save').prop('disabled', false);
            } else {
                $('#save').prop('disabled', true);
            }

        });
        $('#password').keyup(function () {
            if ($('#password').val() == $('#password2').val()) {
                $('#save').prop('disabled', false);
            } else {
                $('#save').prop('disabled', true);
            }

        });

        $('#cpass').change(function () {
            if (this.checked) {
                $("#password").prop("disabled", false);
                $("#password2").prop("disabled", false);
                $("#save").prop("disabled", true); //Do stuff

            } else {
                $("#password").prop("disabled", true);
                $("#password2").prop("disabled", true); //Do stuff
            }

            console.log($('#cpass').val());


        });

    })

</script>

@stop
