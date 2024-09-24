@extends('admin.app_admin')
@section('admin_content')
    <h1 class="h3 mb-3 text-gray-800">{{ CUSTOMERS }}</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-flex justify-content-left">
                    <form class="d-flex flex-wrap align-items-left" id="search" action="{{ route('admin_customer_view') }}"  method="GET">
                        <div class="me-sm-3 ml-2">
                            <select name="status" class="form-control" id="statusFilter">
                                <option selected disabled>--Please select status--</option>
                                <option value="Active"  {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Pending"  {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>

                            </select>
                        </div>
                        <div class="me-sm-3 ml-2">
                            <input type="text" class="form-control my-1 my-lg-0" name="name" value="{{ request('name') }}" id="nameFilter" placeholder="Name...">
                        </div>

                        <div class="me-sm-3 ml-2">
                            <input type="text" class="form-control my-1 my-lg-0" name="email" id="emailFilter" value="{{request('email')}}"  placeholder="Email-Id">
                        </div>
                        <div class="me-sm-3 ml-2">
                            <select name="sort_by" class="form-control" id="statusFilter">
                                <option value="id" {{ request('sort_by') == '' ? 'selected' : '' }}>--Please select Sort by--</option>
                                <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>Id</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="email" {{ request('sort_by') == 'email' ? 'selected' : '' }}>Email</option>
                                {{-- <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option> --}}

                            </select>
                        </div>

                        <div class="me-sm-3 ml-2">
                            <select name="sort_direction" class="form-control" id="sortDirectionFilter">
                                <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <div class="text-lg-end my-1 my-lg-0">
                                <a type="reset" href="{{ route('admin_customer_view') }}" class="btn btn-secondary waves-effect waves-light">Clear</a>
                                <button type="submit" class="btn btn-danger waves-effect waves-light">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered"   width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>{{ SERIAL }}</th>
                        <th>Mobile</th>
                        <th>{{ EMAIL }}</th>
                        <th>Own Code</th>
                        <th>Ref. Code</th>
                        <th>Cust ID</th>
                        <th>Member</th>
                        <th>Wallet</th>
                        <th>Recharge</th>
                        <th>Reg. Date</th>
                        <th>{{ ACTION }}</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>

                            <td>123123123</td>
                            <td>test@gmail.com</td>
                            <td>84777</td>
                            <td>83962</td>
                            <td>83962</td>
                            <td>83962</td>
                            <td>00081111</td>
                            <td>00081111</td>
                            <td>20-03-2022</td>

                            <td>
                                <a href="{{ route('admin_customer_detail',1) }}" class="btn btn-info btn-sm btn-block">{{ DETAIL }}</a>
                                <a href="{{ route('admin_customer_delete',1) }}" class="btn btn-danger btn-sm btn-block" onClick="return confirm('{{ ARE_YOU_SURE }}');">{{ DELETE }}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">

                </div>
            </div>
        </div>
    </div>

    <script>
        function customerStatus(id){
            $.ajax({
                type:"get",
                url:"{{url('/admin/customer-status/')}}"+"/"+id,
                success:function(response){
                   toastr.success(response)
                },
                error:function(err){
                    console.log(err);
                }
            })
        }
    </script>
@endsection
