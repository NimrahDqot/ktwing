
@extends('admin.app_admin')
@section('admin_content')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>


    <h1 class="h3 mb-3 text-gray-800">Add Volunteer</h1>

    <form action="{{ route('admin_volunteer_store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin_volunteer_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        {{ VIEW_ALL }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Mobile</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
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
                                    <option value="{{$role->id}}"{{ old("role_id") == $role->id ? "selected":""}}>{{$role->name}}</option>
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
                            <input type="password" name="password_confirmation" class="form-control" value="{{ old('confirm_password') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Experience</label>
                            <input type="text" name="experience" class="form-control" value="{{ old('experience') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" accept="image/*" onchange="loadFile(event)"  name="image" class="form-control">

                        </div>
                    </div>
                    <div class="col-md-4">
                        <img id="output" class="w_300"/>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Assign Villages</label>

                                <select name="village_id[]" data-placeholder="-Select Attendees-" multiple class="chosen-select">
                                    <option value="" disabled>-Select Villages-</option>
                                    @foreach($villages as $village)
                                        <option value="{{ $village->id }}"  >{{ $village->name }}</option>
                                    @endforeach
                                </select>
                            </select>

                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
            </div>

        </div>
    </form>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

<script>
      $(document).ready(function() {
        $(".chosen-select").chosen({
            no_results_text: "Oops, nothing found!",
            width: "100%"
        });
    });

  var loadFile = function(event) {
    var output = document.getElementById('output');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>
