@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Village</h1>

        <form action="{{ route('admin_village_update',$village->id) }}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                    <div class="float-right d-inline">
                        <a href="{{ route('admin_village_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                            {{ VIEW_ALL }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Village Name</label>
                                <input type="text" maxlength="10" name="name" oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '');"  class="form-control" value="{{ old('name',$village->name) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">District</label>
                                <input type="text" name="district" class="form-control" value="{{ old('district',$village->district) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Population</label>
                                <input type="text" name="population" class="form-control" value="{{ old('population',$village->population) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">language</label>
                                <input type="text" name="language" class="form-control" value="{{ old('language',$village->language) }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Contact</label>
                            <input type="text" maxlength="10" name="contact" oninput="this.value = this.value.replace(/[^0-9]/g, '');"  class="form-control" value="{{ old('contact',$village->contact) }}">
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
                </div>

            </div>
        </form>

@endsection

<script>
    var loadFile = function(event) {
      var output = document.getElementById('output');
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
      }
    };
</script>
