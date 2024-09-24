@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Add Banner</h1>

        <form action="{{ route('admin_banner_update',$banner->id) }}" method="post" enctype="multipart/form-data">
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
                    <input type="text" name="title" class="form-control" value="{{ $banner->title }}">
                </div>
                <div class="form-group">
                    <label for="">Url</label>
                    <input type="url" name="url" class="form-control" value="{{ $banner->url }}">
                </div>
                <div class="form-group">
                    <label for="">Type *</label>
                    <input type="text" name="type" class="form-control" value="{{ $banner->type }}">
                </div>

                <div class="form-group">
                    <label for="">Sort *</label>
                    <input type="number" name="sort_by" class="form-control" value="{{ $banner->sort_by }}">

                </div>
                <div class="form-group">
                    <label for="">{{ EXISTING_PHOTO }}</label>
                    <div>
                        <img src="{{ asset('uploads/banner/'.$banner->image) }}" alt="" class="w_200">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Image *</label>
                    <div>
                        <input type="file" name="image">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">{{ UPDATE }}</button>
            </div>
        </div>
    </form>
@endsection
