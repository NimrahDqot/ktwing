@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Event Category</h1>

        <form action="{{ route('admin_event_category_update',$event_category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                    <div class="float-right d-inline">
                        <a href="{{ route('admin_event_category_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                            {{ VIEW_ALL }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Event Category Name</label>
                                <input type="text" maxlength="10" name="name" oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '');"  class="form-control" value="{{ old('name',$event_category->name) }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
                </div>

            </div>
        </form>

@endsection
