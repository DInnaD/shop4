@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Change Book
        <small>Good Words..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
	{{Form::open([
		'route'	=>	['books.edit', $book->id],
		'files'	=>	true,
		'method'	=>	'put'
	])}}
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Renew Book</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$book->name}}" name="name">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Author Name</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$book->author_name}}" name="author_name">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Page</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$book->page}}" name="page">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Made In</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$book->autor}}" name="autor">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Year</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$book->year}}" name="year">
            </div>
            <!-- checkbox -->
            <div class="form-group">
              <label>
              {{Form::checkbox('is_hard', '1', $book->is_hard, ['class'=>'minimal'])}}
              </label>
              <label>
                Is Hard
              </label>
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Кind</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$book->kindof}}" name="kindof">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Size</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$book->size}}" name="size">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Price</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$book->price}}" name="price">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Old Price</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$book->old_price}}" name="old_price">
            </div>

            <div class="form-group">
              <img src="{{$book->getImage()}}" alt="" class="img-responsive" width="200">
              <label for="exampleInputFile">Image</label>
              <input type="file" id="exampleInputFile" name="img">

              <p class="help-block">Info..</p>
            </div>
            
            <div class="form-group">
              <label for="exampleInputEmail1">Discont</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$book->discont_global}}" name="discont_global">
            </div>
            <!-- checkbox -->
            <div class="form-group">
              <label>
                {{Form::checkbox('status', '1', $book->status, ['class'=>'minimal'])}}
              </label>
              <label>
                Draft
              </label>
            </div>
          </div>
          
        </div>
          
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-warning pull-right">Edit</button>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
	{{Form::close()}}
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection