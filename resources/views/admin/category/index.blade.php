@extends('layouts.dashboard')

@section('content')
    <div class="">
        <div class="row">
            <div class="col-lg-9">
                <div class="card h-auto">
                    <div class="card-header bg-danger">
                        <h3 class="text-white">Category List</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('category.marked') }}" method="POST">
                            @csrf
                        <table class="table table-striped">
                            <thead class="bg-light">
                            <tr>
                                <th><input type="checkbox" id="checkAll"> Mark All</th>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Added By</th>
                                <th>Image</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>

                            @forelse ($categories as $key => $category)
                             {{-- <thead class="bg-danger"> --}}
                                <tr>
                                    <td><input type="checkbox" name="mark[]" value="{{ $category->id }}"></td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $category->category_name }}</td>
                                    <td>{{ $category->rel_to_user->name }}</td>
                                    <td> <img width="50" src="{{ asset('/uploads/category') }}/{{ $category->category_image }}" alt=""> </td>
                                    <td>{{ $category->created_at->diffForHumans() }}</td>
                                       <td>
                                    <div class="dropdown">
														<button type="button" class="btn btn-danger light sharp" data-toggle="dropdown">
															<svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
														</button>

                                     <div class="dropdown-menu">
                                     <a href="{{ route('category.edit', $category->id) }}" class="dropdown-item" >Edit</a>
                                     <a href="{{ route('del', $category->id) }}" class="dropdown-item" >Delete</a>
                                      </div>
                                    </div>

                                   </td>
                                </tr>
                             @empty
                                <tr>
                                    <td colspan="5" class="text-center"> No Data Found </td>
                                </tr>
                            @endforelse
                              </thead>
                        </table>
                        @error('mark')
                            <div>
                                <strong class="text-danger">{{ $message }}</strong>
                            </div>
                        @enderror

                        @if (App\Models\Category::count() > 0)
                       <button type="submit" class="btn btn-danger">Delete Marked</button>
                        @endif
                        </form>
                    </div>
                    {{-- 2nd card start  --}}

                </div>
                  <div class="card mt-5 h-auto">
                    <div class="card-header">
                        <h3> Trashed Category List </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Added By</th>
                                <th>Created At</th>
                                <th>Action</th>
                                <th>Delete</th>
                            </tr>
                            @forelse ($trash_categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $category->category_name }}</td>
                                    <td>{{ $category->rel_to_user->name }}</td>
                                    <td>{{ $category->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('category.restore', $category->id) }}"
                                            class="btn btn-primary">Restore</a>

                                    </td>
                                    <td>
                                        <a href="{{ route('category.per.delete', $category->id) }}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No Data Found</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>


                </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="text-white">Add Category</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mt-3">
                                <label for="" class="form-label">Category Name</label>
                                <input type="text" name="category_name" class="form-control">
                                @error('category_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Category Image</label>
                                <input type="file" name="category_image" class="form-control">
                                @error('category_image')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">Add Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_script')
    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            })
        </script>
    @endif
    <script>
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
