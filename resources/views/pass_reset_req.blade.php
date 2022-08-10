@extends('frontend.master')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card my-5">
            <div class="card-header bg-primary">
                <h4 class="text-white">Password Reset Request Form</h4>
            </div>
            <div class="card-body bg-secondary">
                <form action="{{ route('customer.pass.reset.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label" ><p class="text-white">Email Address</p></label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="mb-3">
                    <button class="btn btn-primary">Send Reset Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
