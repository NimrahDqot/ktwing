@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">View Volunteer</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Volunteer</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin_volunteer_create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                    {{ ADD_NEW }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ SERIAL }}</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Contact Details</th>
                            <th>Role</th>
                            <th>Villages</th>
                            <th>Status</th>
                            <th>{{ ACTION }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp

                        @foreach ($volunteer as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ asset($row->image) }}" target="_blank">
                                        <img src="{{ asset($row->image) }}" alt="{{ $row->name }}" class="w_50">
                                    </a>
                                </td>
                                <td class="text-capitalize">
                                    {{ $row->name }}</td>
                                <td>Experience: {{ $row->experience }} <br> {{ $row->email }} <br> {{ $row->phone }}
                                </td>
                                <td class="text-capitalize">
                                    {{ $row->role_id ? $row->Role->name : '' }}</td>
                                <td class="text-capitalize">
                                    @if ($row->villages()->isNotEmpty())
                                        @foreach ($row->villages() as $village)
                                            {{ $village->name }}@if (!$loop->last)
                                                ,
                                            @endif <!-- Display names with commas -->
                                        @endforeach
                                    @else
                                        None
                                    @endif
                                </td>

                                <td>

                                    @if ($row->status == '0')
                                        <!-- Pending -->
                                        <button class="btn btn-success"
                                            onclick="changeStatus({{ $row->id }}, '1')">Approve</button>
                                        <button class="btn btn-danger"
                                            onclick="toggleRejectInput({{ $row->id }})">Reject</button>
                                        <div id="rejection_div_{{ $row->id }}" style="display: none;">
                                            <input type="text" id="rejection_reason_{{ $row->id }}"
                                                class="form-control mt-2" placeholder="Enter rejection reason">
                                            <button type="button" class="btn btn-danger mt-2"
                                                onclick="submitRejection({{ $row->id }})">Submit Reason</button>
                                        </div>
                                    @elseif ($row->status == '1')
                                        <!-- Pending -->
                                        <button class="btn btn-warning"
                                            onclick="changeStatus({{ $row->id }}, '0')">Pending</button>
                                        <button class="btn btn-danger"
                                            onclick="toggleRejectInput({{ $row->id }})">Reject</button>
                                        <div id="rejection_div_{{ $row->id }}" style="display: none;">
                                            <input type="text" id="rejection_reason_{{ $row->id }}"
                                                class="form-control mt-2" placeholder="Enter rejection reason">
                                            <button type="button" class="btn btn-danger mt-2"
                                                onclick="submitRejection({{ $row->id }})">Submit Reason</button>
                                        </div>
                                    @elseif ($row->status == '2')
                                        <!-- Rejected -->
                                        <button class="btn btn-success"
                                            onclick="changeStatus({{ $row->id }}, '1')">Approve</button>

                                        <button class="btn btn-warning"
                                            onclick="changeStatus({{ $row->id }}, '0')">Pending</button>
                                        <div>
                                            <input type="text" id="rejection_reason_{{ $row->id }}"
                                                class="form-control mt-2" placeholder="Enter rejection reason"
                                                value="{{ old('rejection_reason', $row->rejection_reason) }}" readonly>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin_volunteer_edit', $row->id) }}"
                                        class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin_volunteer_delete', $row->id) }}" class="btn btn-danger btn-sm"
                                        onClick="return confirm('{{ ARE_YOU_SURE }}');"><i
                                            class="fas fa-trash-alt"></i></a>
                                    <button type="button" class="btn btn-warning btn-sm"
                                        onclick="openNotification({{ $row->id }})" data-toggle="modal"
                                        data-target="#exampleModal">
                                        <i class="fas fa-bell"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="col-12">
                    {{ $volunteer->links() }}
                </div>
                <div class="modal fade" id="assignNotification" tabindex="-1" aria-labelledby="assignattendeeLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="assignattendeeLabel">Send Notification</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form id="attendeeForm">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <input type="text" id="type" name="type" class="form-control"
                                            placeholder="Enter notification type" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" id="title" name="title" class="form-control"
                                            placeholder="Enter notification title" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea id="description" name="description" class="form-control editor"
                                            placeholder="Enter notification description" rows="3" required></textarea>
                                    </div>
                                </form>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary"
                                    onclick="submitNotification()">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <script>
        function changeStatus(id, status) {
            $.ajax({
                url: '/change-status',
                method: 'POST',
                data: {
                    id: id,
                    status: status,
                    _token: '{{ csrf_token() }}'

                },
                success: function(response) {
                    toastr.success('Status changed successfully');
                    location.reload(); // Optional: Reload page or update UI
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    toastr.success('Error occurred while changing status');
                }
            });
        }


        function toggleRejectInput(id) {
            const rejectionDiv = document.getElementById(`rejection_div_${id}`);
            rejectionDiv.style.display = rejectionDiv.style.display === 'none' ? 'block' : 'none';
        }

        function submitRejection(id) {
            const rejectionReason = document.getElementById(`rejection_reason_${id}`).value;

            if (rejectionReason.trim() === '') {
                toastr.error('Please enter a rejection reason');
                return;
            }

            $.ajax({
                url: '/submit-rejection-reason', // Your route here
                method: 'POST',
                data: {
                    id: id,
                    rejection_reason: rejectionReason,
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
        }

        function openNotification(rowId) {
            console.log(rowId);
            const modal = document.getElementById('assignNotification');
            modal.dataset.rowId = rowId;


            // Show the modal
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
        }

        function submitNotification() {
            // Get the input values from the form
            var type = $('#type').val();
            var title = $('#title').val();
            var description = CKEDITOR.instances.description.getData();
            // var description = $('#description').val();
            console.log(type, title, description);
            var modal = document.getElementById('assignNotification');
            var rowId = modal.dataset.rowId; // Assuming this is dynamically set

            // Validate that all fields are filled
            if (type && title && description) {
                $.ajax({
                    url: "{{ url('/admin/send-volunteer-notification') }}",
                    method: 'POST',
                    data: {
                        id: rowId,
                        type: type,
                        title: title,
                        description: description,
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        toastr.success('Notification sent successfully');
                        location.reload(); // Reload the page to reflect changes
                    },
                    error: function(error) {
                        toastr.error('Error occurred while sending notification');
                    }
                });
            } else {
                toastr.warning('Please fill all fields');
            }
        }
    </script>
