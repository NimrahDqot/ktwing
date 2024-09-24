
@extends('admin.app_admin')
@section('admin_content')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

<h1 class="h3 mb-3 text-gray-800">Edit Event</h1>


<form action="{{ route('admin_event_update', $event->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin_event_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        {{ VIEW_ALL }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Event Category Name</label>
                            <select name="event_category_id" class="form-control">
                                <option value="" disabled selected>-Select event category-</option>
                                @foreach($event_category as $category)
                                    <option value="{{ $category->id}}" {{$category->id == $event->event_category_id ? 'selected' : ''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" onkeydown="return /[a-zA-Z ]/i.test(event.key)" value="{{ old('name',$event->name) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="text" name="description" class="form-control"   value="{{ old('description',$event->description) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Village Name</label>
                            <select name="village_id"  class="form-control">
                                <option value="" disabled selected>-Select event category-</option>
                                @foreach($villages as $village)
                                    <option value="{{$village->id}}" {{$village->id == $event->village_id ? 'selected' : ''}}>{{$village->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="date" name="event_date" class="form-control"  value="{{ old('event_date',$event->event_date) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Event Time</label>
                            <input type="time" name="event_time" class="form-control"  value="{{ old('event_time',$event->event_time) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Event Duration</label>
                            <input type="text" name="event_duration" class="form-control"  value="{{ old('event_duration',$event->event_duration) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Event Agenda</label>
                            <input type="text" name="event_agenda" class="form-control"  value="{{ old('event_agenda',$event->event_agenda) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Expected Attendance</label>
                            <input type="number" name="expected_attendance" class="form-control"  value="{{ old('expected_attendance',$event->expected_attendance) }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Resource List</label>
                            <input type="text" name="resoure_list" class="form-control"  value="{{ old('resoure_list',$event->resoure_list) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Important Attendees</label>

                                <select name="attendees_id[]" data-placeholder="-Select Attendees-" multiple class="chosen-select">
                                    <option value="" disabled>-Select Attendees-</option>
                                    @foreach($attendees as $attendee)
                                        <option value="{{ $attendee->id }}" {{in_array($attendee->id,explode(',', $event->attendees_id)) ? 'selected' : ''}} >{{ $attendee->name }}</option>
                                    @endforeach
                                </select>

                        </div>
                    </div>

                    <div class="col-md-4">
                           <a class="btn btn-info mt-4" href="{{route('admin_attendees_create')}}">+ Add More Attendees</a>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Image</label>
                            <input type="file" accept="image/*" onchange="loadFile(event)"  name="image" class="form-control">

                        </div>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ asset($event->image )}}" target="_blank">
                            <img src="{{ asset($event->image )}}" alt="{{ $event->name }}" class="w_200"  id="output">
                        </a>
                    </div>

                    <div class="col-md-4">
                        <img id="output" class="w_300"/>
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

    function displayAttendeeImages() {
        const selectedValues = $('#attendeesSelect').val(); // Get selected values
        const imagesContainer = $('#attendeeImages');
        imagesContainer.empty(); // Clear previous images

        // Check if any options are selected
        if (selectedValues.length === 0) {
            imagesContainer.append('<p>No attendees selected.</p>'); // Optional: message if no selections
            return;
        }

        selectedValues.forEach(value => {
            const option = $(`#attendeesSelect option[value="${value}"]`);
            const imgSrc = option.data('image');
            const imgElement = $('<img>').attr('src', imgSrc).addClass('w_200 m-1'); // Add styling as needed
            imagesContainer.append(imgElement);
        });
    }
</script>

