@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">View Sub Module</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Module</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin_sub_manage_module_create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ ADD_NEW }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ SERIAL }}</th>
                        <th>Module Name</th>
                        <th>Key</th>
                        <th>Name</th>
                        <th>{{ ACTION }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($manage_modules as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{!! isset($row->Module->name) ? $row->Module->name : '<span class="text-secondary">'.'Not Found'.'<span>' !!}</td>
                                <td>{{ $row->key }}</td>
                            <td>{{ $row->name }}</td>
                            <td>
                                @if ($row->id >= 8)

                                <a href="{{ route('admin_sub_manage_module_edit',$row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('admin_sub_manage_module_delete',$row->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('{{ ARE_YOU_SURE }}');"><i class="fas fa-trash-alt"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-12">
                    {{ $manage_modules->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
