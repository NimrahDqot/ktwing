@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Task</h1>

    <form action="{{ route('admin_task_update', $task->id) }}" method="post">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 mt-2 font-weight-bold text-primary"></h6>
                <div class="float-right d-inline">
                    <a href="{{ route('admin_task_view') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                        {{ VIEW_ALL }}</a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Role *</label>
                        <select name="role_id" id="" class="form-control">
                            <option disabled selected>--Select Role--</option>
                            @foreach ($role as $item)
                                <option value="{{ $item->id }}"  {{$task->role_id == $item->id ? 'selected' :'' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    @php $i=0; @endphp
                    @foreach ($module as $row)
                        @php $i++; @endphp
                        <div class="col-md-4">
                            <div class="form-check mb_10">
                                <input class="form-check-input" name="module_id[]" type="checkbox"
                                    value="{{ $row->id }}" {{ in_array($row->id, $task->Module->pluck('id')->toArray()) ? 'checked' : '' }} id="module_id{{ $i }}">
                                <label class="form-check-label" for="module_id{{ $i }}">
                                    {{ $row->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach


                </div>
                <hr>
                <div class="row">
                    @php $i=0; @endphp
                    @foreach ($sub_module as $row)
                        @php $i++; @endphp
                        <div class="col-md-4">
                            <div class="form-check mb_10">
                                <input class="form-check-input" name="sub_module_id[]" type="checkbox"
                                    value="{{ $row->id }}" {{ in_array($row->id, $task->SubModule->pluck('id')->toArray()) ? 'checked' : '' }}  id="sub_module_id{{ $i }}">
                                <label class="form-check-label" for="sub_module_id{{ $i }}">
                                    {{ $row->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
        </div>
    </form>
@endsection
