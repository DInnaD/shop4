@extends('homes.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Blank page
        <small>it all starts here</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
            <div class="box-header">
              <h3 class="box-title">Purchases All</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <a href="{{route('home.index')}}" class="btn btn-success">Continue Shoping</a>
              </div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>QUANTITY</th>
                  <th>AMOUNT</th>
                  <th>DATE</th>
                  <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ordersAlls as $ordersAll)
	                <tr>
	                  <td>{{$ordersAll->id}}</td>
	                  <td>{{$ordersAll->number}}</td>
                    <td>{{$ordersAll->sum}}</td>
                    <td>{{$ordersAll->created_at}}</td>
                    <td>{{$ordersAll->orders()->pluck('id')->implode(', ')}}</td>
	                </tr>
                @endforeach

                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection