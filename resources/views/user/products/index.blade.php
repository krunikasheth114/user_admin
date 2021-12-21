@extends('user.user_layout.master')
@section('content')
    <section class="blog-posts grid-system">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="all-blog-posts">
                        <div class="row">
                            <div class="col-lg-6">
                                <h3 id="">Products</h3>
                            </div>
                            <div class="col-lg-6 ">
                                <label for="change-currency" class="pull-right"> <b> Change Currency</b></label>
                                <select class="form-select pull-right" aria-label="Default select currency" name="currency"
                                    id="currency">
                                    <option value="INR">INR</option>
                                    <option value="EUR">EURO</option>
                                </select>
                            </div>
                        </div>
                        <div class="row product-data">
                            @foreach ($products as $product)
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
                                            <span class="converted-currency" name="currency[]">
                                                <i class="fa fa-rupee">{{ $product->price }}</i> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('page_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        var from;
        $("#currency").on('focus', function() {
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
                
                    $(".product-data").html('');
                    $.each(data.data, function(key, value) {
                        $(".product-data").append(`<div class="col-lg-6">
                                    <div class="blog-post">
                                        <div class="blog-thumb">
                                            <img src="` + /images/ + value.image  +`"/> 
                                        </div>
                                        <div class="down-content">
                                                <span id=""> ` + value.category_name + `</span>
                                            <a href="#">
                                                <h4>` + value.name + `</h4>
                                            </a>
                                            <span class="converted-currency" name="currency"> <i class="fa fa-euro">   ` + value.new_price + `</i> 
                                           
                                            </span>
                                        </div>
                                    </div>
                                </div>`);
                    });

                }
            })
        });
    </script>
@endpush
