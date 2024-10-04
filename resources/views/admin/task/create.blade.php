@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Assign Module and Submodule Permissions</h1>

    <form action="{{ route('admin_task_store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Assign Task</h6>
                <div>
                    <a href="{{ route('admin_task_view') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> {{ VIEW_ALL }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="">Admin *</label>
                        <select name="role_id" id="" class="form-control">
                            <option disabled selected>--Select Admin--</option>
                            @foreach ($roles as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                            <div class="list-group-item">
                                <div class="form-check">
                                    <input class="form-check-input module" name="module_id[]" type="checkbox" value="{{ $row->id }}" id="module_id{{ $row->id }}">
                                    <label class="form-check-label" for="module_id{{ $row->id }}">
                                        <strong>{{ $row->name }}</strong>
                                    </label>
                                </div>
                                <div class="pl-4">
                                    @foreach ($sub_module as $sub)
                                        @if ($sub->module_id == $row->id)
                                            <div class="form-check">
                                                <input class="form-check-input sub_module" name="sub_module_id[]" type="checkbox" value="{{ $sub->id }}" id="sub_module_id{{ $sub->id }}" data-module-id="{{ $row->id }}">
                                                <label class="form-check-label" for="sub_module_id{{ $sub->id }}"  >
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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Handle sub-module checkbox click
    const subModuleCheckboxes = document.querySelectorAll('.sub_module');
    subModuleCheckboxes.forEach(subModule => {
        subModule.addEventListener('change', function() {
            const moduleId = this.getAttribute('data-module-id');
            const moduleCheckbox = document.getElementById(`module_id${moduleId}`);

            // If a sub-module is checked, check its corresponding module
            if (this.checked) {
                moduleCheckbox.checked = true;
            }
        });
    });

    // Handle module checkbox click
    const moduleCheckboxes = document.querySelectorAll('.module');
    moduleCheckboxes.forEach(module => {
        module.addEventListener('change', function() {
            const moduleId = this.value; // Get the module ID
            const subModuleCheckboxes = document.querySelectorAll(`.sub_module[data-module-id="${moduleId}"]`);

            // Check or uncheck all sub-modules based on the module checkbox
            subModuleCheckboxes.forEach(subModule => {
                subModule.checked = this.checked; // Check or uncheck
            });
        });
    });

    // Handle select all modules checkbox
    document.getElementById('select_all_modules').addEventListener('change', function() {
        const allModules = document.querySelectorAll('.module');
        const allSubModules = document.querySelectorAll('.sub_module');
        allModules.forEach(module => {
            module.checked = this.checked; // Check/uncheck each module
        });
        allSubModules.forEach(subModule => {
            subModule.checked = this.checked; // Check/uncheck each sub-module
        });
    });
});

</script>
@endsection
