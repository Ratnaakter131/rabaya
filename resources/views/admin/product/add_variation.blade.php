@extends('layouts.dashboard')

@section('content')
  <div class="container">
      <div class="row">
          <div class="col-lg-8">
              <div class="card h-auto">
                  <div class="card-header">
                      <h2>Color List</h2>
                  </div>
                  <div class="card-body">
                       <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Color Name</th>
                                <th>Color</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($colors as $key=>$color)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td> {{ $color->color_name}}</td>
                                <td><span class="badge" style="background:{{ $color->color_code}}; color:transparent">col</span> </td>
                                <td>
                                     <a href="#" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                       </table>
                  </div>
              </div>
              <div class="card h-auto mt-5">
                  <div class="card-header">
                      <h2>Size List</h2>
                  </div>
                  <div class="card-body">
                       <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Size Name</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($sizes as $key=>$size)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td> {{ $size->size_name}}</td>
                                <td>
                                     <a href="#" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                       </table>
                  </div>
              </div>
          </div>
          <div class="col-lg-4">
              <div class="card h-auto">
                  <div class="card-header">
                      <h2>Add Color</h2>
                  </div>
                  <div class="card-body">
                      <form action="{{ route('add.color') }}" method="POST">
                          @csrf
                          <div class="form-group">
                              <label for="" class="form-label">Color Name</label>
                              <input type="text" class="form-control" name="color_name">
                          </div>
                          <div class="form-group">
                              <label for="" class="form-label">Color Code</label>
                              <input type="text" class="form-control" name="color_code">
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-primary">Add Color</button>
                          </div>
                      </form>
                  </div>
              </div>

              <div class="card h-auto">
                   <div class="card-header">
                      <h2>Add Size</h2>
                  </div>
                  <div class="card-body">
                      <form action="{{ route('add.size') }}" method="POST">
                          @csrf
                          <div class="form-group">
                              <label for="" class="form-label">Size Name</label>
                              <input type="text" class="form-control" name="size_name">
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-primary">Add Size</button>
                          </div>
                      </form>
                  </div>
              </div>


          </div>
      </div>
  </div>
@endsection()
