@extends('user.user_layout.master')
@section('content')
    <div class="container">
        <div class="row">
            {{-- @dd(Session::get('success')); --}}
            @if (Session::has('success'))
                <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p>{{ Session::get('success') }}</p>
                </div>
            @endif
            <h1>Order History</h1>
        </div>
    </div>
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
                                <td> <i class="fa fa-inr">{{ $val['price'] }}</td>
                                <td> <i class="fa fa-inr">{{ $value['totalamount'] }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @else
                <?php echo '<h6 style="color:red">No Orders From You !!</h6>'; ?>
            @endif

        </tbody>
    </table>
@endsection
