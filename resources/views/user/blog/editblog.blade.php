@extends('user.user_layout.master')
@section('content')


    @foreach ($blogs as $blog)
        <div class="card">
            @include('common.flash')
            <div class="card-header" style="background: white">
                <h1>Edit Blog {{ $blog->title }}</h1>
            </div>
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="row">
                        <div class=col-sm-8>
                            <form action="{{ route('blog.update', $blog->slug) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    {{-- Category --}}
                                    <div class="col-sm-8">
                                        <label for="catgory">{{ __('Blog Category') }} :</label>
                                        <select class="form-control catgory" name="category_id" value="" id="catgory">
                                            <option value=""> ---Select Category--- </option>
                                            @foreach ($category as $c)
                                                <option value="{{ $c->id }}"
                                                    {{ $c->id == $blog->category_id ? 'selected' : '' }}>
                                                    {{ $c->category }} </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('catgory'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('catgory') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>
                                {{-- title --}}
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <label for="title">{{ __('Blog Title') }} :</label>
                                        <input id="title" type="title" class="form-control" name="title"
                                            value="{{ $blog->title }}" autocomplete="title" autofocus>
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                {{-- description --}}
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <label for="description">{{ __('Description') }} :</label>
                                        <textarea id="description" type="description" class="form-control"
                                            name="description" value="" autofocus>{{ $blog->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                {{-- image --}}
                                <div class="form-group row">
                                    <div class="col-sm-8">
                                        <label for="file">{{ __('Add Image') }} :</label>
                                        <input id="file" type="file" class="form-control" name="image" value=""
                                            autocomplete="file" autofocus>
                                        @if ($errors->has('file'))
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $errors->first('file') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <input type="hidden" id="slug" class="slug " name="slug"
                                        value="{{ $blog->slug }}">
                                    <div class="col-sm-2">
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">
                                            {{ __('Update') }}
                                        </button>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="{{ route('blog.delete', $blog->slug) }}" name="delete" id="delete"
                                            class="btn btn-danger">
                                            {{ __('Delete') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{-- <input type="hidden" id="slug" class="slug " name="slug" value="{{ $blog->slug }}"> --}}
                                   
                                </div>
                            </form>
                        </div>
                        <div class=col-sm-4>
                            <img src="{{ asset('images/' . $blog->image) }} "
                            style="width: 100%; height:100%">
                        </div>
                    </div>
                </div>
                <br>
                <br>
            </div>
            <br>
        </div>
        <br>

    @endforeach




@endsection
