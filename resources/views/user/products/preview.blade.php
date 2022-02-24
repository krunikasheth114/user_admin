@extends('user.user_layout.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h3> Product Preview</h3>
                </div>
                <div class="card-body">

                    @foreach ($userCartPreview as $item)
                        {{-- {{ $item['id'] }} --}}
                        @foreach ($item['product_data'] as $data)
                            <div class="row">
                                <div class="col-6">
                                    <img src="{{ asset('images/' . $data['image']) }}" style="width: 75%">
                                </div>
                                <?php
                                $total_amount = $quantity * $data['price'];
                                ?>
                                <div class="col-4">
                                    <h5><b>Product name :</b></h5>
                                    <h5><b>Product Price :</b></h5>
                                    <h5><b>Quantity :</b></h5>
                                    <h5><b>Total payable amount :</b></h5>
                                    <form action="{{ route('product.payment') }}" method="post" >
                                        @csrf
                                        <input type="hidden" id="cart_id" name="cart_id" value="{{ $item['id'] }}">
                                        <input type="hidden" id="quantity" name="quantity" value="{{ $quantity }}">
                                        <input type="hidden" id="total_amount" name="total_amount"
                                            value="{{ $total_amount }}">
                                        <button class="btn btn-primary btn-block submit" name="submit" id="submit"> Precced To Pay
                                            <i class="fa fa-inr">{{ $total_amount }}</i> </button>
                                    </form>

                                </div>
                                <div class="col-2">
                                    <h5>{{ $data['name'] }}</h5>
                                    <h5><i class="fa fa-inr">{{ $data['price'] }}</i></h5>
                                    <h5>{{ $quantity }}</h5>
                                    <h5> <i class="fa fa-inr">{{ $total_amount }}</i></h5>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page_scripts')
    <script>
        // $('body').on('click', ".submit", function() {
        //     var product_id = $("#product_id").val();
        //     var quantity = $("#quantity").val();
        //     var total_amount = $("#total_amount").val();
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //         },
        //         url: "{{ route('product.payment') }}",
        //         method: "post",
        //         data: {
        //             product_id: product_id,
        //             quantity: quantity,
        //             total_amount: total_amount
        //         },
        //         success: function(data) {

        //         }
        //     })
        // })
    </script>
@endpush
