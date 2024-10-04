@php
$user = Auth::user();
$g_setting = \App\Models\GeneralSetting::where('id',1)->first();
$roleId = session('admin_role_id'); // Retrieve the role_id from the session
// $modules = App\Models\Module::with('subModules')->get();

    // Fetch modules and their sub-modules for the user's role
   // Fetch module IDs and sub-module IDs for the user's role
   $moduleIds = \DB::table('module_submodule_roles')
        ->where('role_id', $roleId)
        ->pluck('module_id');

    $subModuleIds = \DB::table('module_submodule_roles')
        ->where('role_id', $roleId)
        ->pluck('sub_module_id');

    // Fetch modules and their sub-modules for the user's role
    $modules = \App\Models\Module::with(['subModules' => function ($query) use ($subModuleIds) {
        // Filter sub-modules based on the IDs retrieved
        $query->whereIn('id', $subModuleIds);
    }])
    ->whereIn('id', $moduleIds) // Filter modules based on the IDs retrieved
    ->get();
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if(isset($g_setting->favicon))
    <link rel="icon" type="image/png" href="{{ asset('uploads/site_photos/'.$g_setting->favicon) }}">
    @endif
    <title>{{ ADMIN_PANEL }}</title>

    @include('admin.app_styles')

    <link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700&display=swap" rel="stylesheet">

    @include('admin.app_scripts')

</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        @php
            $route = Route::currentRouteName();
        @endphp

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin_dashboard') }}">
            <div class="sidebar-brand-text mx-3 ttn">
                <div class="left">
                    @if(isset($g_setting->favicon))
                    <img src="{{ asset('uploads/site_photos/'.$g_setting->favicon) }}" alt="">
                    @endif
                </div>
                <div class="right">
                    {{ env('APP_NAME') }}
                </div>
            </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-2">

        <!-- Dynamic Module and Sub-Module Display -->
        @foreach($modules as $module)
        @php
            // Get the route name for the module if it exists
            $routeName = $module->route_name ?? '';
            $isActive = $route == $routeName ? 'active' : '';
        @endphp
        <li class="nav-item {{ $isActive }}">
            @if($module->subModules->isNotEmpty())
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{{ $module->id }}" aria-expanded="true" aria-controls="collapse{{ $module->id }}">
                    <i class="fas fa-folder"></i>
                    <span>{{ $module->name }}</span>
                </a>
                <div id="collapse{{ $module->id }}" class="collapse {{ $isActive }}" aria-labelledby="heading{{ $module->id }}" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @foreach($module->subModules as $subModule)
                            @php
                                // Get the route name for the sub-module if it exists
                                $subRouteName = $subModule->route_name ?? '';
                            @endphp
                            <a class="collapse-item {{ $route == $subRouteName ? 'active' : '' }}"
                               href="{{ $subRouteName ? route($subRouteName) : '#' }}">
                               {{ $subModule->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @else
                <a class="nav-link {{ $isActive }}" href="{{ $routeName ? route($routeName) : '#' }}">
                    <i class="fas fa-folder"></i>
                    <span>{{ $module->name }}</span>
                </a>
            @endif
        </li>
    @endforeach


        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>


    </ul>
    <!-- End of Sidebar -->


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">


                    <!-- Nav Item - Alerts -->

                    <div class="topbar-divider d-none d-sm-block"></div>
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600">{{ $user->name }}</span>
                            <img class="img-profile rounded-circle" src="{{ asset($user->image) }}">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                            <a class="dropdown-item" href="{{ route('admin_profile_change') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> {{ CHANGE_PROFILE }}
                            </a>
                            <a class="dropdown-item" href="{{ route('admin_password_change') }}">
                                <i class="fas fa-unlock-alt fa-sm fa-fw mr-2 text-gray-400"></i> {{ CHANGE_PASSWORD }}
                            </a>
                            <a class="dropdown-item" href="{{ route('admin_photo_change') }}">
                                <i class="fas fa-image fa-sm fa-fw mr-2 text-gray-400"></i> {{ CHANGE_PHOTO }}
                            </a>
                            {{-- <a class="dropdown-item" href="{{ route('admin_banner_change') }}">
                                <i class="fas fa-image fa-sm fa-fw mr-2 text-gray-400"></i> {{ CHANGE_BANNER }}
                            </a> --}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin_logout') }}">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> {{ LOGOUT }}
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->
            <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('admin_content')

            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

@include('admin.app_scripts_footer')

</body>
</html>
