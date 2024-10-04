
@extends('admin.app_admin')
@section('admin_content')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

<style>

</style>
    <h1 class="h3 mb-3 text-gray-800">Add Attendees</h1>

    <form action="{{ route('admin_event_store') }}" method="post" enctype="multipart/form-data">
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
                                    <option value="{{ $category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" onkeydown="return /[a-zA-Z ]/i.test(event.key)" value="{{ old('name') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="text" name="description" class="form-control"   value="{{ old('description') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Village Name</label>
                            <select name="village_id"  class="form-control">
                                <option value="" disabled selected>-Select event category-</option>
                                @foreach($villages as $village)
                                    <option value="{{$village->id}}">{{$village->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="date" name="event_date" class="form-control"  value="{{ old('event_date', date('Y-m-d')) }}"
                            min="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Event Time</label>
                            <input type="time" name="event_time" class="form-control"      value="{{ old('event_time', date('h:i A')) }}"      min="{{ date('h:i A') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Event Duration</label>
                            <input type="text" name="event_duration" class="form-control"   id="event_time"  value="{{ old('event_duration') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Event Agenda</label>
                            <input type="text" name="event_agenda" class="form-control"  value="{{ old('event_agenda') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Expected Attendance</label>
                            <input type="number" name="expected_attendance" class="form-control"  value="{{ old('expected_attendance') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Resource List</label>
                            <input type="text" name="resoure_list" class="form-control"  value="{{ old('resoure_list') }}">
                        </div>
                    </div>
                    {{-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Important Attendees</label>
                                <select name="attendees_id[]" data-placeholder="-Select Attendees-" multiple class="chosen-select">
                                    <option value="" disabled>-Select Attendees-</option>
                                    @foreach($attendees as $attendee)
                                        <option value="{{ $attendee->id }}"  >{{ $attendee->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Important Attendees</label>
                            <select name="attendees_id[]" data-placeholder="-Select Attendees-" multiple class="chosen-select">
                                <option value="" disabled>-Select Attendees-</option>
                                @foreach($attendees as $attendee)
                                    <option value="{{ $attendee->id }}">{{ $attendee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- <div class="col-md-4" id="attendeeImages">
                        <!-- Selected attendee images will be displayed here -->
                    </div> --}}

                    <div class="col-md-4">
                        <button type="button" class="btn btn-info mt-4" data-toggle="modal" data-target="#attendeeModal">
                            + Add Attendee
                        </button>

                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="attendeeModal" tabindex="-1" role="dialog" aria-labelledby="attendeeModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="attendeeModalLabel">Add New Attendee</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="attendeeForm">
                                        @csrf
                                        <div class="form-group">
                                            <label for="new_attendee_name">Name</label>
                                            <input type="text" id="new_attendee_name" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_attendee_role">Role</label>
                                            <input type="text" id="new_attendee_role" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_attendee_image">Image</label>
                                            <input type="file" id="new_attendee_image" accept="image/*" class="form-control" required>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
                                    <button type="button" id="add_attendee" class="btn btn-primary">Add Attendee</button>
                                </div>
                            </div>
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
        $('#add_attendee').on('click', function() {
            var attendeeName = $('#new_attendee_name').val();
            var attendeeRole = $('#new_attendee_role').val();
            var attendeeImage = $('#new_attendee_image')[0].files[0];

            if (attendeeName && attendeeRole && attendeeImage) {
                var formData = new FormData();
                formData.append('name', attendeeName);
                formData.append('role', attendeeRole);
                formData.append('image', attendeeImage);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('admin_attendees_store') }}", // Replace with your route
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            toastr.success(response.message);
                            $('.btn-close').click();
                            var newAttendee = response.attendee;

                            // Log newAttendee to check its structure
                            console.log(newAttendee);

                            var newAttendee = response.attendee;
                            console.log(newAttendee);
                            var option = new Option(newAttendee.name, newAttendee.id, true, true);
                            console.log(option);
                            $('select[name="attendees_id[]"]').append(option);
                            $('select[name="attendees_id[]"]').trigger('chosen:updated');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred. Please try again.');
                    }
                });
            } else {
                alert('Please fill in all fields.');
            }
        });
    });
</script>


{{-- <script>
    $(document).ready(function() {
        $('#add_attendee').on('click', function() {
            var attendeeName = $('#new_attendee_name').val();
            var attendeeRole = $('#new_attendee_role').val();
            var attendeeImage = $('#new_attendee_image')[0].files[0];

            if (attendeeName && attendeeRole && attendeeImage) {
                var formData = new FormData();
                formData.append('name', attendeeName);
                formData.append('role', attendeeRole);
                formData.append('image', attendeeImage);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('admin_attendees_store') }}", // Replace with your route
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            var newAttendee = response.attendee;

                            toastr.success(response.message);
                            location.reload(); // Reload page or handle rejection dynamically

                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred. Please try again.');
                    }
                });
            } else {
                alert('Please fill in all fields.');
            }
        });
    });
</script> --}}

<script>
    // function displayAttendeeImages() {
    //     const selectElement = document.getElementById('attendeesSelect');
    //     const imagesContainer = document.getElementById('attendeeImages');
    //     imagesContainer.innerHTML = ''; // Clear previous images

    //     Array.from(selectElement.selectedOptions).forEach(option => {
    //         const imgSrc = option.getAttribute('data-image');
    //         if (imgSrc) {
    //             const imgElement = document.createElement('img');
    //             imgElement.src = imgSrc;
    //             imgElement.alt = option.text;
    //             imgElement.className = 'w_200 m-1'; // Add styling as needed
    //             imagesContainer.appendChild(imgElement);
    //         }
    //     });
    // }

</script>
<script>
    // $(document).ready(function() {
    //     $(".chosen-select").chosen({
    //         no_results_text: "Oops, nothing found!",
    //         width: "100%"
    //     });
    // });

    // function displayAttendeeImages() {
    //     const selectedValues = $('#attendeesSelect').val(); // Get selected values
    //     const imagesContainer = $('#attendeeImages');
    //     imagesContainer.empty(); // Clear previous images

    //     selectedValues.forEach(value => {
    //         const option = $(`#attendeesSelect option[value="${value}"]`);
    //         const imgSrc = option.data('image');
    //         const imgElement = $('<img>').attr('src', imgSrc).addClass('w_200 m-1'); // Add styling as needed
    //         imagesContainer.append(imgElement);
    //     });
    // }
</script>
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

<script>
    document.getElementById('event_time').addEventListener('input', function() {
        const inputTime = this.value;
        const now = new Date();
        const currentHour = now.getHours();
        const currentMinutes = now.getMinutes();

        // Parse the input time
        const [hour, minuteAndPeriod] = inputTime.split(':');
        const [minute, period] = minuteAndPeriod.split(' ');

        // Convert to 24-hour format for comparison
        let inputHour = parseInt(hour);
        if (period === 'PM' && inputHour < 12) {
            inputHour += 12; // Convert to 24-hour
        } else if (period === 'AM' && inputHour === 12) {
            inputHour = 0; // Convert 12 AM to 0 hours
        }

        // Compare times
        if (inputHour < currentHour || (inputHour === currentHour && parseInt(minute) <= currentMinutes)) {
            alert("Event time must be greater than the current time.");
            this.value = ''; // Clear the input
        }
    });
    </script>
