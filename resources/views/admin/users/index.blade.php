@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="card">
                <div class="card-header d-flex bg-secondary">
                    <h3 class="text-light"> <strong> User List </strong></h3>
                    <span class="float-end; text-light"><strong>Total User:</strong>({{ $total_user }})</span>
                </div>
                <div class="card-body bg-secondary">
                    <table class="table table-bordered bg-light">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Photo</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($all_users as $key=>$user)
                        <tr>
                            <td>{{ $all_users->firstitem()+$key }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->photo == null)
                                <img width="55" src="{{ Avatar::create($user->name)->toBase64(); }}" alt="">
                                @else
                                <img width="55" src="{{ asset('uploads/user/profile') }}/{{ Auth::user()->photo }}" alt="">
                              @endif
                             </td>
                            <td>{{ $user->created_at }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('delete.user', $user->id) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {{$all_users->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
