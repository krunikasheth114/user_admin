@extends('user.user_layout.master')
@section('content')

        <div class="row">   
            <div class="col-lg-8">
                @foreach ($blog as $b)
                <div class="all-blog-posts">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="blog-post">
                                <div class="blog-thumb">
                                    <img src="{{ asset('images/' . $b->image) }}" alt="">
                                </div>
                                <div class="down-content">
                                    <span>{{ $b->category->category }}</span>
                                    <a href="{{ route('display', $b->slug) }}">
                                        <h4>{{ $b->title }}</h4>
                                    </a>
                                    <ul class="post-info">
                                        <li><i class="fa fa-thumbs-up">{{ $b->bloglike()->count() }}</i></li>
                                        <li><i class="fa fa-comments-o">{{ $b->blogcomments()->count() }}</i></li>
                                        <li><i class="fa fa-eye">{{ getblogView($b->id) }}</i></li>
                                        <li><a href="#">{{ $b->created_at }}</a></li>
                                    </ul>
                                    <p>{{ $b->description }}</p>
                                    <div class="post-options">
                                        <div class="row">
                                            <div class="col-6">
                                                <ul class="post-tags">
                                                    <li><i class="fa fa-tags"></i></li>
                                                    <li><a href="#">Best Templates</a>,</li>
                                                    <li><a href="#">TemplateMo</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-6">
                                                <ul class="post-share">
                                                    <li><i class="fa fa-share-alt"></i></li>
                                                    <li><a href="#">Facebook</a>,</li>
                                                    <li><a href="#"> Twitter</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-lg-4"></div>
          
        </div>
 








    {{-- <div class="row">

        @foreach ($blog as $b)

            <div class="col-sm-4">
                <div class="card" style="margin: 10px 10px 10px 10px">
                    <div class="blog">
                        <div class="box">
                            <img src="{{ asset('images/' . $b->image) }} " style="width: 100%;">
                        </div>
                    </div>
                </div>
                <div class="content-category">
                    <div class="category">
                        <span class="category"
                            style="margin:10px 10px;font-size:18px;text-transform:uppercase; color:lightsalmon;margin:10px ">{{ $b->category->category }}</span>
                    </div>
                </div>
                <div class="content-title">
                    <div class="title">
                        <a href="{{ route('display', $b->slug) }} " 
                            style="margin:10px 10px;font-weight:500;text-transform:capitalize"  onclick="count()">{{ $b->title }}</a>
                        <h6 style="margin: 5px 5px 5px 5px"><i class="fa fa-thumbs-up">{{ $b->bloglike()->count() }}</i>
                            &nbsp;&nbsp;<i class="fa fa-comments-o">{{ $b->blogcomments()->count() }}</i>&nbsp;&nbsp;<i
                                class="fa fa-eye">{{getblogView($b->id)}}</i> </h6>
                    </div>
                </div>
                <div class="content-description">
                    <div class="description">
                        <p style="margin:10px 10px;font-weight:500 ; border:5% black ; box-sizing:50%">{{ $b->description }}</p>
                    </div>
                </div>

            </div>
        @endforeach
    </div> --}}


@endsection
