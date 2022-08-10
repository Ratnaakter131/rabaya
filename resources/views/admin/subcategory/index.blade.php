@extends('layouts.dashboard')

@section('content')
    <div class="">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="text-white">Subcategory List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <tr>
                                <th>SL</th>
                                <th>Category Name</th>
                                <th>Action</th>
                                <th>Delete</th>
                            </tr>
                            @foreach ($subcategories as $key => $subcategory)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $subcategory->rel_to_category->category_name ?? 'Uncategorized' }}</td>
                                    <td>{{ $subcategory->subcategory_name }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"><i
                                                class="fa fa-pencil"></i></a>
                                        <a href="#" class="btn btn-danger shadow btn-xs sharp mr-1"><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-success">
                        <h3 class="text-white">Add Subcategory</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('subcategory.store') }}" method="POST">
                            @csrf
                            <div class="mt-3">
                                <select name="category_id" class="form-control">
                                    <option value="">--Select Category--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3">
                                <label for="">Subcategory Name</label>
                                <input type="text" name="subcategory_name" class="form-control">
                                @if (session('exist'))
                                    <strong class="text-danger">{{ session('exist') }}</strong>
                                @endif
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">Add Subcategory</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
