@extends('user.user_layout.master')
@section('content')
    {{-- @dd($orderSummary) --}}
    <style></style>
    <div class="container">
        <div class="row">
            <h3>Order Summary</h3><br>
            <hr>
        </div>
        <br>
        <form action="{{ route('product.user-order') }}" method="patch" enctype="multipart/form-data">
            @csrf
            @foreach ($orderSummary as $item)
                {{-- @dd($orderId) --}}
                <div class="row">
                    <div class="col-6">
                        <img src="{{ asset('images/' . $item['image']) }}" style="height: 250px">
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-3">
                                <b> Product name: </b><br>
                                <b> Product price:</b><br>
                                <b> quantity:</b>
                            </div>
                            <div class="col-3">
                                {{ $item['name'] }} <br>
                                {{ $item['price'] }} <br>
                                <input type="hidden" name="productId" id="productId" value="{{ $item['id'] }}">
                                <input type="number" name="quantity" id="quantity" class="form-control" value="1"> <br>
                                <input type="hidden" name="orderId" id="orderId" value="{{ $orderId }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <button class="btn btn-success" name="submit" id="submit">Place Order</button>
        </form>
    </div>
@endsection
{{-- @push('page_scripts')
    <script>
        $('body').on('click', '#submit', function() {
            // alert(123);
            var order_id = $('#orderId').val();
            var product_id = $('#productId').val();
            var quantity = $('#quantity').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('product.user-order') }}",
                method: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    order_id: order_id,
                    product_id: product_id,
                    quantity: quantity
                },
                success: function(data) {

                }
            })




        })
    </script>
@endpush --}}
