
<style>
    .modal-image {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1000; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.9); /* Black with opacity */
    }

    .modal-image-content {
        margin-top: 20px !important;
        margin: auto;
        display: block;
        width: 50% !important; /* Width of the modal image */
        max-width: 700px; /* Max width */
    }

    .close-image {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #ffffff !important;
        font-size: 2.5rem !important;
        font-weight: bold;
        cursor: pointer;
    }
</style>
<link rel="stylesheet" href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/fontawesome-iconpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/sb-admin-2.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/jquery-ui.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/jquery.timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/bootstrap4-toggle.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/spacing.css') }}">
<link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
@php
$g_settings = \App\Models\GeneralSetting::where('id',1)->first();
@endphp
@if($g_settings->layout_direction == 'rtl')
    <link rel="stylesheet" href="{{ asset('backend/css/rtl.css') }}">
@endif

