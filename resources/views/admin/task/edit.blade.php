@extends('admin.app_admin')

@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Edit Module and Submodule Permissions</h1>

    <form action="{{ route('admin_task_update', $task->id) }}" method="post">
        @csrf

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Assign Task</h6>
                <div>
                    <a href="{{ route('admin_task_view') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-eye"></i> {{ VIEW_ALL }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="role_id">Admin *</label>
                        <select name="role_id" id="role_id" class="form-control" required>
                            <option disabled selected>--Select Admin--</option>
                            @foreach ($role as $item)
                                <option value="{{ $item->id }}" {{ $task->role_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-10">
                    <h5 class="mt-4 mb-3">Select Modules and Submodules</h5>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="select_all_modules">
                        <label class="form-check-label" for="select_all_modules">
                            Select All Modules
                        </label>
                    </div>
                    <div class="list-group">
                        @foreach ($module as $row)
                       <?php
                        // echo $row->id;
                        // print_r($task->modules->pluck('id')->toArray());
                          ?>

                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input" name="module_id[]" type="checkbox"
                                        value="{{ $row->id }}"
                                        {{ in_array($row->id, $task->modules->pluck('id')->toArray()) ? 'checked' : '' }}
                                        id="module_id{{ $row->id }}">

                                    <label class="form-check-label" for="module_id{{ $row->id }}">
                                        <strong>{{ $row->name }}</strong>
                                    </label>
                                </div>
                                <div class="pl-4">
                                    @foreach ($sub_module as $sub)
                                        @if ($sub->module_id == $row->id)
                                            <div class="form-check">
                                                <input class="form-check-input sub_module" name="sub_module_id[]" type="checkbox"
                                                    value="{{ $sub->id }}"
                                                    {{ in_array($sub->id, $task->subModules->pluck('id')->toArray()) ? 'checked' : '' }}
                                                    id="sub_module_id{{ $sub->id }}">

                                                <label class="form-check-label" for="sub_module_id{{ $sub->id }}">
                                                    {{ $sub->name }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-footer text-left">
                <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select_all_modules');
            const moduleCheckboxes = document.querySelectorAll('input[name="module_id[]"]');
            const subModuleCheckboxes = document.querySelectorAll('input[name="sub_module_id[]"]');

            selectAllCheckbox.addEventListener('change', function () {
                const isChecked = selectAllCheckbox.checked;

                moduleCheckboxes.forEach(moduleCheckbox => {
                    moduleCheckbox.checked = isChecked;
                    const subCheckboxes = moduleCheckbox.closest('.list-group-item').querySelectorAll('.sub_module');
                    subCheckboxes.forEach(subCheckbox => {
                        subCheckbox.checked = isChecked;
                    });
                });
            });
        });
    </script>

@endsection
