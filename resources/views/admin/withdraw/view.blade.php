@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">View Withdraw</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex justify-content-left">
                    <form class="d-flex flex-wrap align-items-left" id="search" action=" "  method="GET">
                        <div class="me-sm-3 ml-2">
                            <select name="status" class="form-control" id="statusFilter">
                                <option selected disabled>--Please select status--</option>
                                <option value="Active"  {{ request('status') == 'Active' ? 'selected' : '' }}>Request</option>
                                <option value="Pending"  {{ request('status') == 'Pending' ? 'selected' : '' }}>Accept</option>
                                <option value="Pending"  {{ request('status') == 'Pending' ? 'selected' : '' }}>Rejected</option>
                                <option value="Pending"  {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>

                            </select>
                        </div>
                        <div class="col-auto">
                            <div class="text-lg-end my-1 my-lg-0">
                                <a type="reset" href=" " class="btn btn-secondary waves-effect waves-light">Clear</a>
                                <button type="submit" class="btn btn-danger waves-effect waves-light">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 mt-2 font-weight-bold text-primary">Module</h6>
            <div class="float-right d-inline">
                <a href="{{ route('admin_product_create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ ADD_NEW }}</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ SERIAL }}</th>
                        <th>Mobile</th>
                        <th>Amount</th>
                        <th>Payout Type</th>
                        <th>Req. Date</th>
                        <th>{{ ACTION }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php $i=0; @endphp

                        <tr>
                            <td>1</td>
                            <td>1231231</td>
                            <td>123</td>
                            <td>BANK</td>
                            <td>25-02-2022</td>
                            <td>
                                <a href="{{ route('admin_product_edit',1) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
