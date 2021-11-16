@extends('user.user_layout.master')
@section('content')
    <section class="">

    </section>
    <div class="row">
        @foreach ($blog as $b)
            <div class="col-sm-4">
                <div class="card" style="margin: 10px 10px 10px 10px">
                    <div class="blog">
                        <div class="blog-thumb">
                            <img src="{{ asset('images/' . $b->image) }} " style="width: 100%; height:100%">
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
                            <a href="#"
                                style="margin:10px 10px;font-weight:500;text-transform:capitalize">{{ $b->title }}</a>
                        </div>
                    </div>
                    <div class="content-description">
                        <div class="description">
                            <p style="margin:10px 10px;font-weight:500">{{ $b->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection
