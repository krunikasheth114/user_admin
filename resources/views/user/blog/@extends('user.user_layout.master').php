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
                            {{ $view->bloglike()->count() }}
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
                                class="fa fa-comments-o"
                                aria-hidden="true"></i>&nbsp;&nbsp;{{ $view->blogcomments()->count() }}</button>
                    @else
                        <a href="{{ route('user.login') }}" class="btn comment" name="comment" id="comment"
                            style="margin: 10px"><i class="fa fa-comments-o"></i> </a>
                    @endif
                </div>
                {{-- <div class="col-sm-1">
                    <button class="btn" name="view" id="view" style="margin: 10px"> <i class="fa fa-eye"
                            aria-hidden="true"> </i></button>
                </div> --}}
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
                <div class="col-6 mycomments" style="margin: 5px 5px 5px 5px">
                    <label for="mycomments"> <b>Comments:</b> </label><br>
                    {{-- view Comments --}}
                    @foreach ($comments as $key => $item)
                        <div>
                            <b>@</b><b>{{ $item->getUser->firstname }}:</b>
                            <input type="text"
                                style="background: transparent; border: none; border-bottom: 1px solid #000000; width:50% "
                                name="comment" id="{{ $item->id }}" value=" {{ $item->comment }}"
                                class="form-group " /Readonly>
                            @if (\Auth::check())
                                <i class=" fa fa-remove delete" id="{{ $item->id }}"></i>
                                <i class="fa fa-reply reply" id="reply_{{ $key }}"
                                    data-id="{{ $item->id }}"></i>
                                <button class="btn-sm btn btn-primary view_replies" id="view_replies"> View Replies</button>
                            @endif
                            @php
                                $childComment = getChildComment($item->id);
                                $marginleft = 0;
                            @endphp
                            @if (!empty($childComment))
                                @if($item->id == 0)
                                   @php $marginleft = 0; @endphp
                                @else
                                @php $marginleft = $marginleft + 48; @endphp
                                @endif
                                @foreach ($childComment as $comment)
                                    <div class="col-sm-6 child-comment" style="margin-left:{{$marginleft}}px">
                                        <b>@</b><b>{{ $comment->getUser->firstname }}:</b>
                                        <br><input type="text"
                                            style="background: transparent; border: none; border-bottom: 1px solid #000000; width:50% "
                                            name="comment" data-id="{{ $comment->id }}" parent_id="{{ $comment->id }}"
                                            value="{{ $comment->comment }}" class="form-group ">
                                        <i class="fa fa-reply add_rep" parent_id="{{ $comment->id }}"
                                            data-id="{{ $comment->id }}"></i>
                                        <i class="fa fa-remove delete" parent_id="{{ $comment->id }}"
                                            id="{{ $comment->id }}"></i>
                                    </div>
                                @endforeach
                            @endif
                        </div>
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
                            .data.id + `"></i>>`
                        );

                        $('.value').effect("highlight", {}, 3000);
                        $('.my_add').html('');
                    }
                    location.reload();
                }
            })

        })

        // Delete Comment
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
                    if (status == true) {}
                    location.reload();
                }
            })
        });

        // reply
        $('body').on('click', '.reply', function() {
            var thisClicked = $(this).attr('id');
            var cmt_id = $(this).attr('data-id');
            var html = `<div><input type="text" class="myrep" id="myrep" value="">
                <i class="fa fa-remove delete" id="` + thisClicked + `"></i><i class="fa fa-send post" data-id="` +
                cmt_id +
                `" id="` + thisClicked + `"></i><i class="fa fa-reply add_rep" data-id="` + cmt_id +
                `" id="` + thisClicked + `" style="display:none"></i>
            </div><br><br>`;
            $(this).after(html);

        })
        $('body').on('click', '.post', function() {
            var cmnt_id = $(this).attr('data-id');
            var comment = $('.myrep').val();
            blog_id = "{{ $view->id }}"
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('blog.commentReply') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    parent_id: cmnt_id,
                    blog_id: blog_id,
                    comment: comment
                },
                success: function(data) {
                    console.log(data)
                    $('.post').hide();
                    $('.add_rep').show();
                    $('.view_replies').after(`<br><input type="text" style="background: transparent; border: none; border-bottom: 1px solid #000000; width:50% "
                                name="comment" data-id="` + data.data.id + `" id="` + data.data.parent_id +
                        `" value="` + data.data.comment + `" class="form-group "> `
                    );
                    location.reload();
                },

            });

        })
        // view Reolies
        $('.view_replies').on('click', function() {
            $(this).parent().find('.child-comment').show();
        })

        $('body').on('click', '.add_rep', function() {
            var comment_id = $(this).attr('data-id');
            var parent_id = $(this).attr('parent_id');
            $('.delete').hide();
            var html = `<div><input type="text" class="myres" id="myres" value="">
                <i class="fa fa-remove delete" data-id="` + comment_id +
                `" id="` + parent_id + `"> </i><i class="fa fa-send rep_sec" data-id="` + comment_id +
                `" id="` + parent_id + `"></i>
            </div><br><br>`;
            // $(this).parent().find('.child-comment').show();
            $(this).after(html);


        })
        $('body').on('click', '.rep_sec', function() {
            var comment = $('.myres').val();
            var cmt_id = $(this).attr('data-id');
            var parent_id = $(this).attr('id');
            blog_id = "{{ $view->id }}"
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('blog.response') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cmt_id: cmt_id,
                    parent_id: parent_id,
                    blog_id: blog_id,
                    comment: comment
                },
                success: function(data) {

                    if (status == true) {}
                    location.reload();


                }

            });


        })
    </script>

@endsection
