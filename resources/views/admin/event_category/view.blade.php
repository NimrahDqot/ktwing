
@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">View Event Category</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Volunteer</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin_event_category_create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ ADD_NEW }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ SERIAL }}</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>{{ ACTION }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp

                        @foreach($event_category as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::ucfirst($row->name) }}</td>
                            <td>
                                @if ($row->status == '1')
                                <a href="" onclick="changeStatus({{ $row->id }})"><input type="checkbox" checked data-toggle="toggle" data-on="Active" data-off="InActive" data-onstyle="success" data-offstyle="danger"></a>
                                @else
                                    <a href="" onclick="changeStatus({{ $row->id }})"><input type="checkbox" data-toggle="toggle" data-on="Active" data-off="InActive" data-onstyle="success" data-offstyle="danger"></a>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('admin_event_category_edit',$row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>

                                @if(!$used_cat_ids->contains($row->id))
                                    <a href="{{ route('admin_event_category_delete',$row->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('{{ ARE_YOU_SURE }}');"><i class="fas fa-trash-alt"></i></a>
                                </a>
                                @endif
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
                url:"{{url('/admin/event-category-status/')}}"+"/"+id,
                success:function(response){
                   toastr.success(response)
                },
                error:function(err){
                    console.log(err);
                }
            })
        }
</script>
