@extends('layouts.dashboard')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h4><strong>Role and Permission List </strong></h4>
                </div>
                <div class="card-body abcd">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>ROLE</th>
                            <th>PERMISSION</th>
                            <th>ACTION</th>
                        </tr>
                        @foreach ($roles as $key=> $role)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                               <ul>
                                  @foreach ($role->getAllPermissions() as $permission)
                                    <li>{{ $permission->name }}<br></li>
                                @endforeach
                               </ul>
                            </td>
                            <td>
                                <a href="{{ route('edit.permission', $role->id) }}" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                         @endforeach
                    </table>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h4><strong>User and Roles</strong></h4>
                </div>
                <div class="card-body abcd">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>User</th>
                            <th>ROLE</th>
                            <th>PERMISSION</th>
                            <th>ACTION</th>
                        </tr>
                        @foreach ($all_users as $key=> $user)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $user->name }}</td>

                            <td>
                               <ul>
                                  @foreach ($user->getRoleNames() as $role)
                                    <li>{{ $role}}<br></li>
                                @endforeach
                               </ul>
                            </td>
                              <td>
                               <ul>
                                  @foreach ($user->getAllPermissions() as $permission)
                                    <li>{{ $permission->name}}<br></li>
                                @endforeach
                               </ul>
                            </td>
                            <td>
                                <a href="{{ route('edit.permission', $user->id) }}" class="btn btn-secondary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                         @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h4><strong>Add Permission</strong></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('permission.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Permission Name</label>
                            <input type="text" class="form-control" name="permission_name">
                        </div>
                        <div class="mb-3">
                          <button type="submit" class="btn btn-primary">Add Permission </button>
                        </div>
                    </form>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h4><strong>Create Role </strong></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('create.role ') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Role Name</label>
                            <input type="text" class="form-control" name="role_name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Permission</label>
                            @foreach ($all_permissions as $permission)
                            <br>
                            <input type="checkbox" value="{{ $permission->id }}" name="permission_name[]">    {{ $permission->name }}
                            @endforeach
                        </div>
                        <div class="mb-3">
                          <button type="submit" class="btn btn-primary">Create Role </button>
                        </div>
                    </form>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <h4><strong>Assgin Role to User </strong></h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('assign.role') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <select name="user_id" class="form-control">
                                <option value="">-- Select User --</option>
                                @foreach ($all_users as $user)
                                <option value="{{ $user->id }}"> {{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <select name="role_id" class="form-control">
                                <option value="">-- Select Role --</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}"> {{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                          <button type="submit" class="btn btn-primary">Assign Role </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
