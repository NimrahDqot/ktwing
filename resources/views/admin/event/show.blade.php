@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Event Detail</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                    <div class="float-right d-inline">
                        <a href="{{ route('admin_event_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                            {{ BACK_TO_PREVIOUS }}</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>Event Banner</td>
                                <td>
                                    <a href="{{ asset($event->image) }}" target="_blank">
                                        <img src="{{ asset($event->image) }}" alt="{{ $event->name }}" class="w_200"
                                            id="output">
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>Event Category Name</td>
                                <td>{{ $event->event_category_info->name }}</td>
                            </tr>
                            <tr>
                                <td>Event Name</td>
                                <td>{{ $event->event_category_info->name }}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{{ $event->name }}</td>
                            </tr>
                            <tr>
                                <td>Village Name</td>
                                <td>{{ $event->village_info->name }}</td>
                            </tr>
                            <tr>
                                <td>Date Time</td>
                                <td>{{ date('d M, Y', strtotime($event->event_date)) }}|
                                    {{ date('g:i A', strtotime($event->event_time)) }}</td>
                            </tr>
                            <tr>
                                <td>Event Duration</td>
                                <td>{{ $event->event_duration }}</td>
                            </tr>
                            <tr>
                                <td>Event Agenda</td>
                                <td>{{ $event->event_agenda }}</td>
                            </tr>
                            <tr>
                                <td>Expected Attendance</td>
                                <td>{{ $event->expected_attendance }}</td>
                            </tr>
                            <tr>
                                <td>Resource List</td>
                                <td>{{ $event->resoure_list }}</td>
                            </tr>
                            <tr>
                                <td>Important Attendees</td>
                                <td>
                                    @php
                                        $attendeeIds = explode(',', $event->attendees_id);
                                        $assignedAttendee = $attendees->whereIn('id', $attendeeIds);
                                    @endphp
                                    @if ($assignedAttendee->count() > 0)
                                        @foreach ($assignedAttendee as $attendee)
                                            <span>{{ $attendee->name }}</span>{{ !$loop->last ? ', ' : '' }}
                                        @endforeach
                                    @else
                                        <span class="text-secondary">No attendee assigned</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Uploaded Photos by Volunteer</td>
                                <td>
                                    <div class="row">
                                        @foreach ($photoRequests as $photoRequest)
                                            <div class="col-md-3 mb-4">
                                                <div class="card shadow-sm">
                                                    <!-- Display each uploaded photo -->
                                                    @if (!empty($photoRequest['uploaded_photos']))
                                                        @foreach ($photoRequest['uploaded_photos'] as $photo)
                                                            <div class="card-body">
                                                                <!-- Show image -->
                                                                <img src="{{ $photo }}" class="img-fluid mb-2"
                                                                    alt="Uploaded Photo">
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p>No Photos available</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Uploaded Audios by Volunteer</td>
                                <td>
                                    <div class="row">
                                        @foreach ($audioRequests as $audioRequest)
                                            <div class="col-md-3 mb-4">
                                                <div class="card shadow-sm">
                                                    <!-- Display each uploaded photo -->
                                                    @if (!empty($audioRequest['uploaded_audios']))
                                                        @foreach ($audioRequest['uploaded_audios'] as $audio)
                                                            <div class="card-body">
                                                                <!-- Show image -->
                                                                <audio class="card-img-top" controls>
                                                                    <source src="{{ $audio }}" type="audio/mpeg">
                                                                    Your browser does not support the audio element.
                                                                </audio>

                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p>No Audios available</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Uploaded Videos by Volunteer</td>
                                <td>
                                    <div class="row">
                                        @foreach ($videoRequests as $videoRequest)
                                            <div class="col-md-3 mb-4">
                                                <div class="card shadow-sm">
                                                    <!-- Display each uploaded photo -->
                                                    @if (!empty($videoRequest['uploaded_videos']))
                                                        @foreach ($videoRequest['uploaded_videos'] as $video)
                                                            <div class="card-body">
                                                                <video class="card-img-top " controls>
                                                                    <source src="{{ $video }}" type="video/mp4">
                                                                    Your browser does not support the video tag.
                                                                </video>

                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p>No Videos available</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    $("#pop").on("click", function() {
        $(this).modal();
    });
</script>
