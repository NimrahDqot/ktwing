@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Admin</h1>

            <form action="{{ route('admin_manage_admin_update',$manage_admin->id) }}" method="post" enctype="multipart/form-data">
                @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ VIEW_ALL }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">User Name</label>
                            <input type="text" name="username" class="form-control" value="{{old('username', $manage_admin->username) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" class="form-control" value="{{old('email', $manage_admin->email) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Mobile</label>
                            <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $manage_admin->mobile) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Role *</label>
                            <select name="role_id" id="" class="form-control">
                                <option disabled selected>--Select Role--</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}"{{ $manage_admin->role_id == $role->id ? "selected":""}}>{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Password *</label>
                            <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Re-Enter Password *</label>
                            <input type="password" name="confirm_password" class="form-control" value="{{ old('confirm_password') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" accept="image/*" onchange="loadFile(event)"  name="image" class="form-control">

                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <a href="{{ asset($manage_admin->image )}}" target="_blank">
                            <img src="{{ asset($manage_admin->image )}}" alt="{{ $manage_admin->name }}" class="w_200"  id="output">
                        </a>
                    </div> --}}

                    <div class="col-md-4">
                        <img id="output" class="w_150" style="cursor: pointer;" onclick="zoomImage(this)" src="{{ asset($manage_admin->image )}}" />
                    </div>
                    <div id="modal" class="modal modal-image" onclick="closeModal()">
                        <span class="close close-image" onclick="closeModal()">&times;</span>
                        <img class="modal-image-content modal-content" id="modalImage">
                        <div id="caption"></div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
            </div>
        </div>
    </form>

@endsection
