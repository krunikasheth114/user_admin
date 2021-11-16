@extends('user.user_layout.master')
@section('content')
    <div class="card">
        <div class="card-header" style="background: white">
            <h1>Create Your Blog</h1>
        </div>
        <div class="card-body">
            @include('common.flash')
            <form action="{{ route('blog.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="catgory">{{ __('Blog Category') }} :</label>
                        <select class="form-control catgory" name="category_id" id="catgory" required>
                            <option value=""> ---Select Country--- </option>
                            @foreach ($category as $c)
                                <option value="{{ $c->id }}">
                                    {{ $c->category }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('catgory'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('catgory') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="title">{{ __('Blog Title') }} :</label>
                        <input id="title" type="title" class="form-control" name="title" value="" autocomplete="title"
                            autofocus>
                        @if ($errors->has('title'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="description">{{ __('Description') }} :</label>
                        <textarea id="description" type="description" class="form-control" name="description" value=""
                            autocomplete="description" autofocus></textarea>
                        @if ($errors->has('description'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-8">
                        <label for="file">{{ __('Add Image') }} :</label>
                        <input id="file" type="file" class="form-control" name="image" value="" autocomplete="file"
                            autofocus>
                        @if ($errors->has('file'))
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" id="user_id" class="user_id " name="user_id" value="{{ Auth::user()->id }}">
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Create') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
