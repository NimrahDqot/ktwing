@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">View App Language</h1>


    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 mt-2 font-weight-bold text-primary">{{ SETUP_KEY_VALUES }}</h6>
                    <div class="float-right d-inline">
                        <a href="{{ route('admin_app_language_create') }}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i> {{ ADD_NEW }}</a>
                    </div>
                </div>
                <form action="{{ route('admin_app_language_update') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>{{ SERIAL }}</th>
                                        <th>{{ KEY }}</th>
                                        <th>{{ VALUE }}</th>
                                        <th>{{ ACTION }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($language_data as $row)
                                        <input type="hidden" name="lang_id[]" value="{{ $row->id }}">
                                        <input type="hidden" name="lang_key[]" value="{{ $row->lang_key }}">
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                <input type="text" name="" class="form-control"
                                                    value="{{ $row->lang_key }}" disabled>
                                            </td>
                                            <td>
                                                <input type="text" name="lang_value[]" class="form-control"
                                                    value="{{ $row->lang_value }}">
                                            </td>

                                            <td>
                                                <a href="{{ route('admin_app_language_edit',$row->id) }}" class="btn btn-warning btn-sm  "><i class="fas fa-edit"></i></a>
                                               @if( $row->id >83)
                                                <a href="{{ route('admin_app_language_delete',$row->id) }}" class="btn btn-danger btn-sm" onClick="return confirm('{{ ARE_YOU_SURE }}');"><i class="fas fa-trash-alt"></i></a>
                                                @endif
                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">{{ UPDATE }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
