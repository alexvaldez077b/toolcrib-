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
                <div class="table-responsive">
                    <table id="records" class="table no-margin">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status </th>
                                <th>Created_at</th>
                                <th>Role</th>

                                @can('edit users')
                                <th> Actions </th>
                                @endcan

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $row)
                            <tr>
                                <td>{{$row->name}}</td>
                                <td>{{ $row->email }}</td>
                                <td>  <span class="label label-{{$row->status?'success':'danger'}}"> {{$row->status?'Active':'Inactive'}} </span> </td>
                                <td> {{$row->created_at}} </td>
                                <td>
                                    


                                    <!-- $row->getAllPermissions() -->
                                    <span class="label label-primary"> {{$row->getRoleNames()->first()?$row->getRoleNames()->first():"Operator"}} </span>
                                    

                                </td>
                                @can('edit users')
                                <td>
                                    <button onclick="editUser({{$row->id}})" class="btn btn-sm btn-primary btn-flat pull-left">Edit</button>
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


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- form start -->
            <form role="form" action="{{route('edituser')}}" method="post"> <!--  -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">User data</h4>
                </div>

                <div class="modal-body">
                    <!-- -->
                    {{ csrf_field() }}
                    <!-- /.box-header -->
                    <input type="text" id="userid" hidden name='userid' value="" >
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" required name="name" class="form-control" id="name" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="text" required name="email" class="form-control" id="email" placeholder="">
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">Role</label>
                        
                        <select name="role" id="role" class="form-control" >
                            <option value="1">Admin</option>
                            <option value="2">Toolcrib</option>
                            <option value="3">Enginner</option>
                            <option value="4">Leader</option>
                            <option value="5">Materialist</option>
                        </select>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input name='status' id='status' type="checkbox"> Active
                        </label>
                    </div>

                    <div class="checkbox">
                        <label>
                            <input name='cpass' id="cpass" type="checkbox"> Change Password
                        </label>
                    </div>
                    <hr>

                    <div class="form-group">
                        <label for="exampleInputEmail1">password</label>
                        <input type="password" disabled  name="password" id="password"  class="form-control" id="" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Confirm Password</label>
                        <input type="password" disabled  name="password2" id="password2"  class="form-control"  placeholder="">
                    </div>

                    <!-- /.box-body -->






                    <!-- -->


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button id="save" type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


@stop @section('js')

<script>
    function editUser(id) {

        $('#modal-default').modal();
        
        $.ajax({
            url: `{{route("getuser")}}`,  
            method: 'get',
            data: {
                id: id
            },
            success: response => {
                console.log(response);
                $('#name').val( response.user.name );
                $('#email').val( response.user.email );
                $('#userid').val(response.user.id)
                $('#status').attr('checked', response.user.status?true:false);
                console.log(response.role);
                $("#role").val(response.role);        
            
            },
            error: (request, status, error) => {
                //console.log(request.responseText);
                swal(error, "The AJAX request failed!", "error");

            }
        })

        

        
    }



    $(document).ready(e => {
        $('#records').DataTable();
        
        $('#password2').keyup( function(){
            if( $('#password').val() == $('#password2').val() ){
                $('#save').prop('disabled', false);
            }
            else{
                $('#save').prop('disabled', true);
            }
                
        } );
        $('#password').keyup( function(){
            if( $('#password').val() == $('#password2').val() ){
                $('#save').prop('disabled', false);
            }
            else{
                $('#save').prop('disabled', true);
            }
                
        } );

        $('#cpass').change(  function(){
            if(this.checked) {
                $( "#password" ).prop( "disabled",  false );
                $( "#password2" ).prop( "disabled", false );    
                $( "#save" ).prop( "disabled", true );    //Do stuff

            }else{
                $( "#password" ).prop( "disabled",  true );
               $( "#password2" ).prop( "disabled", true );    //Do stuff
            }

            console.log($('#cpass').val());
            

        } );

    })
</script>

@stop