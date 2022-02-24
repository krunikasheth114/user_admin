@extends('user.user_layout.master')
@section('content')
    <table class="table table-hover table table-bordered">
        <thead>
            <tr>
                <th scope="col">image</th>
                <th scope="col">Product</th>
                <th scope="col">price</th>
                <th scope="col">quantity</th>
                <th scope="col">View </th>
            </tr>
        </thead>
        <tbody>
            {{-- @dd($product) --}}
            @if (!empty($product))
                @foreach ($product as $detail)
                    @foreach ($detail['product_data'] as $id => $item)
                        <tr>
                            <td scope="col"><img src="/images/{{ $item['image'] }}" alt="" height="50px" width="50px">
                            </td>
                            <td scope="col">{{ $item['name'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <form action="{{ route('product.preview') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <td> <input type="number" name="quantity" id="quantity" class="col-md-2" value="1">
                                </td>
                                <td>
                                    <input type="hidden" name="product_id" id="product_id" value="{{ $item['id'] }}">
                                    <button name="submit" id="submit" class="btn btn-primary submit">Place Order</button>
                            </form>
                            <a href="{{ route('product.user-cart-remove', $item['id']) }}" name="remove" id="remove"
                                class="btn btn-danger remove" value=""> <i class="fa fa-remove"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @else
                <?php echo 'Your Cart is Empty!!'; ?>
            @endif
        </tbody>
    </table>
@endsection
@push('page_scripts')
    {{-- <script>
        function myFunction(e) {
            alert(123);
            Swal.fire({
                title: 'Custom width, padding, color, background.',
                width: 600,
                padding: '3em',
                color: '#716add',
                background: '#fff url(https://sweetalert2.github.io/images/trees.png)',
                backdrop: `
                            rgba(0,0,123,0.4)
                            url("https://sweetalert2.github.io/images/nyan-cat.gif")
                            left top
                              no-repeat
                                `;
            });
        }


     
    </script> --}}
    {{-- <script>
        $("#remove").on("click", function() {
            var product_id = $(this).val();
            // alert(product_id);   
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('product.user-cart-remove') }}",
                method: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    product_id: product_id,
                },
                success: function(data) {

                }
            })

        })
    </script> --}}
@endpush
