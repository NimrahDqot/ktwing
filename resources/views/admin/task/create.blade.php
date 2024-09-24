@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Add Task</h1>

    <form action="{{ route('admin_task_store') }}" method="post" enctype="multipart/form-data">
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
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    @foreach ($module as $row)
                        @php $moduleIndex = $loop->index + 1; @endphp
                        <div class="col-md-12">
                            <div class="form-check mb_10">
                                <input class="form-check-input" name="module_id[]" type="checkbox"
                                    value="{{ $row->id }}" id="module_id{{ $moduleIndex }}">
                                <label class="form-check-label" for="module_id{{ $moduleIndex }}">
                                    <strong>{{ $row->name }}</strong>
                                </label>
                            </div>
                        </div>

                        @foreach ($sub_module as $sub)
                            @if ($sub->module_id == $row->id)
                                @php $subModuleIndex = $loop->index + 1; @endphp
                                <div class="col-md-10 offset-md-2 bg-light pl-4 mb-2">
                                    <div class="form-check mb_10">
                                        <input class="form-check-input" name="sub_module_id[]" type="checkbox"
                                            value="{{ $sub->id }}"
                                            id="sub_module_id{{ $moduleIndex }}_{{ $subModuleIndex }}">
                                        <label class="form-check-label"
                                            for="sub_module_id{{ $moduleIndex }}_{{ $subModuleIndex }}">
                                            {{ $sub->name }}
                                        </label>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>

            </div>

            <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
        </div>
    </form>
@endsection
