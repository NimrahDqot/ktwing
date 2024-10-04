@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">View Admin</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Admin</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin_manage_admin_create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ ADD_NEW }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ SERIAL }}</th>
                        <th>User Image</th>
                        <th>User Name</th>
                        <th>User Details</th>
                        <th>Role</th>
                        <th>Activation Status</th>
                        <th>Is Admin</th>
                        <th>{{ ACTION }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($manage_admin as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset($row->image) }}" style="cursor: pointer;" onclick="zoomImage(this)" class="w_50">
                            </td>
                            </td>
                            <td>{{ $row->username }}</td>
                            <td>
                                <a href="mailto:{{ $row->email }}">{{ $row->email }}</a> <br>
                                <a href="tel:{{ $row->mobile }}">{{ $row->mobile }}</a>
                            </td>
                            <td>{{ isset($row->Role->name) ? $row->Role->name : '' }}</td>
                            <td>
                                <input type="checkbox"
                                       class="{{ $row->id == Auth::user()->id ? 'disabled' : '' }}"
                                       data-toggle="toggle"
                                       data-on="Active"
                                       data-off="InActive"
                                       data-onstyle="success"
                                       data-offstyle="danger"
                                       {{ $row->activation_status == '1' ? 'checked' : '' }}
                                       {{ $row->id == Auth::user()->id ? 'disabled' : '' }}>
                            </td>
                            <td>
                                <input type="checkbox"
                                       class="{{ $row->id == Auth::user()->id ? 'disabled' : '' }}"
                                       data-toggle="toggle"
                                       data-on="Active"
                                       data-off="InActive"
                                       data-onstyle="success"
                                       data-offstyle="danger"
                                       {{ $row->is_admin == '1' ? 'checked' : '' }}
                                       {{ $row->id == Auth::user()->id ? 'disabled' : '' }}>
                            </td>
                            <td>
                                <a href="{{ route('admin_manage_admin_edit',$row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('admin_manage_admin_delete', $row->id) }}" class="btn btn-danger btn-sm {{ $row->id == Auth::user()->id ? 'disabled' : '' }}"
                                    onClick="return confirm('{{ ARE_YOU_SURE }}');">
                                     <i class="fas fa-trash-alt"></i>
                                 </a>  </td>
                        </tr>
                        @endforeach
                    </tbody>

                    <!-- Modal for Image Display -->
                    <div id="modal" class="modal modal-image" onclick="closeModal()">
                        <span class="close close-image" onclick="closeModal()">&times;</span>
                        <img class="modal-image-content modal-content" id="modalImage">
                        <div id="caption"></div>
                    </div>
                </table>
                <div class="col-12">
                    {{ $manage_admin->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
<script>
     function changeActivationStatus(id){
        $.ajax({
            type:"get",
            url:"{{url('/admin/activate-status/')}}"+"/"+id,
            success:function(response){
                toastr.success(response)
            },
            error:function(err){
                console.log(err);
            }
        })
    }
    function changeIsAdminStatus(id){
        $.ajax({
            type:"get",
            url:"{{url('/admin/is-admin-status/')}}"+"/"+id,
            success:function(response){
                toastr.success(response)
            },
            error:function(err){
                console.log(err);
            }
        })
    }

</script>
