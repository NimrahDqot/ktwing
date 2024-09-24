@extends('front.app_front')

@section('content')
    <div class="page-banner"
        style="background-image: url('{{ asset('uploads/page_banners/' . $property_page_data->banner) }}')">
        <div class="page-banner-bg"></div>
        <h1>{{ $property_page_data->name }}</h1>
        <nav>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ HOME }}</a></li>
                <li class="breadcrumb-item active">{{ $property_page_data->name }}</li>
            </ol>
        </nav>
    </div>

    <div class="page-content">
        <div class="container">
            <div class="row property pt_0 pb_0">

                <div class="col-lg-4 col-md-6 col-sm-12">

                    <form id="searchFormId">

                        <div class="property-filter">

                            <div class="lf-heading">
                                {{ FILTERS }}
                            </div>

                            <div class="lf-widget">
                                <input type="text" id="text" name="text" class="form-control"
                                    placeholder="{{ FIND_ANYTHING }}"
                                    value="{{ request()->has('text') ? request()->get('text') : '' }}">
                            </div>

                            <div class="lf-widget">
                                <h2>{{ TYPE }}</h2>

                                <select name="property_type" class="form-control" id="property_type">
                                    <option value="">{{ ALL }}</option>
                                    @if (request()->has('property_type'))
                                        <option {{ request()->get('property_type') == 'sale' ? 'selected' : '' }}
                                            value="sale">{{ FOR_SALE }}</option>
                                        <option {{ request()->get('property_type') == 'rent' ? 'selected' : '' }}
                                            value="rent">{{ FOR_RENT }}</option>
                                        <option {{ request()->get('property_type') == 'For Home Stay' ? 'selected' : '' }}
                                            value="For Home Stay">{{ FOR_HOME_STAY }}</option>
                                        <option
                                            {{ request()->get('property_type') == 'For Construction' ? 'selected' : '' }}
                                            value="For Construction">{{ FOR_CONSTRUCTION }}</option>
                                    @else
                                        <option value="sale">{{ FOR_SALE }}</option>
                                        <option value="rent">{{ FOR_RENT }}</option>
                                        <option value="For Home Stay">{{ FOR_HOME_STAY }}</option>
                                        <option value="For Construction">{{ FOR_CONSTRUCTION }}</option>
                                    @endif
                                </select>
                            </div>

                            @php
                                $sort_cat = [];
                                if (request()->has('category')) {
                                    foreach (request()->get('category') as $cat) {
                                        array_push($sort_cat, (int) $cat);
                                    }
                                }
                            @endphp

                            <div class="lf-widget">
                                <h2>{{ CATEGORIES }}</h2>
                                @php $ii=0; @endphp
                                @foreach ($property_categories as $index => $row)
                                    <div class="form-check">
                                        <input {{ in_array($row->id, $sort_cat) ? 'checked' : '' }} name="category[]"
                                            class="form-check-input" type="checkbox" value="{{ $row->id }}"
                                            id="cat{{ $index }}">
                                        <label class="form-check-label" for="cat{{ $index }}">
                                            {{ $row->property_category_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            @php
                                $sort_aminity = [];
                                if (request()->has('amenity')) {
                                    foreach (request()->get('amenity') as $cat) {
                                        array_push($sort_aminity, (int) $cat);
                                    }
                                }
                            @endphp

                            <div class="lf-widget">
                                <h2>{{ AMENITIES }}</h2>
                                @foreach ($amenities as $index => $row)
                                    <div class="form-check">
                                        <input {{ in_array($row->id, $sort_aminity) ? 'checked' : '' }} name="amenity[]"
                                            class="form-check-input" type="checkbox" value="{{ $row->id }}"
                                            id="amn{{ $index }}">
                                        <label class="form-check-label" for="amn{{ $index }}">
                                            {{ $row->amenity_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>


                            @php
                                $sort_loc = [];
                                if (request()->has('location')) {
                                    foreach (request()->get('location') as $cat) {
                                        array_push($sort_loc, (int) $cat);
                                    }
                                }
                            @endphp

                            <div class="lf-widget">
                                <h2>{{ LOCATIONS }}</h2>
                                @foreach ($property_locations as $index => $row)
                                    <div class="form-check">
                                        <input {{ in_array($row->id, $sort_loc) ? 'checked' : '' }} name="location[]"
                                            class="form-check-input" type="checkbox" value="{{ $row->id }}"
                                            id="loc{{ $index }}">
                                        <label class="form-check-label" for="loc{{ $index }}">
                                            {{ $row->property_location_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <input type="submit" class="form-control filter-button" value="{{ FILTER }}">
                            </div>

                        </div>




                </div>

                <div class="col-lg-8 col-md-6 col-sm-12">
                    <div class="contruction-fillter d-none" id="contruction-fillter">
                        <input name="construction_property_status" class="form-check-input" type="radio" value=""
                            id="cat-all" checked>
                        <label class="form-check-label" for="cat-all">All</label>

                        <input name="construction_property_status" class="form-check-input" type="radio" value="Ongoing"
                            id="cat-Ongoing">
                        <label class="form-check-label" for="cat-Ongoing">Ongoing</label>

                        <input name="construction_property_status" class="form-check-input" type="radio" value="Completed"
                            id="cat-Completed">
                        <label class="form-check-label" for="cat-Completed">Completed</label>

                        <input name="construction_property_status" class="form-check-input" type="radio" value="Upcomming"
                            id="cat-Upcomming">
                        <label class="form-check-label" for="cat-Upcomming">Upcomming</label>

                    </div>

                    <div class="right-area">

                        <div class="row d-none" id="loader-area">
                            <div class="col-12 text-center mt-5">
                                <div>
                                    <img src="{{ asset('loader.gif') }}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="row property-list" id="content-area">
                            <div class="col-12 text-center mt-5">
                                <div>
                                    <img src="{{ asset('loader.gif') }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                </form>

            </div>
        </div>
    </div>



    <script>
        let loaderHtml = $("#loader-area").html();
        (function($) {
            "use strict";
            $(document).ready(function() {

                loadPropertyUsingAjax();

                $("#searchFormId").on('submit', function(e) {
                    e.preventDefault();
                    submitSearchForm()
                })

                $("#property_type").on('change', function() {
                    submitSearchForm()
                })
                $("#contruction-fillter").on('click', function() {
                    submitSearchForm()
                })

                $(".form-check-input").on('click', function() {
                    submitSearchForm()
                })

                $("#text").on('keyup', function(e) {
                    if (e.target.keyCode === '13') {
                        submitSearchForm()
                    }
                })

            });
        })(jQuery);

        function loadPropertyUsingAjax() {
            submitSearchForm()
        }

        function submitSearchForm() {
            $('#content-area').html(loaderHtml);

            $.ajax({
                type: 'get',
                data: $('#searchFormId').serialize(),
                url: "{{ route('search-front_property_result') }}",
                success: function(response) {
                    $('#content-area').html(response);
                },
                error: function(err) {}
            });
        }


        function addToWishlist(id, element) {
            let url = "{{ url('customer/ajax-wishlist/add/') }}" + "/" + id;

            $.ajax({
                type: 'get',
                url: url,
                success: function(response) {
                    Swal.fire({
                        icon: response.is_success ? 'success' : 'error',
                        title: '',
                        html: response.message
                    });

                    if (response.is_success) {
                        let iconHtml = response.message === "{{ SUCCESS_WISHLIST_ADD }}"
                            ? `<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 391.837 391.837" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M285.257 35.528c58.743.286 106.294 47.836 106.58 106.58 0 107.624-195.918 214.204-195.918 214.204S0 248.165 0 142.108c0-58.862 47.717-106.58 106.58-106.58a105.534 105.534 0 0 1 89.339 48.065 106.578 106.578 0 0 1 89.338-48.065z" style="" fill="#b90000" data-original="#d7443e" opacity="1" class=""></path></g></svg>`
                            : `<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" x="0" y="0" viewBox="0 0 412.735 412.735" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M295.706 35.522a115.985 115.985 0 0 0-89.339 41.273 114.413 114.413 0 0 0-89.339-41.273C52.395 35.522 0 87.917 0 152.55c0 110.76 193.306 218.906 201.143 223.086a9.404 9.404 0 0 0 10.449 0c7.837-4.18 201.143-110.759 201.143-223.086 0-64.633-52.396-117.028-117.029-117.028zm-89.339 319.216C176.065 336.975 20.898 242.412 20.898 152.55c0-53.091 43.039-96.131 96.131-96.131a94.041 94.041 0 0 1 80.457 43.363c3.557 4.905 10.418 5.998 15.323 2.44a10.968 10.968 0 0 0 2.44-2.44c29.055-44.435 88.631-56.903 133.066-27.848a96.129 96.129 0 0 1 43.521 80.615c.001 90.907-155.167 184.948-185.469 202.189z" fill="#b90000" opacity="1" data-original="#000000" class=""></path></g></svg>`;

                        // Update the icon for the current element only
                        $(element).html(iconHtml);
                    }
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an issue adding the item to the wishlist. Please try again later.'
                    });
                }
            });
        }




        $(document).ready(function() {
            // Function to show/hide construction filter based on property type
            function toggleConstructionFilter(selectedType) {
                if (selectedType == 'For Construction') {

                    $('.contruction-fillter').removeClass('d-none');
                } else {
                    $('.contruction-fillter').addClass('d-none');
                }
            }

            // Get initial property type from request and set filter visibility
            const initialPropertyType = '{{ request()->get('property_type') }}';
            toggleConstructionFilter(initialPropertyType);

            // Event listener for property type change
            $('#property_type').change(function() {
                const selectedType = $(this).val();
                console.log(selectedType + '...........selectedType');
                toggleConstructionFilter(selectedType);
            });
        });
    </script>
@endsection
