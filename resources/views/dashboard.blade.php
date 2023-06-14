@extends('layouts.master')

@section('title')
  dashboard
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="border-radius: 7px">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i>Dashboard</i>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px;background-color: #9400D3;color: white;">
            <div class="inner">
              <h3>{{ $countdata['pendataanmounthnow'] }}</h3>
              <p> Pendataan Bulan Ini</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <a class="small-box-footer"> <i class="fa fa-arrow"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px;background-color: #4e32df;color: white">
            <div class="inner">
              <h3>{{ $countdata['kegiatan'] }}</h3>
              <p> Total Kegiatan</p>
            </div>
            <div class="icon">
              <i class="fa fa-camera-retro"></i>
            </div>
            <a class="small-box-footer"><i class="fa fa-arrow"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px;background-color: #765df8;color: white">
            <div class="inner">
              <h3>{{ $countdata['kegiatan_i'] }}</h3>
              <p> Kegiatan Per-orangan</p>
            </div>
            <div class="icon" >
              <i class="fa fa-camera-retro"></i>
            </div>
            <a href="{{url('/event_internal')}}" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px;background-color: #9d8bfb;color: white">
            <div class="inner">
              <h3>{{ $countdata['kegiatan_y'] }}</h3>
              <p> Kegiatan Per-yayasan</p>
            </div>
            <div class="icon">
              <i class="fa fa-camera-retro"></i>
            </div>
            <a href="{{url('/event')}}" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px;background-color: #4B0082;color: white;">
            <div class="inner">
              <h3>{{ $countdata['all_pr'] }}</h3>
              <p> Penduduk Rentan</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="{{url('/all_pr')}}" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px; background-color: #0000FF;color: white;">
            <div class="inner">
              <h3>{{ $countdata['disabilitas'] }}</h3>
              <p> Disabilitas</p>
            </div>
            <div class="icon" >
              <i class="fa fa-user" style="width: 40%;"></i>
            </div>
            <a href="{{url('/penduduk')}}" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px;background-color: #00FF00;color: white;">
            <div class="inner">
              <h3>{{ $countdata['napi'] }}</h3>
              <p> Napi</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="{{url('/list_napi')}}" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px;background-color: #f1e12a;color: white;">
            <div class="inner">
              <h3>{{ $countdata['transgender'] }}</h3>
              <p> Transgender</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="{{url('/list_transgender')}}" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px;background-color: #FF7F00;color: white;">
            <div class="inner">
              <h3>{{ $countdata['odgj'] }}</h3>
              <p> Odgj</p>
            </div>
            <div class="icon" >
              <i class="fa fa-user"></i>
            </div>
            <a href="{{url('/list_odgj')}}" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px;background-color: #FF0000;color: white;">
            <div class="inner">
              <h3>{{ $countdata['panti_asuhan'] }}</h3>
              <p> Panti Asuhan</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="{{url('/list_panti_asuhan')}}" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px;background-color: #32c6df;color: white;">
            <div class="inner">
              <h3>{{ $countdata['yayasan'] }}</h3>
              <p> Yayasan</p>
            </div>
            <div class="icon">
              <i class="fa fa-bank"></i>
            </div>
            <a href="{{url('/yayasan')}}" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="border-radius: 5px;background-color: #4e8a90;color: white">
            <div class="inner">
              <h3>{{ $countdata['pengguna'] }}</h3>
              <p> Pengguna</p>
            </div>
            <div class="icon" >
              <i class="fa fa-user-circle-o"></i>
            </div>
            <a href="{{url('/user')}}" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
