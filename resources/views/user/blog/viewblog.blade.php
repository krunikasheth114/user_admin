@extends('user.user_layout.master')

@push('css')
    <style>
        .red {
            color: red;
            text-shadow: 1px 1px 1px red;
        }

    </style>
@endpush
@section('content')
    @foreach ($view as $v)
        <div class="card">
            <div class="card-header">
                <h1>{{ $v->title }}</h1>
            </div>
            <div class="card-body">
                <div class="col-sm-8">
                    <img src="{{ asset('images/' . $v->image) }} " style="width:80%; height:70%">
                </div>
                <div class="row">
                    <p
                        style="margin:10px 10px 10px 10px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color:black;font-weight:500">
                        {{ $v->description }}</p>
                </div>
                <div class="row">
                    <div class="col-sm-1">
                        @if (Auth::check())
                        <button class="btn like {{ isLike($v->id) ? 'red' : '' }}" id="{{ $v->id }}"
                            style="margin: 10px"><i class="fa fa-heart-o"></i>
                        </button>
                        @else
                        <a  href="{{route('user.login')}}" class="btn like " id="id"
                            style="margin: 10px"><i class="fa fa-heart-o"></i>
                        </a>
                        @endif
                       
                    </div>
                    <div class="col-sm-1">

                        <button class="btn " name="comment" id="comment" style="margin: 10px"><i
                                class="fa fa-comments-o" aria-hidden="true"></i></i></button>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn" name="view" id="view" style="margin: 10px"> <i class="fa fa-eye"
                                aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script>
        $('body').on('click', '.like', function() {
            var blog = $('.like').attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('blog.like') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: blog
                },
                success: function(data) {
                    if (data.status == true) {
                        $(".like").addClass('red');
                    } else {
                        $(".like").removeClass("red");
                    }
                },
            })
        })
    </script>

@endsection
