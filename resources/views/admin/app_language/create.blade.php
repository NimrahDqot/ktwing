
@extends('admin.app_admin')
@section('admin_content')
<style>

</style>
    <h1 class="h3 mb-3 text-gray-800">Add Attendees</h1>

    <form action="{{ route('admin_app_language_store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin_app_language_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        {{ VIEW_ALL }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Key</label>
                            <input type="text" name="lang_key" class="form-control text-uppercase" onkeydown="return /[a-zA-Z_]/i.test(event.key)" value="{{ old('lang_key') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">value</label>
                            <input type="text" name="lang_value" class="form-control"  value="{{ old('lang_value') }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
            </div>

        </div>
    </form>
@endsection

