@extends('admin.app_admin')
@section('admin_content')
    @php
        // Define a mapping array for statuses
        $statusLabels = [
            '0' => 'Pending',
            '1' => 'Approved',
            '2' => 'Rejected',
        ];
        $statusClasses = [
            '0' => 'badge badge-warning', // Pending (Yellow/Warning)
            '1' => 'badge badge-success', // Approved (Green/Success)
            '2' => 'badge badge-danger', // Rejected (Red/Danger)
        ];
    @endphp

    <div class="container">
        <h2 class="mb-4">Media Details</h2>
        <div class="float-right d-inline">
            <a href="{{ route('admin_event_request_view') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> {{ BACK_TO_PREVIOUS }}
            </a>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'photo' ? 'active' : '' }}" href="#photosTab" data-toggle="tab">Photos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'video' ? 'active' : '' }}" href="#videosTab"
                    data-toggle="tab">Videos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $activeTab == 'audio' ? 'active' : '' }}" href="#audiosTab"
                    data-toggle="tab">Audios</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade {{ $activeTab == 'photo' ? 'show active' : '' }}" id="photosTab">

                <h3 class="mb-3">Uploaded Photos</h3>
                @if ($photoRequests->isEmpty())
                    <p>No photos uploaded.</p>
                @else
                    <div class="row">
                        @foreach ($photoRequests as $photoRequest)
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm">
                                    <!-- Display each uploaded photo -->
                                    @if (!empty($photoRequest['uploaded_photos']))
                                        @foreach ($photoRequest['uploaded_photos'] as $photo)
                                            <div class="card-body">
                                                <!-- Show image -->
                                                <img src="{{ $photo }}" class="img-fluid mb-2 w_300 h_200" alt="Uploaded Photo">
                                            </div>
                                        @endforeach
                                    @endif

                                    <!-- Display status -->
                                    <div class="card-footer">

                                        <p>Status: <span
                                                class="{{ $statusClasses[$photoRequest['status']] ?? 'badge badge-secondary' }}">
                                                {{ $statusLabels[$photoRequest['status']] ?? 'Unknown' }}
                                            </span></p> <!-- Approve and Reject buttons -->

                                        @if ($photoRequest->status == '0')
                                            <!-- Approve button -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $photoRequest->id, 'type' => 'photo', 'status' => '1']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Are you sure you want to approve this photo?')">Approve</button>
                                            </form>
                                            <!-- Reject button -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $photoRequest->id, 'type' => 'photo', 'status' => '2']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to reject this photo?')">Reject</button>
                                            </form>
                                        @elseif($photoRequest->status == '1')
                                            <!-- Show only the Reject button when status is approved -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $photoRequest->id, 'type' => 'photo', 'status' => '2']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to reject this photo?')">Reject</button>
                                            </form>
                                        @elseif($photoRequest->status == '2')
                                            <!-- Show only the Approve button when status is rejected -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $photoRequest->id, 'type' => 'photo', 'status' => '1']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Are you sure you want to approve this photo?')">Approve</button>
                                            </form>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Videos Section -->
            <div class="tab-pane fade {{ $activeTab == 'video' ? 'show active' : '' }}" id="videosTab">
                <h3 class="mb-3">Uploaded Videos</h3>
                @if ($videoRequests->isEmpty())
                    <p>No videos uploaded.</p>
                @else
                    <div class="row">
                        @foreach ($videoRequests as $videoRequest)
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm">
                                    <!-- Display each uploaded Video -->
                                    @if (!empty($videoRequest['uploaded_videos']))
                                        @foreach ($videoRequest['uploaded_videos'] as $video)
                                            <div class="card-body">
                                                <!-- Show image -->
                                                <video class="card-img-top" controls>
                                                    <source src="{{ $video }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        @endforeach
                                    @endif

                                    <!-- Display status -->
                                    <div class="card-footer">

                                        <p>Status: <span
                                                class="{{ $statusClasses[$videoRequest['status']] ?? 'badge badge-secondary' }}">
                                                {{ $statusLabels[$videoRequest['status']] ?? 'Unknown' }}
                                            </span></p> <!-- Approve and Reject buttons -->

                                        @if ($videoRequest->status == '0')
                                            <!-- Approve button -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $videoRequest->id, 'type' => 'video', 'status' => '1']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Are you sure you want to approve this Video?')">Approve</button>
                                            </form>
                                            <!-- Reject button -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $videoRequest->id, 'type' => 'video', 'status' => '2']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to reject this Video?')">Reject</button>
                                            </form>
                                        @elseif($videoRequest->status == '1')
                                            <!-- Show only the Reject button when status is approved -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $videoRequest->id, 'type' => 'video', 'status' => '2']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to reject this Video?')">Reject</button>
                                            </form>
                                        @elseif($videoRequest->status == '2')
                                            <!-- Show only the Approve button when status is rejected -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $videoRequest->id, 'type' => 'video', 'status' => '1']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Are you sure you want to approve this Video?')">Approve</button>
                                            </form>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Audios Section -->
            <div class="tab-pane fade {{ $activeTab == 'audio' ? 'show active' : '' }}" id="audiosTab">
                <h3 class="mb-3">Uploaded Audios</h3>
                @if ($audioRequests->isEmpty())
                    <p>No audios uploaded.</p>
                @else
                    <div class="row">
                        @foreach ($audioRequests as $audioRequest)
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm">
                                    <!-- Display each uploaded Video -->
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
                                    @endif

                                    <!-- Display status -->
                                    <div class="card-footer">

                                        <p>Status: <span
                                                class="{{ $statusClasses[$audioRequest['status']] ?? 'badge badge-secondary' }}">
                                                {{ $statusLabels[$audioRequest['status']] ?? 'Unknown' }}
                                            </span></p> <!-- Approve and Reject buttons -->

                                        @if ($audioRequest->status == '0')
                                            <!-- Approve button -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $audioRequest->id, 'type' => 'audio', 'status' => '1']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Are you sure you want to approve this Audio?')">Approve</button>
                                            </form>
                                            <!-- Reject button -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $audioRequest->id, 'type' => 'audio', 'status' => '2']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to reject this Audio?')">Reject</button>
                                            </form>
                                        @elseif($audioRequest->status == '1')
                                            <!-- Show only the Reject button when status is approved -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $audioRequest->id, 'type' => 'audio', 'status' => '2']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to reject this Audio?')">Reject</button>
                                            </form>
                                        @elseif($audioRequest->status == '2')
                                            <!-- Show only the Approve button when status is rejected -->
                                            <form
                                                action="{{ route('update_media_status', ['id' => $audioRequest->id, 'type' => 'audio', 'status' => '1']) }}"
                                                method="POST" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"
                                                    onclick="return confirm('Are you sure you want to approve this Audio?')">Approve</button>
                                            </form>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var activeTab = "{{ session('activeTab', 'photo') }}"; // Default to 'photo'
        $('[href="#' + activeTab + 'Tab"]').tab('show');
    });
</script>
