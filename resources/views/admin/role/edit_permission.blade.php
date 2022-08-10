@extends('layouts.dashboard')
@section('content')
   <div class="container">
     <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Role Permission</h3>
                </div>
                 <div class="card-body">
                    <form action="{{ route('role.permissions.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Role Name</label>
                            <input type="hidden" name="role_id" value="{{ $role->id }}">
                            <input type="text" readonly class="form-control" value="{{ $role->name }}" >
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Permission</label>
                            @foreach ($all_permissions as $permission)
                            <br>
                            <input type="checkbox" {{ ($role->hasPermissionTo($permission->name))?'checked':''}} value="{{ $permission->id }}" name="permission_name[]">    {{ $permission->name }}
                            @endforeach
                        </div>
                        <div class="mb-3">
                          <button type="submit" class="btn btn-primary">Update Roles Permission </button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
     </div>
   </div>
@endsection
