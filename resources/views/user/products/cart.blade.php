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
            @if (isset($product))
                @foreach ($product as $detail)
                    @foreach ($detail['product_data'] as $id => $item)
                        <tr>
                            <td scope="col"><img src="/images/{{ $item['image'] }}" alt="" height="50px" width="50px">
                            </td>
                            <td scope="col">{{ $item['name'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td> <input type="number" class="col-md-2" value="1"> </td>
                            <td>
                                <form action="{{ route('product.user-order') }}" method="post">
                                    <input type="hidden" name="product_id" id="product_id" value="{{ $item['id'] }}">
                                    <a href="" class="btn btn-primary">Order Place</a>
                            </td>
                            </form>
                        </tr>
                    @endforeach
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
