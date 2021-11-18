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
    <div class="card">
        <div class="card-header">
            <h1>{{ $view->title }}</h1>
        </div>
        <div class="card-body">
            <div class="col-sm-8">
                <img src="{{ asset('images/' . $view->image) }} " style="width:80%; height:70%">
            </div>
            <div class="row">
                <p
                    style="margin:10px 10px 10px 10px;font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; color:black;font-weight:500">
                    {{ $view->description }}</p>
            </div>
            <div class="row">
                <div class="col-sm-1">
                    @if (Auth::check())
                        <button class="btn like {{ isLike($view->id) ? 'red' : '' }}" id="{{ $view->id }}"
                            style="margin: 10px"><i class="fa fa-heart-o"></i>
                        </button>
                    @else
                        <a href="{{ route('user.login') }}" class="btn like " id="id" style="margin: 10px"><i
                                class="fa fa-heart-o"></i>
                        </a>
                    @endif
                </div>
                <div class="col-sm-1">
                    @if (Auth::check())
                        <button class="btn comment" name="comment" id="comment" style="margin: 10px"><i
                                class="fa fa-comments-o" aria-hidden="true"></i></i></button>
                    @else
                        <a href="{{ route('user.login') }}" class="btn comment" name="comment" id="comment"
                            style="margin: 10px"><i class="fa fa-comments-o"></i> </a>
                    @endif
                </div>
                <div class="col-sm-1">
                    <button class="btn" name="view" id="view" style="margin: 10px"> <i class="fa fa-eye"
                            aria-hidden="true"></i></button>
                </div>
            </div>

            {{-- add comments --}}
            <div class="row mydiv" style="display: none">
                <div class="col-12 my_add">
                    {{-- write comments --}}

                    <br>
                </div>
            </div>
            {{-- list comments --}}
            <div class="row">
                <div class="col-12 mycomments" style="margin: 5px 5px 5px 5px">
                    <label for="mycomments"> <b>Comments:</b> </label><br>
                    {{-- view Comments --}}
                    @foreach ($comments as $item)
                        <input type="text"
                            style="background: transparent; border: none; border-bottom: 1px solid #000000; width:50% "
                            name="comment" id="commentlist" value="{{ $item->comment }}" class="form-group "><i
                            class="fa fa-remove delete" id="{{ $item->id }}"></i>
                    @endforeach
                    <br>
                </div>
            </div>


        </div>
    </div>

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
        $('.comment').on('click', function() {
            blog_id = "{{ $view->id }}"
            my_addmore_count = $('body').find('.my_add').length;
            i = my_addmore_count + 1;
            var html =
                `<input type="text" style="background: transparent; border: none; border-bottom: 1px solid #000000; width:50% " 
            name="comments" id="comments" value=""  class="form-group comments" > <i class="fa fa-paper-plane send"  aria-hidden="true"></i>`
            $(".mydiv").show();
            $(".my_add").append(html);

        })

        $('body').on('click', '.send', function() {
            var comment = $('.comments').val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('blog.comment') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    comment: comment,
                    id: blog_id
                },
                success: function(data) {
                    console.log(data);
                    if (data.status == true) {
                        $('.mycomments').append(`<input type="text" style="background: transparent; border: none; border-bottom: 1px solid #000000; width:50% "
                                name="comment" id="` + data.data.blog_id + `" value="` + data.data.comment +
                            `" class="form-group value"><i class="fa fa-remove delete" id="` + data
                            .data.id + `"></i><br>`
                        );

                        $('.value').effect("highlight", {}, 3000);

                        $('.my_add').html('');
                    }


                }
            })


        })

        $('body').on('click', '.delete', function() {
            var id = $(this).attr('id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('blog.delete.comment') }}",
                method: "post",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(data) {
                    if (status == true) {

                    }


                }
            })
        });
    </script>

@endsection
