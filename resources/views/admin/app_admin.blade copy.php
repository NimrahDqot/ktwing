@php
$user = Auth::user();
$g_setting = \App\Models\GeneralSetting::where('id',1)->first();
$roleId = session('admin_role_id'); // Retrieve the role_id from the session
$modules = App\Models\Module::with('subModules')->get();
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
        <hr class="sidebar-divider my-0">

        {{-- <!-- Dashboard -->
        <li class="nav-item {{ $route == 'admin_dashboard' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_dashboard') }}">
                <i class="fas fa-fw fa-home"></i>
                <span>{{ DASHBOARD }}</span>
            </a>
        </li>

        <li class="nav-item {{ $route == 'admin_manage_module_view'||$route =='admin_sub_manage_module_view' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseModuleManagement" aria-expanded="true" aria-controls="collapseModuleManagement">
                <i class="fas fa-folder"></i>
                <span>Module Management</span>
            </a>
            <div id="collapseModuleManagement" class="collapse {{ $route == 'admin_sub_manage_module_view'||$route == 'admin_manage_module_view' ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin_manage_module_view') }}">Module</a>
                    <a class="collapse-item" href="{{ route('admin_sub_manage_module_view') }}">Sub Module</a>
                </div>
            </div>
        </li>
        <li class="nav-item {{ $route == 'admin_role_view'||  $route =='admin_role_edit'||  $route =='admin_role_create'|| $route =='admin_task_view' || $route =='admin_view' ||$route =='admin_view' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                <i class="fas fa-folder"></i>
                <span>Admin Manager</span>
            </a>
            <div id="collapseSetting" class="collapse {{ $route == 'admin_role_view'||$route == 'admin_role_create'||$route == 'admin_task_view'||$route =='admin_role_edit'||$route =='admin_task_create'||$route =='admin_view'||$route == 'admin_task_view'||$route == 'admin_task_edit' ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin_view') }}">Manage Admin</a>
                    <a class="collapse-item" href="{{ route('admin_role_view') }}">Manage Role</a>
                    <a class="collapse-item" href="{{ route('admin_task_view') }}">Manage Task</a>
                </div>
            </div>
        </li>

        <li class="nav-item {{ $route == 'admin_banner_view' ||'admin_banner_create' || 'admin_banner_edit' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_banner_view') }}">
                <i class="far fa-caret-square-right"></i>
                <span>Banner Manager</span>
            </a>
        </li>


        <li class="nav-item {{ $route == 'admin_volunteer_view' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_volunteer_view') }}">
                <i class="far fa-caret-square-right"></i>
                <span>Volunteer Management</span>
            </a>
        </li>

        <li class="nav-item {{ $route == 'admin_village_view' ||'admin_village_create' || 'admin_village_edit' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_village_view') }}">
                <i class="far fa-caret-square-right"></i>
                <span>Village Manager</span>
            </a>
        </li>

        <li class="nav-item {{ $route == 'admin_event_category_view' ||'admin_event_category_create' || 'admin_event_category_edit' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_event_category_view') }}">
                <i class="far fa-caret-square-right"></i>
                <span>Event Category Manager</span>
            </a>
        </li>
        <li class="nav-item {{ $route == 'admin_attendees_view' ||'admin_attendees_create' || 'admin_attendees_edit' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_attendees_view') }}">
                <i class="far fa-caret-square-right"></i>
                <span>Attendees Manager</span>
            </a>
        </li>
        <li class="nav-item {{ $route == 'admin_event_view' ||'admin_event_create' || 'admin_event_edit' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_event_view') }}">
                <i class="far fa-caret-square-right"></i>
                <span>Event Manager</span>
            </a>
        </li>

        <li class="nav-item {{ $route == 'admin_page_privacy_edit'||$route =='admin_page_term_edit' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePrivacyPolicy" aria-expanded="true" aria-controls="collapsePrivacyPolicy">
                <i class="fas fa-folder"></i>
                <span>Content Management</span>
            </a>
            <div id="collapsePrivacyPolicy" class="collapse {{ $route == 'admin_page_term_edit'||$route == 'admin_page_privacy_edit' ? 'show' : '' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="{{ route('admin_page_privacy_edit') }}">Privacy Policy</a>
                    <a class="collapse-item" href="{{ route('admin_page_term_edit') }}">Risk Disclosure Agreement</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">

        <li  class="nav-item text-center p-2 text-success">
            <span>App Manager</span>
        </li>
        <hr class="sidebar-divider">


        <li class="nav-item {{ $route == 'admin_app_language_view' ||'admin_app_language_create' || 'admin_app_language_edit' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_app_language_view') }}">
                <i class="far fa-caret-square-right"></i>
                <span>App language</span>
            </a>
        </li>

        <li class="nav-item {{ $route == 'admin_notification_view' ||'admin_notification_create' || 'admin_notification_edit' ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_notification_view') }}">
                <i class="far fa-caret-square-right"></i>
                <span>Notification</span>
            </a>
        </li>

        <li class="nav-item {{ $route == 'admin_visitor_view'  ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_visitor_view') }}">
                <i class="far fa-caret-square-right"></i>
                <span>Visitors</span>
            </a>
        </li>

        <li class="nav-item {{ $route == 'admin_event_request_view'  ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin_event_request_view') }}">
                <i class="far fa-caret-square-right"></i>
                <span>Volunteer Event Request</span>
            </a>
        </li> --}}
        <hr class="sidebar-divider">
        <hr class="sidebar-divider">
        <hr class="sidebar-divider">

<!-- Dynamic Module and Sub-Module Display -->
@foreach($modules as $module)
    <li class="nav-item {{ $route == $module->route_name ? 'active' : '' }}">
        @if($module->subModules->isNotEmpty())
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{{ $module->id }}" aria-expanded="true" aria-controls="collapse{{ $module->id }}">
                <i class="fas fa-folder"></i>
                <span>{{ $module->name }}</span>
            </a>
            <div id="collapse{{ $module->id }}" class="collapse {{ $route == $module->route_name ? 'show' : '' }}" aria-labelledby="heading{{ $module->id }}" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @foreach($module->subModules as $subModule)
                        <a class="collapse-item {{ $route == $subModule->route_name ? 'active' : '' }}" href="{{ route($subModule->route_name) }}">{{ $subModule->name }}</a>
                    @endforeach
                </div>
            </div>
        @else
            @php
                // Debug output
                $routeName = $module->route_name;
                $routeExists = Route::has($routeName);
            @endphp

            <a class="nav-link {{ !$routeExists ? 'disabled' : '' }}" href="{{ $routeExists ? route($routeName) : '#' }}">
                <i class="fas fa-folder"></i>
                <span>{{ $module->name }}</span>
            </a>
        @endif
    </li>
@endforeach



        <?php /* ?>
     s

<?php  */ ?>



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
                            <img class="img-profile rounded-circle" src="{{ asset('uploads/admin_photos/'.$user->image) }}">
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
