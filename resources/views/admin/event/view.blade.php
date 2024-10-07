
@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">View Event</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex justify-content-left">
                    <form class="d-flex flex-wrap align-items-left" id="search" action="{{ route('admin_event_view') }}"  method="GET">
                        <div class="me-sm-3 ml-2">
                            <select name="status" class="form-control" id="statusFilter">
                                <option selected disabled>--Event status--</option>
                                <option value="1"  {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0"  {{ request('status') == '0' ? 'selected' : '' }}>InActive</option>
                            </select>
                        </div>
                        <div class="me-sm-3 ml-2">
                            <select name="event_status" class="form-control" id="statusFilter">
                                <option selected disabled>--Current event status--</option>
                                <option value="Completed"  {{ request('event_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Upcoming"  {{ request('event_status') == 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                                <option value="Ongoing"  {{ request('event_status') == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                            </select>
                        </div>
                        <div class="me-sm-3 ml-2">
                            <input type="text" class="form-control my-1 my-lg-0" name="name" value="{{ request('name') }}" id="nameFilter" placeholder="Event Name...">
                        </div>
                        <div class="me-sm-3 ml-2">
                            <select name="per_page"  class="form-control" id="per_page">
                                <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>all</option>
                            </select>
                        </div>
                    <div class="me-sm-3 ml-2">
                            <select name="sort_by" class="form-control" id="statusFilter">
                                <option value="id" {{ request('sort_by') == '' ? 'selected' : '' }}>--Please select Sort by--</option>
                                <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Id</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                            </select>
                        </div>

                        <div class="me-sm-3 ml-2">
                            <select name="sort_direction" class="form-control" id="sortDirectionFilter">
                                <option value="ASC" {{ request('sort_direction') == 'ASC' ? 'selected' : '' }}>Ascending</option>
                                <option value="DESC" {{ request('sort_direction') == 'DESC' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <div class="text-lg-end my-1 my-lg-0">
                                <a type="reset" href="{{ route('admin_event_view') }}" class="btn btn-secondary waves-effect waves-light">Clear</a>
                                <button type="submit" class="btn btn-danger waves-effect waves-light">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Event</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin_event_create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ ADD_NEW }}</a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ SERIAL }}</th>
                        <th>Image</th>
                        <th>Category Name</th>
                        <th>Event Details</th>
                        <th>Status</th>
                        <th>Assign to volunteer</th>
                        <th>Assign to Attendee</th>

                        <th>{{ ACTION }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp

                        @foreach($events as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ asset($row->image )}}" target="_blank">
                                    <img src="{{ asset($row->image )}}" alt="{{ $row->name }}" class="w_50">
                                </a>
                            </td>
                            <td>{{ Str::ucfirst($row->event_category_info->name) }}</td>
                            <td>
                                <b>Name: {{ Str::ucfirst($row->name) }} </b><br>
                                <b>Date: </b>{{ date('d M, Y', strtotime($row->event_date)) }}, {{ date('g:i A', strtotime($row->event_time)) }}
                               <br>
                               @if($row->event_status == 'Ongoing')
                                    <span class="badge badge-pill badge-primary mt-2">{{ $row->event_status }}</span>
                                @elseif($row->event_status == 'Completed')
                                    <span class="badge badge-pill badge-success mt-2">{{ $row->event_status }}</span>
                                @elseif($row->event_status == 'Upcoming')
                                    <span class="badge badge-pill badge-warning mt-2">{{ $row->event_status }}</span>
                                @endif

                            </td>
                            <td>
                                @if ($row->status == '1')
                                <a href="" onclick="changeStatus({{ $row->id }})"><input type="checkbox" checked data-toggle="toggle" data-on="Active" data-off="InActive" data-onstyle="success" data-offstyle="danger"></a>
                                @else
                                    <a href="" onclick="changeStatus({{ $row->id }})"><input type="checkbox" data-toggle="toggle" data-on="Active" data-off="InActive" data-onstyle="success" data-offstyle="danger"></a>
                                @endif
                            </td>

                            <td>
                                @php
                                    $volunteerIds = explode(',', $row->volunteer_id); // Assuming the IDs are stored as CSV
                                    $assignedVolunteers = $volunteers->whereIn('id', $volunteerIds); // Fetch volunteer names based on IDs
                                @endphp
                                @if($assignedVolunteers->count() > 0)
                                    @foreach($assignedVolunteers as $volunteer)
                                        <span>{{ $volunteer->name }}</span>{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                @else
                                    <span class="text-secondary">No volunteers assigned</span>
                                @endif
                                <p class="pt-2">
                                    <button class="btn btn-warning" onclick="openModal({{ $row->id }}, {{ json_encode($volunteerIds) }})">Assign to volunteer</button>
                                </p>
                            </td>
                            <td>
                                @php
                                    $attendeeIds = explode(',', $row->attendees_id); // Assuming the IDs are stored as CSV
                                    $assignedAttendee = $attendees->whereIn('id', $attendeeIds); // Fetch volunteer names based on IDs
                                @endphp
                                @if($assignedAttendee->count() > 0)
                                    @foreach($assignedAttendee as $attendee)
                                        <span>{{ $attendee->name }}</span>{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                @else
                                    <span class="text-secondary">No attendee assigned</span>
                                @endif
                                <p class="pt-2">
                                    <button class="btn btn-info" onclick="openAttendeeModal({{ $row->id }}, {{ json_encode($attendeeIds) }})">Assign to attendee</button>
                                </p>
                            </td>
                            <td>
                                @if($row->event_status == 'Completed')
                                <a href="{{ route('admin_event_view_detail',$row->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                @elseif($row->event_status == 'Ongoing')
                                <a href="{{ route('admin_event_view_detail',$row->id) }}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin_event_edit',$row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                @else
                                    <a href="{{ route('admin_event_edit',$row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin_event_delete',$row->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('{{ ARE_YOU_SURE }}');"><i class="fas fa-trash-alt"></i></a>
                                @endif
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>

                <div class="col-12">
                    {{ $events->links() }}
                </div>

                <!-- Assign Volunteer Modal -->
                <div class="modal fade" id="assignVolunteerModal" tabindex="-1" aria-labelledby="assignVolunteerLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="assignVolunteerLabel">Assign Volunteer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>
                            <div class="modal-body">
                                <form id="assignVolunteerForm">
                                        <select name="volunteer_id[]" id="volunteerSelect" data-placeholder="-Select Volunteer-" multiple class="form-control my-select2-class" style="width: 100%">
                                        @foreach($volunteers as $volunteer)
                                            <option value="{{ $volunteer->id }}">{{ $volunteer->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="submitVolunteer()" >Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Assign Attendee Modal -->
                 <div class="modal fade" id="assignattendeeModal" tabindex="-1" aria-labelledby="assignattendeeLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="assignattendeeLabel">Assign attendee</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                            </div>

                            <div class="modal-body">

                                <button type="button" class="btn btn-info float-right mb-2" data-toggle="modal" data-target="#attendeeModal">+ Add Attendee</button>
                                <form id="assignattendeeForm">
                                <select name="attendee_id[]" id="attendeeSelect"   multiple class="form-control my-select2-class" style="width:100%">

                                        @foreach($attendees as $attendee)
                                            <option value="{{ $attendee->id }}">{{ $attendee->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="submitAttendee()" >Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <!--Add new attendees Modal -->
    <div class="modal fade" id="attendeeModal" role="dialog" tabindex="-1" aria-labelledby="attendeeModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="add_attendee" class="btn btn-primary" onclick="addAttendee()">Add Attendee</button>
                </div>
            </div>
        </div>
    </div>

@endsection



<script type="text/javascript">
    function changeStatus(id){
        $.ajax({
            type:"get",
            url:"{{url('/admin/event-status/')}}"+"/"+id,
            success:function(response){
                toastr.success(response)
            },
            error:function(err){
                console.log(err);
            }
        })
    }
    function openModal(rowId, selectedVolunteers) {
        const modal = document.getElementById('assignVolunteerModal');
        modal.dataset.rowId = rowId;

        // Clear previous selections
        $('#volunteerSelect').val([]).trigger('change'); // Use 'change' for Select2

        // Set the selected volunteers for this row
        if (selectedVolunteers && selectedVolunteers.length > 0) {
            $('#volunteerSelect').val(selectedVolunteers).trigger('change'); // Use 'change' for Select2
        }

        // Show the modal
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    }

    // function openModal(rowId, selectedVolunteers) {
    //     const modal = document.getElementById('assignVolunteerModal');
    //     modal.dataset.rowId = rowId;

    //     // Clear previous selections
    //     $('#volunteerSelect').val([]).trigger('chosen:updated');

    //     // Set the selected volunteers for this row
    //     if (selectedVolunteers && selectedVolunteers.length > 0) {
    //         $('#volunteerSelect').val(selectedVolunteers).trigger('chosen:updated');
    //     }

    //     // Show the modal
    //     const modalInstance = new bootstrap.Modal(modal);
    //     modalInstance.show();
    // }


    function openAttendeeModal(rowId, selectedAttendee) {
        const modal = document.getElementById('assignattendeeModal');
        modal.dataset.rowId = rowId;

        // Clear previous selections
        $('#attendeeSelect').val([]).trigger('change'); // Use 'change' for Select2

        // Set the selected volunteers for this row
        if (selectedAttendee && selectedAttendee.length > 0) {
            $('#attendeeSelect').val(selectedAttendee).trigger('change'); // Use 'change' for Select2
        }

        // Show the modal
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
    }

function submitVolunteer() {
    // Get the selected volunteers from the form
    var selectedVolunteers = $('#volunteerSelect').val();
    var modal = document.getElementById('assignVolunteerModal');
    var rowId = modal.dataset.rowId;
        console.log(selectedVolunteers);
    if (selectedVolunteers && selectedVolunteers.length > 0) {
        $.ajax({
            url:'{{route('assign_volunteer')}}',
            method: 'POST',
            data: {
                id: rowId,
                volunteer_id: selectedVolunteers,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toastr.success('Volunteers assigned successfully');

                // Update the specific <td> with the new volunteer names
                var updatedVolunteersHtml = '';
                    // if (response.assignedVolunteers.length > 0) {
                    //     response.assignedVolunteers.forEach(function(volunteer, index) {
                    //         updatedVolunteersHtml += volunteer.name;
                    //         if (index < response.assignedVolunteers.length ) {
                    //             updatedVolunteersHtml += ', ';
                    //         }
                    //     });
                    // } else {
                    //     updatedVolunteersHtml = '<span class="text-secondary">No volunteers assigned</span>';
                    // }

                    // // Update the <td> with class 'updateOnrefresh'
                    // $('td.updateOnrefresh[data-row-id="' + rowId + '"]').html(updatedVolunteersHtml);


                    // $("#assignVolunteerModal").removeClass("show").attr("aria-hidden", "true").css("display", "none");

                    // // Optionally, remove the modal backdrop if it's still visible
                    // $(".modal-backdrop").remove();
                //    $('#assignVolunteerModal').modal('hide');
                //    alert('h');
                location.reload(); // Reload the page or handle dynamically
            },
            error: function(error) {

                toastr.error(error,'Error occurred while assigning volunteers');
            }
        });

    } else {
        toastr.warning('Please select at least one volunteer');

        //   toastr.warning('Please select at least one volunteer');
    }
}


function submitAttendee() {
    // Get the selected volunteers from the form
    var selectedAttendee = $('#attendeeSelect').val();
    var modal = document.getElementById('assignattendeeModal');
    var rowId = modal.dataset.rowId;
        console.log(selectedAttendee);
    if (selectedAttendee && selectedAttendee.length > 0) {
        $.ajax({
            url:"{{url('/admin/assign-attendee')}}",
            method: 'POST',
            data: {
                id: rowId,
                attendees_id: selectedAttendee,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toastr.success('Attendee assigned successfully');
                location.reload();
            },
            error: function(error) {
                console.log(error.errors.name);
                toastr.error('Error occurred while assigning attendees');
            }
        });

    } else {
        toastr.warning('Please select at least one attendee');

    }
}
</script>

<script>
    // Function to handle adding an attendee
    function addAttendee() {
        const name = document.getElementById('new_attendee_name').value;
        const role = document.getElementById('new_attendee_role').value;
        const image = document.getElementById('new_attendee_image').files[0];

        // Assuming you have an API endpoint to add the attendee
        const formData = new FormData();
        formData.append('name', name);
        formData.append('role', role);
        formData.append('image', image);
        formData.append('_token', '{{ csrf_token() }}'); // Include CSRF token

         // Use jQuery AJAX to submit the form data
        $.ajax({
            url: "{{ url('/admin/attendees') }}", // Update with your endpoint
            method: 'POST',
            processData: false, // Prevent jQuery from automatically transforming the data into a query string
            contentType: false, // Let the browser set the content type
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Update the attendee select options here

                    // Update the attendee select options here
                    $('#attendeeSelect').append(new Option(response.attendee.name, response.attendee.id));

                    // Clear the input fields
                    document.getElementById('attendeeForm').reset();

                    // Close the modal using jQuery
                    $('#attendeeModal .close').click();

                    toastr.success('Attendee added successfully');
                    toastr.success('Attendee added successfully');
                } else {
                    alert(response.message);
                }
            },
            error: function(error) {
                if (error.status === 422) {
                    // Handle validation errors
                    const errors = error.responseJSON.errors;
                    for (const key in errors) {

                        toastr.error(errors[key].join(", ")); // Example alert for errors
                    }
                } else {
                    console.error('An unexpected error occurred.');
                }
                toastr.error('Error occurred while adding attendee');
            }
        });
    }
</script>
