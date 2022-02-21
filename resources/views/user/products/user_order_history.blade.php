@extends('user.user_layout.master')
@section('content')
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No:</th>
                <th scope="col">image</th>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total Amount</th>

            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @if (!empty($data))
                {{-- @dd($data) --}}
                @foreach ($data as $item)
                    @foreach ($item['user_order'] as $key => $value)
                        @foreach ($value['get_product'] as $val)
                            <?php $i++; ?>
                            <tr>
                                <th scope="row">{{ $i }}</th>
                                <td><img src="/images/{{ $val['image'] }}" height="50px" width="50px"></td>
                                <td>{{ $val['name'] }}</td>
                                <td>{{ $value['quantity'] }}</td>
                                <td>{{ $val['price'] }}</td>
                                <td>{{ $value['totalamount'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @else
                <?php echo 'No Orders From You !!'; ?>
            @endif

        </tbody>
    </table>
@endsection
