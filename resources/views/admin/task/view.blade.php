@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">View Task</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Module</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin_task_create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ ADD_NEW }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ SERIAL }}</th>
                        <th>Role</th>
                        <th>Task</th>
                        <th>Sub Task</th>
                        <th>{{ ACTION }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp
                        @foreach($task as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->role_id ? $row->Role->name : '' }}</td>
                            <td>
                                <ul>
                                    @foreach($row->Module as $module)
                                        <li>{{ $module->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach($row->SubModule as $subModule)
                                        <li>{{ $subModule->name }}</li>
                                    @endforeach
                                </ul>
                            <td>
                                <a href="{{ route('admin_task_edit',$row->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('admin_task_delete',$row->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('{{ ARE_YOU_SURE }}');"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
