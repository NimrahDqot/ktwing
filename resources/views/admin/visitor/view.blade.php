@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">App Visitors</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Visitors</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ SERIAL }}</th>
                        <th>Visitor</th>
                        <th>Other Details</th>
                        <th>Review</th>
                        <th>Audio</th>
                        <th>Status</th>
                        <th>{{ ACTION }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($visitors as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-capitalize">
                                @if($row->image)
                                <a href="{{ asset('uploads/visitor/'.$row->image )}}" target="_blank">
                                    <img src="{{ asset('uploads/visitor/'.$row->image )}}" alt="{{ $row->name }}" class="w_50">
                                </a>
                                @else
                                <a href="{{ asset('uploads/user_photos/default_photo.jpg')}}" target="_blank">
                                    <img src="{{ asset('uploads/user_photos/default_photo.jpg')}}" alt="{{ $row->name }}" class="w_50">
                                </a>
                                @endif
                                <p>
                                <b> user id: </b>
                                {{ $row->id }} <br>
                                 <b>name: </b>
                                 {{$row->name}} <br>
                                 <b>Phone: </b>
                                 {{$row->phone}}
                                </p>
                            </td>
                            <td class="text-capitalize"> <b> Role:</b>
                                {{ $row->role }} <br>
                                <b> Bio:</b>
                                {{ $row->bio }} <br>
                                <b> Grade:</b>
                                {{ $row->grade }}
                            </td>
                            <td class="text-capitalize">{{ $row->review }}</td>
                            <td>
                                @if($row->audio)
                                <audio controls>
                                    <source src="{{ asset('uploads/visitor/' . $row->audio) }}" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                @endif
                            <td>
                                @if ($row->status == '1')
                                <a href="" onclick="changeStatus({{ $row->id }})"><input type="checkbox" checked data-toggle="toggle" data-on="Active" data-off="Pending" data-onstyle="success" data-offstyle="danger"></a>
                                @else
                                    <a href="" onclick="changeStatus({{ $row->id }})"><input type="checkbox" data-toggle="toggle" data-on="Active" data-off="Pending" data-onstyle="success" data-offstyle="danger"></a>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin_visitor_delete',$row->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('{{ ARE_YOU_SURE }}');"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


<script>
    function changeStatus(id){
        $.ajax({
            type:"get",
            url:"{{url('/admin/visitor-status/')}}"+"/"+id,
            success:function(response){
               toastr.success(response)
            },
            error:function(err){
                console.log(err);
            }
        })
    }
</script>
