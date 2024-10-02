@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">Assign Module and Submodule Permissions</h1>

    <form action="{{ route('admin_task_store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Task Details</h6>
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
                            @foreach ($admins as $item)
                                <option value="{{ $item->id }}">{{ $item->username }}</option>
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
                                    <input class="form-check-input" name="module_id[]" type="checkbox" value="{{ $row->id }}" id="module_id{{ $row->id }}">
                                    <label class="form-check-label" for="module_id{{ $row->id }}">
                                        <strong>{{ $row->name }}</strong>
                                    </label>
                                </div>
                                <div class="pl-4">
                                    @foreach ($sub_module as $sub)
                                        @if ($sub->module_id == $row->id)
                                            <div class="form-check">
                                                <input class="form-check-input" name="sub_module_id[]" type="checkbox" value="{{ $sub->id }}" id="sub_module_id{{ $sub->id }}">
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

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success">{{ SUBMIT }}</button>
            </div>
        </div>
    </form>

    <script>
        // JavaScript to handle Select All functionality for modules and submodules
        document.getElementById('select_all_modules').addEventListener('change', function() {
            const isChecked = this.checked;

            // Set the state of all module checkboxes
            document.querySelectorAll('input[name="module_id[]"]').forEach(moduleCheckbox => {
                moduleCheckbox.checked = isChecked;

                // Set the state of all corresponding submodule checkboxes
                const moduleId = moduleCheckbox.value;
                document.querySelectorAll(`input[name="sub_module_id[]"][id^="sub_module_id"][id*="${moduleId}"]`).forEach(submoduleCheckbox => {
                    submoduleCheckbox.checked = isChecked;
                });
            });
        });
    </script>
@endsection
