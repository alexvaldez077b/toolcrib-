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
                        <th>Code</th>
                        <th>Part Number</th>
                        <th>Description</th>
                        <th>Localization</th>
                        <th>Price</th>
                        <th>Lead Time</th>
                        <th>UM Delivery</th>
                        <th>UM Purchase</th>
                        <th>Price</th>
                        <th>Priority</th>
                        <th>Currency</th>
                        
                        <th>Stock</th>

                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
            <button id="InputButton" class="btn btn-warning btn-flat pull-right">Import CSV/EXCEL</button>
        </div>
        <!-- /.box-footer -->
    </div>
    <!-- /.box -->
</div>


<!-- Modal -->
<div id="InputFile" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Load File .CSV</h4>
      </div>
      <div class="modal-body">
        <form action="">
            <div class="form-group">
                <label for=""> CSV FILE: </label>
                <input id="fileupload" type="file">
            </div>
        </form>
        <style>
        .modal-dialog {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            }

            .modal-content {
            height: auto;
            min-height: 100%;
            border-radius: 0;
            }
        </style>

        <table id="tableUpload" class="table table-responsive ">
            <thead id="header_table">   </thead>
            <tbody id="body_table">     </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<!--/div-->
<!-- /.row -->
@stop @section('js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.8.9/jquery.csv.min.js"></script>
<script>
    $(document).ready(e => {
        $('#records').DataTable();

        $("#InputButton").click(e=>{
            $('#InputFile').modal();
        });
        
        $("#fileupload").change(function(e){
            console.log(URL.createObjectURL(e.target.files[0]));

            var ext = $("#fileupload").val().split(".").pop().toLowerCase();

            if($.inArray(ext, ["csv"]) == -1) {
                alert('Upload CSV');
                return false;
            }
            
            

            if(e.target.files != undefined){
                jQuery.get(URL.createObjectURL(e.target.files[0]), function(data) {
                    
                    var rows = $.csv.toArrays(data);
                    //console.log(rows);
                    
                    var htmlString = "";

                    

                    rows.forEach( (item,iteration) =>{
                        if(iteration == 0){
                            $('header_table').html(`
                                <tr>
                                        <th>${item[0]}</th>
                                        <th>${item[1]}</th>
                                        <th>${item[2]}</th>
                                        <th>${item[3]}</th>
                                        <th>${item[4]}</th>
                                        <th>${item[5]}</th>
                                        <th>${item[6]}</th>
                                        <th>${item[7]}</th>
                                        <th>${item[8]}</th>
                                        <th>${item[9]}</th>
                                        <th>${item[10]}</th>
                                        <th>${item[11]}</th>
                                        <th>${item[12]}</th>
                                    </tr>
                                `);
                        }
                            


                        htmlString += `
                        <tr>
                            <td>${item[0]}</td>
                            <td>${item[1]}</td>
                            <td>${item[2]}</td>
                            <td>${item[3]}</td>
                            <td>${item[4]}</td>
                            <td>${item[5]}</td>
                            <td>${item[6]}</td>
                            <td>${item[7]}</td>
                            <td>${item[8]}</td>
                            <td>${item[9]}</td>
                            <td>${item[10]}</td>
                            <td>${item[11]}</td>
                            <td>${item[12]}</td>
                        </tr>
                        `;
                        //console.log(item);
                    } );

                    $('#body_table').html(htmlString);
                    $('#tableUpload').DataTable();

            });
            }
        });

        // code	description	localization	pn	stock	status	family	um_delivery	um_purchase	price	packing	lead_time	currency

    });

</script>
@stop
