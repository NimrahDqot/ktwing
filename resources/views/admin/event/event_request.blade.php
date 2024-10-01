
@extends('admin.app_admin')
@section('admin_content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

    <h1 class="h3 mb-3 text-gray-800">View Completed Event Request</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Completed Event Request</h6>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Event Name</th>
                            <th>Assign Volunteers</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>

                                @php
                                    $volunteerIds = explode(',', $user->volunteer_id); // Assuming the IDs are stored as CSV
                                    $assignedVolunteers = $volunteers->whereIn('id', $volunteerIds); // Fetch volunteer names based on IDs
                                @endphp
                                @if($assignedVolunteers->count() > 0)
                                    @foreach($assignedVolunteers as $volunteer)
                                        <span>{{ $volunteer->name }}</span>{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                @else
                                    <span class="text-secondary">No volunteers</span>
                                @endif
                            </td>
                            <td>
                                <!-- Link to the user media details page -->
                                <a href="{{ route('user_media_details', $user->id) }}" class="btn btn-primary">View Media</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>
        </div>
    </div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>
<link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

