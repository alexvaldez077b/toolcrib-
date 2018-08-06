@extends('adminlte::page') @section('title') @section('content_header')
<h1>
    Dashboard
    <small>Version 2.0</small>
</h1>
<ol class="breadcrumb">
    <li>
        <a href="#">
            <i class="fa fa-dashboard"></i> Home</a>
    </li>
    <li class="active">Dashboard</li>
</ol>
@stop @section('content')
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua">
                <i class="ion ion-ios-gear-outline"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Customers</span>
                    <small></small>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-red">
                <i class="fa fa-google-plus"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Models</span>
                <span class="info-box-number">X</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green">
                <i class="ion ion-ios-cart-outline"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Items</span>
                <span class="info-box-number">X</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow">
                <i class="ion ion-ios-people-outline"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number">X</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@stop
