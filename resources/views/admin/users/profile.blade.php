@extends('layouts.dashboard')
@section('content')
   <div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Update Profile Image</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="photo" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   </div>
@endsection
