@extends('user.user_layout.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2">
                <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#card-model" name="submit"
                    id="submit" type="submit">Add Card</button>
            </div>
        </div>
        @include('user.products.payment.create')
        </body>
      
    @endsection
