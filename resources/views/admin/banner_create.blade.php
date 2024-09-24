@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Add Banner</h1>

    <form action="{{ route('admin_banner_store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin_banner_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        {{ VIEW_ALL }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">{{ TITLE }} *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" autofocus>
                </div>

                <div class="form-group">
                    <label for="">Type *</label>
                    <input type="text" name="type" class="form-control" value="{{ old('type') }}">
                </div>

                <div class="form-group">
                    <label for="">Sort *</label>
                    <input type="number" name="sort_by" class="form-control" value="{{ old('sort_by') }}">

                </div>

                <div class="form-group">
                    <label for="">Image *</label>
                    <div>
                        <input type="file" name="image">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
            </div>
        </div>
    </form>
@endsection
