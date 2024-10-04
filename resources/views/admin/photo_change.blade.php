@extends('admin.app_admin')
@section('admin_content')



    </style>
    <h1 class="h3 mb-3 text-gray-800">{{ EDIT_PHOTO }}</h1>

    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('admin_photo_change_update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="">{{ EXISTING_PHOTO }} *</label>
                            <div>
                                <img src="{{ asset($admin_data->image) }}" alt="" class="w_150">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">{{ CHANGE_PHOTO }} *</label>
                            <div>
                                <input type="file" accept="image/*" onchange="loadFile(event)" name="image" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <img id="output" class="w_150" style="cursor: pointer;" onclick="zoomImage(this)" />
                            </div>
                        </div>
                        <!-- Modal for Zoom Effect -->
                        <div id="modal" class="modal modal-image" onclick="closeModal()">
                            <span class="close close-image" onclick="closeModal()">&times;</span>
                            <img class="modal-image-content modal-content" id="modalImage">
                            <div id="caption"></div>
                        </div>
                        <button type="submit" class="btn btn-success">{{ UPDATE }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

