@extends('user.user_layout.master')
@section('content')
    <section class="blog-posts grid-system">
        @if ($message = \Session::get('success'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="container">

            <div class="row">

                <div class="col-lg-4">
                    <h3>Category</h3>
                    <hr style="width:100%" , size="3" , color=black>
                    {{-- @dd(( Session::get('category')) ? 'checked' : '' )); --}}
                    @foreach ($category as $c)
                        <label class="form-check">
                            <input class="form-check-input " name="category[]" value="{{ $c->id }}"
                                {{-- @dd(in_array($c->id, Session::get('category')) ? 'checked' : '') --}}
                                @if (!empty(Session::get('category'))) {{ in_array($c->id, Session::get('category')) ? 'checked' : '' }} @endif
                                type="checkbox">
                            <span class="form-check-label">
                                <span class="float-right badge badge-light round"></span> {{ $c->name }}
                            </span>
                        </label>
                    @endforeach
                    <h3>Price</h3>
                    <hr style="width:100%" size="3" , color=black>
                    <div class="form-group">
                        <label for="amount">Price range:</label>
                        <input type="text" class="js-range-slider" name="my_range" value=""
                            {{ !empty(Session::get('price_range')) ? 'checked' : '' }} id="pricerangeslider" />
                    </div>
                    <div class="row">
                        <a href="{{ route('product.cart-view') }}" name="submit">
                            <u>
                                <h4 style="color: black"> View cart</h4>
                            </u>
                        </a>
                    </div>
                    <div class="row">
                        <a href="{{ route('product.order-history') }}" name="submit">
                            <u>
                                <h4 style="color: black">My Orders</h4>
                            </u>
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="all-blog-posts">
                        <div class="row">
                            <div class="col-lg-3">
                                <h3 id="">Products</h3>
                            </div>
                            <div class="col-lg-3">
                                <form action="" method="post">

                                </form>

                            </div>
                            <div class="col-lg-3 ">

                                {{-- <label for="change-currency" class="pull-right"> <b> Change Currency</b></label>
                                <select class="form-select pull-right" aria-label="Default select currency" name="currency"
                                    id="currency">
                                    <option value="INR" {{ Session::get('currency1') == 'INR' ? 'selected' : '' }}>INR
                                    </option>
                                    <option value="EUR" {{ Session::get('currency1') == 'EUR' ? 'selected' : '' }}>EURO
                                    </option>
                                </select> --}}
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
                                            {{-- @dd(Auth::user()->id) --}}
                                            <form action="{{ route('product.cart') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id" id="product_id"
                                                    value="{{ $product->id }}">
                                                {{-- <input type="number" name="quantity" id="quantity" class="col-md-4"
                                                    value="1"> --}}
                                                <button name="submit" id="submit" class="btn btn-success submit">Add To
                                                    cart</button>
                                            </form>
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js"></script>
    <script>
        var pricerangeslider = "{{ route('product.cat-filter') }}"
        var currency = "{{ route('product.change-currency') }}"
        var cart = "{{ route('product.cart') }}"
        // var filterProduct = "{{ route('product.cat-filter') }}"

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
                    url: " {{ route('product.cat-filter') }}",
                    method: "POST",
                    data: {

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
                                            <img src="` + /images/ + value.image + `"/> 
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
        // Prize Filter
        // $('body').on('click','.submit', function() {
        //     var productId = $('#product_id').val();
        //     var quantity = $('#quantity').val();
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //         },
        //         url: "{{ route('product.cart') }}",
        //         method: "post",
        //         data: {
        //             _token: "{{ csrf_token() }}",
        //             productId: productId,
        //             quantity: quantity
        //         },
        //         success: function(data) {

        //         }
        //     })
        // })

        // Currency converter
        // var from;
        // $("#currency").on('focus', function() {
        //     // e.preventDefault();
        //     from = this.value;
        // }).change(function() {
        //     var to = this.value;
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //         },
        //         url: "{{ route('product.change-currency') }}",
        //         method: "POST",
        //         data: {
        //             _token: "{{ csrf_token() }}",
        //             from: from,
        //             to: to
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             $(".product-data").html('');
        //             $.each(data.data, function(key, value) {
        //                 if (value.session_val == "EUR") {
        //                     $(".product-data").append(`<div class="col-lg-6">
    //                             <div class="blog-post">
    //                                 <div class="blog-thumb">
    //                                     <img src="` + /images/ + value.image + `"/> 
    //                                 </div>
    //                                 <div class="down-content">
    //                                         <span id=""> ` + value.category.name + `</span>
    //                                     <a href="#">
    //                                         <h4>` + value.name +
        //                         `</h4>
    //                                     </a>
    //                                         <span class="converted-currency" name="currency"> <i class="fa fa-euro">` +
        //                         +
        //                         value.new_price + `</i> 
    //                                     </span>
    //                                 </div>
    //                             </div>
    //                         </div>`);
        //                 } else {
        //                     $(".product-data").append(`<div class="col-lg-6">
    //                             <div class="blog-post">
    //                                 <div class="blog-thumb">
    //                                     <img src="` + /images/ + value.image + `"/> 
    //                                 </div>
    //                                 <div class="down-content">
    //                                         <span id=""> ` + value.category_name + `</span>
    //                                     <a href="#">
    //                                         <h4>` + value.name +
        //                         `</h4>
    //                                     </a>
    //                                         <span class="converted-currency" name="currency"> <i class="fa fa-rupee">` +
        //                         value.price + `</i> 
    //                                     </span>
    //                                 </div>
    //                             </div>
    //                         </div>`);
        //                 }
        //             });
        //         }
        //     })
        // });
        // Add To cart
        // $('body').on('click', '.cart', function() {
        //     var id = $(this).attr('id');
        //     $.ajax({
        //             headers: {
        //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //             },
        //             url: "{{ route('product.cart') }}",
        //             method: "POST",
        //             data: {
        //                 _token: "{{ csrf_token() }}",
        //                 id: id,
        //             },
        //             success: function(data) {
        //                 if (data.status == true) {
        //                     toastr.success(data.msg)
        //                         .delay(500)
        //                 }
        //             });
        //     });
        // });

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
