@extends('user.user_layout.master')
@section('content')
    <section class="blog-posts grid-system">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    {{-- {{dd(!empty(Session::get('price_range')))}} --}}
                    <h3>Category</h3>
                    <hr style="width:100%" , size="3" , color=black>
                    @foreach ($category as $c)
                        <label class="form-check">
                            <input class="form-check-input " name="category[]" value="{{ $c->id }}"
                                @if (!empty(Session::get('category'))) {{ in_array($c->id, Session::get('category')) ? 'checked' : '' }} @endif type="checkbox">
                            <span class="form-check-label">
                                <span class="float-right badge badge-light round"></span> {{ $c->name }}
                            </span>
                        </label>
                    @endforeach
                    <h3>Price</h3>
                    <hr style="width:100%" , size="3" , color=black>
                    <div class="form-group">
                        <label for="amount">Price range:</label>
                        <input type="text" class="js-range-slider" name="my_range" value=""
                            {{ !empty(Session::get('price_range')) ? 'checked' : '' }} id="pricerangeslider" />
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="all-blog-posts">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 id="">Products</h3>
                            </div>
                            <div class="col-lg-6 ">
                                <label for="change-currency" class="pull-right"> <b> Change Currency</b></label>
                                <select class="form-select pull-right" aria-label="Default select currency" name="currency"
                                    id="currency">
                                    <option value="INR" {{ Session::get('currency1') == 'INR' ? 'selected' : '' }}>INR
                                    </option>
                                    <option value="EUR" {{ Session::get('currency1') == 'EUR' ? 'selected' : '' }}>EURO
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row product-data">
                            @foreach ($products as $product)
                                {{-- @if (empty(Session::get('category'))) --}}
                                <div class="col-lg-6">
                                    <div class="blog-post">
                                        <div class="blog-thumb">
                                            <img src="{{ asset('images/' . $product->image) }}" alt="">
                                        </div>
                                        <div class="down-content">
                                            @foreach ($category as $c)
                                                <span
                                                    id="{{ $c->id }}">{{ $product->category_id == $c->id ? $c->name : '' }}</span>
                                            @endforeach
                                            <a href="#">
                                                <h4>{{ $product->name }}</h4>
                                            </a>
                                            @if (Session::get('currency1') == 'EUR')
                                                <span class="converted-currency" name="currency">
                                                    <i class="fa fa-euro ">{{ getEuroPrice($product->price) }}</i>
                                                </span>
                                            @else
                                                <span class="converted-currency" name="currency">
                                                    <i class="fa fa-rupee ">{{ $product->price }}</i>
                                                </span>
                                            @endif
                                            <br>
                                            <button class="btn btn-secondary cart" id="{{ $product->id }}">Add To
                                                Cart</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- @endif --}}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@push('page_scripts')
    <script>
        // Prize Filter
        $(function() {
            $("#pricerangeslider").ionRangeSlider({
                type: "double",
                min: 0,
                max: 3000,
                from: 100,
                prefix: "₹",
                to: 500,
                skin: "round"
                // grid: true
            }).change(function() {
                var price_range = $(this).val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('product.cat-filter') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        price_range: price_range
                    },
                    success: function(data) {
                        console.log(data);
                        $(".product-data").html('');
                        if ((data.data) != "") {
                            $.each(data.data, function(key, value) {
                                console.log(value);
                                $(".product-data").append(`<div class="col-lg-6">
                                    <div class="blog-post">
                                        <div class="blog-thumb">
                                            <img src="` + /images/ + value.image + `"/> 
                                        </div>
                                        <div class="down-content">
                                                <span id=""> ` + value.get_category.name + `</span>
                                            <a href="#">
                                                <h4>` + value.name +
                                    `</h4>
                                            </a>
                                                <span class="converted-currency" name="currency"> <i class="fa fa-rupee">` +
                                    +
                                    value.price + `</i> 
                                            </span>
                                        </div>
                                    </div>
                                </div>`);
                            });
                        }
                    }
                })
            });
        });
        // Currency converter
        var from;
        $("#currency").on('focus', function() {
            // e.preventDefault();
            from = this.value;
        }).change(function() {
            var to = this.value;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('product.change-currency') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    from: from,
                    to: to
                },
                success: function(data) {
                    console.log(data);
                    $(".product-data").html('');
                    $.each(data.data, function(key, value) {
                        if (value.session_val == "EUR") {
                            $(".product-data").append(`<div class="col-lg-6">
                                    <div class="blog-post">
                                        <div class="blog-thumb">
                                            <img src="` + /images/ + value.image + `"/> 
                                        </div>
                                        <div class="down-content">
                                                <span id=""> ` + value.category.name + `</span>
                                            <a href="#">
                                                <h4>` + value.name +
                                `</h4>
                                            </a>
                                                <span class="converted-currency" name="currency"> <i class="fa fa-euro">` +
                                +
                                value.new_price + `</i> 
                                            </span>
                                        </div>
                                    </div>
                                </div>`);
                        } else {
                            $(".product-data").append(`<div class="col-lg-6">
                                    <div class="blog-post">
                                        <div class="blog-thumb">
                                            <img src="` + /images/ + value.image + `"/> 
                                        </div>
                                        <div class="down-content">
                                                <span id=""> ` + value.category_name + `</span>
                                            <a href="#">
                                                <h4>` + value.name +
                                `</h4>
                                            </a>
                                                <span class="converted-currency" name="currency"> <i class="fa fa-rupee">` +
                                value.price + `</i> 
                                            </span>
                                        </div>
                                    </div>
                                </div>`);
                        }
                    });
                }
            })
        });
        // Add To cart
        $('body').on('click', '.cart', function() {
            var id = $(this).attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('product.cart') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(data) {
                    window.location = "{{ route('product.cart-view') }}";
                }
            })
        })
        // Category Filter
        var categories;
        $('input[name="category[]"]').on('change', function(e) {
            e.preventDefault();
            categories = [];
            $('input[name="category[]"]:checked').each(function() {
                categories.push($(this).val());

            });
            $.ajax({
                type: 'POST',
                url: '{{ route('product.cat-filter') }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    categories: categories,
                },
                success: function(data) {
                    // console.log(data.data.category)
                    $(".product-data").html('');
                    if ((data.data) != "") {
                        $.each(data.data, function(key, value) {
                            console.log(value);
                            $(".product-data").append(`<div class="col-lg-6">
                                    <div class="blog-post">
                                        <div class="blog-thumb">
                                            <img src="` + /images/ + value.image + `"/> 
                                        </div>
                                        <div class="down-content">
                                                <span id=""> ` + value.get_category.name + `</span>
                                            <a href="#">
                                                <h4>` + value.name +
                                `</h4>
                                            </a>
                                                <span class="converted-currency" name="currency"> <i class="fa fa-rupee">` +
                                +
                                value.price + `</i> 
                                            </span>
                                        </div>
                                    </div>
                                </div>`);
                        });
                    }
                }
            });
        })
    </script>
@endpush
