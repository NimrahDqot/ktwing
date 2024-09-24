
@extends('admin.app_admin')
@section('admin_content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

    <h1 class="h3 mb-3 text-gray-800">View Event</h1>

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
                        <th>Volunteers Name</th>
                        <th>Assign to volunteer</th>
                        <th>{{ ACTION }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp

                        @foreach($event as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ asset($row->image )}}" target="_blank">
                                    <img src="{{ asset($row->image )}}" alt="{{ $row->name }}" class="w_50">
                                </a>
                            </td>
                            <td>{{ Str::ucfirst($row->event_category_info->name) }}</td>
                            <td>
                                <b>Name: </b>{{ Str::ucfirst($row->name) }} <br>
                                <b>Date: </b>{{ date('d M, Y', strtotime($row->event_date)) }}, {{ date('g:i A', strtotime($row->event_time)) }}
                            </td>
                            <td>
                                @if ($row->status == '1')
                                <a href="" onclick="changeStatus({{ $row->id }})"><input type="checkbox" checked data-toggle="toggle" data-on="Active" data-off="Pending" data-onstyle="success" data-offstyle="danger"></a>
                                @else
                                    <a href="" onclick="changeStatus({{ $row->id }})"><input type="checkbox" data-toggle="toggle" data-on="Active" data-off="Pending" data-onstyle="success" data-offstyle="danger"></a>
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
                                    <span>No volunteers assigned</span>
                                @endif
                            </td>

                            <!-- Assign Volunteer Button -->
                            <td>
                                <button class="btn btn-warning" onclick="openModal({{ $row->id }}, {{ json_encode($volunteerIds) }})">Assign to volunteer</button>
                            </td>
                            <td>
                                <a href="{{ route('admin_event_edit',$row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('admin_event_delete',$row->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('{{ ARE_YOU_SURE }}');"><i class="fas fa-trash-alt"></i></a>
                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>
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
                                    <select name="volunteer_id[]" id="volunteerSelect" data-placeholder="-Select Volunteer-" multiple class="chosen-select" style="width:100%">
                                        <option value="" disabled>-Select Volunteer-</option>
                                        @foreach($volunteers as $volunteer)
                                            <option value="{{ $volunteer->id }}">{{ $volunteer->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="submitVolunteer()" data-dismiss="modal">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->


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
        $('#volunteerSelect').val([]).trigger('chosen:updated');

        // Set the selected volunteers for this row
        if (selectedVolunteers && selectedVolunteers.length > 0) {
            $('#volunteerSelect').val(selectedVolunteers).trigger('chosen:updated');
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

    if (selectedVolunteers.length > 0) {
        $.ajax({
            url:"{{url('/admin/submit-volunteer')}}",
            method: 'POST',
            data: {
                id: rowId,
                volunteer_id: selectedVolunteers,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                toastr.success('Volunteers assigned successfully');
                // $(this).modal('hide');
                // $('.modal').each(function(){
                //     $(this).modal('hide');
                // });
                   $('#assignVolunteerModal').modal('hide');
                   alert('h');
                // location.reload(); // Reload the page or handle dynamically
            },
            error: function(error) {
                toastr.error('Error occurred while assigning volunteers');
            }
        });

        // Close the modal after submission
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
    } else {
        alert("Please select at least one volunteer.");
    }
}


// function toggleAssignVolunteer(id) {
//     const rejectionDiv = document.getElementById(`rejection_div_${id}`);
//     rejectionDiv.style.display = rejectionDiv.style.display === 'none' ? 'block' : 'none';
// }

// function submitRejection(id) {
//     const rejectionReason = document.getElementById(`rejection_reason_${id}`).value;

//     if (rejectionReason.trim() === '') {
//         toastr.error('Please enter a rejection reason');
//         return;
//     }

    $.ajax({
        url: '/submit-volunteer', // Your route here
        method: 'POST',
        data: {
            id: id,
            volunteer: volunteer_id,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            toastr.success('Rejection reason submitted successfully');
            location.reload(); // Reload page or handle rejection dynamically
        },
        error: function(error) {
            toastr.error('Error occurred while submitting rejection reason');
        }
    });
// }
</script>
