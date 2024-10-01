@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Attendees</h1>

        <form action="{{ route('admin_attendees_update',$attendees->id) }}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                    <div class="float-right d-inline">
                        <a href="{{ route('admin_attendees_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                            {{ VIEW_ALL }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" name="name" class="form-control" onkeydown="return /[a-zA-Z ]/i.test(event.key)" value="{{ old('name',$attendees->name) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Role</label>
                                <input type="text" name="role" class="form-control" onkeydown="return /[a-zA-Z ]/i.test(event.key)" value="{{ old('role', $attendees->role) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Image</label>
                                <input type="file" accept="image/*" onchange="loadFile(event)"  name="image" class="form-control">
                            </div>
                        </div>
                        <div class="offset-md-8 col-md-4">
                            <a href="{{ asset($attendees->image )}}" target="_blank">
                                <img src="{{ asset($attendees->image )}}" alt="{{ $attendees->name }}" class="w_100"  id="output">
                            </a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
                </div>

            </div>
        </form>

@endsection
