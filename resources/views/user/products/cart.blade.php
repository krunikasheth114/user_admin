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
          {{-- @dd(Session::get('cart')); --}}
            @foreach (Session::get('cart') as $id => $detail)
            {{-- @if($detail['quantity']<0) --}}
                <tr>
                    <td scope="col"><img src="/images/{{ $detail['image'] }}" alt="" height="50px" width="50px"></td>
                    <td scope="col">{{ $detail['name'] }}</td>
                    <td>{{ $detail['price'] }}</td>
                    <td> <input type="number" class="col-md-2" value ="{{$detail['quantity']}}">  </td>
                    <td><button class="btn btn-primary">view all</button></td>
                 
                </tr>
              {{-- @endif --}}
            @endforeach
        </tbody>
    </table>
@endsection
