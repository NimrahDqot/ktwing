@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Add Reward</h1>

    <form action="{{ route('admin_reward_store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin_product_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        {{ VIEW_ALL }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="">{{ NAME }} *</label>
                    <select name="user_id" class="form-control" id="">
                        <option value="1">1234567890</option>
                        <option value="2">1234323890</option>
                        <option value="3">1223567890</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Amount *</label>
                    <input type="number" name="amount" class="form-control" value="{{ old('amount') }}" autofocus>
                </div>
            </div>
            <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
        </div>
    </form>
@endsection
