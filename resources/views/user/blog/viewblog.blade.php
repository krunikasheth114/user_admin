@extends('user.user_layout.master')
@section('page_title', ' Blog Details ')
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
                <p style="margin:10px 10px 10px 10px;font-family: 'Franklin Gothic Medium'; color:black;font-weight:500">
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
                        <a href="{{ route('user.login') }}"  class="btn like " id="id"
                            style="margin: 10px"><i class="fa fa-heart-o">{{ $view->bloglike()->count() }}</i>
                        </a>
                    @endif
                </div>
                <div class="col-sm-1">
                    <button class="btn " id="{{ $view->id }}" style="margin: 10px"><i
                            class="fa fa-comment-o"></i>
                        {{ $view->blogcomments()->count() }}
                    </button>
                </div>
                <div class="col-sm-1">
                    <button class="btn" name="view" id="view" style="margin: 10px"> <i class="fa fa-eye"
                            aria-hidden="true"> </i>
                        {{ $view->blogviews()->count() }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5">
        <div class="col-lg-12" class="mb-5">
            <div id="display_comment">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="sidebar-item submit-comment">
                <div class="sidebar-heading">
                    <h2>Your comment</h2>
                </div>

                <div class="content">
                    <form action="{{ route('blog.comment') }}" id="comment-form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <fieldset>
                                    <textarea name="comment" rows="6" id="comment" placeholder="Type your comment"
                                        value=""></textarea>
                                </fieldset>
                            </div>
                            <input type="hidden" name="blog_id" value="{{ $view->id }}">
                            <div class="col-lg-12">
                                <fieldset>
                                    <button type="submit" id="form-submit" class="main-button">Submit</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

    <script>
        $("#comment-form").validate({
            rules: {
                comment: {
                    required: true,
                },
                messages: {
                    comment: {
                        required: "This field is required",
                    },
                }
            },
        })
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

        $('body').on('submit', '#comment-form', function() {
            var comment = $('#comment').val();
            blog_id = "{{ $view->id }}"
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
                }
            })
        })

        // Delete Comment
        $('body').on('click', '.delete', function() {
            var id = $(this).attr('data-id');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('blog.delete.comment') }}",
                method: "POST",
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
            $('.reply').toggle();
            var thisClicked = $(this).attr('id');
            var cmt_id = $(this).attr('data-id');
            var route = "{{ route('blog.commentReply') }}";
            blog_id = "{{ $view->id }}";
            var html = `<div class="sidebar-item submit-comment">
                            <div class="content">
                                <form action="` + route + `" id="comment_reply_form" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <fieldset>
                                            <textarea name="comment_reply" rows="6" id="comment_reply" placeholder="Type your comment" required></textarea>
                                            </fieldset>
                                        </div>
                                        <input type="hidden" name="blog_id" value="` + blog_id + `">
                                        <input type="hidden" name="parent_id" value="` + cmt_id + `">
                                        <div class="col-lg-12">
                                            <fieldset>
                                            <button type="submit" id="reply-submit"  data-id="` + cmt_id + `" class="main-button">Submit</button>
                                            </fieldset>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>`;
            $(this).after(html);
        })
        $('body').on('click', '#reply-submit', function() {
            var cmnt_id = $(this).attr('data-id');
            var comment = $('#comment_reply').val();
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

                },
            });
        });
        load_comment();
        function load_comment() {
            blog_id = "{{ $view->id }}"
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                url: "{{ route('blog.fetch_comment') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    blog_id: blog_id
                },
                success: function(data) {
                    console.log(data.data);
                    if (data.status == true) {
                        $('#display_comment').html(data.data);
                    }
                }
            })
        }
    </script>
@endpush
