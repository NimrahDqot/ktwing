@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Add Sub Module</h1>

    <form action="{{ route('admin_sub_manage_module_store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin_sub_manage_module_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ VIEW_ALL }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Module *</label>
                                <select name="module_id" id="" class="form-control">
                                    <option   disabled selected>--Select Module--</option>
                                    @foreach ($module as $item)
                                    <option value="{{$item->id }}">{{$item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">{{ NAME }} *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" autofocus>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Key *</label>
                                <input type="text" name="key" class="form-control" value="{{ old('key') }}" autofocus>
                            </div>
                        </div>

                <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
            </div>
        </div>
    </form>

@endsection
