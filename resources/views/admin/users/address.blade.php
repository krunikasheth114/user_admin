@extends('layouts.master')

@section('page_title', __('messages.updateuser'))

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0">@yield('page_title')</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);"></a></li>
                                    <li class="breadcrumb-item active"></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                            </div>
                            <div class="card-body">
                                <!-- ajax form response -->
                                <div class="ajax-msg"></div>
                                <div class="table-responsive">
                                    <form method="post" id="update-data"
                                        action="{{ route('admin.address.update', $userdata['id']) }}"
                                        enctype="multipart/form-data">
                                        @method('patch')
                                        @csrf
                                        <div class="form-group">
                                            @if (empty($userdata->profile))
                                                <img src="{{ asset('images/default/default.jpg') }}"
                                                    style="width: 50px; height:50px">
                                            @else
                                                <img src="{{ asset('images/' . $userdata->profile) }} "
                                                    style="width: 50px; height:50px">
                                            @endif
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <label for="firstname"> {{ __('messages.firstname') }}</label>
                                                <input id="firstname" type="firstname" class="form-control"
                                                    name="firstname" value="{{ $userdata['firstname'] }}"
                                                    autocomplete="firstname" autofocus>
                                                @if ($errors->has('firstname'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('firstname') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="lastname"> {{ __('messages.lastname') }}</label>
                                                <input id="lastname" type="lastname" class="form-control " name="lastname"
                                                    value="{{ $userdata['lastname'] }}" autocomplete="lastname" autofocus>
                                                @if ($errors->has('lastname'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('lastname') }}</strong>
                                                    </span>
                                                @endif
                                            </div>


                                            <div class="col-sm-4">
                                                <label for="email"> {{ __('messages.email') }}</label>
                                                <input id="email" type="email" class="form-control " name="email"
                                                    value="{{ old('email', isset($userdata->email) ? $userdata->email : '') }}"
                                                    autocomplete="email" autofocus>
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-4">
                                                <label for="category"> {{ __('messages.category') }}</label>
                                                <select class="form-control" name="category" id="category">

                                                    @foreach ($category as $cat)
                                                        <option value="{{ $cat->id }}"
                                                            {{ $cat->id == $userdata->category_id ? 'selected' : '' }}>

                                                            {{ $cat->category_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                @if ($errors->has('category'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('category') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="subcategory"> {{ __('messages.sub_category') }}</label>
                                                <select class="form-control subcategory" name="subcategory"
                                                    id="subcategory">

                                                    @foreach ($subcategory as $s)
                                                        <option value="{{ $s->id }} "
                                                            {{ $s->id == $userdata->subcategory_id ? 'selected' : '' }}>

                                                            {{ "$s->subcategory_name" }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                </option>
                                                @if ($errors->has('subcategory'))
                                                    <span class="invalid-feedback d-block" role="alert">
                                                        <strong>{{ $errors->first('subcategory') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="profile"> {{ __('messages.profile') }} </label>
                                                <input id="profile" type="file"
                                                    class="form-control @error('profile') is-invalid @enderror"
                                                    name="profile" autocomplete="current-profile">
                                            </div>
                                        </div>


                                        @if (!empty($userdata->userAddress))
                                            @foreach ($userdata->userAddress as $key => $address)
                                                <div class="my-address del-add">
                                                    <div class="form-group row ">
                                                        <div class="col-sm-6">
                                                            <label for="Address">{{ __('messages.address') }} :</label>
                                                            <textarea id="address" type="text" class="form-control"
                                                                name="address[{{ $key }}][address]"
                                                                autocomplete="address"
                                                                autofocus>{{ $address->address }}</textarea>
                                                            @if ($errors->has('address'))
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $errors->first('address') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <button type="button"
                                                                class="btn btn-danger {{ $key }}_add"
                                                                value="{{ $userdata->id }}" id="delete_add"
                                                                title="Delete"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label for="country">{{ __('messages.country') }} </label>
                                                            <select class="form-control country"
                                                                name="address[{{ $key }}][country]" id="country"
                                                                required>
                                                                <option value=""> ---Select Country--- </option>
                                                                @foreach ($data as $country)
                                                                    <option value="{{ $country->id }}"
                                                                        {{ $address->country == $country->id ? 'selected' : '' }}>
                                                                        {{ $country->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('country'))
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $errors->first('country') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <label for="state">{{ __('messages.state') }} :</label>
                                                            <select class="form-control state"
                                                                name="address[{{ $key }}][state]" id="state"
                                                                required>
                                                                <option value=""> ---Select State--- </option>
                                                                @foreach ($state as $s)
                                                                    <option value="{{ $s->id }}"
                                                                        {{ $address->state == $s->id ? 'selected' : '' }}>
                                                                        {{ $s->name }}
                                                                    </option>
                                                                @endforeach
                                                                </option>
                                                            </select>
                                                            @if ($errors->has('state'))
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $errors->first('state') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-sm-4">

                                                            <label for="city">{{ __('messages.city') }} </label>
                                                            <select class="form-control city"
                                                                name="address[{{ $key }}][city]" id="city"
                                                                required>
                                                                <option value=""> ---Select City --- </option>
                                                                @foreach ($city as $c)
                                                                    <option value="{{ $c->id }}"
                                                                        {{ $address->city == $c->id ? 'selected' : '' }}>
                                                                        {{ $c->name }}
                                                                    </option>
                                                                @endforeach
                                                                </option>
                                                            </select>
                                                            @if ($errors->has('city'))
                                                                <span class="invalid-feedback d-block" role="alert">
                                                                    <strong>{{ $errors->first('city') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="col-4"></div>
                                                <button type="button" class="btn btn-success" id="add-more"
                                                    title="Add">{{ __('messages.addmoreaddress') }} </button>
                                            </div>
                                        </div>

                                        <div id="add-address">

                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <button type="submit" name="submit" value="submit"
                                                class="btn btn-primary submit">
                                                {{ __('messages.update') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
        @endsection
        @push('page_scripts')
        <script>
            $('#add-more').on('click', function() {
                // $('#update-data').validate();


                my_addmore_count = $('body').find('.my_addmore').length;
                i = my_addmore_count + 1;
                // add rows to the form
                var html = `<div class="add_` + i + `"><div class="form-group row  my_addmore">
                            <div class="col-sm-6 ">
                                <label for="Address">{{ __('Address') }} :</label>
                                <textarea id="address_` + i + `" type="text" class="form-control" name="address[` + i + `][address]" value=""  autocomplete="address" autofocus required></textarea>
                            </div>
                        </div>
                            <div class="form-group row my_addmore">
                             <div class="col-sm-4">

                                <label for="country">{{ __('Country') }} :</label>
                                <select class="form-control country" name="address[` + i + `][country]" id="country_` +
                    i + `" required>
                                    <option value=""> ---Select Country--- </option>
                                    @foreach ($data as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                </div>
                            <div class="col-sm-4">

                                <label for="state">{{ __('State') }} :</label>
                                <select class="form-control state" name="address[` + i + `][state]" id="state_` + i + `" required>
                                    <option value=""> ---Select State--- </option>
                                </select>
                            </div>
                            <div class="col-sm-4">

                                <label for="city">{{ __('City') }} :</label>
                                <select class="form-control city" name="address[` + i + `][city]" id="city_` + i + `" required>
                                    <option value=""> ---Select City--- </option>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-sm-4">
                                <button type = "button" style="margin:5px;" class="btn btn-danger delete">Delete </button>
                            </div>
                    </div></div>`;
                $("#add-address").append(html);

                $('.delete').on('click', function() {
                    $(this).parent().parent().remove();
                });
            })


            $("#update-data").validate({
                rules: {
                    firstname: {
                        required: true,
                    },
                    lastname: {
                        required: true,
                    },
                    email: {
                        required: true,
                    },
                    category: {
                        required: true,
                    },
                    subcategory: {
                        required: true,
                    },
                },
            });



            $('.country').each(function() {
                $(this).rules('add', {
                    required: true,
                    messages: {
                        required: "This field is required",
                    },

                });
            });
            $('.state').each(function() {
                $(this).rules('add', {
                    required: true,
                    messages: {
                        required: "This field is required",
                    },

                });
            });

            $('.city').each(function() {
                $(this).rules('add', {
                    required: true,
                    messages: {
                        required: "This field is required",
                    },

                });
            });


            $('body').on('change', '.country', function() {
                $this = $(this);
                country = $this.val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.getstate') }}",
                    type: 'POST',
                    data: {
                        country: country
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $this.parent().parent().find(".state").html('');
                        $this.parent().parent().find(".state").append(
                            '<option value="">---Select State---</option>');
                        $.each(data.data, function(key, value) {
                            $this.parent().parent().find(".state").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
            $('body').on('change', '.state', function() {
                $this = $(this);
                state = $this.val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.getcity') }}",
                    type: 'POST',
                    data: {
                        state: state
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $this.parent().parent().find(".city").html('');
                        $this.parent().parent().find(".city").append(
                            '<option value="">---Select City---</option>');
                        $.each(data.data, function(key, value) {
                            $this.parent().parent().find(".city").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                })
            });

            $('#category').on('change', function() {
                category = $('#category').val();
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{ route('admin.getsubcategory') }}",
                    type: 'POST',
                    data: {
                        category: category
                    },
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data.data);
                        $.each(data.data, function(key, value) {
                            $(".subcategory").append('<option value="' + value.id + '">' + value
                                .subcategory_name + '</option>');
                        });
                    }

                });
            });

            $('body').on('click', '#delete_add', function() {
                $(this).parent().parent().parent().remove();
            })
        </script>

    @endpush